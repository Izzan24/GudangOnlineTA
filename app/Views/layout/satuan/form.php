<?= $this->extend('layout/page_layout'); ?>

<?= $this->section('content'); ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h5 class="m-0">Satuan</h5>
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
              <h3 class="card-title">Satuan</h3>
            </div>
          </div>
          <form id="form" onsubmit="saveSatuan();return false;">
          <div class="card-body">
            <div id="alert"></div>
              <div class="form-group">
                  <label for="name">Nama Satuan</label>
                  <input type="name" class="form-control required" name="name" id="name" placeholder="Nama Satuan">
              </div>
            </div>
            <div class="card-footer">
              <a class="btn btn-secondary" href="/satuan">Kembali</a>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="<?=base_url('js/master/satuan.js')?>"></script>

<script>
  const id = "<?=$id ?? '';?>"; 
  $(document).ready(() => {
    getSatuan(id);
  });
</script>
<?= $this->endSection(); ?>