<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangKeluarDetailModel extends Model
{
    protected $table            = 'table_detail_barang_keluar';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['barang_keluar','barang','qty','harga_jual','harga_beli','subtotal'];

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getBarangKeluar($tanggal = null)
    {
        $result = $this->db->table($this->table)
            ->select("table_barang_keluar.*, COUNT(*) as jumlah_item")
            ->join("table_barang_keluar", "table_barang_keluar.faktur = {$this->table}.barang_keluar", 'left');
        
        if($tanggal){
            $result->where('tanggal', $tanggal);
        }
        
        $result = $result->orderBy('id','DESC')->groupBy("barang_keluar")->get();
        return $result;
    }

    public function getBarangKeluarDetail($faktur)
    {
        return $this->db->table($this->table)
            ->select("{$this->table}.*, table_barang.name")
            ->join("table_barang", "table_barang.code = {$this->table}.barang", 'left')
            ->where('barang_keluar', $faktur)
            ->get();
    }
}
