<?php

namespace App\Controllers\Api;

use App\Models\BarangMasukModel;

use CodeIgniter\RESTful\ResourceController;

class BarangMasukDetail extends ResourceController
{
    protected $modelName = 'App\Models\ArusStokModel';
    protected $format = 'json';
    
    public function show($id = null)
    {
        return $this->respond($this->model->where('barang_masuk_detail',$id)->get()->getResult(),200);
    }

    public function delete($faktur = null)
    {
        $arus_stok_model = new \App\Models\ArusStokModel();
        $arus_stok_model
            ->set('barang_masuk_detail', NULL)
            ->set('barang_keluar_detail', NULL)
            ->update();
        
        $db = \Config\Database::connect();
        $db->table('table_detail_barang_keluar')->truncate();
        $db->table('table_detail_barang_masuk')->truncate();
        $db->query("DELETE FROM `table_barang_keluar` WHERE 1");
        $db->query("DELETE FROM `table_barang_masuk` WHERE 1");
        $db->close();

        return $this->respond("Sukses menghapus data!", 200);
    }
}
