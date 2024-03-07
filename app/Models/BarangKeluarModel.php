<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangKeluarModel extends Model
{
    protected $table            = 'table_barang_keluar';
    protected $primaryKey       = 'faktur';
    protected $allowedFields = ['faktur','tanggal','total_harga'];
}
