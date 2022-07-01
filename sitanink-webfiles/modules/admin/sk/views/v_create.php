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
                    <h3 class="box-title">Buat SK</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-offset-1 col-sm-8 col-md-offset-1 col-md-8 col-lg-offset-4 col-lg-4">
                            <form action="<?= route_to('sk.do-create') ?>" method="POST" role="form">
                                <?= csrf_field() ?>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group <?= isset($fdErr['number']) ? 'has-error' : '' ?>">
                                            <label class="control-label"><?= isset($fdErr['number']) ? $errIcon : '' ?>&nbsp;Nomor Surat (<span style="color: #dd4b39;">*</span>)</label>
                                            <input type="text" name="number" class="form-control" placeholder="Masukkan Nomor Surat ..." value="<?= old('number') ?? '' ?>">
                                            <?php if (isset($fdErr['number'])) : ?>
                                                <span class="help-block"><?= $fdErr['number'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group <?= isset($fdErr['year']) ? 'has-error' : '' ?>">
                                            <label class="control-label"><?= isset($fdErr['year']) ? $errIcon : '' ?>&nbsp;Tahun Surat (<span style="color: #dd4b39;">*</span>)</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="year" class="form-control pull-right" value="" id="year-picker" placeholder="Masukkan Tahun Surat...">
                                                <?php if (isset($fdErr['year'])) : ?>
                                                    <span class="help-block"><?= $fdErr['year'] ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group <?= isset($fdErr['valid_until']) ? 'has-error' : '' ?>">
                                            <label class="control-label"><?= isset($fdErr['valid_until']) ? $errIcon : '' ?>&nbsp;Surat Berlaku Sampai (<span style="color: #dd4b39;">*</span>)</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="valid_until" class="form-control pull-right" value="" id="valid-until-picker" placeholder="Masukkan Berlaku Sampai...">
                                                <?php if (isset($fdErr['valid_until'])) : ?>
                                                    <span class="help-block"><?= $fdErr['valid_until'] ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group <?= isset($fdErr['set_date']) ? 'has-error' : '' ?>">
                                            <label class="control-label"><?= isset($fdErr['set_date']) ? $errIcon : '' ?>&nbsp;Tanggal Surat Ditetapkan (<span style="color: #dd4b39;">*</span>)</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="set_date" class="form-control pull-right" value="" id="set-date-picker" placeholder="Masukkan Tanggal Surat Ditetapkan...">
                                                <?php if (isset($fdErr['set_date'])) : ?>
                                                    <span class="help-block"><?= $fdErr['set_date'] ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group <?= isset($fdErr['boss_nip']) ? 'has-error' : '' ?>">
                                            <label class="control-label"><?= isset($fdErr['boss_nip']) ? $errIcon : '' ?>&nbsp;NIP Kepala (<span style="color: #dd4b39;">*</span>)</label>
                                            <input type="text" name="boss_nip" class="form-control" placeholder="Masukkan NIP Kepala ..." value="<?= old('boss_nip') ?? '' ?>">
                                            <?php if (isset($fdErr['boss_nip'])) : ?>
                                                <span class="help-block"><?= $fdErr['boss_nip'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group <?= isset($fdErr['boss_name']) ? 'has-error' : '' ?>">
                                            <label class="control-label"><?= isset($fdErr['boss_name']) ? $errIcon : '' ?>&nbsp;Nama Kepala (<span style="color: #dd4b39;">*</span>)</label>
                                            <input type="text" name="boss_name" class="form-control" placeholder="Masukkan Nama Kepala ..." value="<?= old('boss_name') ?? '' ?>">
                                            <?php if (isset($fdErr['boss_name'])) : ?>
                                                <span class="help-block"><?= $fdErr['boss_name'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label <?= isset($fdErr['attachments']) ? 'has-error' : '' ?>"><?= isset($fdErr['attachments']) ? $errIcon : '' ?>&nbsp;List Pekerja Pada Lampiran (<span style="color: #dd4b39;">*</span>)</label>
                                            <select name="attachments_view" class="form-control select2" multiple="multiple" data-placeholder="Pilih Pekerja Yang Akan Dilampirkan" style="width: 100%;">
                                                <?php foreach($listPekerja as $itemPekerja): ?>
                                                    <option value="<?=$itemPekerja->id?>"><?=$itemPekerja->nama . ' [' . $itemPekerja->nik . ']'?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <input type="hidden" name="attachments" value="">
                                            <?php if (isset($fdErr['attachments'])) : ?>
                                                <span class="help-block"><?= $fdErr['attachments'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
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

<?= $renderer->section('custom-js') ?>
<!-- Select2 -->
<script src="<?= site_url('adminlte2/bower_components/select2/dist/js/select2.full.min.js') ?>"></script>
<script src="<?= site_url('adminlte2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') ?>"></script>
<script>
    $(function() {
        $('select[name="attachments_view"]').select2({
            multiple: true
        });

        $('select[name="attachments_view"]').on('change', function(e) {
            $('input[name="attachments"]').val($(this).val());
        });

        $('#year-picker').datepicker({
            format: 'yyyy',
            viewMode: 'years',
            minViewMode: 'years',
            autoclose: true
        });

        $('#valid-until-picker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        $('#set-date-picker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });
</script>
<?= $renderer->endSection() ?>

<?= $renderer->section('custom-css') ?>
<!-- Select2 -->
<link rel="stylesheet" href="<?= site_url('adminlte2/bower_components/select2/dist/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?= site_url('adminlte2/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') ?>">
<?= $renderer->endSection() ?>