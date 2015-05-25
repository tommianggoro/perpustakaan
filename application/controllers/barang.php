<?php
class Barang extends CI_Controller {
    private $limit = 20;
    
    function __construct() {
        parent::__construct();
        $this->load->library(array('template', 'form_validation', 'pagination', 'upload'));
        $this->load->model('m_barang');
        
        if (!$this->session->userdata('username')) {
            redirect('web');
        }
    }
    
    function index($offset = 0, $order_column = 'kode_barang', $order_type = 'asc') {
        if (empty($offset)) $offset = 0;
        if (empty($order_column)) $order_column = 'kode_barang';
        if (empty($order_type)) $order_type = 'asc';
        
        //load data
        $data['barang'] = $this->m_barang->semua($this->limit, $offset, $order_column, $order_type)->result();
        $data['title'] = "Data Barang";
        
        $config['base_url'] = site_url('anggota/index/');
        $config['total_rows'] = $this->m_barang->jumlah();
        $config['per_page'] = $this->limit;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        
        if ($this->uri->segment(3) == "delete_success") $data['message'] = "<div class='alert alert-success'>Data berhasil dihapus</div>";
        else if ($this->uri->segment(3) == "add_success") $data['message'] = "<div class='alert alert-success'>Data Berhasil disimpan</div>";
        else $data['message'] = '';
        $this->template->display('barang/index', $data);
    }
    
    function tambah() {
        $data['title'] = "Tambah Barang";
        $this->_set_rules();
        if ($this->form_validation->run() == true) {
             //jika validasi dijalankan dan benar
            $kode = $this->input->post('kode');
             // mendapatkan input dari kode
            $cek = $this->m_barang->cek($kode);
             // cek kode di database
            if ($cek->num_rows() > 0) {
                 // jika kode sudah ada, maka tampilkan pesan
                $data['message'] = "<div class='alert alert-danger'>Kode Barang sudah ada</div>";
                $this->template->display('barang/tambah', $data);
            } 
            else {
                $info = array(
                    'kode_barang' => $this->input->post('kode'), 
                    'type' => $this->input->post('type'), 
                    'merk' => $this->input->post('merk'), 
                    'jenis' => $this->input->post('jenis'),
                    'dibuat' => time()
                );
                $this->m_barang->simpan($info);
                redirect('barang/index/add_success');
            }
        } 
        else {
            $data['message'] = "";
            $this->template->display('barang/tambah', $data);
        }
    }
    
    function edit($id) {
        $data['title'] = "Edit data Barang";
        $this->_set_rules();
        if ($this->form_validation->run() == true) {
            $kode = $this->input->post('kode');
            
            $info = array(
                    'kode_barang' => $this->input->post('kode'), 
                    'type' => $this->input->post('type'), 
                    'merk' => $this->input->post('merk'), 
                    'jenis' => $this->input->post('jenis'),
                    'dibuat' => time()
                );
            $this->m_barang->update($kode, $info);
            
            $data['barang'] = $this->m_barang->cek($id)->row_array();
            $data['message'] = "<div class='alert alert-success'>Data berhasil diupdate</div>";
            redirect('barang');
        } 
        else {
            $data['message'] = "";
            $data['barang'] = $this->m_barang->cek($id)->row_array();
            $this->template->display('barang/edit', $data);
        }
    }
    
    function hapus() {
        $kode = $this->input->post('kode');
        $detail = $this->m_barang->cek($kode)->result();
        foreach ($detail as $det):
            unlink("assets/img/" . $det->image);
        endforeach;
        $this->m_barang->hapus($kode);
    }
    
    function cari() {
        $data['title'] = "Pencairan";
        $cari = $this->input->post('cari');
        $cek = $this->m_barang->cari($cari);
        if ($cek->num_rows() > 0) {
            $data['message'] = "";
            $data['barang'] = $cek->result();
            $data['cari'] = $cari;
            $this->template->display('barang/cari', $data);
        } 
        else {
            $data['message'] = "<div class='alert alert-success'>Data tidak ditemukan</div>";
            $data['barang'] = $cek->result();
            $this->template->display('barang/cari', $data);
        }
    }
    
    function _set_rules() {
        $this->form_validation->set_rules('kode', 'Kode Barang', 'required|max_length[5]');
        $this->form_validation->set_rules('type', 'Type Barang', 'required|max_length[100]');
        $this->form_validation->set_rules('jenis', 'Jenis', 'required|max_length[100]');
        $this->form_validation->set_rules('merk', 'Merk', 'required|max_length[100]');
        $this->form_validation->set_error_delimiters("<div class='alert alert-danger'>", "</div>");
    }
}
