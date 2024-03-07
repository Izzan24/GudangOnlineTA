<?= $this->extend('layout/page_layout'); ?>

<?= $this->section('content'); ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h5 class="m-0">Cetak Tag RFID</h5>
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
              <h3 class="card-title">Input Cetak Tag RFID</h3>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">

                <div class="card mb-3">
                  <div class="card-header text-white bg-primary">
                    <h3 class="card-title">Input Manual Tag RFID</h3>
                  </div>
                  <form id="form" onsubmit="createRfidTag();return false;">
                    <div class="card-body">
                        <div class="row">
                            <div id="message" class="w-100"></div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="date">Barang</label>
                                    <select name="barang" class="form-control barang required" id="barang"></select>
                                </div>
                                <div class="form-group">
                                    <label for="name">Tag RFID</label>
                                    <input type="text" class="form-control required" name="rfid_tag" id="rfid_tag" placeholder="Tag RFID" maxlength="16" minlength="16">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-primary" id="submit">Simpan</button>
                            </div>
                        </div>
                      </div>
                  </form>
                </div>
              </div>
              <div class="col-md-6">
                <div class="d-flex">
                  <label>Barang:</label> <select name="" id="" class="filter_barang form-control barang form-control-sm ml-2" onchange="getRfidData()"></select>
                  <label class="ml-2">Tanggal:</label> <input type="date" class="filter_tanggal form-control form-control-sm ml-2" placeholder="" onchange="getRfidData()">
                </div>
                <hr>
                <div class="table-responsive">
                  <table class="table" id="rfid">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Barang</th>
                        <th scope="col">RFID</th>
                        <th scope="col">Scan Date</th>
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
<script src="<?=base_url('js/stock/cetak-tag-rfid.js')?>"></script>
<script>  
const CHANNEL_IDENTIFIER = 'scan';
const EVENT = '1';

Pusher.logToConsole = true;

const pusher = new Pusher('b67c982cfe9b4de71605', {
    cluster: 'ap1'
});


$(document).ready(() => {
  getBarangData();
  getRfidData();
  
  var channel = pusher.subscribe(CHANNEL_IDENTIFIER);
  channel.bind(EVENT, function(data) {
    $('#rfid_tag').val('')
    $('#rfid_tag').val(data)
  });
});
</script>
<?= $this->endSection(); ?>