<?= $this->extend('layout/page_layout'); ?>

<?= $this->section('content'); ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h5 class="m-0">Testing</h5>
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
              <h3 class="card-title">Testing Features</h3>
            </div>
          </div>
          <div class="card-body">
            <div class="row">

              <div class="col-md-6">

                <div class="card mb-3">
                  <div class="card-header text-white bg-primary">
                    <h3 class="card-title">Clear Inbound Outbound Data</h3>
                  </div>
                  <div class="card-body">
                      <div class="row justify-content-between">
                        <div id="alert" class="w-100"></div>
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-danger btn-block" onclick="deleteConfirm('Konfirmasi', 'Apakah anda yakin menghapus data Inbound Outbound?', 'Delete', clearInboundOutbound);">Clear Inbound Outbound Data</button>
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

</section>
<?= $this->endSection(); ?>



<?= $this->section('script'); ?>
<script>
  const clearInboundOutbound = () => {
    $.ajax({
        method: "DELETE",
        url: `${base_url}/api/barang-masuk-detail/1`,
        success: (res) => {
            showAlert('#alert', 'success', 'Berhasil menghapus data');
        },
        error: () => {
            showAlert('#alert', 'warning', 'Kesalahan pada server')
        },
    });
  }
</script>
<?= $this->endSection(); ?>