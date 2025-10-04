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
                <h3 class="box-title">Form Edit User</h3>
            </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12 col-lg-5">
                            <form action="<?= route_to('user.update', $userdata->id) ?>" method="POST" role="form">
                                <?= csrf_field() ?>
                                <!-- <input type="hidden" name="id" value="<?= $userdata->id ?>"> -->
                                <!-- text input -->
                                <div class="form-group <?= isset($fdErr['username']) ? 'has-error' : '' ?>">
                                    <label class="control-label"><?= isset($fdErr['username']) ? $errIcon : '' ?>&nbsp;Username</label>
                                    <input type="text" name="username" class="form-control" placeholder="Masukkan username ..." value="<?= $userdata->username ?>">
                                    <?php if (isset($fdErr['username'])) : ?>
                                        <span class="help-block"><?= $fdErr['username'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['email']) ? 'has-error' : '' ?>">
                                    <label class="control-label"><?= isset($fdErr['email']) ? $errIcon : '' ?>&nbsp;</i>Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Masukkan email ..." value="<?= $userdata->email ?>">
                                    <?php if (isset($fdErr['email'])) : ?>
                                        <span class="help-block"><?= $fdErr['email'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group <?= isset($fdErr['level']) ? 'has-error' : '' ?>"">
                            <label class=" control-label"><?= isset($fdErr['level']) ? $errIcon : '' ?>&nbsp;Level</label>
                                    <select name="level" class="form-control">
                                        <option value="">-- Pilih salah satu --</option>
                                        <option value="admin" <?= $userdata->level == 'admin' ? 'selected' : '' ?>>Admin</option>
                                        <option value="reguler" <?= $userdata->level == 'reguler' ? 'selected' : '' ?>>Reguler</option>
                                    </select>
                                    <?php if (isset($fdErr['level'])) : ?>
                                        <span class="help-block"><?= $fdErr['level'] ?></span>
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