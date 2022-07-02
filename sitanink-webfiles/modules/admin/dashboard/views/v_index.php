<?= $renderer->extend('modules/shared/core/views/layout') ?>

<?= $renderer->section('content') ?>
<section class="content">

    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Pekerja</span>
                    <span class="info-box-number"><?= $totalPekerja ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="ion ion-map"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Wilayah</span>
                    <span class="info-box-number"><?= $totalWilayah ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-id-card-o"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Kartu</span>
                    <span class="info-box-number"><?= $totalKartu ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-document-text"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">SK Diterbitkan</span>
                    <span class="info-box-number"><?= $totalSk ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-lg-12">
            <!-- Default box -->
            <div class="box box-success">
                <div class="box-body">
                    <h3>Halo <strong><?= session()->get('username') ?></strong>, selamat datang diaplikasi web sitani nusakambangan.</h3>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-green">
                    <div class="widget-user-image">
                        <i class="ion ion-map" style="float: left; font-size: 40px;"></i>
                    </div>
                    <!-- /.widget-user-image -->
                    <h3 class="widget-user-username">Data Per Wilayah</h3>
                    <h5 class="widget-user-desc"></h5>
                </div>
                <div class="box-footer no-padding">
                    <ul class="nav nav-stacked">
                        <?php foreach ($listWilayah as $itemWilayah) : ?>
                            <li><a href="#"><?= $itemWilayah->nama ?> <span class="pull-right badge bg-green"><?= $itemWilayah->total_pekerja ?></span></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</section>
<?= $renderer->endSection() ?>