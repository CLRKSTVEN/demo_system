<?php
defined('BASEPATH') or exit('No direct script access allowed');

class OnlinePayment extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('OPaymentModel');
        $this->load->helper(['url', 'form']);
        $this->load->config('dragonpay'); // load defaults
        $this->load->library('upload');

        if ($this->session->userdata('logged_in') !== TRUE) {
            redirect('login');
        }

        // ✅ Override config from DB
        $s = $this->OPaymentModel->getDragonpaySettings();
        if (!empty($s['dragonpay_merchantid'])) $this->config->set_item('dragonpay_merchantid', $s['dragonpay_merchantid']);
        if (!empty($s['dragonpay_password']))   $this->config->set_item('dragonpay_password',   $s['dragonpay_password']);
        if (!empty($s['dragonpay_url']))        $this->config->set_item('dragonpay_url',        $s['dragonpay_url']);
    }

    public function index()
    {

        // Get current session values
        $sy   = $this->session->userdata('sy');
        $sem  = $this->session->userdata('semester');
        $stud = $this->session->userdata('username');

        // Fetch history filtered by current term
        $history = $this->OPaymentModel->getHistoryByTerm($stud, $sy, $sem);

        // Pass to view
        $data['studentNumber'] = $stud;
        $data['history']       = $history;

        $this->load->view('online_payment_form', $data);
    }



    public function initiate()
    {
        // 1) Collect & validate input
        $studentNumber = trim($this->input->post('studentNumber', true));
        $amountIn      = $this->input->post('amount', true);
        $amount        = number_format((float)$amountIn, 2, '.', '');
        $description   = 'Tuition Fee Payment';
        $email         = $this->session->userdata('email') ?: 'artadybasty@gmail.com'; // TODO: pull real student email

        if (!$studentNumber || (float)$amountIn <= 0 || empty($email)) {
            show_error('Missing or invalid fields.', 400);
        }

        // 2) Create local txn (PENDING)
        // Generate unique reference number
        $refNo = uniqid('SRMS-');

        // Always take StudentNumber from the logged-in session username
        $studentNumber = $this->session->userdata('username');

        // Get current SY and Semester from session
        $sy  = $this->session->userdata('sy');
        $sem = $this->session->userdata('semester');

        // Create payment record
        $this->OPaymentModel->create_payment([
            'StudentNumber' => $studentNumber,   // match DB column case
            'refNo'         => $refNo,
            'description'   => $description,
            'amount'        => (float) $amountIn,
            'status'        => 'PENDING',
            'sy'            => $sy,
            'sem'           => $sem
        ]);


        // 3) Load Dragonpay config (already overridden in __construct)
        $merchantid = $this->config->item('dragonpay_merchantid');
        $password   = $this->config->item('dragonpay_password');
        $payUrl     = rtrim($this->config->item('dragonpay_url'), '/');

        if (!$merchantid || !$password || !$payUrl) {
            show_error('Dragonpay is not configured.', 500);
        }
        if (stripos($payUrl, 'Pay.aspx') === false) {
            $payUrl .= '/Pay.aspx';
        }

        // 4) Build request params
        $params = [
            'merchantid'  => $merchantid,
            'txnid'       => $refNo,
            'amount'      => $amount,           // two decimals, no commas
            'ccy'         => 'PHP',
            'description' => $description,      // keep ASCII/simple to avoid encoding surprises
            'email'       => trim($email),

            // Absolute callback URLs (works with or without index.php)
            'urlsuccess'  => site_url('OnlinePayment/payment_success'),
            'urlcancel'   => site_url('OnlinePayment/payment_cancel'),
            'urlfail'     => site_url('OnlinePayment/payment_cancel'),
            'urlnotify'   => site_url('OnlinePayment/payment_notify'),
        ];

        // 5) Compute digest on RAW (non‑URL‑encoded) values in exact order:
        // sha1( merchantid : txnid : amount : ccy : description : email : password )
        $params['digest'] = sha1(implode(':', [
            $params['merchantid'],
            $params['txnid'],
            $params['amount'],
            $params['ccy'],
            $params['description'],
            $params['email'],
            $password
        ]));

        // (optional) log for debugging (remove in production)
        log_message('error', 'DP URL => ' . $payUrl . '?' . http_build_query($params));

        // 6) Redirect to Dragonpay
        redirect($payUrl . '?' . http_build_query($params));
    }


    public function payment_success()
    {
        $refNo  = $this->input->get('txnid');
        $status = $this->input->get('status');

        if ($refNo && strtoupper($status) === 'S') {
            $this->OPaymentModel->update_payment_status($refNo, 'SUCCESS');
        }
        echo "Payment successful for Ref: {$refNo}";
    }

    public function payment_cancel()
    {
        $refNo = $this->input->get('txnid');
        if ($refNo) {
            $this->OPaymentModel->update_payment_status($refNo, 'CANCELLED');
        }
        echo "Payment cancelled for Ref: {$refNo}";
    }

    public function payment_notify()
    {
        $refNo  = $this->input->get('txnid');
        $status = $this->input->get('status');

        if ($refNo && $status) {
            $map = ['S' => 'SUCCESS', 'P' => 'PENDING', 'F' => 'FAILED', 'C' => 'CANCELLED'];
            $this->OPaymentModel->update_payment_status($refNo, $map[strtoupper($status)] ?? strtoupper($status));
        }
        http_response_code(200);
        echo 'OK';
    }


    public function uploadPayments()
    {
        if ($this->session->userdata('level') !== 'Student') {
            show_error('Access Denied', 403);
            return;
        }

        $studentNumber = $this->input->post('StudentNumber', true);
        $description   = $this->input->post('description', true);
        $amount        = (float) $this->input->post('amount', true);
        $sy            = $this->input->post('sy', true);
        // $sem           = $this->input->post('sem', true);
        $status        = $this->input->post('status', true) ?: 'PENDING';
        $email         = $this->input->post('email', true) ?: $this->session->userdata('email');

        if (!$studentNumber || !$description || $amount <= 0 || !$sy) {
            $this->session->set_flashdata(
                'msg',
                '<div class="alert alert-danger">Missing or invalid fields.</div>'
            );
            redirect('Page/proof_payment');
            return;
        }

        $uploadPath = FCPATH . 'upload/payments/';
        if (!is_dir($uploadPath)) {
            @mkdir($uploadPath, 0755, true);
        }

        // 🔑 Ref No. now prefixed with UPLOAD-
        $refNo = 'UPLOAD-' . strtoupper(uniqid());
        $fileBaseName = $refNo . '_' . date('YmdHis');

        $config = [
            'upload_path'      => $uploadPath,
            'allowed_types'    => 'jpg|jpeg|png|pdf',
            'max_size'         => 5120,
            'file_ext_tolower' => true,
            'remove_spaces'    => true,
            'overwrite'        => false,
            'file_name'        => $fileBaseName
        ];
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('depositAttachment')) {
            $this->session->set_flashdata(
                'msg',
                '<div class="alert alert-danger">Upload failed: ' . $this->upload->display_errors('', '') . '</div>'
            );
            redirect('Page/proof_payment');
            return;
        }

        $uploadData = $this->upload->data();
        $filename   = $uploadData['file_name'];

        $now = date('Y-m-d H:i:s');
        $payload = [
            'StudentNumber'     => $studentNumber,
            'refNo'             => $refNo,
            'description'       => $description,
            'amount'            => $amount,
            'status'            => $status,
            'email'             => $email,
            'sy'                => $sy,
            // 'sem'               => $sem,
            'depositAttachment' => $filename,
            'created_at'        => $now,
            'updated_at'        => $now,
        ];

        $ok = $this->db->insert('online_payments', $payload);

        if ($ok) {
            $this->session->set_flashdata(
                'msg',
                '<div class="alert alert-success">
                Your proof of payment was uploaded successfully.<br>
                <strong>Reference No.:</strong> ' . htmlspecialchars($refNo) . '
             </div>'
            );
        } else {
            @unlink($uploadPath . $filename);
            $this->session->set_flashdata(
                'msg',
                '<div class="alert alert-danger">Failed to save payment record. Please try again.</div>'
            );
        }

        redirect('Page/proof_payment');
    }
}
