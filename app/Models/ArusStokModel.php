<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\RawSql;

class ArusStokModel extends Model
{
    protected $table            = 'table_barang_rfid';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['barang', 'barang_masuk_detail','barang_keluar_detail','rfid_tag','identifier_barang'];

    protected $useTimestamps = TRUE;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function rfidAll($forceInStok = false, $tanggal = null, $barang = null)
    {
        $data = $this
            ->select('table_barang.*, table_barang_rfid.*')
            ->join("table_barang", "table_barang_rfid.barang = table_barang.code",'left')
            ->orderBy('table_barang_rfid.created_at', "desc");
        
        if($forceInStok){
            $data = $data->where('barang_masuk_detail <>',  NULL)->where('barang_keluar_detail',  NULL);
            return $data->get()->getResult();
        }
        
        if($barang){
            $data = $data->where('code', $barang);
        }

        if($tanggal){
            $data = $data->where("DATE(table_barang_rfid.created_at)", $tanggal);
        }

        return $data->get()->getResult();
    }

    public function getBarangByCode($rfid_tag = null)
    {
        return $this->db->table("table_barang")
            ->select("table_barang.name, table_barang.harga_beli,table_barang.harga_jual, table_barang_rfid.*")
            ->join("table_barang_rfid", "table_barang_rfid.barang = table_barang.code",'left')
            ->where('rfid_tag', $rfid_tag)
            ->get();
    }

    public function getArusStok()
    {
        $rawSql = new RawSql("SELECT COUNT(*) as stok_barang, barang
        FROM {$this->table}
        WHERE barang_masuk_detail IS NOT NULL 
        AND barang_keluar_detail IS NULL
        GROUP BY barang");

        return $this->db->table("table_barang")
            ->select("table_barang.code, table_barang.name,table_satuan.name as unit, COALESCE(stok_barang, 0) stok")
            ->join("table_satuan", "table_satuan.id = table_barang.satuan",'left')
            ->join("($rawSql) stok", "stok.barang = table_barang.code",'left')
            ->get();
    }

    public function getOutOfStok()
    {
        $rawSql = new RawSql("SELECT COUNT(*) as stok_barang, barang
        FROM {$this->table}
        WHERE barang_masuk_detail IS NOT NULL 
        AND barang_keluar_detail IS NULL
        GROUP BY barang");

        return $this->db->table("table_barang")
            ->join("($rawSql) stok", "stok.barang = table_barang.code",'left')
            ->where('stok.stok_barang', NULL)
            ->countAllResults();
    }

    public function getInStok($kode = null, $faktur = null, $tanggal =  null)
    {
        $data = $this->db->table("table_barang_masuk")
            ->select("faktur, tanggal, harga_beli, rfid_tag")
            ->join("table_detail_barang_masuk", "table_detail_barang_masuk.barang_masuk = table_barang_masuk.faktur",'left')
            ->join("{$this->table}", "table_detail_barang_masuk.id = {$this->table}.barang_masuk_detail AND barang_masuk_detail IS NOT NULL AND barang_keluar_detail IS NULL")
            ->where("table_detail_barang_masuk.barang", $kode);

        if($faktur && $faktur != "null"){
            $data = $data->where('table_barang_masuk.faktur', $faktur);
        }
        if($tanggal){
            $data = $data->where('table_barang_masuk.tanggal', $tanggal);
        }
        return $data->orderBy('table_detail_barang_masuk.id','DESC')->get();
    }

    public function getOutStok($kode = null, $faktur = null, $tanggal =  null)
    {
        $data = $this->db->table("table_barang_keluar")
            ->select("faktur, tanggal, harga_jual, rfid_tag")
            ->join("table_detail_barang_keluar", "table_detail_barang_keluar.barang_keluar = table_barang_keluar.faktur",'left')
            ->join("{$this->table}", "table_detail_barang_keluar.id = {$this->table}.barang_keluar_detail AND barang_masuk_detail IS NOT NULL AND barang_keluar_detail IS NOT NULL")
            ->where("table_detail_barang_keluar.barang", $kode);
        
        if($faktur && $faktur != "null"){
            $data = $data->where('table_barang_keluar.faktur', $faktur);
        }
        if($tanggal){
            $data = $data->where('table_barang_keluar.tanggal', $tanggal);
        }
        return $data->orderBy('table_detail_barang_keluar.id','DESC')->get();
    }

    public function checkInboundStokKeluar($faktur)
    {
        $db = \Config\Database::connect();        
        $subQuery = $db->table('table_detail_barang_masuk')->select('id')->where('barang_masuk', $faktur);
        $count = $db->table('table_barang_rfid')
            ->whereIn('barang_masuk_detail', $subQuery)
            ->where('barang_keluar_detail <>',  NULL)
            ->countAllResults();
        $db->close();
        return $count;
    }


    public function deleteInbound($faktur)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $add_tracing_rfid = $db->table('table_barang_rfid')
            ->whereIn('barang_masuk_detail',
                $db->table('table_detail_barang_masuk')->select('id')->where('barang_masuk', $faktur)
            )
            ->get()->getResult();

        $db->table('table_barang_rfid')
            ->whereIn('barang_masuk_detail',
                $db->table('table_detail_barang_masuk')->select('id')->where('barang_masuk', $faktur)
            )
            ->set('barang_masuk_detail', NULL)
            ->update();
        $this->db->table("table_detail_barang_masuk")->where('barang_masuk', $faktur)->delete();
        $this->db->table("table_barang_masuk")->where('faktur', $faktur)->delete();

        helper('tracking');
        foreach ($add_tracing_rfid as $val) {
            create_tracking(["rfid_tag" => $val->rfid_tag, "description" => "Deleting Inbound Faktur {$faktur}", "type" => "inbound_deleted"]);
        }
        $db->transComplete();
        
        if ($db->transStatus() === false) {
            $db->transRollback();
            $db->close();
            return false;
        }
        
        $db->transCommit();
        $db->close();
        return true;
    }

    public function deleteOutbound($faktur)
    {
        $db = \Config\Database::connect();
        
        $db->transStart();

        $add_tracing_rfid = $db->table('table_barang_rfid')
            ->whereIn('barang_keluar_detail', 
                $db->table('table_detail_barang_keluar')->select('id')->where('barang_keluar', $faktur)
            )
            ->get()->getResult();

        $db->table('table_barang_rfid')
            ->whereIn('barang_keluar_detail', 
                $db->table('table_detail_barang_keluar')->select('id')->where('barang_keluar', $faktur)
            )
            ->set('barang_keluar_detail', NULL)
            ->update();

        $this->db->table("table_detail_barang_keluar")->where('barang_keluar', $faktur)->delete();
        $this->db->table("table_barang_keluar")->where('faktur', $faktur)->delete();
        
        helper('tracking');
        foreach ($add_tracing_rfid as $val) {
            create_tracking(["rfid_tag" => $val->rfid_tag, "description" => "Deleting Outbound Faktur {$faktur}", "type" => "outbound_deleted"]);
        }
        $db->transComplete();

        if ($db->transStatus() === false) {
            $db->transRollback();
            $db->close();
            return false;
        }
        
        $db->transCommit();
        $db->close();
        return true;
    }
}
