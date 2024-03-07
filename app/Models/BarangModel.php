<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table            = 'table_barang';
    protected $primaryKey       = 'code';
    protected $allowedFields = ['code','kategori','satuan','harga_jual','harga_beli','image','name','is_deleted'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getBarang()
    {
        return $this->db->table($this->table)
            ->select('table_barang.*, table_kategori.name as kategori, table_satuan.name as satuan')
            ->join('table_kategori', 'table_kategori.id = table_barang.kategori', 'left')
            ->join('table_satuan', 'table_satuan.id = table_barang.satuan', 'left')
            ->where('table_barang.is_deleted', 0)
            ->get();
    }

    public function getBarangByCode($code)
    {
        return $this->db->table($this->table)
            ->select('table_barang.*, table_kategori.name as kategori_name, table_satuan.name as satuan_name')
            ->join('table_kategori', 'table_kategori.id = table_barang.kategori', 'left')
            ->join('table_satuan', 'table_satuan.id = table_barang.satuan', 'left')
            ->where('code', $code)
            ->get();
    }
}
