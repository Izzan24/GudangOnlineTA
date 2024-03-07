<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CetakTagRfid extends BaseController
{
    public function index()
    {
        return view('layout/cetak-tag-rfid/index');
    }
}
