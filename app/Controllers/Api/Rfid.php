<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Rfid extends ResourceController
{
    protected $modelName = 'App\Models\ArusStokModel';
    protected $format = 'json';

    
    public function index()
    {
        $tanggal = $this->request->getGet('tanggal');
        $barang = $this->request->getGet('barang');
        return $this->respond($this->model->rfidAll(false, $tanggal, $barang));
    }

    
    public function show($rfid_tag = null)
    {
        return $this->respond($this->model->getBarangByCode($rfid_tag)->getRow(),200);
    }

    
    public function create()
    {
        $data = $this->request->getPost();
        $barang = $this->model->where('barang', $data['barang'])->orderBy('identifier_barang',"DESC")->first();

        if($barang){
            $barang["identifier_barang"] = (int) $barang["identifier_barang"]+1;
            $data['identifier_barang'] = str_pad((string) $barang["identifier_barang"], 5,  "0", STR_PAD_LEFT);
        }else{
            $data['identifier_barang'] = "00001";
        }
        
        helper('tracking');
        create_tracking(["rfid_tag" => $data["rfid_tag"],"description" => "Tag registration", "type" => "registration"]);

        return $this->respond($this->model->insert($data));
    }
}
