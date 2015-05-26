<?php
class Pengembalian extends CI_Controller {
    //code
    
    function __construct() {
        parent::__construct();
        $this->load->library(array('template', 'form_validation'));
        $this->load->model('m_pengembalian');
        
        if (!$this->session->userdata('username')) {
            redirect('web');
        }
        $this->m_peminjaman->deleteTmp();
    }
    
    function index() {
        $data['title'] = "Pengembalian Buku";
        $data['tanggal'] = date('Y-m-d');
        $this->template->display('pengembalian/index', $data);
    }
    
    function cariTransaksi() {
        $no = $this->input->post('no');
        $transaksi = $this->m_pengembalian->cariTransaksi($no);
        $ret['code'] = 500;
        $ret['result'] = array();
        if ($transaksi->num_rows() > 0) {
            $ret['result'] = $transaksi->row_array();
            $ret['result']['tanggal_pinjam'] = date('d-m-Y',$ret['result']['tanggal_pinjam']);
            $ret['code'] = 200;
        }

        echo json_encode($ret);exit;
    }
    
    function tampil() {
        $no = $_GET['no'];
        $data['barang'] = $this->m_pengembalian->tampilBarang($no)->result();
        $transaksi = $this->m_pengembalian->cariTransaksi($no)->row_array();
        
        $this->load->view('pengembalian/tampilbuku', $data);
    }
    
    function simpan() {
        $ret['code'] = 500;
        $idTrans = $this->input->post('no');
        $tglKembali = time();

        $cek = $this->db->update('transaksi', array('tanggal_kembali' => $tglKembali), array('id_transaksi' => $idTrans));
        if($cek){
            $this->db->where('id_transaksi', $idTrans);
            $get = $this->db->get('transaksi_detail')->result();
            foreach ($get as $key => $value) {
                $this->_plusBarang($value->kode_barang, $value->jumlah);
            }
            $ret['code'] = 200;
        }
        echo json_encode($ret);exit;
    }
    
    function cari_by_nis() {
        $nis = $this->input->post('nis');
        $data['pencarian'] = $this->m_pengembalian->cari_by_nis($nis)->result();
        $this->load->view('pengembalian/pencarian', $data);
    }

    function cari_by_kode() {
        $nis = $this->input->post('nis');
        $data['pencarian'] = $this->m_pengembalian->cari_by_kode($nis);
        $this->load->view('pengembalian/pencarian', $data);
    }

    private function _minBarang($kode, $jumlah = 1){
        return $this->db->query("Update barang set jumlah_tmp = jumlah_tmp - $jumlah where kode_barang = '$kode'");
    }

    private function _plusBarang($kode, $jumlah = 1){
        return $this->db->query("Update barang set jumlah_tmp = jumlah_tmp + $jumlah where kode_barang = '$kode'");
    }
}
