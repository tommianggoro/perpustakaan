<?php
class M_Pengembalian extends CI_Model {
    
    function cariTransaksi($no) {
        $this->db->select('transaksi.*, cabang.nama');
        $this->db->where('id_transaksi', $no);
        $this->db->where('tanggal_kembali', 0);
        $this->db->join('cabang','cabang.kode = transaksi.id_cabang');
        return $this->db->get('transaksi');

        /**
        $query = $this->db->query("select a.*,b.nama from transaksi a,
                                anggota b
                                where a.id_transaksi='$no' and a.id_transaksi
                                not in(select id_transaksi from pengembalian)
                                and a.nis=b.nis");
        return $query;
        **/
    }
    
    function tampilBuku($no) {
        $query = $this->db->query("select a.*,b.judul,b.pengarang
                                from transaksi a,buku b
                                where a.id_transaksi='$no' and
                                a.id_transaksi not in(select id_transaksi from pengembalian)
                                and a.kode_buku=b.kode_buku");
        return $query;
    }

    function tampilBarang($no) {
        $this->db->where('id_transaksi', $no);
        $this->db->join('barang','barang.kode_barang = transaksi_detail.kode_barang');
        $query = $this->db->get('transaksi_detail');
        return $query;
    }
    
    function simpan($info) {
        $this->db->insert("pengembalian", $info);
    }
    
    function update($no, $update) {
        $this->db->where("id_transaksi", $no);
        $this->db->update("transaksi", $update);
    }
    
    function cari_by_nis($nis) {
        $query = $this->db->query("select * from transaksi where id_transaksi
                                not in(select id_transaksi from pengembalian)
                                and nis like'%$nis%' group by nis");
        return $query;
    }

    function cari_by_kode($kode){
        $this->db->where('id_cabang', $kode);
        $this->db->where('tanggal_kembali', 0);
        $q = $this->db->get('transaksi');
        if($q->num_rows() > 0){
            return $q->result();
        }
        return false;
    }
}
