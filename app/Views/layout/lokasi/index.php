<?= $this->extend('layout/page_layout'); ?>

<?= $this->section('content'); ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h5 class="m-0">Lokasi</h5>
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
                <h3 class="card-title">Data Lokasi</h3>
                <div class="col-sm-6 text-right">
                  <a href="javascript:void(0)" onclick="addLokasi()" class="btn btn-outline-primary rounded-pill btn-sm mr-2">
                    <i class="fas fa-plus mr-1"></i> Tambah Ruangan
                  </a>
                  <a href="javascript:void(0)" onclick="addSubLokasi()" class="btn btn-outline-primary rounded-pill btn-sm">
                    <i class="fas fa-plus mr-1"></i> Tambah Rak
                  </a>
                </div>
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
                            <th>#</th>
                            <th>Nama Lokasi</th>
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

<div class="modal fade" id="modalLokasi" tabindex="-1" aria-labelledby="modalLokasi" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalLokasiLabel">List Ruang</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form onsubmit="saveLokasi($(this)); return false;">
            <div class="form-group mb-4">
              <label for="name">Tambah Ruangan</label>
              <div class="row">
                <div class="col-sm-10">
                  <input type="hidden" name="id"  id="id">
                  <input type="name" class="form-control required" name="name" id="name" placeholder="Ruangan">
                </div>
                <div class="col-sm-2">
                  <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                </div>
              </div>
            </div>
          </form>
          <div id="alertModalLokasi" class="w-100"></div>
          <div class="table-responsive">
            <table id="lokasi" class="table">
                <thead>
                    <tr>
                    <th>#</th>
                    <th>Ruangan</th>
                    <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
          </div>
      </div>
      </div>
    </div>
</div>

<div class="modal fade" id="modalSubLokasi" tabindex="-1" aria-labelledby="modalSubLokasi" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalSubLokasiLabel">Input Sub Lokasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form onsubmit="saveSubLokasi($(this)); return false;">
            <div class="row mb-4">
              <div class="col-md-12">
                <div class="form-group">
                    <label for="name">Lokasi</label>
                    <select name="parent" id="select-lokasi" class="form-control required"></select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                    <label for="name">Sub Lokasi</label>
                    <input type="hidden" name="id"  id="id">
                    <input type="name" class="form-control required" name="name" id="sub-lokasi-name" placeholder="Lokasi">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                </div>
              </div>
            </div>
          </form>
      </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="<?=base_url('js/master/lokasi.js')?>"></script>

<script>
  $(document).ready(() => {
    loadLokasiData();
  });
</script>
<?= $this->endSection(); ?>
