<?php
class M_jenis extends CI_Model {
    private $table = "type";
    private $primary = "id";
    
    function semua($limit = 10, $offset = 0, $order_column = '', $order_type = 'asc') {
        if (empty($order_column) || empty($order_type)) $this->db->order_by($this->primary, 'asc');
        else $this->db->order_by($order_column, $order_type);
        return $this->db->get($this->table, $limit, $offset);
    }
    
    function jumlah() {
        return $this->db->count_all($this->table);
    }
    
    function cek($kode) {
        $this->db->where($this->primary, $kode);
        $query = $this->db->get($this->table);
        
        return $query;
    }
    
    function simpan($jenis) {
        $this->db->insert($this->table, $jenis);
        return $this->db->insert_id();
    }
    
    function update($kode, $jenis) {
        $this->db->where($this->primary, $kode);
        $this->db->update($this->table, $jenis);
    }
    
    function hapus($kode) {
        $this->db->where($this->primary, $kode);
        $this->db->delete($this->table);
    }
    
    function cari($cari) {
        $this->db->like("nama", $cari);
        return $this->db->get($this->table);
    }

    function getAll(){
        $q = $this->db->get($this->table);
        if($q->num_rows() > 0)
            return $q->result();
        return false;
    }
}
