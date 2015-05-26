<?php
class M_Laporan extends CI_Model{
    #code
    
    function semuaAnggota(){
        return $this->db->get("anggota");
    }
    
    function semuaBuku(){
        return $this->db->get("buku");
    }
    
    function detailpeminjaman($tanggal1,$tanggal2){
        $this->db->where('tanggal_pinjam >=', $tanggal1);
        $this->db->where('tanggal_pinjam <=', $tanggal2);
        $this->db->join('cabang','cabang.kode = transaksi.id_cabang');
        return $this->db->get('transaksi');
    }
    
    function detail_pinjam($id){
        $this->db->where("transaksi.id_transaksi",$id);
        $this->db->join('transaksi_detail','transaksi_detail.id_transaksi = transaksi.id_transaksi');
        $this->db->join('barang','barang.kode_barang = transaksi_detail.kode_barang');
        return $this->db->get('transaksi');
    }
    
    function detailpengembalian($tanggal1,$tanggal2){
        $this->db->where('tanggal_pinjam >=', $tanggal1);
        $this->db->where('tanggal_pinjam <=', $tanggal2);
        $this->db->where('tanggal_kembali >',0);
        $this->db->join('cabang','cabang.kode = transaksi.id_cabang');
        return $this->db->get('transaksi');
    }
}
