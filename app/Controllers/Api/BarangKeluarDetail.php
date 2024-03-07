<?php

namespace App\Controllers\Api;

use App\Models\BarangMasukModel;

use CodeIgniter\RESTful\ResourceController;

class BarangKeluarDetail extends ResourceController
{
    protected $modelName = 'App\Models\ArusStokModel';
    protected $format = 'json';

    public function show($id = null)
    {
        return $this->respond($this->model->where('barang_keluar_detail',$id)->get()->getResult(),200);
    }
}
