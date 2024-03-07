<?= $this->extend('layout/page_layout'); ?>

<?= $this->section('content'); ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h5 class="m-0">Stok List</h5>
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
                <h3 class="card-title">Data Stok</h3>
              </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="table" class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Barang</th>
                            <th>Unit</th>
                            <th>Stok</th>
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


<div class="modal fade" id="modalInStokBarang" tabindex="-1" aria-labelledby="modalBarangLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="modalBarangLabel">List in Stock</h5>
          </div>
          <div class="modal-body">
              <div class="row mb-3" style="border-radius: 8px; border: 1px solid #d2d2cf">
                <div class="form-inline w-100 justify-content-between p-3">
                  <input type="hidden" id="code" value="">
                  <div class="col-sm-5">
                    <input type="text" class="form-control w-100" id="faktur_beli" placeholder="Faktur">
                  </div>
                  <div class="col-sm-4 justify-content-between d-flex">
                    <input  type="date" class="form-control w-100" id="tanggal_beli" placeholder="Tanggal" value="">
                  </div>
                  <div class="col-sm-3">
                    <button type="button" onclick="loadInStokData()" class="btn btn-primary">Filter</button>
                    <button type="button" onclick="resetInStokFilter()" class="btn btn-secondary">Reset</button>
                  </div>
                </div>
              </div>
              <div class="table-responsive">
              <table id="in-stok-data" class="table">
                  <thead>
                      <tr>
                      <th>#</th>
                      <th>Tanggal</th>
                      <th>Faktur Pembelian</th>
                      <th>Harga Beli</th>
                      <th>Rfid Tag</th>
                      </tr>
                  </thead>
                  <tbody></tbody>
              </table>
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary text-right" class="close" data-dismiss="modal" aria-label="Close">
            Close
            </button>
        </div>
    </div>
    </div>
</div>

<div class="modal fade" id="modalOutStokBarang" tabindex="-1" aria-labelledby="modalBarangLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalBarangLabel">List out Stock</h5>
        </div>
        <div class="modal-body">
            <div class="row mb-3" style="border-radius: 8px; border: 1px solid #d2d2cf">
              <div class="form-inline w-100 justify-content-between p-3">
                <input type="hidden" id="code" value="">
                <div class="col-sm-5">
                  <input type="text" class="form-control w-100" id="faktur_jual" placeholder="Faktur">
                </div>
                <div class="col-sm-4 justify-content-between d-flex">
                  <input  type="date" class="form-control w-100" id="tanggal_jual" placeholder="Tanggal" value="">
                </div>
                <div class="col-sm-3">
                  <button type="button" onclick="loadOutStokData()" class="btn btn-primary">Filter</button>
                  <button type="button" onclick="resetOutStokFilter()" class="btn btn-secondary">Reset</button>
                </div>
              </div>
            </div>
            <div class="table-responsive">
            <table id="out-stok-data" class="table">
                <thead>
                    <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Faktur Penjualan</th>
                    <th>Harga Jual</th>
                    <th>Rfid Tag</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary text-right" class="close" data-dismiss="modal" aria-label="Close">
        Close
        </button>
    </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="<?=base_url('js/stock/stock.js')?>"></script>

<script>
  $(document).ready(() => {
    loadStokData();
    loadInBoundData();
    loadOutBoundData();
  });
</script>
<?= $this->endSection(); ?>
