<?= $this->extend('layout/page_layout'); ?>

<?= $this->section('content'); ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h5 class="m-0">Kategori</h5>
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
                <h3 class="card-title">Data Kategori</h3>
                <a href="kategori/add" class="btn btn-outline-primary rounded-pill btn-sm">
                  <i class="fas fa-plus mr-1"></i> Tambah Kategori
                </a>
              </div>
            </div>
            <div class="card-body">
              <div id="alert"></div>
              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table id="table" class="table">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>Nama Kategori</th>
                              <th  width="90">Aksi</th>
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
<script src="<?=base_url('js/master/kategori.js')?>"></script>

<script>
  $(document).ready(() => {
    loadKategoriData();
  });
</script>
<?= $this->endSection(); ?>
