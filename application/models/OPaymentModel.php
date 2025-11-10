<?php
defined('BASEPATH') or exit('No direct script access allowed');

class OPaymentModel extends CI_Model
{
    public function create_payment($data)
    {
        $this->db->insert('online_payments', $data);
        return $this->db->insert_id();
    }

    public function update_payment_status($refNo, $status)
    {
        $this->db->where('refNo', $refNo)
            ->update('online_payments', ['status' => $status]);
    }

    public function get_payment_by_ref($refNo)
    {
        return $this->db->get_where('online_payments', ['refNo' => $refNo])->row();
    }

    /**
     * Get Dragonpay credentials from o_srms_settings table
     */
    public function getDragonpaySettings()
    {
        $row = $this->db->select('dragonpay_merchantid, dragonpay_password, dragonpay_url')
            ->from('srms_settings_o')
            ->order_by('settingsID', 'DESC') // latest row if multiple
            ->limit(1)
            ->get()
            ->row_array();

        return $row ?: [];
    }

    public function getHistoryByTerm($studentNumber, $sy, $sem)
    {
        return $this->db->select('id, refNo, description, amount, status, email, created_at, sy, sem')
            ->from('online_payments')
            ->where('StudentNumber', $studentNumber)
            ->where('sy', $sy)
            ->where('sem', $sem)
            ->order_by('created_at', 'DESC')
            ->get()->result();
    }
}
