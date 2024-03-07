<?= $this->extend('layout/page_layout'); ?>

<?= $this->section('content'); ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h5 class="m-0">Barang Masuk</h5>
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
                <h3 class="card-title">Data Barang Masuk</h3>
                <a href="barang-masuk/add" class="btn btn-outline-primary rounded-pill btn-sm">
                  <i class="fas fa-plus mr-1"></i> Tambah Barang Masuk
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
                            <th width="50">Tanggal</th>
                            <th>Faktur</th>
                            <th width="140">Jumlah Item</th>
                            <th width="90">Total Harga</th>
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

<div class="modal fade" id="modalDetailBarang" tabindex="-1" aria-labelledby="modalBarangLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalBarangLabel">List Barang</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table id="data" class="table">
                <thead>
                    <tr>
                    <th>#</th>
                    <th>Kode</th>
                    <th>Barang</th>
                    <th>Qty</th>
                    <th>Harga Beli</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
          </div>
          <div id="detail-barang"></div>
      </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="<?=base_url('js/stock/barang-masuk.js')?>"></script>
<script>
  $(document).ready(() => {
    loadDataBarangMasuk();
  });
</script>
<?= $this->endSection(); ?>
