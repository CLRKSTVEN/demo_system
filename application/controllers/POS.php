<?php

class POS extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('POSModel');
    }

    public function index()
    {
        $data['inventory'] = $this->POSModel->get_inventory();
        $this->load->view('pos/index', $data);
    }

    public function purchase()
    {
        $student_number = $this->input->post('StudentNumber');
        $item_id = $this->input->post('item_id');
        $quantity = $this->input->post('quantity');

        $this->POSModel->process_purchase($student_number, $item_id, $quantity);
        redirect('pos');
    }

    public function reload_card()
    {
        $student_number = $this->input->post('StudentNumber');
        $amount = $this->input->post('amount');
        $this->POSModel->reload_card($student_number, $amount);
        redirect('pos');
    }

    public function inventory()
    {
        $data['inventory'] = $this->POSModel->get_inventory();
        $this->load->view('pos/inventory', $data);
    }
}
