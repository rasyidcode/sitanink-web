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
                    <h3 class="box-title">Form Edit Pekerja</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-offset-3 col-xs-6">
                            <form id="form-edit-pekerja" action="<?= route_to('pekerja.update', $data->id) ?>" method="POST" role="form" enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                <div class="row">
                                    <div class="col-xs-4">
                                        <div class="form-group <?= isset($fdErr['nik']) ? 'has-error' : '' ?>">
                                            <label class="control-label"><?= isset($fdErr['nik']) ? $errIcon : '' ?>&nbsp;NIK (<span style="color: #dd4b39;">*</span>)</label>
                                            <input type="text" name="nik" class="form-control" placeholder="Masukkan nik ..." value="<?= old('nik', $data->nik) ?? '' ?>">
                                            <?php if (isset($fdErr['nik'])) : ?>
                                                <span class="help-block"><?= $fdErr['nik'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group <?= isset($fdErr['nama']) ? 'has-error' : '' ?>">
                                            <label class="control-label"><?= isset($fdErr['nama']) ? $errIcon : '' ?>&nbsp;Nama Lengkap (<span style="color: #dd4b39;">*</span>)</label>
                                            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap ..." value="<?= old('nama', $data->nama) ?? '' ?>">
                                            <?php if (isset($fdErr['nama'])) : ?>
                                                <span class="help-block"><?= $fdErr['nama'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group <?= isset($fdErr['tempat_lahir']) || isset($fdErr['tgl_lahir']) ? 'has-error' : '' ?>">
                                    <label class="control-label"><?= isset($fdErr['tempat_lahir']) || isset($fdErr['tgl_lahir']) ? $errIcon : '' ?>&nbsp;TTL (<span style="color: #dd4b39;">*</span>)</label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="text" name="tempat_lahir" class="form-control" placeholder="Masukkan tempat lahir ..." value="<?= old('tempat_lahir', $data->tempat_lahir) ?? '' ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="tgl_lahir" class="form-control pull-right" id="datepicker" placeholder="Masukkan tanggal lahir ..." value="<?= old('tgl_lahir', $data->tgl_lahir) ?? '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <?php if (isset($fdErr['tempat_lahir'])) : ?>
                                        <span class="help-block"><?= $fdErr['tempat_lahir'] ?></span>
                                    <?php endif; ?>
                                    <?php if (isset($fdErr['tgl_lahir'])) : ?>
                                        <span class="help-block"><?= $fdErr['tgl_lahir'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['alamat']) ? 'has-error' : '' ?>">
                                    <label class="control-label"><?= isset($fdErr['alamat']) ? $errIcon : '' ?>&nbsp;</i>Alamat (<span style="color: #dd4b39;">*</span>)</label>
                                    <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap ..."><?= old('alamat', $data->alamat) ?? '' ?></textarea>
                                    <?php if (isset($fdErr['alamat'])) : ?>
                                        <span class="help-block"><?= $fdErr['alamat'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['id_pekerjaan']) ? 'has-error' : '' ?>">
                                    <label class=" control-label"><?= isset($fdErr['pekerjaan']) ? $errIcon : '' ?>&nbsp;Pekerjaan (<span style="color: #dd4b39;">*</span>)</label>
                                    <select name="id_pekerjaan" class="form-control">
                                        <option value="">-- Pilih salah satu --</option>
                                        <?php $oldPekerjaan = old('id_pekerjaan', $data->id_pekerjaan); ?>
                                        <?php foreach ($ddData['pekerjaan'] as $pekerjaanItem) : ?>
                                            <option value="<?= $pekerjaanItem->value ?>" <?= isset($oldPekerjaan) ? ($oldPekerjaan == $pekerjaanItem->value ? 'selected' : '') : '' ?>><?= $pekerjaanItem->text ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (isset($fdErr['id_pekerjaan'])) : ?>
                                        <span class="help-block"><?= $fdErr['id_pekerjaan'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['id_jenis_pekerja']) ? 'has-error' : '' ?>">
                                    <label class=" control-label"><?= isset($fdErr['jenis_pekerja']) ? $errIcon : '' ?>&nbsp;Jenis Pekerja (<span style="color: #dd4b39;">*</span>)</label>
                                    <select name="id_jenis_pekerja" class="form-control">
                                        <option value="">-- Pilih salah satu --</option>
                                        <?php $oldJenisPekerja = old('id_jenis_pekerja', $data->id_jenis_pekerja); ?>
                                        <?php foreach ($ddData['jenis_pekerja'] as $jenisPekerjaItem) : ?>
                                            <option value="<?= $jenisPekerjaItem->value ?>" <?= isset($oldJenisPekerja) ? ($oldJenisPekerja == $jenisPekerjaItem->value ? 'selected' : '') : '' ?>><?= $jenisPekerjaItem->text ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (isset($fdErr['id_jenis_pekerja'])) : ?>
                                        <span class="help-block"><?= $fdErr['id_jenis_pekerja'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['id_lokasi_kerja']) ? 'has-error' : '' ?>">
                                    <label class=" control-label"><?= isset($fdErr['id_lokasi_kerja']) ? $errIcon : '' ?>&nbsp;Lokasi Kerja (<span style="color: #dd4b39;">*</span>)</label>
                                    <select name="id_lokasi_kerja" class="form-control">
                                        <option value="">-- Pilih salah satu --</option>
                                        <?php $oldLokasikerja = old('id_lokasi_kerja', $data->id_lokasi_kerja); ?>
                                        <?php foreach ($ddData['lokasi_kerja'] as $lokasikerjaItem) : ?>
                                            <option value="<?= $lokasikerjaItem->value ?>" <?= isset($oldLokasikerja) ? ($oldLokasikerja == $lokasikerjaItem->value ? 'selected' : '') : '' ?>><?= $lokasikerjaItem->text ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (isset($fdErr['id_lokasi_kerja'])) : ?>
                                        <span class="help-block"><?= $fdErr['id_lokasi_kerja'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['foto']) ? 'has-error' : '' ?>">
                                    <label for="foto"><?= isset($fdErr['foto']) ? $errIcon : '' ?>&nbsp;Foto (<span style="color: #dd4b39;">*</span>)</label>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <input type="file" name="foto">
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <a style="cursor: pointer;" 
                                                data-toggle="modal" 
                                                data-target="#modal-show-image" 
                                                data-tipe-berkas="foto"
                                                onclick="return false"><i class="fa fa-eye"></i>&nbsp;lihat berkas</a>&nbsp;&nbsp;
                                            <a class="hapus-berkas text-danger" href="javascript:void(0)"><i class="fa fa-trash"></i>&nbsp;hapus</a>
                                        </div>
                                    </div>
                                    <p>Max. <strong>200 KB</strong></p>
                                    <?php if (isset($fdErr['foto'])) : ?>
                                        <span class="help-block"><?= $fdErr['foto'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['ktp']) ? 'has-error' : '' ?>">
                                    <label for="ktp"><?= isset($fdErr['ktp']) ? $errIcon : '' ?>&nbsp;KTP (<span style="color: #dd4b39;">*</span>)</label>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <input type="file" name="ktp">
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <a style="cursor: pointer;" 
                                                data-toggle="modal" 
                                                data-target="#modal-show-image" 
                                                data-tipe-berkas="ktp"
                                                onclick="return false"><i class="fa fa-eye"></i>&nbsp;lihat berkas</a>&nbsp;&nbsp;
                                            <a class="hapus-berkas text-danger" href="javascript:void(0)"><i class="fa fa-trash"></i>&nbsp;hapus</a>
                                        </div>
                                    </div>
                                    <p>Max. <strong>200 KB</strong></p>
                                    <?php if (isset($fdErr['ktp'])) : ?>
                                        <span class="help-block"><?= $fdErr['ktp'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['kk']) ? 'has-error' : '' ?>">
                                    <label for="kk"><?= isset($fdErr['kk']) ? $errIcon : '' ?>&nbsp;Kartu Keluarga (<span style="color: #dd4b39;">*</span>)</label>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <input type="file" name="kk">
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <a style="cursor: pointer;" 
                                                data-toggle="modal" 
                                                data-target="#modal-show-image" 
                                                data-tipe-berkas="kk"
                                                onclick="return false"><i class="fa fa-eye"></i>&nbsp;lihat berkas</a>&nbsp;&nbsp;
                                            <a class="hapus-berkas text-danger" href="javascript:void(0)"><i class="fa fa-trash"></i>&nbsp;hapus</a>
                                        </div>
                                    </div>
                                    <p>Max. <strong>200 KB</strong></p>
                                    <?php if (isset($fdErr['kk'])) : ?>
                                        <span class="help-block"><?= $fdErr['kk'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['spiu']) ? 'has-error' : '' ?>">
                                    <label for="spiu"><?= isset($fdErr['spiu']) ? $errIcon : '' ?>&nbsp;Surat Permohohan Ijin Usaha (<span style="color: #dd4b39;">*</span>)</label>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <input type="file" name="spiu">
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <a style="cursor: pointer;" 
                                                data-toggle="modal" 
                                                data-target="#modal-show-image" 
                                                data-tipe-berkas="spiu"
                                                onclick="return false"><i class="fa fa-eye"></i>&nbsp;lihat berkas</a>&nbsp;&nbsp;
                                            <a class="hapus-berkas text-danger" href="javascript:void(0)"><i class="fa fa-trash"></i>&nbsp;hapus</a>
                                        </div>
                                    </div>
                                    <p>Max. <strong>200 KB</strong></p>
                                    <?php if (isset($fdErr['spiu'])) : ?>
                                        <span class="help-block"><?= $fdErr['spiu'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['sp']) ? 'has-error' : '' ?>">
                                    <label for="sp"><?= isset($fdErr['sp']) ? $errIcon : '' ?>&nbsp;Surat Pernyataan (<span style="color: #dd4b39;">*</span>)</label>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <input type="file" name="sp">
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <a style="cursor: pointer;" 
                                                data-toggle="modal" 
                                                data-target="#modal-show-image" 
                                                data-tipe-berkas="sp"
                                                onclick="return false"><i class="fa fa-eye"></i>&nbsp;lihat berkas</a>&nbsp;&nbsp;
                                            <a class="hapus-berkas text-danger" href="javascript:void(0)"><i class="fa fa-trash"></i>&nbsp;hapus</a>
                                        </div>
                                    </div>
                                    <p>Max. <strong>200 KB</strong></p>
                                    <?php if (isset($fdErr['sp'])) : ?>
                                        <span class="help-block"><?= $fdErr['sp'] ?></span>
                                    <?php endif; ?>
                                </div>
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

    <!-- <div class="modal fade" id="modal-camera" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Camera</h4>
                </div>
                <div class="modal-body">
                    <video id="video" width="640" height="480" autoplay></video>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button id="btn-camera-confirm" type="button" class="btn btn-primary">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div> -->

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
</section>

<?= $renderer->endSection() ?>

<?= $renderer->section('custom-css') ?>
<link rel="stylesheet" href="<?= site_url('adminlte2/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') ?>">
<?= $renderer->endSection() ?>

<?= $renderer->section('custom-js') ?>
<script src="<?= site_url('adminlte2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') ?>"></script>
<script src="<?= site_url('adminlte2/plugins/input-mask/jquery.inputmask.js') ?>"></script>
<script>
    $(function() {
        var canvas = document.querySelector('#canvas');
        var video = document.getElementById('video');

        $('#datepicker').datepicker({
            autoclose: true
        });

        $('#form-add-pekerja input[name="nik"]').inputmask('9999-9999-9999-9999');

        // $('#camera-ktp').on('click', function(e) {
        //     $('#modal-camera').modal('show');
        // });

        // $('#modal-camera').on('shown.bs.modal', async function(e) {
        //     if (location.protocol !== 'https:') {
        //         $('#video').parent().html('<p class="text-danger">This website is not secured</p>');
        //     } else {
        //         var stream = await navigator.mediaDevices.getUserMedia({
        //             video: true,
        //             audio: false
        //         });

        //         video.srcObject = stream;
        //     }
        // });

        // $('#btn-camera-confirm').on('click', function(e) {
        //     canvas.getContext('2d')
        //         .drawImage(video, 0, 0, canvas.width, canvas.height);
        //     var imageDataUrl = canvas.DataToURL('image/jpeg');
        // });

        $('#form-edit-pekerja').on('click', '.row .col-xs-6.text-right a.hapus-berkas', function(e) {
            if (confirm('Apakah yakin ingin menghapus berkas ini?')) {
                var tipe = $(this).prev().data().tipeBerkas;
                $.ajax({
                    type: 'post',
                    url: `<?= route_to('api.pekerja.delete-berkas', $data->id) ?>?tipe=${tipe}`,
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('Authorization', 'Basic ' + btoa('sitaninkadmin:admin123'));
                    },
                    success: function(res) {
                        console.log(res);

                        alert(res.message);
                        if (res.success) {
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(err) {
                        console.log(err);

                        alert('Gagal menghapus berkas, silahkan hubungi administrator!');
                    }
                });
            }
        });

        $('#modal-show-image').on('show.bs.modal', function(e) {
            var relatedTarget = $(e.relatedTarget).data();
            var tipe = relatedTarget.tipeBerkas;
            var $thisElement = $(this);

            $($thisElement).find('img')
                .attr('src', '')
                .attr('alt', tipe);
            $.ajax({
                type: 'get',
                url: `<?= route_to('api.pekerja.get-berkas', $data->id) ?>?tipe=${tipe}`,
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', 'Basic ' + btoa('sitaninkadmin:admin123'));
                },
                success: function(res) {
                    console.log(res);

                    if (res.data) {
                        $thisElement.find('img')
                               .attr('src', `<?= site_url('uploads') ?>/${res.data.filename}`)
                               .attr('alt', tipe);
                    } else {
                        alert('Failed to show image!');
                    }
                },
                error: function(err) {
                    console.log(err);

                    alert('Failed to show image!');
                }
            })
        });
    });
</script>
<?= $renderer->endSection() ?>