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
                    <h3 class="box-title">Tambah Tipe Berkas</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-offset-1 col-sm-8 col-md-offset-1 col-md-8 col-lg-offset-4 col-lg-4">
                            <form action="<?= route_to('tipe-berkas.create') ?>" method="POST" role="form">
                                <?= csrf_field() ?>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group <?= isset($fdErr['name']) ? 'has-error' : '' ?>">
                                            <label class="control-label"><?= isset($fdErr['name']) ? $errIcon : '' ?>&nbsp;Nama</label>
                                            <input type="text" name="name" class="form-control" placeholder="Masukkan nama ..." value="<?= old('name') ?? '' ?>">
                                            <?php if (isset($fdErr['name'])) : ?>
                                                <span class="help-block"><?= $fdErr['name'] ?></span>
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
<?= $renderer->endSection() ?>

<?= $renderer->section('custom-css') ?>
<?= $renderer->endSection() ?>