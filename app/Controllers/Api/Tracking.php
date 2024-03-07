<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Tracking extends ResourceController
{
    protected $modelName = 'App\Models\TrackingBarangModel';
    protected $format = 'json';
    
    public function index()
    {
        $barang = $this->request->getGet('barang');
        $lokasi = $this->request->getGet('lokasi');

        $data = $this->model->getListTracking($barang, $lokasi);
        return $this->respond($data, 200);        
    }

    public function show($id = null)
    {
        $data = $this->model->detailTracking($id);
        return $this->respond($data, 200);        
    }
}
