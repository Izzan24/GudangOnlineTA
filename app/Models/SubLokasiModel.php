<?php

namespace App\Models;

use CodeIgniter\Model;

class SubLokasiModel extends Model
{
    protected $table            = 'table_sub_lokasi';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['name','parent','is_deleted'];
    
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getLokasiAll()
    {
        return $this->db->table($this->table)
            ->select('table_sub_lokasi.*, table_lokasi.name as lokasi')
            ->join('table_lokasi', 'table_lokasi.id = table_sub_lokasi.parent', 'left')
            ->where('table_sub_lokasi.is_deleted', 0)
            ->get();
    }


    public function getLokasiById($id)
    {
        return $this->db->table($this->table)
            ->select('table_sub_lokasi.*, table_lokasi.name as lokasi')
            ->join('table_lokasi', 'table_lokasi.id = table_sub_lokasi.parent', 'left')
            ->where('table_sub_lokasi.id', $id)
            ->get();
    }
}
