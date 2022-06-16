<?= $renderer->extend('modules/shared/core/views/layout') ?>

<?= $renderer->section('content') ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">Data Map</h3>
                </div>
                <div class="box-body">
                    <div id="lokasi-kerja-peta" style="max-width: 800px; height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">Data Wilayah Pekerja</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="data-wilayah" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr role="row">
                                            <th>#</th>
                                            <th>Lokasi</th>
                                            <th>Longitude</th>
                                            <th>Latitude</th>
                                            <th>Jumlah Pekerja</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-list-pekerja">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">List Pekerja</h4>
                </div>
                <div class="modal-body">
                    <table style="width: 100%;" class="table table-condensed">
                        <tbody>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Jenis Pekerja</th>
                            </tr>
                        </tbody>
                    </table>
                    <div style="display:none" class="loading center-block"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</section>
<?= $renderer->endSection() ?>

<?= $renderer->section('custom-js') ?>
<script src="<?= site_url('adminlte2/bower_components/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= site_url('adminlte2/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') ?>"></script>
<script src='https://api.mapbox.com/mapbox-gl-js/v2.0.1/mapbox-gl.js'></script>
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.min.js"></script>
<script>
    $(function() {
        mapboxgl.accessToken = 'pk.eyJ1IjoiamFtaWxjaGFuIiwiYSI6ImNrNG1oOWI1YjJqNmUzZG9iZjU3MHRhYzQifQ.U4Y11hHODjokNS7Jmlw0Xg';
        var map = new mapboxgl.Map({
            container: 'lokasi-kerja-peta', //id elemen html
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [106.69972796989238, -6.238601629433243], //koordinat lokasi garis bujur dan lintang,longitude dan latitude
            zoom: 4 // starting zoom
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

        $('#data-wilayah').DataTable({
            dom: 'lrtip',
            searching: true,
            responsive: true,
            pageLength: 10,
            processing: true,
            serverSide: true,
            order: [],
            ajax: function(data, callback, settings) {
                var data = {
                    ...data,
                    ['<?= csrf_token() ?>']: '<?= csrf_hash() ?>'
                }
                $.ajax({
                    type: 'post',
                    url: '<?= route_to('api.wilayah.get-data') ?>',
                    data: data,
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('Authorization', 'Basic ' + btoa('sitaninkadmin:admin123'));
                    },
                    success: function(res) {
                        console.log(res);
                        callback(res);

                        let marker = null
                        res.data.forEach(function(item, index) {
                            var popup = new mapboxgl.Popup()
                                .setText('Jumlah Pekerja: ' + item[4])
                                .addTo(map);
                            new mapboxgl.Marker()
                                .setLngLat([item[2], item[3]])
                                .addTo(map)
                                .setPopup(popup);
                        });
                    },
                    error: function(err) {
                        console.log(err);
                        callback([]);
                    }
                });
            },
            columns: [{
                    targets: 0,
                    orderable: false,
                    searchable: false
                },
                {
                    targets: 1,
                    orderable: true,
                    searchable: true
                },
                {
                    targets: 2,
                    orderable: true,
                    searchable: true
                },
                {
                    targets: 3,
                    orderable: true,
                    searchable: true
                },
                {
                    targets: 4,
                    orderable: true,
                    searchable: false
                },
                {
                    targets: 5,
                    orderable: true,
                    searchable: false
                },
                {
                    targets: 6,
                    orderable: false,
                    searchable: false
                },
            ],
            drawCallback: function(settings) {}
        });

        $('#data-wilayah tbody').on('click', 'tr td button.btn.btn-success', function(e) {
            var id = $(this).data().id;
            $('#modal-list-pekerja').modal('show', {id: id});
        });

        $('#modal-list-pekerja').on('show.bs.modal', function(e) {
            $('.loading').show();
            var id = e.relatedTarget.id;

            $.ajax({
                type: 'get',
                url: `<?= site_url('api/v1/wilayah') ?>/${id}/pekerja`,
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', 'Basic ' + btoa('sitaninkadmin:admin123'));
                },
                success: function(res) {
                    console.log(res);
                    $('#modal-list-pekerja').find('table tbody')
                        .html(`<tr>
                                <th style="width: 10px">#</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Jenis Pekerja</th>
                            </tr>`);
                    res.data.forEach(function(item, index) {
                        $('#modal-list-pekerja').find('table tbody')
                            .append(`
                                <tr>
                                    <td style="width: 10px">${index+1}.</td>
                                    <td>${item.nik}</td>
                                    <td>${item.nama}</td>
                                    <td>${item.jenis_pekerja}</td>
                                </tr>
                            `)
                    });

                    $('.loading').hide();
                },
                error: function(err) {
                    console.log(err);
                    $('.loading').hide();
                    alert('Something went wrong');
                    $('#modal-list-pekerja').modal('hide');
                }
            });
        });

        $('#data-wilayah').on('click', 'tr td button.btn.btn-info', function(e) {
            var lon = $(this).data().lon;
            var lat = $(this).data().lat;
            map.flyTo({center: [lat,lon], zoom: 10});
            window.scrollTo(0, 0);
        });
    });
</script>
<?= $renderer->endSection() ?>

<?= $renderer->section('custom-css') ?>
<link rel="stylesheet" href="<?= site_url('adminlte2/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') ?>">
<link href='https://api.mapbox.com/mapbox-gl-js/v2.0.1/mapbox-gl.css' rel='stylesheet' />
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.css" type="text/css">
<style>
    .loading {
        border: 4px solid #f3f3f3;
        border-radius: 50%;
        border-top: 4px solid #3498db;
        width: 40px;
        height: 40px;
        -webkit-animation: spin 2s linear infinite;
        /* Safari */
        animation: spin 2s linear infinite;
    }

    /* Safari */
    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<?= $renderer->endSection() ?>