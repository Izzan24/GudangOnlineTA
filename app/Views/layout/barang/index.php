<?= $this->extend('layout/page_layout'); ?>

<?= $this->section('content'); ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h5 class="m-0">Barang</h5>
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
                <h3 class="card-title">Data Barang</h3>
                <a href="barang/add" class="btn btn-outline-primary rounded-pill btn-sm">
                  <i class="fas fa-plus mr-1"></i> Tambah Barang
                </a>
              </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="table" class="table">
                    <thead>
                        <tr>
                            <th width="5">#</th>
                            <th width="50">Kode</th>
                            <th>Barang</th>
                            <th width="80">Kategori</th>
                            <th width="60">Satuan</th>
                            <th width="80">Harga Beli</th>
                            <th width="80">Harga Jual</th>
                            <th width="50">Aksi</th>
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
<script src="<?=base_url('js/master/barang.js')?>"></script>

<script>
  $(document).ready(() => {
    loadBarangData();
  });
</script>
<?= $this->endSection(); ?>
