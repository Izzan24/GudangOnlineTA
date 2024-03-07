<nav class="main-header navbar navbar-expand navbar-white navbar-light">
<!-- Left navbar links -->
<ul class="navbar-nav">
    <li class="nav-item">
    <a class="nav-link" data-widget="pushmenu" href="#" role="button"
        ><i class="fas fa-bars"></i
    ></a>
    </li>
</ul>

<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">
    <li class="nav-item">
    <a href="<?= base_url('logout') ?>" class="nav-link"><?= session()->user->name ?? "No Name" ?> <i class="fas fa-sign-out-alt ml-1"></i></a>
    </li>
</ul>
</nav>