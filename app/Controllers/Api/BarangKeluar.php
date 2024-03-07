<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

use App\Models\BarangKeluarDetailModel;
use App\Models\ArusStokModel;

class BarangKeluar extends ResourceController
{
    protected $modelName = 'App\Models\BarangKeluarModel';
    protected $format = 'json';
    
    public function index()
    {
        $tanggal = $this->request->getGet('tanggal');
        $barang_keluar_detail_model = new BarangKeluarDetailModel();
        return $this->respond($barang_keluar_detail_model->getBarangKeluar($tanggal)->getResult());
    }

    
    public function show($faktur = null)
    {
        $barang_keluar_detail_model = new BarangKeluarDetailModel();
        return $this->respond($barang_keluar_detail_model->getBarangKeluarDetail($faktur)->getResult());
    }
    
    public function create()
    {
        // Define Model dan Config database db transaction
        $detail_barang_keluar_model = new BarangKeluarDetailModel();
        $arus_stok_model = new ArusStokModel();
        $db = \Config\Database::connect();

        // Define Request Post
        $data = $this->request->getPost();
        
        // Format Data untuk Insert Barang Masuk
        $detail_barang_keluar = $data['barang_keluar'];
        $barang_keluar = [
            'faktur' => $data['faktur'],
            'tanggal' => $data['tanggal'],
            'total_harga' => array_sum(array_column($detail_barang_keluar,'subtotal')),
        ];
        
        // Start Transaksi Db (Simpan Data Barang Masuk, Detail Barang Masuk, Update RFID Tag (stok) )
        $db->transStart();
        $this->model->insert($barang_keluar);
        
        $add_tracing_rfid = [];
        foreach ($detail_barang_keluar as $value) {
            $insert = [
                'barang_keluar' => $data['faktur'],
                'barang' => $value['barang'],
                'harga_jual' => $value['harga_jual'],
                'qty' => $value['qty'],
                'subtotal' => $value['subtotal'],
            ];
            $detail_barang_keluar_model->insert($insert);

            $barang_keluar_detail_id = $detail_barang_keluar_model->getInsertID();
            $arus_stok_model
                ->whereIn('rfid_tag', $value['rfid'])
                ->set(['barang_keluar_detail' => $barang_keluar_detail_id ])
                ->update();
            
            if($value['rfid']) {
                foreach ($value['rfid'] as $rfid_scanned) {
                    array_push($add_tracing_rfid, ["rfid_tag" => $rfid_scanned,"description" => "Outbound Faktur {$data['faktur']}", "type" => "outbound"]);
                }
            }

        }
        
        helper('tracking');
        create_tracking($add_tracing_rfid);
        
        $db->transComplete();

        if ($db->transStatus() === false) {
            $db->transRollback();
            $db->close();
            return $this->respond(["message" => "Gagal menyimpan data Outbound"], 500);
        } else {
            $db->transCommit();
            $db->close();
            return $this->respond("Sukses menyimpan data Outbound", 200);
        }
    }

    public function delete($faktur = null)
    {
        if(!$faktur) return $this->respond(["message" => "Gagal menghapus data Outbound"], 500);
        $arus_stok_model = new ArusStokModel();
        $out_bound = $arus_stok_model->deleteOutbound($faktur);
        
        if ($out_bound === false) {
            return $this->respond(["message" => "Gagal menghapus data Outbound"], 500);
        }
        
        return $this->respond("Sukses menghapus data Outbound", 200);
    }
}
