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
                    <h3 class="box-title">Tambah User</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-offset-1 col-sm-8 col-md-offset-1 col-md-8 col-lg-offset-4 col-lg-4">
                            <form action="<?= route_to('user.create') ?>" method="POST" role="form">
                                <?= csrf_field() ?>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group <?= isset($fdErr['username']) ? 'has-error' : '' ?>">
                                            <label class="control-label"><?= isset($fdErr['username']) ? $errIcon : '' ?>&nbsp;Username</label>
                                            <input type="text" name="username" class="form-control" placeholder="Masukkan username ..." value="<?= old('username') ?? '' ?>">
                                            <?php if (isset($fdErr['username'])) : ?>
                                                <span class="help-block"><?= $fdErr['username'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group <?= isset($fdErr['email']) ? 'has-error' : '' ?>">
                                            <label class="control-label"><?= isset($fdErr['email']) ? $errIcon : '' ?>&nbsp;</i>Email</label>
                                            <input type="email" name="email" class="form-control" placeholder="Masukkan email ..." value="<?= old('email') ?? '' ?>">
                                            <?php if (isset($fdErr['email'])) : ?>
                                                <span class="help-block"><?= $fdErr['email'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group <?= isset($fdErr['password']) ? 'has-error' : '' ?>">
                                            <label class="control-label"><?= isset($fdErr['password']) ? $errIcon : '' ?>&nbsp;Password</label>
                                            <input type="password" name="password" class="form-control" placeholder="Masukkan password ...">
                                            <?php if (isset($fdErr['password'])) : ?>
                                                <span class="help-block"><?= $fdErr['password'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group <?= isset($fdErr['repassword']) ? 'has-error' : '' ?>">
                                            <label class="control-label"><?= isset($fdErr['repassword']) ? $errIcon : '' ?>&nbsp;Konfirmasi Password</label>
                                            <input type="password" name="repassword" class="form-control" placeholder="Masukkan password lagi ...">
                                            <?php if (isset($fdErr['repassword'])) : ?>
                                                <span class="help-block"><?= $fdErr['repassword'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group <?= isset($fdErr['level']) ? 'has-error' : '' ?>"">
                                    <label class=" control-label"><?= isset($fdErr['level']) ? $errIcon : '' ?>&nbsp;Level</label>
                                            <select name="level" class="form-control">
                                                <option value="">-- Pilih salah satu --</option>
                                                <?php $oldLevel = old('level'); ?>
                                                <option value="admin" <?= isset($oldLevel) ? ($oldLevel == 'admin' ? 'selected' : '') : '' ?>>Admin</option>
                                                <option value="reguler" <?= isset($oldLevel) ? ($oldLevel == 'reguler' ? 'selected' : '') : '' ?>>Reguler</option>
                                            </select>
                                            <?php if (isset($fdErr['level'])) : ?>
                                                <span class="help-block"><?= $fdErr['level'] ?></span>
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