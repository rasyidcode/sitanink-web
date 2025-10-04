<?= $renderer->extend('modules/shared/core/views/layout') ?>

<?= $renderer->section('content') ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header">
                    <a href="<?= route_to('jenis-pekerja.add') ?>" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah Jenis Pekerja</a>
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
                                <table id="data-jenis-pekerja" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr role="row">
                                            <th>#</th>
                                            <th>Nama</th>
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
        $('#data-jenis-pekerja').DataTable({
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
                    url: '<?= route_to('api.jenis-pekerja.get-data') ?>',
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
                    orderable: false,
                    searchable: false
                },
                {
                    targets: 3,
                    orderable: false,
                    searchable: false
                },
            ],
            drawCallback: function(settings) {}
        });

        // delete user
        $('#data-jenis-pekerja tbody').on('click', 'tr td button.btn.btn-danger', function(e) {
            var id = $(this).data().jenisPekerjaId;
            var baseUrl = window.location.href;

            if (confirm('Anda yakin mau dihapus?')) {
                $.ajax({
                    url: baseUrl + '/' + id + '/delete',
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

        $('#data-jenis-pekerja tbody').on('click', 'tr td a.btn.btn-success', function(e) {
            console.log('comming soon');
            alert('Comming soon!');
        });
    });
</script>
<?= $renderer->endSection() ?>

<?= $renderer->section('custom-css') ?>
<link rel="stylesheet" href="<?= site_url('adminlte2/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') ?>">
<?= $renderer->endSection() ?>