<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangMasukDetailModel extends Model
{
    protected $table            = 'table_detail_barang_masuk';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['barang_masuk','barang','qty','harga_jual','harga_beli','subtotal'];

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getBarangMasuk($tanggal = null)
    {
        $result = $this->db->table($this->table)
            ->select("table_barang_masuk.*, COUNT(*) as jumlah_item")
            ->join("table_barang_masuk", "table_barang_masuk.faktur = {$this->table}.barang_masuk", 'left');
        
        if($tanggal){
            $result->where('tanggal', $tanggal);
        }
        $result = $result->orderBy('id','DESC')->groupBy("barang_masuk")->get();

        return $result;
    }

    public function getBarangMasukDetail($faktur)
    {
        return $this->db->table($this->table)
            ->select("{$this->table}.*, table_barang.name")
            ->join("table_barang", "table_barang.code = {$this->table}.barang", 'left')
            ->where('barang_masuk', $faktur)
            ->get();
    }
}