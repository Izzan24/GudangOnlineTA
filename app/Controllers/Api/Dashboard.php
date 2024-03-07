<?php

namespace App\Controllers\Api;

use App\Models\ArusStokModel;
use CodeIgniter\Database\RawSql;
use CodeIgniter\RESTful\ResourceController;

class Dashboard extends ResourceController
{
    protected $modelName = 'App\Models\ArusStokModel';
    protected $format = 'json';

    

    public function index()
    {
        $box = $this->box();
        $transaction = $this->transaction();
        return $this->respond(compact('box','transaction'),200);
    }

    protected function box()
    {
        $db = \Config\Database::connect();
        $table_stock = $db->table('table_barang_rfid');
        $new_stock = $table_stock->where('barang_masuk_detail <>', NULL)->where('barang_keluar_detail', NULL)->countAllResults();
        $tag_registration = $table_stock->countAllResults();
        $out_of_stok = $this->model->getOutOfStok();
        $db->close();

        return [
            [
                'class' => '.new-stock',
                'path' => 'barang-masuk',
                'value' => $new_stock,
                'prefix' => '',
            ],
            [
                'class' => '.out-of-stock',
                'path' => 'stok',
                'value' => $out_of_stok,
                'prefix' => '',
            ],
            [
                'class' => '.tag',
                'path' => 'cetak-tag-rfid',
                'value' => $tag_registration,
                'prefix' => '',
            ]
        ];
    }

    protected function transaction()
    {
        $tahun = date('Y');
        $bulan = date('m');

        $db = \Config\Database::connect();
        $barang_masuk = $db->query("SELECT tanggal, SUM(item) jumlah FROM `table_barang_masuk`
        LEFT JOIN (
            SELECT barang_masuk, SUM(qty) item 
            FROM table_detail_barang_masuk 
            GROUP BY barang_masuk
        ) barang_masuk_detail ON table_barang_masuk.faktur = barang_masuk_detail.barang_masuk
        WHERE MONTH(tanggal) = {$bulan} AND YEAR(tanggal) = {$tahun}
        GROUP BY tanggal;")->getResult();

        
        $barang_keluar = $db->query("SELECT tanggal, SUM(item) jumlah FROM `table_barang_keluar`
        LEFT JOIN (
            SELECT barang_keluar, SUM(qty) item 
            FROM table_detail_barang_keluar 
            GROUP BY barang_keluar
        ) barang_keluar_detail ON table_barang_keluar.faktur = barang_keluar_detail.barang_keluar
        WHERE MONTH(tanggal) = {$bulan} AND YEAR(tanggal) = {$tahun}
        GROUP BY tanggal;")->getResult();
        $db->close();
        
        $awal = date("01", strtotime(date("{$tahun}-{$bulan}-01")));
        $akhir = date("t", strtotime(date("{$tahun}-{$bulan}-01")));
        $date = compact('awal','akhir');
        $tanggal = $in = $out = [];

        for ($i=(int) $awal; $i <= (int) $akhir; $i++) { 
            $tempTanggal = str_pad((string) $i, 2,  "0", STR_PAD_LEFT);
            array_push($tanggal, $tempTanggal);

            $index = $i - 1;
            
            $in[$index] = $out[$index] = 0;

            foreach ($barang_masuk as $masuk) {
                if($masuk->tanggal == "$tahun-$bulan-$tempTanggal"){
                    $in[$index] = $masuk->jumlah ;
                    continue;
                }
            }

            foreach ($barang_keluar as $keluar) {
                if($keluar->tanggal == "$tahun-$bulan-$tempTanggal"){
                    $out[$index] = $keluar->jumlah ;
                    continue;
                }
            }
        }
        return 
            [
                'labels' => $tanggal,
                'datasets' => [
                    [
                        'label' => " Inbound",
                        "type" => 'line',
                        "data" => $in,
                        "backgroundColor" => 'transparent',
                        "borderColor" => '#007bff',
                        "pointBorderColor" => '#007bff',
                        "pointBackgroundColor" => '#007bff',
                        "fill" => false
                    ],
                    [
                        'label' => " Outbound",
                        "type" => 'line',
                        "data" => $out,
                        "backgroundColor" => 'transparent',
                        "borderColor" => '#ced4da',
                        "pointBorderColor" => '#ced4da',
                        "pointBackgroundColor" => '#ced4da',
                        "fill" => false
                    ],
                ]
            ];
    }
}
