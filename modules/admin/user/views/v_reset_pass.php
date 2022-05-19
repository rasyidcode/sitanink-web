<?= $renderer->extend('modules/shared/core/views/layout') ?>

<?= $renderer->section('content') ?>
<section class="content">
    <div class="row">
        <div class="col-xs-8">
            <div class="box box-warning">
                <div class="box-body">
                    <form action="#" method="POST" role="form">
                        <div class="form-group <?=isset($fdErr['password']) ? 'has-error': ''?>">
                            <label class="control-label"><?=isset($fdErr['password']) ? $errIcon : ''?>&nbsp;Password Baru</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan password ...">
                            <?php if(isset($fdErr['password'])): ?>
                                <span class="help-block"><?=$fdErr['password']?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group <?=isset($fdErr['repassword']) ? 'has-error': ''?>">
                            <label class="control-label"><?=isset($fdErr['repassword']) ? $errIcon : ''?>&nbsp;Konfirmasi Password Baru</label>
                            <input type="password" name="repassword" class="form-control" placeholder="Masukkan password lagi ...">
                            <?php if(isset($fdErr['repassword'])): ?>
                                <span class="help-block"><?=$fdErr['repassword']?></span>
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
</section>
<?= $renderer->endSection() ?>