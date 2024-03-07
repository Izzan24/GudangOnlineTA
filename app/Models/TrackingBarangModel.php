<?php

namespace App\Models;

use CodeIgniter\Model;

class TrackingBarangModel extends Model
{
    protected $table            = 'table_tracking';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['rfid_tag','description','type','lokasi'];

    protected $useTimestamps = TRUE;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getListTracking($barang = false, $lokasi = false)
    {
        $db = \Config\Database::connect();   
        $subQuery = new \CodeIgniter\Database\RawSql(
            'SELECT t.* FROM table_tracking AS t
            JOIN(
                SELECT rfid_tag , MAX(id) AS max_id_tag_rfid
                FROM table_tracking
                GROUP BY rfid_tag
            ) AS tg ON (tg.rfid_tag, tg.max_id_tag_rfid) = (t.rfid_tag, t.id)
            ORDER BY t.id DESC'
        );
        $data = $db->table('table_barang_rfid')
            ->select("table_barang.name, tracking.*, table_barang_rfid.*, table_sub_lokasi.name as lokasi, table_lokasi.name as ruangan")
            ->join("({$subQuery}) tracking", "table_barang_rfid.rfid_tag = tracking.rfid_tag",'left')
            ->join('table_barang', "table_barang.code = table_barang_rfid.barang",'left')
            ->join('table_sub_lokasi', "table_sub_lokasi.id = tracking.lokasi",'left')
            ->join('table_lokasi', "table_lokasi.id = table_sub_lokasi.parent",'left');
        
        if($barang){
            $data = $data->where("table_barang_rfid.barang", $barang);
        }
        
        if($lokasi){
            $data = $data->where('lokasi', $lokasi);
        }
        
        $data = $data->get()->getResultArray();

        $db->close();
        foreach ($data as $key => $value) {
            if($value['barang_keluar_detail']){
                $data[$key]['lokasi'] = "Out";
                continue;
            }

            if($value['barang_masuk_detail'] && is_null($value['lokasi'])){
                $data[$key]['lokasi'] = "Loading In";
                continue;
            }

            if(is_null($value['barang_masuk_detail']) && is_null($value['barang_keluar_detail']) && is_null($value['lokasi'])){
                $data[$key]['lokasi'] = "Waiting Inbound";
                continue;
            }
        }
        return $data;
    }

    public function detailTracking($rfid_tag = null)
    {
        $data = $this
            ->where('rfid_tag', $rfid_tag)
            ->orderBy("{$this->table}.id", 'ASC')
            ->get()
            ->getResultArray();

        $icon = [
            "registration" => 'fas fa-check',
            "inbound" => 'fas fa-arrow-down',
            "outbound" => 'fas fa-arrow-up',
            "relocation" => 'fas fa-random', 
            "inbound_deleted" => 'fas fa-trash',
            "outbound_deleted" => 'fas fa-trash',
        ];

        $color = [
            "registration" => 'text-success',
            "inbound" => 'text-primary',
            "outbound" => 'text-danger',
            "relocation" => 'text-warning', 
            "inbound_deleted" => 'text-secondary',
            "outbound_deleted" => 'text-secondary',
        ];

        foreach ($data as $key => $value) {
            $data[$key]['icon'] = $icon[$value['type']];
            $data[$key]['color'] = $color[$value['type']];
        }

        return $data;
    }

    public function create_tracking($data)
    {
        if(isset($data[0]) && is_array($data[0])){
            return $this->insertBatch($data);
        }else{
            return $this->insert($data);
        }
    }

}
