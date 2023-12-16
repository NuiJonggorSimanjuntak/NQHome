<?= $this->extend('auth/templates/app'); ?>

<?= $this->section('content'); ?>

<div class="register-box" style="width: 50%;">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <h1><strong><?= lang('Auth.register') ?></strong></h1>
        </div>
        <div class="card-body">

            <p class="login-box-msg"><strong>Pendaftaran Santri Baru</strong></p>

            <form action="<?= url_to('register') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-6">

                        <div class="input-group mb-3">
                            <input type="number" name="nis" id="" class="form-control <?php if (session('errors.nis')) : ?>is-invalid<?php endif ?>" placeholder="NIS" value="<?= old('nis'); ?>">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-hashtag"></span>
                                </div>
                            </div>
                            <div class="invalid-feedback"><?= session('errors.nis'); ?></div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" id="name" name="name" class="form-control <?php if (session('errors.name')) : ?>is-invalid<?php endif  ?>" placeholder="Fullname" value="<?= old('name'); ?>">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-text-width"></span>
                                </div>
                            </div>
                            <div class="invalid-feedback">
                                <?= session('errors.name'); ?>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" name="username" class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>

                        <small id="emailHelp" class="form-text text-muted"><?= lang('Auth.weNeverShare') ?></small>
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" autocomplete="off">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" name="pass_confirm" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="awal_masuk" id="" class="form-control <?php if (session('errors.awal_masuk')) : ?>is-invalid<?php endif ?>" placeholder="Tahun Awal Masuk" value="<?= old('awal_masuk'); ?>">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-calendar-plus"></span>
                                </div>
                            </div>
                            <div class="invalid-feedback"><?= session('errors.awal_masuk'); ?></div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="input-group mb-3">
                            <select id="id_kelas" name="id_kelas" class="form-control custom-select <?php if (session('errors.id_kelas')) : ?>is-invalid<?php endif  ?>">
                                <option selected disabled>--Pilih Jenjang Pendidikan--</option>
                                <?php foreach ($jenjang_pendidikan as $jp) : ?>
                                    <option value="<?= $jp['id_kelas']; ?>" <?php if (old('id_kelas') === $jp['id_kelas']) : ?>selected<?php endif; ?>><?= $jp['tingkat']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-chair"></span>
                                </div>
                            </div>
                            <div class="invalid-feedback"><?= session('errors.id_kelas'); ?></div>
                        </div>
                        <div class="input-group mb-3">
                            <select id="kelas" name="kelas" class="form-control custom-select <?php if (session('errors.kelas')) : ?>is-invalid<?php endif  ?>">
                                <option value="" selected>Pilih Jenjang Pendidikan terlebih dahulu</option>
                                <?php if (old('jenjang_pendidikan') == 'SD') : ?>
                                    <option value="Kelas 1" <?= old('kelas') === 'Kelas 1' ? 'selected' : '' ?>>Kelas 1</option>
                                    <option value="Kelas 2" <?= old('kelas') === 'Kelas 2' ? 'selected' : '' ?>>Kelas 2</option>
                                    <option value="Kelas 3" <?= old('kelas') === 'Kelas 3' ? 'selected' : '' ?>>Kelas 3</option>
                                    <option value="Kelas 4" <?= old('kelas') === 'Kelas 4' ? 'selected' : '' ?>>Kelas 4</option>
                                    <option value="Kelas 5" <?= old('kelas') === 'Kelas 5' ? 'selected' : '' ?>>Kelas 5</option>
                                    <option value="Kelas 6" <?= old('kelas') === 'Kelas 6' ? 'selected' : '' ?>>Kelas 6</option>
                                <?php elseif (old('jenjang_pendidikan') == 'SMP') : ?>
                                    <option value="Kelas 7" <?= old('kelas') === 'Kelas 7' ? 'selected' : '' ?>>Kelas 7</option>
                                    <option value="Kelas 8" <?= old('kelas') === 'Kelas 8' ? 'selected' : '' ?>>Kelas 8</option>
                                    <option value="Kelas 9" <?= old('kelas') === 'Kelas 9' ? 'selected' : '' ?>>Kelas 9</option>
                                <?php elseif (old('jenjang_pendidikan') == 'SMA') : ?>
                                    <option value="Kelas 10" <?= old('kelas') === 'Kelas 10' ? 'selected' : '' ?>>Kelas 10</option>
                                    <option value="Kelas 11" <?= old('kelas') === 'Kelas 11' ? 'selected' : '' ?>>Kelas 11</option>
                                    <option value="Kelas 12" <?= old('kelas') === 'Kelas 12' ? 'selected' : '' ?>>Kelas 12</option>
                                <?php endif; ?>
                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-chair"></span>
                                </div>
                            </div>
                            <div class="invalid-feedback"><?= session('errors.kelas'); ?></div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="date" name="tanggal_lahir" id="" class="form-control <?php if (session('errors.tanggal_lahir')) : ?>is-invalid<?php endif ?>" placeholder="Tanggal Lahir" value="<?= old('tanggal_lahir'); ?>">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-calendar"></span>
                                </div>
                            </div>
                            <div class="invalid-feedback"><?= session('errors.tanggal_lahir'); ?></div>
                        </div>
                        <div class="input-group mb-3">
                            <select id="jenis_kelamin" name="jenis_kelamin" class="form-control custom-select <?php if (session('errors.jenis_kelamin')) : ?>is-invalid<?php endif  ?>">
                                <option selected disabled>--Pilih Gender--</option>
                                <option value="Laki-Laki" <?php if (old('jenis_kelamin') === 'Laki-Laki') : ?>selected<?php endif; ?>>Laki-Laki</option>
                                <option value="Perempuan" <?php if (old('jenis_kelamin') === 'Perempuan') : ?>selected<?php endif; ?>>Perempuan</option>
                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-venus-mars"></span>
                                </div>
                            </div>
                            <div class="invalid-feedback"><?= session('errors.jenis_kelamin'); ?></div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="riwayat_kesehatan" id="" class="form-control <?php if (session('errors.riwayat_kesehatan')) : ?>is-invalid<?php endif ?>" placeholder="Riwayat Kesehatan" value="<?= old('riwayat_kesehatan'); ?>">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-notes-medical"></span>
                                </div>
                            </div>
                            <div class="invalid-feedback"><?= session('errors.riwayat_kesehatan'); ?></div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <img src="/pas_photo/default.jpg" class="img-thumbnail img-priview" style="width: 100px; height: 100px;">
                                </div>
                                <div class="col-9" style="margin-block-start: auto;">
                                    <label for="image">Pas Photo (:Latar Belakang Merah)</label>
                                    <div class="custom-file">
                                        <input type="file" id="image" name="image" class="custom-file-input <?php if (session('errors.image')) : ?>is-invalid<?php endif  ?>" onchange="priviewImg()">
                                        <label class="custom-file-label" for="Image">Pilih Pas Photo..</label>
                                        <div class="invalid-feedback">
                                            <?= session('errors.image'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-8">
                        <a href="<?= url_to('login') ?>" class=""><?= lang('Auth.alreadyRegistered') ?> <?= lang('Auth.signIn') ?></a>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.register') ?></button>
                    </div>
                </div>

            </form>


        </div>
    </div>
</div>

<?= $this->endSection(); ?>