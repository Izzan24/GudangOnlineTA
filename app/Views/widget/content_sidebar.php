<?php
$master_menu = [
    ['name' => 'Kategori','icon' => 'fa-tasks', 'path' => 'kategori'],
    ['name' => 'Satuan','icon' => 'fa-book', 'path' => 'satuan'],
    ['name' => 'Barang','icon' => 'fa-box', 'path' => 'barang'],
    ['name' => 'Lokasi','icon' => 'fa-dolly', 'path' => 'lokasi'],
];
$input_menu = [
    ['name' => 'In Bound','icon' => 'fa-arrow-alt-circle-down', 'path' => 'barang-masuk'],
    ['name' => 'Out Bound','icon' => 'fa-arrow-alt-circle-up', 'path' => 'barang-keluar'],
    ['name' => 'Stock List','icon' => 'fa-cubes', 'path' => 'stok'],
    ['name' => 'Relocation','icon' => 'fa-people-carry', 'path' => 'relocation'],
    ['name' => 'Tracking','icon' => 'fa-route', 'path' => 'tracking'],
    ['name' => 'Tag RFID','icon' => 'fa-barcode', 'path' => 'cetak-tag-rfid'],
    ['name' => 'Testing','icon' => 'fa-check', 'path' => 'page'],
];
$setting_menu = [
    ['name' => 'User','icon' => 'fa-user-lock', 'path' => 'user'],
];
$url = uri_string(true);
$module = explode('/',$url)[0] ?? '';
?>
<li class="nav-item"><a href="/" class="nav-link <?= $module == '' ? 'active' : '';?>">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>
<li class="nav-header">Master Data</li>
<?php
foreach ($master_menu as $master) {
    $active = ($module == "{$master['path']}" ? 'active' : '');
    echo '<li class="nav-item"><a href="/'.$master['path'].'" class="nav-link '.$active.'">
        <i class="nav-icon fas '.$master['icon'].'"></i>
        <p>'.$master['name'].'</p>
    </a>
</li>';
}
?>
<li class="nav-header">Stock</li>
<?php
foreach ($input_menu as $input) {
    $active = ($module == "{$input['path']}" ? 'active' : '');
    echo '<li class="nav-item"><a href="/'.$input['path'].'" class="nav-link '.$active.'">
        <i class="nav-icon fas '.$input['icon'].'"></i>
        <p>'.$input['name'].'</p>
    </a>
</li>';
}
?>

<li class="nav-header">Seting</li>
<?php
foreach ($setting_menu as $setting) {
    $active = ($module == "{$setting['path']}" ? 'active' : '');
    echo '<li class="nav-item"><a href="/'.$setting['path'].'" class="nav-link '.$active.'">
        <i class="nav-icon fas '.$setting['icon'].'"></i>
        <p>'.$setting['name'].'</p>
    </a>
</li>';
}
?>