<?php
class M_Peminjaman extends CI_Model {
    private $table = "transaksi";
    
    function nootomatis() {
        $today = date('Ymd');
        
        // $query = mysql_query("select max(id_transaksi) as last from transaksi where id_transaksi like '$today%'");
        // $data = mysql_fetch_array($query);
        $query = $this->db->query("select max(id_transaksi) as last from transaksi where id_transaksi like '$today%'");
        $data = $query->row_array();
        
        $lastNoFaktur = $data['last'];
        
        $lastNoUrut = substr($lastNoFaktur, 8, 3);
        
        $nextNoUrut = $lastNoUrut + 1;
        
        $nextNoTransaksi = $today . sprintf('%03s', $nextNoUrut);
        
        return $nextNoTransaksi;
    }
    
    function getAnggota() {
        return $this->db->get("anggota");
    }
    
    function cariAnggota($nis) {
        $this->db->where("nis", $nis);
        return $this->db->get("anggota");
    }

    function cariCabang($nis) {
        $this->db->where("kode", $nis);
        return $this->db->get("cabang");
    }

    function getCabang() {
        return $this->db->get("cabang");
    }
    
    function cariBuku($kode) {
        $this->db->where("kode_buku", $kode);
        return $this->db->get("buku");
    }

    function cariBarang($kode) {
        $this->db->where("kode_barang", $kode);
        $this->db->join("type","type.id = barang.type");
        return $this->db->get("barang");
    }
    
    function simpanTmp($info) {
        $this->db->insert("tmp", $info);
    }
    
    function tampilTmp($id) {
        $this->db->select('type.nama, tmp_detail.*');
        $this->db->where('tmp_id', $id);
        $this->db->join("type","type.id = tmp_detail.type");
        return $this->db->get("tmp_detail");
    }
    
    function cekTmp($id, $date) {
        $this->db->where("id_user", $id);
        $this->db->where("created", $date);
        return $this->db->get("tmp");
    }
    
    function jumlahTmp() {
        return $this->db->count_all("tmp");
    }
    
    function hapusTmp($kode) {
        $this->db->where("kode_barang", $kode);
        $this->db->delete("tmp");
    }
    
    function simpan($info) {
        $this->db->insert("transaksi", $info);
    }
    
    function pencarianbuku($cari) {
        $this->db->like("judul", $cari);
        return $this->db->get("buku");
    }

    function pencarianbarang($cari) {
        $this->db->like("judul", $cari);
        return $this->db->get("buku");
    }
}
