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
                    <h3 class="box-title">Form ganti password</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-4">
                            <form action="<?= route_to('user.do-change-pass', $userId) ?>" method="POST" role="form">
                                <?= csrf_field() ?>
                                <div class="form-group <?= isset($fdErr['password']) ? 'has-error' : '' ?>">
                                    <label class="control-label"><?= isset($fdErr['password']) ? $errIcon : '' ?>&nbsp;Password Baru</label>
                                    <input type="password" name="password" class="form-control" placeholder="Masukkan password ...">
                                    <?php if (isset($fdErr['password'])) : ?>
                                        <span class="help-block"><?= $fdErr['password'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['repassword']) ? 'has-error' : '' ?>">
                                    <label class="control-label"><?= isset($fdErr['repassword']) ? $errIcon : '' ?>&nbsp;Konfirmasi Password Baru</label>
                                    <input type="password" name="repassword" class="form-control" placeholder="Masukkan password lagi ...">
                                    <?php if (isset($fdErr['repassword'])) : ?>
                                        <span class="help-block"><?= $fdErr['repassword'] ?></span>
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