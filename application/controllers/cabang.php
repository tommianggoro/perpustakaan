<?php
class Cabang extends CI_Controller{
    private $limit=20;
    
    function __construct(){
        parent::__construct();
        $this->load->library(array('template','pagination','form_validation','upload'));
        $this->load->model('m_cabang');
        
        if(!$this->session->userdata('username')){
            redirect('web');
        }
    }
    
    function index($offset=0,$order_column='dibuat',$order_type='asc'){
        if(empty($offset)) $offset=0;
        if(empty($order_column)) $order_column='dibuat';
        if(empty($order_type)) $order_type='asc';
        
        //load data
        $data['cabang']=$this->m_cabang->semua($this->limit,$offset,$order_column,$order_type)->result();
        $data['title']="Data Cabang";
        
        $config['base_url']=site_url('cabang/index/');
        $config['total_rows']=$this->m_cabang->jumlah();
        $config['per_page']=$this->limit;
        $config['uri_segment']=3;
        $this->pagination->initialize($config);
        $data['pagination']=$this->pagination->create_links();
        
        
        if($this->uri->segment(3)=="delete_success")
            $data['message']="<div class='alert alert-success'>Data berhasil dihapus</div>";
        else if($this->uri->segment(3)=="add_success")
            $data['message']="<div class='alert alert-success'>Data Berhasil disimpan</div>";
        else
            $data['message']='';
            $this->template->display('cabang/index',$data);
    }
    
    
    function edit($id){
        $data['title']="Edit Data Cabang";
        $this->_set_rules();
        if($this->form_validation->run()==true){
            $info=array(
                'kode'=>$this->input->post('kode'),
                'nama'=>$this->input->post('nama'),
                'uker'=>$this->input->post('uker'),
                'pic'=>$this->input->post('pic')
            );
            //update data angggota
            $this->m_cabang->update($id,$info);
            
            //tampilkan pesan
            $data['message']="<div class='alert alert-success'>Data Berhasil diupdate</div>";
            
            //tampilkan data cabang 
            $data['cabang']=$this->m_cabang->cek($id)->row_array();
            redirect('cabang');
            $this->template->display('cabang/edit',$data);
        }else{
            $data['cabang']=$this->m_cabang->cek($id)->row_array();
            $data['message']="";
            $this->template->display('cabang/edit',$data);
        }
    }
    
    
    function tambah(){
        $data['title']="Tambah Data Cabang";
        $this->_set_rules();
        if($this->form_validation->run()==true){
            $nis=$this->input->post('kode');
            $cek=$this->m_cabang->cek($nis);
            if($cek->num_rows()>0){
                $data['message']="<div class='alert alert-warning'>Kode sudah digunakan</div>";
                $this->template->display('cabang/tambah',$data);
            }else{                
                $info=array(
                    'kode'=>$this->input->post('kode'),
                    'nama'=>$this->input->post('nama'),
                    'uker'=>$this->input->post('uker'),
                    'pic'=>$this->input->post('pic'),
                    'dibuat' => time()
                );
                $this->m_cabang->simpan($info);
                redirect('cabang/index/add_success');
            }
        }else{
            $data['message']="";
            $this->template->display('cabang/tambah',$data);
        }
    }
    
    
    function hapus(){
        $kode=$this->input->post('kode');
        $detail=$this->m_cabang->cek($kode)->result();
	foreach($detail as $det):
	    unlink("assets/img/cabang/".$det->image);
	endforeach;
        $this->m_cabang->hapus($kode);
    }
    
    function cari(){
        $data['title']= "Pencarian";
        $data['cari'] = $cari=$this->input->post('cari');
        $cek=$this->m_cabang->cari($cari);
        if($cek->num_rows()>0){
            $data['message']="";
            $data['cabang']=$cek->result();
            $this->template->display('cabang/cari',$data);
        }else{
            $data['message']="<div class='alert alert-success'>Data tidak ditemukan</div>";
            $data['cabang']=$cek->result();
            $this->template->display('cabang/cari',$data);
        }
    }
    
    function _set_rules(){
        $this->form_validation->set_rules('kode','Kode','required|max_length[10]');
        $this->form_validation->set_rules('nama','Nama','required');
        $this->form_validation->set_rules('uker','Uker','required');
        $this->form_validation->set_rules('pic','PIC','required');
        $this->form_validation->set_error_delimiters("<div class='alert alert-danger'>","</div>");
    }
}