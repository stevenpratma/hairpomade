<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Change_password_admin extends CI_Controller
{

    public function index()
    {
        $data['title'] = 'Change Password';
        $this->load->view('layout/admin/header', $data);
        $this->load->view('change_password_admin', $data);
        $this->load->view('layout/admin/footer');
    }

    public function process()
    {
        $new_password = $this->input->post('new_password');
        $confirm_password = $this->input->post('confirm_password');

        $this->form_validation->set_rules('new_password', 'New Password', 'required|matches[confirm_password]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required');

        if ($this->form_validation->run() != FALSE) {
            $data = array('password' => $new_password);
            $id = array('id_user' => $this->session->userdata('id_user'));

            $this->model_pembayaran->update('user', $data, $id);
            redirect('welcome');
        } else {
            $data['title'] = 'Change Password';
            $this->load->view('layout/admin/header', $data);
            $this->load->view('change_password_admin', $data);
            $this->load->view('layout/admin/footer');
        }
    }
}
