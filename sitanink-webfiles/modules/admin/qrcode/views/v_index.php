<?= $renderer->extend('modules/shared/core/views/layout') ?>

<?= $renderer->section('content') ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">Data QR Code Pekerja</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="data-qrcode" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr role="row">
                                            <th>#</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Status QRCode</th>
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

    <div class="modal fade" id="modal-show-qrcode">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">QRCode</h4>
                </div>
                <div class="modal-body">
                    <div id="qrcode-pekerja"></div>
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
<script src="<?= site_url('assets/js/qrcode.min.js'); ?>"></script>
<script>
    $(function() {
        var qrcode = new QRCode(document.getElementById('qrcode-pekerja'), 'init_value');

        $('#data-qrcode').DataTable({
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
                    url: '<?= route_to('api.qrcode.get-data') ?>',
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
                    orderable: false,
                    searchable: false
                }
            ],
            drawCallback: function(settings) {}
        });

        $('#data-qrcode tbody').on('click', 'tr td button.btn.btn-success', function(e) {
            var qrsecret = $(this).data().qrsecret;
            $('#modal-show-qrcode').modal('show', {qrsecret: qrsecret});
        });

        $('#modal-show-qrcode').on('show.bs.modal', function(e) {
            var qrsecret = e.relatedTarget.qrsecret;
            console.log(qrsecret);
            qrcode.clear();

            if (!qrcode) {
                qrsecret = 'invalid';
            }
            
            qrcode.makeCode(`<?=site_url('qrcode/show-data')?>?qrsecret=${qrsecret}`);
        });

        $('#data-qrcode tbody').on('click', 'tr td button.btn.btn-primary', function(e) {
            if (confirm('Generate QR Code sekarang?')) {
                var id = $(this).data().id;

                $.ajax({
                    url: `<?=site_url('api/v1/qrcode')?>/${id}/generate`,
                    type: 'post',
                    data: { id: id },
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('Authorization', 'Basic ' + btoa('sitaninkadmin:admin123'));
                    },
                    success: function(res) {
                        console.log(res);

                        if (res.success) {
                            alert(res.message);
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            alert('Something went wrong!');
                        }
                    },
                    error: function(err) {
                        console.log(err);
                        alert(err.responseJSON);
                    }
                })
            }
        });
    });
</script>
<?= $renderer->endSection() ?>

<?= $renderer->section('custom-css') ?>
<link rel="stylesheet" href="<?= site_url('adminlte2/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') ?>">
<?= $renderer->endSection() ?>