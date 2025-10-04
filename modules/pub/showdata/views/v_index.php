<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Data Pekerja</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?= site_url('adminlte2/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= site_url('adminlte2/bower_components/font-awesome/css/font-awesome.min.css') ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= site_url('adminlte2/bower_components/Ionicons/css/ionicons.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= site_url('adminlte2/dist/css/AdminLTE.min.css') ?>">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= site_url('adminlte2/plugins/iCheck/square/blue.css') ?>">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <style>
        .foto-css {
            width: calc(354px * 0.5);
            height: calc(472px * 0.5);
            object-fit: cover;
        }

        .ktp-css {
            width: calc(640px * 0.8);
            height: calc(320px * 0.8);
            object-fit: cover;
        }

        .sp-css {
            width: 80%;
            height: 80%;
            object-fit: cover;
        }

        .add-border {
            border: 1px solid #aaa;
        }
    </style>
</head>

<body class="hold-transition register-page">
    <div style="width: 640px" class="register-box">
        <div class="register-logo">
            <a href="javascript:void(0)">Data Pekerja</a>
        </div>

        <div class="register-box-body">
            <div class="row">
                <div class="col-xs-12">
                    <div class="foto-css add-border center-block">
                        <?php if (!is_null($data->foto_filename ?? null)) : ?>
                            <img class="foto-css center-block" src="<?= site_url('uploads/' . $data->foto_filename) ?>" alt="Photo">
                        <?php else : ?>
                            <p class="text-left text-danger">Berkas Foto tidak ada!</p>
                        <?php endif; ?>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>NIK</th>
                                    <td>:</td>
                                    <td><?= $data->nik ?? '' ?></td>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <td>:</td>
                                    <td><?= $data->nama ?? '' ?></td>
                                </tr>
                                <tr>
                                    <th>TTL</th>
                                    <td>:</td>
                                    <td><?= $data->ttl ?? '' ?></td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>:</td>
                                    <td><?= $data->alamat ?? '' ?></td>
                                </tr>
                                <tr>
                                    <th>Pekerjaan</th>
                                    <td>:</td>
                                    <td><?= $data->pekerjaan ?? '' ?></td>
                                </tr>
                                <tr>
                                    <th>Lokasi Kerja</th>
                                    <td>:</td>
                                    <td><?= $data->lokasi_kerja ?? '' ?></td>
                                </tr>
                                <tr>
                                    <th>Jenis Pekerja</th>
                                    <td>:</td>
                                    <td><?= $data->jenis_pekerja ?? '' ?></td>
                                </tr>
                                <tr>
                                    <th>KTP</th>
                                    <td>:</td>
                                    <td>
                                        <a style="cursor: pointer;" data-toggle="modal" data-target="#modal-show-image" data-tipe-berkas="2" onclick="return false"><i class="fa fa-eye"></i> Lihat</a>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <th>KK</th>
                                    <td>:</td>
                                    <td>
                                        <a style="cursor: pointer;" data-toggle="modal" data-target="#modal-show-image" data-tipe-berkas="3" onclick="return false"><i class="fa fa-eye"></i> Lihat</a>
                                    </td>
                                </tr> -->
                                <tr>
                                    <th>Surat Permohonan Ijin Usaha</th>
                                    <td>:</td>
                                    <td>
                                        <a style="cursor: pointer;" data-toggle="modal" data-target="#modal-show-image" data-tipe-berkas="4" onclick="return false"><i class="fa fa-eye"></i> Lihat</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Surat Perijinan</th>
                                    <td>:</td>
                                    <td>
                                        <a style="cursor: pointer;" data-toggle="modal" data-target="#modal-show-image" data-tipe-berkas="5" onclick="return false"><i class="fa fa-eye"></i> Lihat</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.form-box -->
    </div>
    <!-- /.register-box -->

    <div class="modal fade" id="modal-show-image">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <img class="center-block img-responsive" src="#" alt="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- jQuery 3 -->
    <script src="<?= site_url('adminlte2/bower_components/jquery/dist/jquery.min.js') ?>"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?= site_url('adminlte2/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
    <!-- iCheck -->
    <script src="<?= site_url('adminlte2/plugins/iCheck/icheck.min.js') ?>"></script>
    <script>
        $(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' /* optional */
            });

            $('#modal-show-image').on('show.bs.modal', function(e) {
                var relatedTarget = $(e.relatedTarget).data();
                var tipe = relatedTarget.tipeBerkas;
                console.log(tipe);
                var $thisElement = $(this);

                $($thisElement)
                    .find('img')
                    .attr('src', '')
                    .attr('alt', '');

                $.ajax({
                    type: 'get',
                    url: `<?= site_url('api/v1/berkas/get-by-pekerja-and-type/' . ($data->id ?? '')) ?>/${tipe}`,
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('Authorization', 'Basic ' + btoa('sitaninkadmin:admin123'));
                    },
                    success: function(res) {
                        console.log(res);

                        if (res.data) {
                            $thisElement
                                .find('img')
                                .show();
                            $thisElement
                                .find('img')
                                .next()
                                .hide()
                            $thisElement.find('img')
                                .attr('src', `<?= site_url('uploads') ?>/${res.data.filename}`)
                                .attr('alt', tipe);
                        } else {
                            $($thisElement)
                                .find('img')
                                .attr('src', '')
                                .attr('alt', '');
                            $thisElement
                                .find('img')
                                .hide();
                            $thisElement
                                .find('img')
                                .next()
                                .show()
                            $thisElement
                                .find('img')
                                .next()
                                .html('[Gambar tidak ditemukan]');
                        }
                    },
                    error: function(err) {
                        console.log(err);

                        $($thisElement)
                            .find('img')
                            .attr('src', '')
                            .attr('alt', '');
                        $thisElement
                            .find('img')
                            .hide();
                        $thisElement
                            .find('img')
                            .next()
                            .show()
                        $thisElement
                            .find('img')
                            .next()
                            .html('[Gambar tidak ditemukan]');
                    }
                })
            });
        });
    </script>
</body>

</html>