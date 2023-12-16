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
        <div class="container-fluid" style="align-items: center; width: 50pc;">
            <form action="/admin/updateSantri/<?= $santris->id; ?>" method="post">
                <?= csrf_field(); ?>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Format Data</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="user_id">Nama</label>
                                            <input style="background-color: #778899;" type="text" id="nama" name="nama" class="form-control <?php if (session('errors.user_id')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Nama Guru" value="<?= $santris->user_id ?> | <?= $santris->name ?>" readonly>
                                            <input type="hidden" id="user_id" name="user_id" value="<?= $santris->user_id ?>">
                                            <div class="invalid-feedback">
                                                <?= session('errors.user_id'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="nis">NIS</label>
                                            <input style="background-color: #778899;" type="number" id="nis" name="nis" class="form-control <?php if (session('errors.nis')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan NIS" value="<?= $santris->nis ?>" readonly>
                                            <div class="invalid-feedback">
                                                <?= session('errors.nis'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="awal_masuk">Tahun Masuk</label>
                                            <input type="number" id="awal_masuk" name="awal_masuk" class="form-control <?php if (session('errors.awal_masuk')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Tahun Awal Masuk" value="<?= old('awal_masuk', $santris->awal_masuk) ?>">
                                            <div class="invalid-feedback">
                                                <?= session('errors.awal_masuk'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="id_kelas">Ruang Kelas</label>
                                            <select name="id_kelas" class="form-control custom-select <?php if (session('errors.id_kelas')) : ?>is-invalid<?php endif  ?>">
                                                <option selected disabled>--Pilih Ruang Kelas--</option>
                                                <?php foreach ($kelas as $jp) : ?>
                                                    <option value="<?= $jp['id_kelas']; ?>" <?= old('id_kelas', $santris->id_kelas) == $jp['id_kelas'] ? 'selected' : '' ?>><?= $jp['nama_kelas']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                <?= session('errors.id_kelas'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="tingkat">Jenjang Pendidikan</label>
                                            <select id="tingkat" name="tingkat" class="form-control custom-select <?php if (session('errors.tingkat')) : ?>is-invalid<?php endif  ?>">
                                                <option selected disabled>--Pilih Jenjang Pendidikan--</option>
                                                <option value="SD" <?= old('tingkat', $santris->tingkat) === 'SD' ? 'selected' : '' ?>>SD</option>
                                                <option value="SMP" <?= old('tingkat', $santris->tingkat) === 'SMP' ? 'selected' : '' ?>>SMP</option>
                                                <option value="SMA" <?= old('tingkat', $santris->tingkat) === 'SMA' ? 'selected' : '' ?>>SMA</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                <?= session('errors.tingkat'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="kelas">Kelas</label>
                                            <select id="kls" name="kelas" class="form-control <?php if (session('errors.kelas')) : ?>is-invalid<?php endif ?>">
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
                                        </div>
                                        <div class=" form-group">
                                            <label for="tgl_lahir">Tanggal Lahir</label>
                                            <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control <?php if (session('errors.tgl_lahir')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Tanggal Lahir" value="<?= old('tanggal_lahir', $santris->tanggal_lahir); ?>">
                                            <div class="invalid-feedback">
                                                <?= session('errors.tgl_lahir'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <textarea id="alamat" name="alamat" class="form-control <?php if (session('errors.alamat')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Alamat"><?= old('alamat', $santris->alamat) ?></textarea>
                                            <div class="invalid-feedback">
                                                <?= session('errors.alamat'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jk">Jenis Kelamin</label>
                                            <select id="jk" name="jk" class="form-control <?php if (session('errors.jk')) : ?>is-invalid<?php endif ?>">
                                                <option value="" selected disabled>Pilih Jenis Kelamin</option>
                                                <option value="1" <?= old('jk', $santris->jenis_kelamin) == 'Laki-Laki' ? 'selected' : '' ?>>Laki-Laki</option>
                                                <option value="2" <?= old('jk', $santris->jenis_kelamin) == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                <?= session('errors.jk'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="riwayat_akademik">Riwayat Akademik</label>
                                            <input type="text" id="riwayat_akademik" name="riwayat_akademik" class="form-control <?php if (session('errors.riwayat_akademik')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Pendidikan Terakhir" value="<?= old('riwayat_akademik', $santris->riwayat_akademik) ?>" autofocus>
                                            <div class="invalid-feedback">
                                                <?= session('errors.riwayat_akademik'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="riwayat_kesehatan">Riwayat Kesehatan</label>
                                            <input type="text" id="riwayat_kesehatan" name="riwayat_kesehatan" class="form-control <?php if (session('errors.riwayat_kesehatan')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Pendidikan Terakhir" value="<?= old('riwayat_kesehatan', $santris->riwayat_kesehatan) ?>" autofocus>
                                            <div class="invalid-feedback">
                                                <?= session('errors.riwayat_kesehatan'); ?>
                                            </div>
                                        </div>
                                        <div class=" form-group">
                                            <label for="nama_kontak_darurat">Nama Kontak Darurat</label>
                                            <input type="text" id="nama_kontak_darurat" name="nama_kontak_darurat" class="form-control <?php if (session('errors.nama_kontak_darurat')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan No.Tlp" value="<?= old('nama_kontak_darurat', $santris->nama_kontak_darurat); ?>">
                                            <div class="invalid-feedback">
                                                <?= session('errors.nama_kontak_darurat'); ?>
                                            </div>
                                        </div>
                                        <div class=" form-group">
                                            <label for="telepon_kontak_darurat">No. Telepon Darurat</label>
                                            <input type="text" id="telepon_kontak_darurat" name="telepon_kontak_darurat" class="form-control <?php if (session('errors.telepon_kontak_darurat')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan No.Tlp" value="<?= old('telepon_kontak_darurat', $santris->telepon_kontak_darurat); ?>">
                                            <div class="invalid-feedback">
                                                <?= session('errors.telepon_kontak_darurat'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Status santri</label>
                                            <select id="status" name="status" class="form-control <?php if (session('errors.status')) : ?>is-invalid<?php endif ?>" autofocus>
                                                <option value="" selected disabled>Pilih Status</option>
                                                <option value="Baru" <?= (old('status', $santris->status) == 'Baru') ? 'selected' : '' ?>>Baru</option>
                                                <option value="Lama" <?= (old('status', $santris->status) == 'Lama') ? 'selected' : '' ?>>Lama</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                <?= session('errors.status'); ?>
                                            </div>
                                        </div>
                                        <div class=" form-group">
                                            <label for="nama_ortu">Nama Orang Tua</label>
                                            <input type="text" id="nama_ortu" name="nama_ortu" class="form-control <?php if (session('errors.nama_ortu')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Nama Ortu" value="<?= old('nama_ortu', $santris->nama_ortu); ?>">
                                            <div class="invalid-feedback">
                                                <?= session('errors.nama_ortu'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?= base_url('admin/daftarSantri'); ?>" class="btn btn-danger">Batal</a>
                                <button type="submit" value="Simpan" class="btn btn-success float-right">Ubah
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>