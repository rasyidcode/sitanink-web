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
                    <span class="info-box-number"><?=$totalPekerja?></span>
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
                    <span class="info-box-number"><?=$totalWilayah?></span>
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
                    <span class="info-box-number"><?=$totalKartu?></span>
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
                    <span class="info-box-number"><?=$totalSk?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Default box -->
    <div class="box box-success">
        <div class="box-body">
            <h3>Halo <strong><?=session()->get('username')?></strong>, selamat datang diaplikasi web sitani nusakambangan.</h3>
        </div>
    </div>
    <!-- /.box -->

</section>
<?= $renderer->endSection() ?>