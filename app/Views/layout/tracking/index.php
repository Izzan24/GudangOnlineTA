<?= $this->extend('layout/page_layout'); ?>

<?= $this->section('content'); ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h5 class="m-0">Tracking</h5>
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
                <h3 class="card-title">Pilih Barang</h3>
              </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                 <div class="form-row">
                  <div class="form-group col-md-5">
                    <label for="inputEmail4">Barang</label>
                    <select name="barang" id="barang" class="form-control"></select>
                  </div>
                  <div class="form-group col-md-5">
                    <label for="inputPassword4">Lokasi</label>
                    <select name="lokasi" id="lokasi" class="form-control"></select>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputPassword4">&nbsp;</label>
                    <button class="btn btn-primary form-control" onclick="loadTrackingData()">Cari</button>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="table" class="table">
                    <thead>
                        <tr>
                            <th width="5">#</th>
                            <th>Barang</th>
                            <th width="190">Rfid Tag</th>
                            <th width="170">Status/Lokasi</th>
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

<div class="modal fade" id="modalTracking" tabindex="-1" aria-labelledby="modalBarangLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-body">
            <div class="d-flex justify-content-between">
              <h5 class="modal-title" id="modalBarangLabel"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
          <i class="modal-title-sub"></i>
            <div class="table-responsive mt-4">
            <table class="table table-striped table-valign-middle">
              <thead>
              <tr>
                <th>Tanggal</th>
                <th>Aktivitas</th>
                <th>Keterangan</th>
              </tr>
              </thead>
              <tbody></tbody>
            </table>
        </div>
    </div>
    </div>
</div>


<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="<?=base_url('js/stock/tracking.js')?>"></script>

<script>
  $(document).ready(async () => {
    loadBarangSelect();
    loadLokasiSelect();
    loadTrackingData();
  });
</script>
<?= $this->endSection(); ?>
