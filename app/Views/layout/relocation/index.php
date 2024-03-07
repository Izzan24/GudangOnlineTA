<?= $this->extend('layout/page_layout'); ?>

<?= $this->section('content'); ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h5 class="m-0">Relocation</h5>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-header">
            <div class="row justify-content-between">
                <h3 class="card-title">Pilih/Scan Barang</h3>
              </div>
          </div>
          <div class="card-body">
            <div class="row">
                <div class="form-group col-md-10">
                    <label for="inputPassword4">Pilih Barang</label>
                    <select name="barang" id="barang" class="form-control"></select>
                </div>
                <div class="col-md-2">
                    <label for="inputPassword4">&nbsp;</label>
                    <button class="btn btn-primary form-control" onclick="addTrackingTemp()">Add</button>
                </div>
                <div class="form-group col-md-12 mt-3">
                    <label for="inputPassword4">Pilih dengan Scan</label>
                    <button type="button" class="btn btn-success btn-block scan" role="button" onclick="scan()">Scan</button>
                    <button type="button" class="btn btn-warning btn-block stop mt-0" role="button" onclick="stop()" style="display: none;">Stop</button>
                </div>
            </div>
          </div>
        </div>
      </div>
       <div class="col-sm-6">
        <div class="card">
          <div class="card-header">
            <div class="row justify-content-between">
                <h3 class="card-title">Barang Dipilih</h3>
              </div>
          </div>
          <div class="card-body">
            <table class="table mb-3" style="display:none;">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Barang</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
            <tbody id="data"></tbody>
        </table>
            <div class="row">
                  <div class="form-group col-md-12">
                    <label for="inputPassword4">Lokasi</label>
                    <select name="lokasi" id="lokasi" class="form-control"></select>
                  </div>
                  <div class="form-group col-md-12">
                    <button class="btn btn-primary form-control" onclick="simpanBarangKeTracking()">Relokasi</button>
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

<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="<?=base_url('js/stock/relocation.js')?>"></script>

<script>
  $(document).ready(() => {
    loadBarangSelect();
    loadLokasiSelect();
  });
</script>
<?= $this->endSection(); ?>
