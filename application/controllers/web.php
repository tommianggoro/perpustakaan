<?php
class Web extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->model(array('m_buku','m_anggota','m_petugas'));
        if($this->session->userdata('username')){
            redirect('dashboard');
        }
    }
    
    function index(){
        $this->load->view('web/index');
    }
    
    function cari_buku(){
        $cari=$this->input->post('cari');
        $data['hasil']=$this->m_buku->cari($cari)->result();
        $data['title']="Pencarian Buku";
        $this->load->view('web/cari_buku',$data);
    }
    
    function anggota(){
        $data['title']="Data Anggota";
        $data['anggota']=$this->m_anggota->semua()->result();
        $this->load->view('web/anggota',$data);
    }
    
    function cari_anggota(){
        $cari=$this->input->post('cari');
        $data['title']="Data Anggota";
        $data['anggota']=$this->m_anggota->cari($cari)->result();
        $this->load->view('web/anggota',$data);
    }
}