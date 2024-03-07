<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Relocation extends ResourceController
{
    protected $modelName = 'App\Models\TrackingBarangModel';
    
    public function index()
    {
        $arus_stok = new \App\Models\ArusStokModel();
        return $this->respond($arus_stok->rfidAll(true));
    }
    
    public function create()
    {
        $data = $this->request->getPost();
        $tracking_data = [];
        
        $lokasi_model = new \App\Models\SubLokasiModel();
        $lokasi = $lokasi_model->getLokasiById($data['lokasi'])->getRow();
        if(!$lokasi) return $this->respond("Data lokasi tidak ditemukan");

        foreach ($data['rfid_scanned'] as $key => $value) {
            array_push($tracking_data, ["rfid_tag" => $value, "description" => "Relocation ke $lokasi->lokasi - $lokasi->name", "type" => "relocation",'lokasi' => $data['lokasi']]);
        }
        $this->model->create_tracking($tracking_data);

        return $this->respond("Sukses menambah data tracking");
    }
}
