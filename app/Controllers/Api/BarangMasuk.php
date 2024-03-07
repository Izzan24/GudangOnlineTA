<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

use App\Models\BarangMasukDetailModel;
use App\Models\ArusStokModel;

class BarangMasuk extends ResourceController
{
    protected $modelName = 'App\Models\BarangMasukModel';
    protected $format = 'json';
    
    public function index()
    {
        $tanggal = $this->request->getGet('tanggal');
        $barang_masuk_detail_model = new BarangMasukDetailModel();
        return $this->respond($barang_masuk_detail_model->getBarangMasuk($tanggal)->getResult());
    }

    public function show($faktur = null)
    {
        $barang_masuk_detail_model = new BarangMasukDetailModel();
        return $this->respond($barang_masuk_detail_model->getBarangMasukDetail($faktur)->getResult());
    }

    public function create()
    {
        // Define Model dan Config database db transaction
        $detail_barang_masuk_model = new BarangMasukDetailModel();
        $arus_stok_model = new ArusStokModel();
        $db = \Config\Database::connect();

        // Define Request Post
        $data = $this->request->getPost();
        
        // Format Data untuk Insert Barang Masuk
        $detail_barang_masuk = $data['barang_masuk'];
        $barang_masuk = [
            'faktur' => $data['faktur'],
            'tanggal' => $data['tanggal'],
            'total_harga' => array_sum(array_column($detail_barang_masuk,'subtotal')),
        ];
        
        // Start Transaksi Db (Simpan Data Barang Masuk, Detail Barang Masuk, Update RFID Tag (stok) )
        $db->transStart();
        $this->model->insert($barang_masuk);
        $add_tracing_rfid = [];
        foreach ($detail_barang_masuk as $value) {
            $insert = [
                'barang_masuk' => $data['faktur'],
                'barang' => $value['barang'],
                'harga_beli' => $value['harga_beli'],
                'qty' => $value['qty'],
                'subtotal' => $value['subtotal'],
            ];
            $detail_barang_masuk_model->insert($insert);

            $barang_masuk_detail_id = $detail_barang_masuk_model->getInsertID();
            $arus_stok_model
                ->whereIn('rfid_tag', $value['rfid'])
                ->set(['barang_masuk_detail' => $barang_masuk_detail_id ])
                ->update();

            if($value['rfid']) {
                foreach ($value['rfid'] as $rfid_scanned) {
                    array_push($add_tracing_rfid, ["rfid_tag" => $rfid_scanned,"description" => "Inbound Faktur {$data['faktur']}", "type" => "inbound"]);
                }
            }
        }
        
        helper('tracking');
        create_tracking($add_tracing_rfid);
        
        $db->transComplete();

        if ($db->transStatus() === false) {
            $db->transRollback();
            $db->close();
            return $this->respond(["message" => "Gagal menyimpan data Inbound"], 500);
        } else {
            $db->transCommit();
            $db->close();
            return $this->respond("Sukses menyimpan data Inbound", 200);
        }
    }
    
    public function delete($faktur = null)
    {
        if(!$faktur) return $this->respond(["message" => "Data tidak valid"], 500);

        $arus_stok_model = new ArusStokModel();
        $count_stok_keluar = $arus_stok_model->checkInboundStokKeluar($faktur);
        if($count_stok_keluar > 0){
            return $this->respond(["message" => "Gagal menghapus data Inbound, Stok sudah keluar"], 500);
        }
        
        $inbound = $arus_stok_model->deleteInbound($faktur);
        
        if ($inbound === false) {
            return $this->respond(["message" => "Gagal menghapus data Inbound"], 500);
        }
        
        return $this->respond("Sukses menghapus data Inbound", 200);
    }
}
