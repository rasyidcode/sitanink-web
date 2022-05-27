<?= $renderer->extend('modules/shared/core/views/layout') ?>

<?= $renderer->section('content') ?>
<section class="content">
    <div class="row">
        <?php if ($totalDataToReview > 0) : ?>
            <div class="col-xs-6">
                <div class="callout callout-danger">
                    <h4><i class="fa fa-bell"></i>&nbsp;&nbsp;Review Data Pekerja</h4>
                    <p>Ada total <strong><?= $totalDataToReview ?> data pekerja</strong> yang harus segera direview, silahkan klik <a href="<?= route_to('pekerja.review') ?>">disini</a> untuk melakukan pengecekan.</p>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-xs-12">
            <div class="box box-warning">
                <div class="box-header">
                    <a href="<?= route_to('pekerja.add') ?>" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah Pekerja</a>
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
                                <table id="data-pekerja" class="table table-bordered table-striped dataTable">
                                    <thead>
                                        <tr role="row">
                                            <th>#</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>TTL</th>
                                            <th>Alamat</th>
                                            <th>Jenis Pekerja</th>
                                            <th>Lokasi Kerja</th>
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
            ajax: function(data, callback, settings) {
                var data = {
                    ...data,
                    ['<?= csrf_token() ?>']: '<?= csrf_hash() ?>'
                }
                $.ajax({
                    type: 'post',
                    url: '<?= route_to('pekerja.get-data') ?>',
                    data: data,
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
                    orderable: true,
                    searchable: true
                },
                {
                    targets: 7,
                    orderable: true,
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