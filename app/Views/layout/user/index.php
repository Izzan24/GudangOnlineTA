<?= $this->extend('layout/page_layout'); ?>

<?= $this->section('content'); ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h5 class="m-0">User</h5>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="row justify-content-between">
                <h3 class="card-title">Data User</h3>
                <a href="user/add" class="btn btn-outline-primary rounded-pill btn-sm">
                  <i class="fas fa-plus mr-1"></i> Tambah User
                </a>
              </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div id="alert"></div>
                <div class="table-responsive">
                  <table id="table" class="table">
                    <thead>
                        <tr>
                            <th width="5">#</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th width="90">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="<?=base_url('js/setting/user.js')?>"></script>
<script>
  $(document).ready(() => {
    loadDataUser();
  });
</script>
<?= $this->endSection(); ?>
