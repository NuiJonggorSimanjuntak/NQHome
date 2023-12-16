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

        <div class="container-fluid">
            <form action="/guru/updateDetailProfile/<?= $users['id']; ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="imagelama" value="<?= $users['image']; ?>">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-priview" src="<?= base_url(); ?>/pas_photo/<?= $users['image']; ?>" alt="User profile picture" style="width: 170px; height: 190px;">
                                    <div class="custom-file" style="width: 170px;">
                                        <input type="file" id="image" name="image" class="custom-file-input <?php if (session('errors.image')) : ?>is-invalid<?php endif  ?>" onchange="priviewImg()">
                                        <label class="custom-file-label" for="Image"><?= $users['image']; ?></label>
                                        <div class="invalid-feedback">
                                            <?= session('errors.image'); ?>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="profile-username text-center"><?= $users['name']; ?></h3>
                                <p class="text-muted text-center"><?= $users['nik'] ?></p>
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Jenis Kelamin</b> <a class="float-right"><?= $users['jenis_kelamin']; ?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Tanggal Lahir</b> <a class="float-right"><?= $users['tanggal_lahir']; ?></a>
                                    </li>
                                </ul>
                                <a href="<?= base_url('guru/profile') ?>" class="btn btn-primary btn-block"><b>KEMBALI</b></a>
                                <p></p>
                                <button type="submit" value="Edit" class="btn btn-warning btn-block"><b>UBAH</b></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Tentang Saya</h3>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong><i class="fa-solid fa-graduation-cap"></i> NIK</strong>
                                        <input type="text" id="nik" name="nik" class="form-control <?php if (session('errors.nik')) : ?>is-invalid<?php endif  ?>" placeholder="Masukkan NIK" value="<?= old('nik', $users['nik']); ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.nik'); ?>
                                        </div>
                                        <br>
                                        <strong><i class="fa-solid fa-graduation-cap"></i> Pendidikan Terakhir</strong>
                                        <input type="text" id="pendidikan_terakhir" name="pendidikan_terakhir" class="form-control <?php if (session('errors.pendidikan_terakhir')) : ?>is-invalid<?php endif  ?>" placeholder="Masukkan pendidikan_terakhir" value="<?= old('pendidikan_terakhir', $users['pendidikan_terakhir']); ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.pendidikan_terakhir'); ?>
                                        </div>
                                        <br>

                                        <strong><i class="fa-solid fa-phone mr-1"></i> No. Telepon</strong>
                                        <input type="text" id="no_telepon" name="no_telepon" class="form-control <?php if (session('errors.no_telepon')) : ?>is-invalid<?php endif  ?>" placeholder="Masukkan no_telepon" value="<?= old('no_telepon', $users['no_telepon']); ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.no_telepon'); ?>
                                        </div>
                                        <br>

                                        <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                                        <input type="text" id="email" name="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif  ?>" placeholder="Masukkan email" value="<?= old('email', $users['email']); ?>" readonly>
                                        <div class="invalid-feedback">
                                            <?= session('errors.email'); ?>
                                        </div>
                                        <br>

                                        <strong><i class="fas fa-pencil-alt mr-1"></i> Alamat</strong>
                                        <input type="text" id="alamat" name="alamat" class="form-control <?php if (session('errors.alamat')) : ?>is-invalid<?php endif  ?>" placeholder="Masukkan alamat" value="<?= old('alamat', $users['alamat']); ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.alamat'); ?>
                                        </div>
                                        <br>

                                        <strong><i class="fas fa-file-alt mr-1"></i> Pengalaman Mengajar</strong>
                                        <input type="text" id="pengalaman_mengajar" name="pengalaman_mengajar" class="form-control <?php if (session('errors.pengalaman_mengajar')) : ?>is-invalid<?php endif  ?>" placeholder="Masukkan pengalaman_mengajar" value="<?= old('pengalaman_mengajar', $users['pengalaman_mengajar']); ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.pengalaman_mengajar'); ?>
                                        </div>
                                        <br>

                                        <strong><i class="fas fa-file-alt mr-1"></i> Nama Lengkap</strong>
                                        <input type="text" id="name" name="name" class="form-control <?php if (session('errors.name')) : ?>is-invalid<?php endif  ?>" placeholder="Masukkan Nama Lengkap" value="<?= old('name', $users['name']); ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.name'); ?>
                                        </div>
                                        <br>
                                    </div>

                                    <div class="col-md-6">
                                        <strong><i class="fas fa-user mr-1"></i> Tentang Pengajar</strong>
                                        <textarea id="tentang_pengajar" name="tentang_pengajar" class="form-control <?php if (session('errors.tentang_pengajar')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan tentang_pengajar"><?= old('tentang_pengajar', $users['tentang_pengajar']); ?></textarea>
                                        <div class="invalid-feedback">
                                            <?= session('errors.tentang_pengajar'); ?>
                                        </div>
                                        <br>
                                        <strong><i class="fa-solid fa-ring"></i> Status Perkawinan</strong>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status_perkawinan" id="status_menikah" value="Menikah" <?php if (old('status_perkawinan') === 'Menikah' || $users['status_perkawinan'] === 'Menikah') echo 'checked'; ?>>
                                            <label class="form-check-label" for="status_menikah">Menikah</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status_perkawinan" id="status_belum_menikah" value="Belum Menikah" <?php if (old('status_perkawinan') === 'Belum Menikah' || $users['status_perkawinan'] === 'Belum Menikah') echo 'checked'; ?>>
                                            <label class="form-check-label" for="status_belum_menikah">Belum Menikah</label>
                                        </div>
                                        <div class="invalid-feedback">
                                            <?= session('errors.status_perkawinan'); ?>
                                        </div>
                                        <br>
                                        <strong><i class="fa-solid fa-book mr-1"></i> Mata Pelajaran</strong>
                                        <select id="id_mp" name="id_mp" class="form-control <?php if (session('errors.id_mp')) : ?>is-invalid<?php endif ?>" autofocus>
                                            <option value="" selected disabled>Pilih Mata Pelajaran</option>
                                            <?php foreach ($mataPelajaran as $mp) : ?>
                                                <option value="<?= $mp['id'] ?>" <?= old('id_mp', $users['id_mp']) == $mp['id'] ? 'selected' : '' ?>><?= $mp['nama_mp'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= session('errors.id_mp'); ?>
                                        </div>
                                        <br>
                                        <strong><i class="fas fa-venus-mars mr-1"></i> Jenis Kelamin</strong>
                                        <div class="form-check <?php if (session('errors.jenis_kelamin')) : ?>is-invalid<?php endif ?>">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="status_laki" value="1" <?php if (old('jenis_kelamin') === 'Laki-Laki' || $users['jenis_kelamin'] === 'Laki-Laki') echo 'checked'; ?>>
                                            <label class="form-check-label" for="status_laki">Laki-Laki</label>
                                        </div>
                                        <div class="form-check <?php if (session('errors.jenis_kelamin')) : ?>is-invalid<?php endif ?>">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="status_perempuan" value="2" <?php if (old('jenis_kelamin') === 'Perempuan' || $users['jenis_kelamin'] === 'Perempuan') echo 'checked'; ?>>
                                            <label class="form-check-label" for="status_perempuan">Perempuan</label>
                                        </div>
                                        <div class="invalid-feedback">
                                            <?= session('errors.jenis_kelamin'); ?>
                                        </div>
                                        <br>
                                        <strong><i class="fas fa-user mr-1"></i> Tanggal Lahir</strong>
                                        <input id="tanggal_lahir" type="date" name="tanggal_lahir" class="form-control <?php if (session('errors.tanggal_lahir')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan tanggal_lahir" value="<?= old('tanggal_lahir', $users['tanggal_lahir']); ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.tanggal_lahir'); ?>
                                        </div>
                                        <br>
                                        <strong><i class="fa-solid fa-key"></i> Password</strong>
                                        <div class="input-group">
                                            <input type="password_hash" id="password" name="password_hash" class="form-control <?php if (session('errors.password_hash')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Password" value="<?= old('password_hash'); ?>" autocomplete="off">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="fas fa-eye"></i></button>
                                            </div>
                                            <div class="invalid-feedback">
                                                <?= session('errors.password_hash'); ?>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
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