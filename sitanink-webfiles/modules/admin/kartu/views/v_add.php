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
                    <h3 class="box-title">Tambah Kartu</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-offset-1 col-sm-8 col-md-offset-1 col-md-8 col-lg-offset-4 col-lg-4">
                            <form action="<?= route_to('kartu.create') ?>" method="POST" role="form">
                                <?= csrf_field() ?>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group <?= isset($fdErr['pekerja']) ? 'has-error' : '' ?>">
                                            <label class=" control-label"><?= isset($fdErr['pekerja']) ? $errIcon : '' ?>&nbsp;Pekerja</label>
                                            <select name="pekerja" class="form-control">
                                                <option value="">-- Pilih salah satu --</option>
                                                <?php $pekerja = old('pekerja'); ?>
                                            </select>
                                            <?php if (isset($fdErr['pekerja'])) : ?>
                                                <span class="help-block"><?= $fdErr['pekerja'] ?></span>
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
                    <div class="row">
                        <div class="col-lg-12">
                            <img src="<?= site_url('assets/images/card-front.png') ?>" alt="Card Front">
                        </div>
                        <div class="col-lg-12">
                            <img src="<?= site_url('assets/images/card-back.png') ?>" alt="Card Back">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $renderer->endSection() ?>