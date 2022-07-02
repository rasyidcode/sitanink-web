<?= $renderer->extend('modules/shared/core/views/layout') ?>

<?= $renderer->section('content') ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header">
                    <a href="<?= route_to('sk.create') ?>" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i>&nbsp;&nbsp;Buat SK</a>
                    <?= $renderer->include('modules/shared/core/views/notification') ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="data-sk" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr role="row">
                                            <th>#</th>
                                            <th>Nomor</th>
                                            <th>Tahun</th>
                                            <th>Berlaku Sampai</th>
                                            <th>Tanggal Ditetapkan</th>
                                            <th>NIP Kepala</th>
                                            <th>Nama Kepala</th>
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
        $('#data-sk').DataTable({
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
                    url: '<?= route_to('api.sk.get-data') ?>',
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
                    orderable: false,
                    searchable: false
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
                {
                    targets: 4,
                    orderable: false,
                    searchable: false
                },
                {
                    targets: 5,
                    orderable: false,
                    searchable: false
                },
                {
                    targets: 6,
                    orderable: false,
                    searchable: false
                },
                {
                    targets: 7,
                    orderable: false,
                    searchable: false
                },
                {
                    targets: 8,
                    orderable: false,
                    searchable: false
                },
            ],
            drawCallback: function(settings) {}
        });

        // delete sk
        $('#data-sk tbody').on('click', 'tr td button.btn.btn-danger', function(e) {
            var id = $(this).data().skId;

            if (confirm('Anda yakin mau dihapus?')) {
                $.ajax({
                    url: `<?=site_url('sk')?>/${id}/delete`,
                    type: 'post',
                    data: {
                        ['<?= csrf_token() ?>']: '<?= csrf_hash() ?>'
                    },
                    success: function(res, textStatus, xhr) {
                        console.log(res);
                        if (xhr.status === 200) {
                            alert('Berhasil terhapus!');
                            location.reload();
                        }
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