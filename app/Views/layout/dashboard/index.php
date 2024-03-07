<?= $this->extend('layout/page_layout'); ?>

<?= $this->section('content'); ?>
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-12">
              <h5 class="m-0">Dashboard</h5>
            </div>
          </div>
        </div>
      </div>
        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
              <div class="col-lg-4 col-12">
                <!-- small box -->
                <div class="small-box bg-info new-stock">
                  <div class="inner">
                    <h3>0</h3>

                    <p>New Stock Count</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-4 col-12">
                <!-- small box -->
                <div class="small-box bg-danger out-of-stock">
                  <div class="inner">
                    <h3>0</h3>

                    <p>Out of stock Items</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-4 col-12">
                <!-- small box -->
                <div class="small-box bg-warning tag">
                  <div class="inner">
                    <h3>0</h3>

                    <p>Tag Registrations</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person-add"></i>
                  </div>
                </div>
              </div>
              <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
              <!-- Left col -->
              <section class="col-lg-12 ">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                  <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                      <h3 class="card-title">Statistic Stock</h3>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="position-relative mb-4">
                      <canvas id="visitors-chart" height="300"></canvas>
                    </div>

                    <div class="d-flex flex-row justify-content-end">
                      <span class="mr-2">
                        <i class="fas fa-square text-primary"></i> Inbound
                      </span>

                      <span>
                        <i class="fas fa-square text-gray"></i> Outbound
                      </span>
                    </div>
                  </div>
                </div>

              </section>
              <!-- /.Left col -->

              <!-- <section class="col-lg-12">
                <div class="row">
                  <div class="col-md-6">
                    <div class="card">
                      <div class="card-header border-0">
                        <h3 class="card-title">
                          <i class="fas fas fa-arrow-alt-circle-left mr-1"></i>
                          Inbound
                        </h3>
                        <div class="card-tools">
                          <button
                            type="button"
                            class="btn btn-tool"
                            data-card-widget="collapse"
                            title="Collapse"
                          >
                            <i class="fas fa-minus"></i>
                          </button>
                        </div>
                      </div>
                      <div class="card-body">
                        <div
                          id="world-map"
                          style="height: 250px; width: 100%"
                        ></div>
                      </div>
                      <div class="card-footer bg-transparent">
                        <div class="row">
                          <div class="col-4 text-center">
                            <div id="sparkline-1"></div>
                            <div class="text-white">Visitors</div>
                          </div>
                          <div class="col-4 text-center">
                            <div id="sparkline-2"></div>
                            <div class="text-white">Online</div>
                          </div>
                          <div class="col-4 text-center">
                            <div id="sparkline-3"></div>
                            <div class="text-white">Sales</div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                     <div class="col-md-6">
                    <div class="card">
                      <div class="card-header border-0">
                        <h3 class="card-title">
                          <i class="fas fas fa-arrow-alt-circle-down mr-1"></i>
                          Outbound
                        </h3>
                        <div class="card-tools">
                          <button
                            type="button"
                            class="btn btn-tool"
                            data-card-widget="collapse"
                            title="Collapse"
                          >
                            <i class="fas fa-minus"></i>
                          </button>
                        </div>
                      </div>
                      <div class="card-body">
                        <div
                          id="world-map"
                          style="height: 250px; width: 100%"
                        ></div>
                      </div>
                      <div class="card-footer bg-transparent">
                        <div class="row">
                          <div class="col-4 text-center">
                            <div id="sparkline-1"></div>
                            <div class="text-white">Visitors</div>
                          </div>
                          <div class="col-4 text-center">
                            <div id="sparkline-2"></div>
                            <div class="text-white">Online</div>
                          </div>
                          <div class="col-4 text-center">
                            <div id="sparkline-3"></div>
                            <div class="text-white">Sales</div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
               
                
                </div>
              </section> -->
              
            </div>
          </div>
        </section>
        <!-- /.content -->
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="<?=base_url('js/setting/dashboard.js')?>"></script>
<script>
  $(document).ready(() => {
    loadDataDashboard();
    $('.card-title').text("Statistic Stock "+moment().lang("id").format('MMMM'));

  });
</script>
<?= $this->endSection(); ?>