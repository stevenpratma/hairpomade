<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('level') != '2') {
            redirect('welcome');
        }
    }

    public function index()
    {
        $data['title'] = 'Dashboard User';
        $data['product'] = $this->model_pembayaran->get('product')->result();
        $this->load->view('layout/user/header', $data);
        $this->load->view('dashboard', $data);
        $this->load->view('layout/user/footer');
    }

    public function cart($id)
    {
        $product = $this->model_pembayaran->find($id);
        $qty = $this->input->post('qty'); // Ambil jumlah stok dari form

        $data = array(
            'id'      => $product->id_brg,
            'qty'     => $qty, // Menggunakan jumlah stok dari form
            'price'   => $product->harga,
            'name'    => $product->nama_brg,
            'options' => array(
                'keterangan' => $product->keterangan,
                'kategori' => $product->kategori,
                'gambar' => $product->gambar
            )
        );

        $this->cart->insert($data);
        
        // Log atau debugging
        log_message('debug', 'Product added to cart: ' . json_encode($data));

        $_SESSION["sukses"] = 'Pesanan telah disimpan di keranjang';
        redirect('dashboard');
    }

    public function detail_cart()
    {
        $data['title'] = 'Detail Cart';
        $this->load->view('layout/user/header', $data);
        $this->load->view('cart', $data);
        $this->load->view('layout/user/footer');
    }

    public function checkout()
    {
        $data['title'] = 'Checkout Product';
        $this->load->view('layout/user/header', $data);
        $this->load->view('checkout', $data);
        $this->load->view('layout/user/footer');
    }

    public function checkout_proccess()
    {
        $data['title'] = 'Payment Notification';
        $is_processed = $this->model_invoice->index();
        if ($is_processed) {
            $this->cart->destroy();
            $this->load->view('layout/user/header', $data);
            $this->load->view('success_pay', $data);
            $this->load->view('layout/user/footer');
        } else {
            echo "Maaf, Pesanan Anda Gagal Di Proses!";
        }
    }

    public function clear()
    {
        $this->cart->destroy();
        $_SESSION["sukses"] = 'Pesanan berhasil di hapus';
        redirect('dashboard');
    }
}
