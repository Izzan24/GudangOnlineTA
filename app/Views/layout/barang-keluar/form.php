<?= $this->extend('layout/page_layout'); ?>

<?= $this->section('content'); ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h5 class="m-0">Barang Keluar</h5>
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
              <h3 class="card-title">Input Barang Keluar</h3>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                    <label for="name">No. Faktur</label>
                    <input type="name" class="form-control" name="faktur" id="faktur" placeholder="No. Faktur" maxlength="20">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                    <label for="date">Tgl. Barang Keluar</label>
                    <input type="date" class="form-control" name="tanggal" id="tanggal" placeholder="Tanggal" value="<?=date('Y-m-d')?>">
                </div>
              </div>
            </div>
          
          <div class="row mt-3">
              <div class="col-md-12">
                <div class="card mb-3">
                  <div class="card-header text-white bg-primary">
                    <h3 class="card-title">Scan Barang</h3>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-7">
                        <h6>Outbound Items</h6>
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Kode</th>
                              <th scope="col">Nama</th>
                              <th scope="col">Harga</th>
                              <th scope="col">Jumlah</th>
                              <th scope="col">Subtotal</th>
                            </tr>
                          </thead>
                          <tbody id="data"></tbody>
                        </table>
                      </div>
                      <div class="col-md-5">
                        <h6>Scanner Log</h6>
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Nama</th>
                              <th scope="col">RFID</th>
                              <th scope="col">InStok</th>
                            </tr>
                          </thead>
                          <tbody id="log"></tbody>
                        </table>
                        
                      </div>
                     
                    </div>
                    <div class="row justify-content-between">
                      <div class="col-md-4">
                        <button type="button" class="btn btn-success mr-2 scan" role="button" onclick="scan()">Scan</button>
                        <button type="button" class="btn btn-warning mr-2 stop" role="button" onclick="stop()" style="display: none;">Stop</button>
                        <button type="button" class="btn btn-success mr-2" role="button" onclick="$('#modalScanBarang').modal('show')">Input</button>
                      </div>
                      <div class="col-md-8 text-right">
                        <button type="button" class="btn btn-primary" id="submit" onclick="simpanBarangKeStok($(this))">Submit</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalScanBarang" tabindex="-1" aria-labelledby="modalBarangLabel" aria-hidden="true">
      <div class="modal-dialog modal-md">
          <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="modalBarangLabel">Input Manual</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
                <label for="name">RFID Tag</label>
                <input type="name" class="form-control" name="rfid_tag" id="rfid_tag" placeholder="Tag RFID" maxlength="16" minlength="16">
            </div>
        </div>
        <div class="modal-footer text-right">
            <button type="button" class="btn btn-primary" id="submit" onclick="inputManualTag()">Tambah</button>
        </div>
      </div>
  </div>
</section>
<style>
.table td, .table th {
  padding: .3rem;
  vertical-align: top;
  border-top: 1px solid #dee2e6;
  font-size: 14px;
}
</style>
<?= $this->endSection(); ?>



<?= $this->section('script'); ?>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="<?=base_url('js/stock/barang-keluar.js')?>"></script>
<?= $this->endSection(); ?>