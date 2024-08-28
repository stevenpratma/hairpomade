<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Change_password extends CI_Controller
{
    public function index()
    {
        $data['title'] = 'Change Password';
        $this->load->view('layout/user/header', $data);
        $this->load->view('change_password', $data);
        $this->load->view('layout/user/footer');
    }

    public function process()
    {
        $new_password = $this->input->post('new_password');
        $confirm_password = $this->input->post('confirm_password');

        $this->form_validation->set_rules('new_password', 'New Password', 'required|matches[confirm_password]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required');

        if ($this->form_validation->run() != FALSE) {
            // Enkripsi password baru menggunakan MD5
            $encrypted_password = md5($new_password);

            // Update password di database
            $data = array('password' => $encrypted_password);
            $id = array('email' => $this->session->userdata('email'));

            $this->model_pembayaran->update('user', $data, $id);

            // Update password email (misalnya mengupdate password email yang tersimpan di database)
            // Tambahkan logika untuk update password email di sini jika diperlukan

            redirect('welcome');
        } else {
            $data['title'] = 'Change Password';
            $this->load->view('layout/user/header', $data);
            $this->load->view('change_password', $data);
            $this->load->view('layout/user/footer');
        }
    }
}
