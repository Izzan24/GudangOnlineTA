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
              <h3 class="card-title">Barang</h3>
            </div>
          </div>
          <form id="form" onsubmit="saveBarang();return false;">
          <div class="card-body">
            <div id="alert"></div>
              <?php if(!isset($id)){ ?>
                <div class="form-group">
                    <label for="name">Kode Barang</label>
                    <input type="name" class="form-control required" name="code" id="code" placeholder="Kode">
                </div>
              <?php } ?>
              <div class="form-group">
                  <label for="name">Nama Barang</label>
                  <input type="name" class="form-control required" name="name" id="name" placeholder="Nama Barang">
              </div>
              <div class="form-group">
                  <label for="name">Kategori</label>
                  <select name="kategori" id="kategori" class="form-control required" placeholder="Pilih Kategori"><option value="" readonly>Pilih Kategori</option></select>
              </div>
              <div class="form-group">
                  <label for="name">Satuan</label>
                  <select name="satuan" id="satuan" class="form-control required" placeholder="Pilih Satuan"><option value="" readonly>Pilih Satuan</option></select>
              </div>
              <div class="form-group">
                  <label for="name">Harga Beli</label>
                  <input type="name" class="form-control required" name="harga_beli" id="harga_beli" placeholder="Harga Beli" onkeyup="formatInputRupiah(this)">
              </div>
              <div class="form-group">
                  <label for="name">Harga Jual</label>
                  <input type="name" class="form-control required" name="harga_jual" id="harga_jual" placeholder="Harga Jual" onkeyup="formatInputRupiah(this)">
              </div>
            </div>
            <div class="card-footer">
              <a class="btn btn-secondary" href="/barang">Kembali</a>
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
<script src="<?=base_url('js/master/barang.js')?>"></script>

<script>
  const id = "<?=$id ?? '';?>"; 
  $(document).ready(() => {
    $('#code').bind('keypress', function (event) {

        var keyCode = event.keyCode || event.which
        if (keyCode == 8 || (keyCode >= 35 && keyCode <= 40)) {
            return;
        }
        
        var regex = new RegExp("^[a-zA-Z0-9]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);

        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });
    getBarang(id);
  });
</script>
<?= $this->endSection(); ?>