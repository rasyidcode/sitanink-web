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
                    <h3 class="box-title">Generate Kartu</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-5">
                            <form id="form-generate-kartu" method="POST" role="form">
                                <?= csrf_field() ?>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">Pekerja (<span style="color: #dd4b39;">*</span>)</label>
                                            <select name="pekerja" class="form-control">
                                                <option value="">-- Pilih salah satu --</option>
                                                <?php foreach ($listPekerja as $pekerja) : ?>
                                                    <option value="<?= $pekerja->id ?>"><?= $pekerja->nama ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <span class="help-block">Pilih pekerja yang akan digenerate kartu nya.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group <?= isset($fdErr['valid_until']) || isset($fdErr['valid_until']) ? 'has-error' : '' ?>">
                                            <label><?= isset($fdErr['tempat_lahir']) || isset($fdErr['tgl_lahir']) ? $errIcon : '' ?>&nbsp;Valid Until (<span style="color: #dd4b39;">*</span>)</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="valid_until" class="form-control pull-right" id="datepicker" placeholder="Masukkan tanggal expired..." value="<?= old('valid_until') ?? '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if (isset($fdErr['tgl_lahir'])) : ?>
                                    <span class="help-block"><?= $fdErr['tgl_lahir'] ?></span>
                                <?php endif; ?>
                                <div class="form-group">
                                    <button type="button" class="btn btn-success btn-sm">
                                        <i style="margin-right: 4px;" class="fa fa-eye"></i>Preview
                                        <span style="display: none;" class="now-loading">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </span>
                                    </button>
                                    <button style="margin-left: 8px;" type="button" class="btn btn-primary btn-sm pull-right">
                                        <i style="margin-right: 4px;" class="fa fa-save"></i>Submit
                                        <span style="display: none;" class="now-loading2">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </span>
                                    </button>
                                    <!-- <button type="button" class="btn btn-danger btn-sm pull-right"><i style="margin-right: 4px;" class="fa fa-times"></i>Batal</button> -->
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <img id="card-front" width="500" height="300" src="<?= site_url('assets/images/card-front.png') ?>" alt="Card Front">
                        </div>
                        <div class="col-lg-12">
                            <img id="card-back" width="500" height="300" src="<?= site_url('assets/images/card-back.png') ?>" alt="Card Back">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $renderer->endSection() ?>

<?= $renderer->section('custom-js') ?>
<script src="<?= site_url('adminlte2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') ?>"></script>
<script>
    $(function() {
        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        $('#form-generate-kartu').find('button.btn-success').on('click', function(e) {
            $('.now-loading').show();

            var idPekerja = $('#form-generate-kartu').find('select[name="pekerja"]').val();
            var validUntil = $('#form-generate-kartu').find('input[name="valid_until"]').val();

            if (idPekerja == '' && validUntil == '') {
                console.log('empty');
                return;
            }

            var data = {
                id_pekerja: idPekerja,
                valid_until: validUntil,
                generate_request: 'preview'
            };

            setTimeout(() => {
                $.ajax({
                    url: '<?= route_to('api.card.generate') ?>',
                    data: data,
                    type: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('Authorization', 'Basic ' + btoa('sitaninkadmin:admin123'));
                    },
                    success: function(res, textStatus, xhr) {
                        console.log(res);

                        if (xhr.status !== 200) {
                            alert(res.message);

                            $('#card-front').attr('src', '<?= site_url('assets/images/card-front.png') ?>');
                            $('#card-back').attr('src', '<?= site_url('assets/images/card-front.png') ?>');
                            return;
                        }

                        $('#card-front').attr('src', res.card_front_path);
                        $('#card-back').attr('src', res.card_front_back);

                        $('.now-loading').hide();
                    },
                    error: function(err) {
                        console.log(err);

                        alert(err.responseJSON.message);
                        $('.now-loading').hide();
                    }
                })
            }, 1000);
        });

        $('#form-generate-kartu').find('button.btn-primary').on('click', function(e) {
            $('.now-loading2').show();

            var idPekerja = $('#form-generate-kartu').find('select[name="pekerja"]').val();
            var validUntil = $('#form-generate-kartu').find('input[name="valid_until"]').val();

            if (idPekerja == '' && validUntil == '') {
                console.log('empty');
                return;
            }

            var data = {
                id_pekerja: idPekerja,
                valid_until: validUntil,
                generate_request: 'save'
            };

            setTimeout(() => {
                $.ajax({
                    url: '<?= route_to('api.card.generate') ?>',
                    data: data,
                    type: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('Authorization', 'Basic ' + btoa('sitaninkadmin:admin123'));
                    },
                    success: function(res, textStatus, xhr) {
                        console.log(res);

                        if (xhr.status !== 200) {
                            alert(res.message);

                            $('#card-front').attr('src', '<?= site_url('assets/images/card-front.png') ?>');
                            $('#card-back').attr('src', '<?= site_url('assets/images/card-front.png') ?>');
                            return;
                        }

                        alert('Berhasil, silahkan kembali ke halaman list');

                        setTimeout(() => {
                            window.location.href = '<?=route_to('kartu')?>'
                        }, 500);

                        $('.now-loading2').hide();
                    },
                    error: function(err) {
                        console.log(err);

                        alert(err.responseJSON.message);
                        $('.now-loading2').hide();
                    }
                })
            }, 1000);
        });
    });
</script>
<?= $renderer->endSection() ?>

<?= $renderer->section('custom-css') ?>
<link rel="stylesheet" href="<?= site_url('adminlte2/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') ?>">
<style>
    .now-loading {
        margin-left: 4px;
        display: inline-block;
        position: relative;
        width: 17px;
        height: 10px;
    }

    .now-loading div {
        box-sizing: border-box;
        display: block;
        position: absolute;
        width: 14px;
        height: 14px;
        /* margin: 2px; */
        border: 2px solid #fff;
        border-radius: 50%;
        animation: now-loading 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        border-color: #fff transparent transparent transparent;
    }

    .now-loading div:nth-child(1) {
        animation-delay: -0.45s;
    }

    .now-loading div:nth-child(2) {
        animation-delay: -0.3s;
    }

    .now-loading div:nth-child(3) {
        animation-delay: -0.15s;
    }

    @keyframes now-loading {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .now-loading2 {
        margin-left: 4px;
        display: inline-block;
        position: relative;
        width: 17px;
        height: 10px;
    }

    .now-loading2 div {
        box-sizing: border-box;
        display: block;
        position: absolute;
        width: 14px;
        height: 14px;
        /* margin: 2px; */
        border: 2px solid #fff;
        border-radius: 50%;
        animation: now-loading2 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        border-color: #fff transparent transparent transparent;
    }

    .now-loading2 div:nth-child(1) {
        animation-delay: -0.45s;
    }

    .now-loading2 div:nth-child(2) {
        animation-delay: -0.3s;
    }

    .now-loading2 div:nth-child(3) {
        animation-delay: -0.15s;
    }

    @keyframes now-loading2 {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<?= $renderer->endSection() ?>