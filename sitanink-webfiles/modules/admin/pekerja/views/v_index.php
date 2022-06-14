<?= $renderer->extend('modules/shared/core/views/layout') ?>

<?= $renderer->section('content') ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header">
                    <a href="<?= route_to('pekerja.add') ?>" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah Pekerja</a>
                    <a href="<?= route_to('pekerja.add') ?>" class="btn btn-info btn-xs"><i class="ion ion-ios-download-outline"></i>&nbsp;&nbsp;Export Excel</a>
                    <a href="<?= route_to('pekerja.add') ?>" class="btn btn-warning btn-xs"><i class="ion ion-ios-upload-outline"></i>&nbsp;&nbsp;Import Excel</a>
                    <?php $successMsg = session()->getFlashdata('success'); ?>
                    <?php if (isset($successMsg)) : ?>
                        <span data-message="<?= $successMsg ?>"></span>
                    <?php endif; ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="data-pekerja" class="table table-bordered table-striped dataTable" style="width: 100%;">
                                    <thead>
                                        <tr role="row">
                                            <th>#</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>TTL</th>
                                            <th>Alamat</th>
                                            <th>Pekerjaan</th>
                                            <th>Lokasi Kerja</th>
                                            <th>Jenis Pekerja</th>
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
</section>
<?= $renderer->endSection() ?>

<?= $renderer->section('custom-js') ?>
<script src="<?= site_url('adminlte2/bower_components/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= site_url('adminlte2/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') ?>"></script>
<script>
    $(function() {
        $('#data-pekerja').DataTable({
            dom: 'lrtip',
            searching: true,
            responsive: true,
            pageLength: 25,
            processing: true,
            serverSide: true,
            order: [],
            scrollX: true,
            ajax: function(data, callback, settings) {
                var data = {
                    ...data,
                    ['<?= csrf_token() ?>']: '<?= csrf_hash() ?>'
                }
                $.ajax({
                    type: 'post',
                    url: '<?= route_to('api.pekerja.get-data') ?>',
                    data: data,
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('Authorization', 'Basic ' + btoa('sitaninkadmin:admin123'));
                    },
                    success: function(res) {
                        console.log(res);
                        callback(res);
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
                    searchable: true
                },
                {
                    targets: 5,
                    orderable: true,
                    searchable: true
                },
                {
                    targets: 6,
                    orderable: false,
                    searchable: true
                },
                {
                    targets: 7,
                    orderable: false,
                    searchable: false
                },
                {
                    targets: 8,
                    orderable: true,
                    searchable: false
                },
                {
                    targets: 9,
                    orderable: false,
                    searchable: false
                }
            ],
            drawCallback: function(settings) {}
        });

        var spanData = $('.box-header').find('span').data();
        if (spanData !== undefined) {
            alert(spanData.message);
        }

        // delete pekerja
        $('#data-pekerja tbody').on('click', 'tr td button.btn.btn-danger', function(e) {
            var pekerjaId = $(this).data().pekerjaId;
            var baseUrl = window.location.href;

            if (confirm('Anda yakin mau dihapus?')) {
                $.ajax({
                    url: baseUrl + '/' + pekerjaId + '/delete',
                    type: 'post',
                    data: {
                        ['<?= csrf_token() ?>']: '<?= csrf_hash() ?>'
                    },
                    success: function(res, textStatus, xhr) {
                        console.log(res);

                        alert(res.message);
                        location.reload();
                    },
                    error: function(err) {
                        console.log(err);

                        alert('Something went wrong!');
                    }
                });
            }
        });
    });
</script>
<?= $renderer->endSection() ?>

<?= $renderer->section('custom-css') ?>
<link rel="stylesheet" href="<?= site_url('adminlte2/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') ?>">
<?= $renderer->endSection() ?>