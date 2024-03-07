<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangMasukModel extends Model
{
    protected $table            = 'table_barang_masuk';
    protected $primaryKey       = 'faktur';
    protected $allowedFields = ['faktur','tanggal','total_harga'];
}
