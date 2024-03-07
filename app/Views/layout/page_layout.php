<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>App Gudang</title>

    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
    />
    <link rel="stylesheet" href="<?=base_url('plugins/fontawesome-free/css/all.min.css')?>" />
    <link
      rel="stylesheet"
      href="<?=base_url('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')?>"
    />
    
	  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />

    <link rel="stylesheet" href="<?=base_url('dist/css/adminlte.min.css')?>" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="<?=base_url('css/style.css')?>" />
    
  </head>
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <!-- Preloader -->
      <div
        class="preloader flex-column justify-content-center align-items-center"
      >
        <img
          class="animation__shake"
          src="<?= base_url('dist/img/AdminLTELogo.png') ?>"
          alt="AdminLTELogo"
          height="60"
          width="60"
        />
      </div>

      <!-- Navbar -->
      <?= $this->include('layout/template/navbar'); ?>
      <!-- /.navbar -->
      
      <!-- Main Sidebar Container -->
      <?= $this->include('layout/template/sidebar'); ?>
      <div class="content-wrapper">
          <?= $this->renderSection('content'); ?>
      </div>
        
        
      </div>
      <div class="modal fade" id="modalGlobal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalGlobalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalGlobalLabel"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body"></div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="ok"></button>
          </div>
        </div>
      </div>
    </div>
   
    <?= $this->include('layout/template/footer'); ?>
      <div class="container-alert" style="display: none">
        <div class="alert alert-primary" role="alert">
        </div>
      </div>
    <!-- ./wrapper -->

    <script src="<?=base_url('plugins/jquery/jquery.min.js')?>"></script>
    <script src="<?=base_url('plugins/jquery-ui/jquery-ui.min.js')?>"></script>
    <script>
      $.widget.bridge("uibutton", $.ui.button);

      const base_url = '<?= base_url() ?>';
    </script>
    <script src="<?=base_url('plugins/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
    <script src="<?=base_url('plugins/chart.js/Chart.min.js')?>"></script>
    <script src="<?=base_url('plugins/moment/moment.min.js')?>"></script>
    <script src="<?=base_url('plugins/moment/locales.min.js')?>"></script>
    <script src="<?=base_url('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')?>"></script>
    <script src="<?=base_url('dist/js/adminlte.js')?>"></script>
    <script src="<?=base_url('js/global.js')?>"></script>

    
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <?= $this->renderSection('script'); ?>
  </body>
</html>
