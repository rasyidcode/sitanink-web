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
                    <h3 class="box-title">Form Tambah Pekerja</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-offset-3 col-xs-6">
                            <form id="form-add-pekerja" action="<?= route_to('pekerja.create') ?>" method="POST" role="form" enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                <div class="row">
                                    <div class="col-xs-4">
                                        <div class="form-group <?= isset($fdErr['nik']) ? 'has-error' : '' ?>">
                                            <label class="control-label"><?= isset($fdErr['nik']) ? $errIcon : '' ?>&nbsp;NIK (<span style="color: #dd4b39;">*</span>)</label>
                                            <input type="text" name="nik_text" class="form-control" placeholder="Masukkan nik ..." value="<?= old('nik') ?? '' ?>">
                                            <input type="hidden" name="nik" class="form-control" value="<?= old('nik') ?? '' ?>">
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
                                            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap ..." value="<?= old('nama') ?? '' ?>">
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
                                            <input type="text" name="tempat_lahir" class="form-control" placeholder="Masukkan tempat lahir ..." value="<?= old('tempat_lahir') ?? '' ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="tgl_lahir" class="form-control pull-right" id="datepicker" placeholder="Masukkan tanggal lahir ..." value="<?= old('tgl_lahir') ?? '' ?>">
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
                                    <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap ..."><?= old('alamat') ?? '' ?></textarea>
                                    <?php if (isset($fdErr['alamat'])) : ?>
                                        <span class="help-block"><?= $fdErr['alamat'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['pekerjaan']) ? 'has-error' : '' ?>">
                                    <label class=" control-label"><?= isset($fdErr['pekerjaan']) ? $errIcon : '' ?>&nbsp;Pekerjaan (<span style="color: #dd4b39;">*</span>)</label>
                                    <input type="text" name="pekerjaan" class="form-control" placeholder="Masukkan Pekerjaan ..." value="<?= old('pekerjaan') ?? '' ?>">
                                    <?php if (isset($fdErr['pekerjaan'])) : ?>
                                        <span class="help-block"><?= $fdErr['pekerjaan'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['id_jenis_pekerja']) ? 'has-error' : '' ?>">
                                    <label class=" control-label"><?= isset($fdErr['jenis_pekerja']) ? $errIcon : '' ?>&nbsp;Jenis Pekerja (<span style="color: #dd4b39;">*</span>)</label>
                                    <select name="id_jenis_pekerja" class="form-control">
                                        <option value="">-- Pilih salah satu --</option>
                                        <?php $oldItem = old('id_jenis_pekerja'); ?>
                                        <?php foreach ($djp as $djpItem) : ?>
                                            <option value="<?= $djpItem->value ?>" <?= isset($oldItem) ? ($oldItem == $djpItem->value ? 'selected' : '') : '' ?>><?= $djpItem->text ?></option>
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
                                        <?php $oldItem = old('id_lokasi_kerja'); ?>
                                        <?php foreach ($dlk as $dlkItem) : ?>
                                            <option value="<?= $dlkItem->value ?>" <?= isset($oldItem) ? ($oldItem == $dlkItem->value ? 'selected' : '') : '' ?>><?= $dlkItem->text ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (isset($fdErr['id_lokasi_kerja'])) : ?>
                                        <span class="help-block"><?= $fdErr['id_lokasi_kerja'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['foto']) ? 'has-error' : '' ?>">
                                    <label for="foto"><?= isset($fdErr['foto']) ? $errIcon : '' ?>&nbsp;Foto (<span style="color: #dd4b39;">*</span>)</label>
                                    <input type="file" name="foto">
                                    <p>Max. <strong>200 KB</strong></p>
                                    <?php if (isset($fdErr['foto'])) : ?>
                                        <span class="help-block"><?= $fdErr['foto'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['ktp']) ? 'has-error' : '' ?>">
                                    <label for="ktp"><?= isset($fdErr['ktp']) ? $errIcon : '' ?>&nbsp;KTP (<span style="color: #dd4b39;">*</span>)</label>
                                    <input type="file" name="ktp">
                                    <p>Max. <strong>200 KB</strong></p>
                                    <?php if (isset($fdErr['ktp'])) : ?>
                                        <span class="help-block"><?= $fdErr['ktp'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <!-- <div class="form-group <?= isset($fdErr['kk']) ? 'has-error' : '' ?>">
                                    <label for="kk"><?= isset($fdErr['kk']) ? $errIcon : '' ?>&nbsp;Kartu Keluarga (<span style="color: #dd4b39;">*</span>)</label>
                                    <input type="file" name="kk">
                                    <p>Max. <strong>200 KB</strong></p>
                                    <?php if (isset($fdErr['kk'])) : ?>
                                        <span class="help-block"><?= $fdErr['kk'] ?></span>
                                    <?php endif; ?>
                                </div> -->
                                <div class="form-group <?= isset($fdErr['spiu']) ? 'has-error' : '' ?>">
                                    <label for="spiu"><?= isset($fdErr['spiu']) ? $errIcon : '' ?>&nbsp;Surat Permohohan Ijin Usaha (<span style="color: #dd4b39;">*</span>)</label>
                                    <input type="file" name="spiu">
                                    <p>Max. <strong>200 KB</strong></p>
                                    <?php if (isset($fdErr['spiu'])) : ?>
                                        <span class="help-block"><?= $fdErr['spiu'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['sp']) ? 'has-error' : '' ?>">
                                    <label for="foto"><?= isset($fdErr['sp']) ? $errIcon : '' ?>&nbsp;Surat Pernyataan (<span style="color: #dd4b39;">*</span>)</label>
                                    <input type="file" name="sp">
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
        $('#datepicker').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });

        $('#form-add-pekerja input[name="nik_text"]').inputmask('9999-9999-9999-9999');

        $('#form-add-pekerja input[name="nik_text"]').on('keypress', function(e) {
            var nikValue = $(this).val();
            
            $(this)
                .next()
                .val(nikValue.split('-').join(''));
        });
    });
</script>
<?= $renderer->endSection() ?>