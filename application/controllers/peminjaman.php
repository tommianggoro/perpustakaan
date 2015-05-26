<?php
class Peminjaman extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->library(array('form_validation', 'template'));
        $this->load->model('m_peminjaman');
        
        if (!$this->session->userdata('username')) {
            redirect('/');
        }
    }
    
    function index() {
        $data['title'] = "Transaksi Peminjaman";
        $data['tanggalpinjam'] = date('Y-m-d');
        $data['tanggalkembali'] = strtotime('+7 day', strtotime($data['tanggalpinjam']));
        $data['noauto'] = $this->m_peminjaman->nootomatis();
        $data['anggota'] = $this->m_peminjaman->getCabang()->result();
        $data['tanggalkembali'] = date('Y-m-d', $data['tanggalkembali']);
        $this->template->display('peminjaman/index', $data);
    }

    function tampil(){
        $tmp = $this->m_peminjaman->cekTmp($this->session->userdata('id'), strtotime(date('Y-m-d')));
        $data['tmp'] = false;
        $data['idTemp'] = '';
        if($tmp->num_rows() > 0){
            $id = $tmp->row()->id;
            $data['idTemp'] = $id;
            $data['tmp'] = $this->m_peminjaman->tampilTmp($id)->result();
        }
        $data['jumlahTmp'] = $this->m_peminjaman->jumlahTmp();
        $this->load->view('peminjaman/tampil',$data);
    }
    
    function sukses() {
        $userId = $this->session->userdata('id');
        $date = strtotime(date('Y-m-d'));
        $cek = $this->m_peminjaman->cekTmp($userId, $date);
        $ret['code'] = 500;
        $ret['result'] = 'Ooops.. Something wrong.';
        if($cek->num_rows() > 0){
            $insTrans = array(
                'id_transaksi' => $this->input->post('nomer'),
                'id_cabang' => $this->input->post('idCabang'),
                'tanggal_pinjam' => strtotime($this->input->post('pinjam')),
                'id_petugas' => $userId,
                'created' => time()
            );

            $this->db->insert('transaksi', $insTrans);

            $idTemp = $cek->row()->id;
            $tmp = $this->m_peminjaman->tampilTmp($idTemp)->result();
            foreach ($tmp as $key => $value) {
                if($value->jumlah > 0){
                    $insTransD = array(
                        'id_transaksi' => $insTrans['id_transaksi'],
                        'kode_barang' => $value->kode_barang,
                        'jumlah' => $value->jumlah
                    );
                    $last = $this->db->insert('transaksi_detail', $insTransD);
                    if($last){
                        $x = $this->_minBarang($insTransD['kode_barang'], $insTransD['jumlah']);
                        if($x){
                            $this->db->delete('tmp_detail',array('id' => $value->id));
                            $ret['code'] = 200;
                            $ret['result'] = 'Success';
                        }
                    }
                }
            }
            if($ret['code'] == 200){
                $this->db->delete('tmp',array('id' => $idTemp));
            }
        }

        echo json_encode($ret);exit;
    }

    function checkStock(){
        $userId = $this->session->userdata('id');
        $date = strtotime(date('Y-m-d'));
        $cek = $this->m_peminjaman->cekTmp($userId, $date);
        $ret['code'] = 500;
        $ret['result'] = 'Ooops.. Something wrong.';
        if($cek->num_rows() > 0){
            $idTemp = $cek->row()->id;
            $tmp = $this->m_peminjaman->tampilTmp($idTemp)->result();
            foreach ($tmp as $key => $value) {
                if($value->jumlah > 0){
                    $item = $this->_checkStokBarang($value->kode_barang);
                    if(!$item){
                        $ret['code'] = 502;
                        $ret['result'] = 'Barang dengan kode '.$value->kode_barang.' sudah kehabisan stock.';
                        break;
                    }else{
                        $ret['code'] = 200;
                        $ret['result'] = 'Success';
                    }
                }
            }
        }

        echo json_encode($ret);exit;
    }
    
    function simpan() {
        $tmp = $this->m_peminjaman->tampilTmp()->result();
        foreach ($tmp as $row) {
            $info = array('id_transaksi' => $this->input->post('nomer'), 'nis' => $this->input->post('nis'), 'kode_buku' => $row->kode_buku, 'tanggal_pinjam' => $this->input->post('pinjam'), 'tanggal_kembali' => $this->input->post('kembali'), 'status' => "N");
            $this->m_peminjaman->simpan($info);
            
            //hapus data di temp
            $this->m_peminjaman->hapusTmp($row->kode_buku);
        }
    }
    
    function cariAnggota() {
        $nis = $this->input->post('nis');
        $anggota = $this->m_peminjaman->cariAnggota($nis);
        if ($anggota->num_rows() > 0) {
            $anggota = $anggota->row_array();
            echo $anggota['nama'];
        }
    }

    function cariCabang() {
        $kode = $this->input->post('kode');
        $anggota = $this->m_peminjaman->cariCabang($kode);
        if ($anggota->num_rows() > 0) {
            $anggota = $anggota->row_array();
            var_dump($anggota);exit;
            echo $anggota['nama'];
        }
    }
    
    function cariBuku() {
        $kode = $this->input->post('kode');
        $buku = $this->m_peminjaman->cariBuku($kode);
        if ($buku->num_rows() > 0) {
            $buku = $buku->row_array();
            echo $buku['judul'] . "|" . $buku['pengarang'];
        }
    }

    function cariBarang() {
        $kode = $this->input->post('kode');
        $buku = $this->m_peminjaman->cariBarang($kode);
        $ret['code'] = 500;
        if ($buku->num_rows() > 0) {
            $ret['code'] = 200;
            $ret['result'] = $buku->row();
        }
        echo json_encode($ret);exit;
    }    
    
    function tambah() {
        $userId = $this->session->userdata('id');
        $date = strtotime(date('Y-m-d'));
        $cek = $this->m_peminjaman->cekTmp($userId, $date);
        
        $ret['code'] = 500;
        $ret['result'] = 'Ooops.. Something wrong';
        $kodeBarang = $this->input->post('kode');
        $check = $this->_checkStokBarang($kodeBarang);
        if($check){
            if ($cek->num_rows() < 1) {
                $tmp = array(
                    'id_user' => $userId,
                    'created' => $date
                );
                $lastId = $this->db->insert('tmp', $tmp);

            }else{
                $row = $cek->row();
                $lastId = $row->id;                      
            }

            $this->db->where('tmp_id', $lastId);
            $this->db->where('kode_barang', $kodeBarang);
            $q = $this->db->get('tmp_detail');
            if($q->num_rows() < 1){
                $info = array(
                    'tmp_id' => $lastId,
                    'kode_barang' => $kodeBarang, 
                    'merk' => $this->input->post('merk'), 
                    'type' => $this->input->post('type'), 
                    'jenis' => $this->input->post('jenis'),
                    'jumlah' => 1
                ); 
                $cek_ = $this->db->insert('tmp_detail', $info);
                if($cek_){
                    $ret['result'] = 'Sukses.';
                    $ret['code'] = 200;
                }
            }else{
                $ret['code'] = 501;
                $ret['result'] = 'Barang sudah terdapat di list.';
            }
        }else{
            $ret['code'] = 502;
            $ret['result'] = 'Ooops.. Stock Barang sudah habis.';
        }

        echo json_encode($ret);exit;
    }
    
    function hapus() {
        $kode = $this->input->post('kode');
        $this->db->delete('tmp_detail',array('id' => $kode));
        // $this->m_peminjaman->hapusTmp($kode);
    }
    
    function pencarianbuku() {
        $cari = $this->input->post('caribuku');
        $data['buku'] = $this->m_peminjaman->pencarianbuku($cari)->result();
        $this->load->view('peminjaman/pencarianbuku', $data);
    }

    function pencarianbarang() {
        $cari = $this->input->post('caribuku');
        $data['buku'] = $this->m_peminjaman->pencarianbuku($cari)->result();
        $this->load->view('peminjaman/pencarianbuku', $data);
    }

    private function _minBarang($kode, $jumlah = 1){
        return $this->db->query("Update barang set jumlah_tmp = jumlah_tmp - $jumlah");
    }

    private function _plusBarang($kode, $jumlah = 1){
        return $this->db->query("Update barang set jumlah_tmp = jumlah_tmp + $jumlah");
    }

    private function _checkStokBarang($kodeBarang){
        $this->db->where('kode_barang', $kodeBarang);
        $q = $this->db->get('barang');
        if($q->num_rows() > 0){
            $row = $q->row();
            if($row->jumlah_tmp <= 0){
                return false;
            }else{
                return $row->jumlah_tmp;
            }
        }
        return false;
    }

    function updateTmp(){
        $id = $this->input->post('id');
        $jumlah = $this->input->post('jumlah');
        $kodeBarang = $this->input->post('kode_barang');
        $check = $this->_checkStokBarang($kodeBarang);
        
        $ret['code'] = 500;
        $ret['result'] = "Ooops.. Something's wrong.";
        if($check){
            if($check >= $jumlah){
                $ret['code'] = 200;
                $ret['result'] = "Sukses.";
                $this->db->update('tmp_detail', array('jumlah' => $jumlah), array('id' => $id));
            }else{
                $ret['code'] = 502;
                $ret['result'] = "Ooops.. Barang sisa : ".$check;
            }
        }

        echo json_encode($ret);exit;
    }
}
