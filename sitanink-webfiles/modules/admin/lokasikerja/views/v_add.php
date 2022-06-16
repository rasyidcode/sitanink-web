<?= $renderer->extend('modules/shared/core/views/layout') ?>

<?php
$fdErr = session()->getFlashdata('error');
$errIcon = '<i class="fa fa-times-circle-o"></i>';
?>

<?= $renderer->section('content') ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Tambah Lokasi Kerja</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-offset-1 col-sm-8 col-md-offset-1 col-md-8 col-lg-offset-4 col-lg-4">
                            <form id="form-tambah-lokasi-kerja" action="<?= route_to('lokasi-kerja.create') ?>" method="POST" role="form">
                                <?= csrf_field() ?>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group <?= isset($fdErr['nama']) ? 'has-error' : '' ?>">
                                            <label class="control-label"><?= isset($fdErr['nama']) ? $errIcon : '' ?>&nbsp;Nama Lokasi</label>
                                            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lokasi ..." value="<?= old('nama') ?? '' ?>">
                                            <?php if (isset($fdErr['nama'])) : ?>
                                                <span class="help-block"><?= $fdErr['nama'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group <?= isset($fdErr['lon']) ? 'has-error' : '' ?>">
                                            <label class="control-label"><?= isset($fdErr['nama']) ? $errIcon : '' ?>&nbsp;Koordinat Lokasi</label>
                                            <div id="lokasi-kerja-peta" style="width: 500px; height: 350px;"></div>
                                            <p>Koordinat : <strong id="koordinat"></strong></p>
                                            <?php if (isset($fdErr['lon'])) : ?>
                                                <span class="help-block"><?= $fdErr['lon'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="lon">
                                <input type="hidden" name="lat">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $renderer->endSection() ?>

<?= $renderer->section('custom-js') ?>
<!-- <script src='https://api.mapbox.com/mapbox-gl-js/v2.0.1/mapbox-gl.js'></script> -->
<!-- <script src='https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl-csp.js'></script> -->
<script src='<?=site_url('assets/js/mapbox-gl-csp.js')?>'></script>
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.min.js"></script>
<script>
    $(function() {
        // mapboxgl.workerUrl = "https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl-csp-worker.js";
        mapboxgl.workerUrl = "<?=site_url('assets/js/mapbox-gl-csp.js')?>";
        mapboxgl.accessToken = 'pk.eyJ1IjoiamFtaWxjaGFuIiwiYSI6ImNrNG1oOWI1YjJqNmUzZG9iZjU3MHRhYzQifQ.U4Y11hHODjokNS7Jmlw0Xg';
        var map = new mapboxgl.Map({
            container: 'lokasi-kerja-peta', //id elemen html
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [106.69972796989238, -6.238601629433243], //koordinat lokasi garis bujur dan lintang,longitude dan latitude
            zoom: 9 // starting zoom
        });

        var geocoder = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            mapboxgl: mapboxgl,
            marker: false,
            placeholder: 'Masukan kata kunci...',
            zoom: 20
        });


        map.addControl(
            geocoder
        );

        let marker = null
        map.on('click', function(e) {
            console.log(e.lngLat);
            if (marker == null) {
                marker = new mapboxgl.Marker()
                    .setLngLat(e.lngLat)
                    .addTo(map);
            } else {
                marker.setLngLat(e.lngLat)
            }
            lk = e.lngLat

            $('#koordinat').text(e.lngLat.lat + "," + e.lngLat.lng);
            $('#form-tambah-lokasi-kerja').find('input[name="lat"]').val(lk.lat);
            $('#form-tambah-lokasi-kerja').find('input[name="lon"]').val(lk.lng);
        });
    });
</script>
<?= $renderer->endSection() ?>

<?= $renderer->section('custom-css') ?>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.css' rel='stylesheet' />
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.css" type="text/css">
<?= $renderer->endSection() ?>