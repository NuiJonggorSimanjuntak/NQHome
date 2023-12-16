<?= $this->extend('auth/templates/app'); ?>

<?= $this->section('content'); ?>

<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <h1><strong><?= lang('Auth.loginTitle') ?></strong></h1>
        </div>
        <div class="card-body">
            <?= view('Myth\Auth\Views\_message_block') ?>

            <p class="login-box-msg">Sign in to start your session</p>

            <form action="<?= url_to('login') ?>" method="post">
                <?= csrf_field() ?>

                <?php if ($config->validFields === ['email']) : ?>
                    <div class="input-group mb-3">
                        <input type="email" name="login" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.email') ?>">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback">
                            <?= session('errors.login') ?>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="input-group mb-3">
                        <input type="text" name="login" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.emailOrUsername') ?>">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback">
                            <?= session('errors.login') ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback">
                        <?= session('errors.password') ?>
                    </div>
                </div>

                <div class="row">
                    <?php if ($config->allowRemembering) : ?>
                        <div class="col-8">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')) : ?> checked <?php endif ?>>
                                    <?= lang('Auth.rememberMe') ?>
                                </label>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.loginAction') ?></button>
                    </div>
                </div>

            </form>

            <?php if ($config->activeResetter) : ?>
                <p class="mb-1">
                    <a href="<?= url_to('forgot') ?>"><?= lang('Auth.forgotYourPassword') ?></a>
                </p>
            <?php endif; ?>

            <?php if ($config->allowRegistration) : ?>
                <p class="mb-0">
                    <a href="<?= url_to('register') ?>" class="text-center"><?= lang('Auth.needAnAccount') ?></a>
                </p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>