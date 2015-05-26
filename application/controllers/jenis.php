<?php
class Jenis extends CI_Controller {
    private $limit = 20;
    
    function __construct() {
        parent::__construct();
        $this->load->library(array('template', 'form_validation', 'pagination', 'upload'));
        $this->load->model('m_jenis');
        
        if (!$this->session->userdata('username')) {
            redirect('web');
        }
        $this->m_peminjaman->deleteTmp();
    }
    
    function index($offset = 0, $order_column = 'id', $order_type = 'asc') {
        if (empty($offset)) $offset = 0;
        if (empty($order_column)) $order_column = 'id';
        if (empty($order_type)) $order_type = 'asc';
        
        //load data
        $data['jenis'] = $this->m_jenis->semua($this->limit, $offset, $order_column, $order_type)->result();
        $data['title'] = "Data Jenis";
        
        $config['base_url'] = site_url('jenis/index/');
        $config['total_rows'] = $this->m_jenis->jumlah();
        $config['per_page'] = $this->limit;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        
        if ($this->uri->segment(3) == "delete_success") $data['message'] = "<div class='alert alert-success'>Data berhasil dihapus</div>";
        else if ($this->uri->segment(3) == "add_success") $data['message'] = "<div class='alert alert-success'>Data Berhasil disimpan</div>";
        else $data['message'] = '';
        $this->template->display('jenis/index', $data);
    }
    
    function tambah() {
        $data['title'] = "Tambah Jenis";
        $this->_set_rules();
        if ($this->form_validation->run() == true) {
            $info = array('nama' => $this->input->post('name'), 'dibuat' => time());
            $this->m_jenis->simpan($info);
            redirect('jenis/index/add_success');
        } 
        else {
            $data['message'] = "";
            $this->template->display('jenis/tambah', $data);
        }
    }
    
    function edit($id) {
        $data['title'] = "Edit data Jenis";
        $this->_set_rules();
        if ($this->form_validation->run() == true) {
           
            $info = array('nama' => $this->input->post('name'), 'dibuat' => time());
            $this->m_jenis->update($id, $info);
            
            $data['jenis'] = $this->m_jenis->cek($id)->row_array();
            $data['message'] = "<div class='alert alert-success'>Data berhasil diupdate</div>";
            redirect('jenis');
        } 
        else {
            $data['message'] = "";
            $data['jenis'] = $this->m_jenis->cek($id)->row_array();
            $this->template->display('jenis/edit', $data);
        }
    }
    
    function hapus() {
        $kode = $this->input->post('kode');
        $this->m_jenis->hapus($kode);
    }
    
    function cari() {
        $data['title'] = "Pencairan";
        $cari = $this->input->post('cari');
        $cek = $this->m_jenis->cari($cari);
        if ($cek->num_rows() > 0) {
            $data['message'] = "";
            $data['jenis'] = $cek->result();
            $data['cari'] = $cari;
            $this->template->display('jenis/cari', $data);
        } 
        else {
            $data['message'] = "<div class='alert alert-success'>Data tidak ditemukan</div>";
            $data['jenis'] = $cek->result();
            $this->template->display('jenis/cari', $data);
        }
    }
    
    function _set_rules() {
        $this->form_validation->set_rules('name', 'Nama', 'required|max_length[255]');
        $this->form_validation->set_error_delimiters("<div class='alert alert-danger'>", "</div>");
    }
}
