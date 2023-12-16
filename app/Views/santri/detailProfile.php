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
            <form action="/santri/updateDetailProfile/<?= $santris->id; ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="imagelama" value="<?= $santris->image; ?>">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-priview" src="<?= base_url(); ?>/pas_photo/<?= $santris->image; ?>" alt="User profile picture" style="width: 170px; height: 190px;">
                                    <div class="custom-file" style="width: 170px;">
                                        <input type="file" id="image" name="image" class="custom-file-input <?php if (session('errors.image')) : ?>is-invalid<?php endif  ?>" onchange="priviewImg()">
                                        <label class="custom-file-label" for="Image"><?= $santris->image; ?></label>
                                        <div class="invalid-feedback">
                                            <?= session('errors.image'); ?>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="profile-username text-center"><?= $santris->name; ?></h3>
                                <p class="text-muted text-center"><?= $santris->nis ?></p>
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Jenis Kelamin</b> <a class="float-right"><?= $santris->jenis_kelamin; ?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Tanggal Lahir</b> <a class="float-right"><?= $santris->tanggal_lahir; ?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Ruang Kelas</b> <a class="float-right"><?= $santris->nama_kelas; ?></a>
                                    </li>
                                </ul>
                                <a href="<?= base_url('santri/profile') ?>" class="btn btn-primary btn-block"><b>KEMBALI</b></a>
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
                                        <strong><i class="fa-solid fa-envelope"></i> Email</strong>
                                        <input type="text" id="email" name="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif  ?>" placeholder="Masukkan Email" value="<?= old('email', $santris->email); ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.email'); ?>
                                        </div>
                                        <br>
                                        <strong><i class="fa-solid fa-user-tag"></i> Nama Lengkap</strong>
                                        <input type="text" id="name" name="name" class="form-control <?php if (session('errors.name')) : ?>is-invalid<?php endif  ?>" placeholder="Masukkan Nama Lengkap" value="<?= old('name', $santris->name); ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.name'); ?>
                                        </div>
                                        <br>
                                        <strong><i class="fa-solid fa-graduation-cap"></i> Jenjang Pendidikan</strong>
                                        <select id="tingkat" name="tingkat" class="form-control custom-select <?php if (session('errors.tingkat')) : ?>is-invalid<?php endif  ?>">
                                            <option selected disabled>--Pilih Jenjang Pendidikan--</option>
                                            <option value="SD" <?= old('tingkat', $santris->tingkat) === 'SD' ? 'selected' : '' ?>>SD</option>
                                            <option value="SMP" <?= old('tingkat', $santris->tingkat) === 'SMP' ? 'selected' : '' ?>>SMP</option>
                                            <option value="SMA" <?= old('tingkat', $santris->tingkat) === 'SMA' ? 'selected' : '' ?>>SMA</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= session('errors.tingkat'); ?>
                                        </div>
                                        <br><br>
                                        <strong><i class="fa-solid fa-chair"></i> Kelas</strong>
                                        <select id="kls" name="kelas" class="form-control custom-select <?php if (session('errors.kelas')) : ?>is-invalid<?php endif; ?>">
                                            <option value="" selected>Pilih Jenjang Pendidikan terlebih dahulu</option>
                                            <?php if (old('tingkat', $santris->tingkat) == 'SD') : ?>
                                                <option value="1" <?= old('kelas', $santris->kelas) === '1' ? 'selected' : '' ?>>Kelas 1</option>
                                                <option value="2" <?= old('kelas', $santris->kelas) === '2' ? 'selected' : '' ?>>Kelas 2</option>
                                                <option value="3" <?= old('kelas', $santris->kelas) === '3' ? 'selected' : '' ?>>Kelas 3</option>
                                                <option value="4" <?= old('kelas', $santris->kelas) === '4' ? 'selected' : '' ?>>Kelas 4</option>
                                                <option value="5" <?= old('kelas', $santris->kelas) === '5' ? 'selected' : '' ?>>Kelas 5</option>
                                                <option value="6" <?= old('kelas', $santris->kelas) === '6' ? 'selected' : '' ?>>Kelas 6</option>
                                            <?php elseif (old('tingkat', $santris->tingkat) == 'SMP') : ?>
                                                <option value="7" <?= old('kelas', $santris->kelas) === '7' ? 'selected' : '' ?>>Kelas 7</option>
                                                <option value="8" <?= old('kelas', $santris->kelas) === '8' ? 'selected' : '' ?>>Kelas 8</option>
                                                <option value="9" <?= old('kelas', $santris->kelas) === '9' ? 'selected' : '' ?>>Kelas 9</option>
                                            <?php elseif (old('tingkat', $santris->tingkat) == 'SMA') : ?>
                                                <option value="10" <?= old('kelas', $santris->kelas) === '10' ? 'selected' : '' ?>>Kelas 10</option>
                                                <option value="11" <?= old('kelas', $santris->kelas) === '11' ? 'selected' : '' ?>>Kelas 11</option>
                                                <option value="12" <?= old('kelas', $santris->kelas) === '12' ? 'selected' : '' ?>>Kelas 12</option>
                                            <?php endif; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= session('errors.kelas'); ?>
                                        </div>
                                        <br><br>
                                        <strong><i class="fa-solid fa-calendar"></i> Tanggal Lahir</strong>
                                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control <?php if (session('errors.tanggal_lahir')) : ?>is-invalid<?php endif  ?>" placeholder="Masukkan Tahun Awal" value="<?= old('tanggal_lahir', $santris->tanggal_lahir); ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.tanggal_lahir'); ?>
                                        </div>
                                        <br>
                                        <strong><i class="fa-solid fa-location-dot"></i> Alamat</strong>
                                        <textarea id="alamat" name="alamat" class="form-control <?php if (session('errors.alamat')) : ?>is-invalid<?php endif  ?>" placeholder="Masukkan Tahun Awal" value=""><?= old('alamat', $santris->alamat); ?></textarea>
                                        <div class="invalid-feedback">
                                            <?= session('errors.alamat'); ?>
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

                                    <div class="col-md-6">
                                        <strong><i class="fa-solid fa-calendar"></i> Awal Masuk</strong>
                                        <input type="number" id="awal_masuk" name="awal_masuk" class="form-control <?php if (session('errors.awal_masuk')) : ?>is-invalid<?php endif  ?>" placeholder="Masukkan Tahun Awal" value="<?= old('awal_masuk', $santris->awal_masuk); ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.awal_masuk'); ?>
                                        </div>
                                        <br>
                                        <strong><i class="fa-solid fa-square-phone"></i> Nama Kontak Darurat</strong>
                                        <input type="text" id="nama_kontak_darurat" name="nama_kontak_darurat" class="form-control <?php if (session('errors.nama_kontak_darurat')) : ?>is-invalid<?php endif  ?>" placeholder="Masukkan Tahun Awal" value="<?= old('nama_kontak_darurat', $santris->nama_kontak_darurat); ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.nama_kontak_darurat'); ?>
                                        </div>
                                        <br>
                                        <strong><i class="fa-solid fa-phone"></i> No. Telp</strong>
                                        <input type="number" id="telepon_kontak_darurat" name="telepon_kontak_darurat" class="form-control <?php if (session('errors.telepon_kontak_darurat')) : ?>is-invalid<?php endif  ?>" placeholder="Masukkan Tahun Awal" value="<?= old('telepon_kontak_darurat', $santris->telepon_kontak_darurat); ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.telepon_kontak_darurat'); ?>
                                        </div>
                                        <br>
                                        <strong><i class="fa-solid fa-venus-mars"></i> Jenis Kelamin</strong>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="status_laki" value="1" <?php if (old('jenis_kelamin') === 'Laki-Laki' || $santris->jenis_kelamin === 'Laki-Laki') echo 'checked'; ?>>
                                            <label class="form-check-label" for="status_laki">Laki-Laki</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="status_perempuan" value="2" <?php if (old('jenis_kelamin') === 'Perempuan' || $santris->jenis_kelamin === 'Perempuan') echo 'checked'; ?>>
                                            <label class="form-check-label" for="status_perempuan">Perempuan</label>
                                        </div>
                                        <div class="invalid-feedback">
                                            <?= session('errors.no_telepon'); ?>
                                        </div>
                                        <br>
                                        <strong><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Akademik</strong>
                                        <textarea id="riwayat_akademik" name="riwayat_akademik" class="form-control <?php if (session('errors.riwayat_akademik')) : ?>is-invalid<?php endif  ?>" placeholder="Masukkan Riwayat Akadamik" value=""><?= old('riwayat_akademik', $santris->riwayat_akademik); ?></textarea>
                                        <div class="invalid-feedback">
                                            <?= session('errors.riwayat_akademik'); ?>
                                        </div>
                                        <br>
                                        <strong><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Kesehatan</strong>
                                        <textarea id="riwayat_kesehatan" name="riwayat_kesehatan" class="form-control <?php if (session('errors.riwayat_kesehatan')) : ?>is-invalid<?php endif  ?>" placeholder="Masukkan Riwayat Kesehatan" value=""><?= old('riwayat_kesehatan', $santris->riwayat_kesehatan); ?></textarea>
                                        <div class="invalid-feedback">
                                            <?= session('errors.riwayat_kesehatan'); ?>
                                        </div>
                                        <br>
                                        <strong><i class="fa-solid fa-users"></i> Nama Orang Tua</strong>
                                        <input type="text" id="nama_ortu" name="nama_ortu" class="form-control <?php if (session('errors.nama_ortu')) : ?>is-invalid<?php endif  ?>" placeholder="Masukkan Nama Orang Tua" value="<?= old('nama_ortu', $santris->nama_ortu); ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.nama_ortu'); ?>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
        </form>
</div>
</section>
<!-- </div> -->
<?= $this->endSection(); ?>