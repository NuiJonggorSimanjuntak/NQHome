<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $title; ?></h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid" style="align-items: center; width: 30pc;">
            <form action="/admin/updateUsers/<?= $users->userid; ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="imagelama" value="<?= $users->image; ?>">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Form</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" id="username" name="username" class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ? old('username') : $users->username ?>">
                                    <div class="invalid-feedback">
                                        <?= session('errors.username'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="role">role</label>
                                    <input type="text" id="role" name="role" class="form-control <?php if (session('errors.role')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.role') ?>" value="<?= old('role') ? old('role') : $users->role ?>" readonly>
                                    <div class="invalid-feedback">
                                        <?= session('errors.role'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ? old('email') : $users->email ?>">
                                    <div class="invalid-feedback">
                                        <?= session('errors.email'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">Nama Lengkap</label>
                                    <input type="text" id="name" name="name" class="form-control <?php if (session('errors.name')) : ?>is-invalid<?php endif  ?>" placeholder="Nama Lengkap" value="<?= old('name') ? old('name') : $users->fullname; ?>" autofocus>
                                    <div class="invalid-feedback">
                                        <?= session('errors.name'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-3">
                                            <img src="/pas_photo/<?= $users->image; ?>" class="img-thumbnail img-priview" style="width: 100px; height: 100px;">
                                        </div>
                                        <div class="col-9" style="margin-block-start: auto;">
                                            <label for="image">Pas Photo (:Latar Belakang Merah)</label>
                                            <div class="custom-file">
                                                <input type="file" id="image" name="image" class="custom-file-input <?php if (session('errors.image')) : ?>is-invalid<?php endif  ?>" onchange="priviewImg()">
                                                <label class="custom-file-label" for="Image"><?= $users->image; ?></label>
                                                <div class="invalid-feedback">
                                                    <?= session('errors.image'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" form-group">
                                    <label for="password">Password</label>
                                    <div class="input-group">
                                        <input type="password" id="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" value="<?= old('password'); ?>" autocomplete="off">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="fas fa-eye"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <a href="<?= base_url('admin/daftarUsers'); ?>" class="btn btn-danger">Batal</a>
                                    <button type="submit" value="Simpan" class="btn btn-success float-right">Edit
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>