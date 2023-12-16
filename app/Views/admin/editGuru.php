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
            <form action="/admin/updateGuru/<?= $gurus->id; ?>" method="post">
                <?= csrf_field(); ?>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-warning">
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
                                            <input type="text" id="user_id" name="user_id" class="form-control <?php if (session('errors.user_id')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Nama Guru" value="<?= $gurus->user_id ?> | <?= $gurus->name ?>">
                                            <input type="hidden" id="user_id" name="user_id" value="<?= $gurus->user_id ?>">
                                            <div class="invalid-feedback">
                                                <?= session('errors.user_id'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="text" id="email" name="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Email" value="<?= $gurus->email ?>">
                                            <input type="hidden" id="email" name="email" value="<?= $gurus->email ?>">
                                            <div class="invalid-feedback">
                                                <?= session('errors.email'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="nip">NIP (Nomor Induk Pengajar)</label>
                                            <input type="text" id="nip" name="nip" class="form-control <?php if (session('errors.nip')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan nip" value="<?= $gurus->nip ?>" readonly>
                                            <div class="invalid-feedback">
                                                <?= session('errors.nip'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="nik">NIK</label>
                                            <input type="text" id="nik" name="nik" class="form-control <?php if (session('errors.nik')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan NIK" value="<?= $gurus->nik ?>">
                                            <div class="invalid-feedback">
                                                <?= session('errors.nik'); ?>
                                            </div>
                                        </div>
                                        <div class=" form-group">
                                            <label for="tgl_lahir">Tanggal Lahir</label>
                                            <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control <?php if (session('errors.tgl_lahir')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Tanggal Lahir" value="<?= old('tgl_lahir', $gurus->tgl_lahir) ?>">
                                            <div class="invalid-feedback">
                                                <?= session('errors.tgl_lahir'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="alamat">Alamat Rumah</label>
                                            <textarea id="alamat" name="alamat" class="form-control <?php if (session('errors.alamat')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Alamat Rumah"><?= old('alamat', $gurus->alamat) ?></textarea>
                                            <div class="invalid-feedback">
                                                <?= session('errors.alamat'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=" pendidikan_terakhir"> Pendidikan Terakhir</label>
                                            <input type="text" id=" pendidikan_terakhir" name=" pendidikan_terakhir" class="form-control <?php if (session('errors. pendidikan_terakhir')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Pendidikan Terakhir" value="<?= $gurus->pendidikan_terakhir; ?>" autofocus>
                                            <div class="invalid-feedback">
                                                <?= session('errors. pendidikan_terakhir'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="pengalaman_mengajar">Pengalaman Mengajar</label>
                                            <input type="text" id="pengalaman_mengajar" name="pengalaman_mengajar" class="form-control <?php if (session('errors.pengalaman_mengajar')) : ?>is-invalid<?php endif  ?>" placeholder="Masukkan Pengalaman Mengajar" value="<?= $gurus->pengalaman_mengajar; ?>">
                                            <div class="invalid-feedback">
                                                <?= session('errors.pengalaman_mengajar'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="tentang_pengajar">Tentang Pengajar</label>
                                            <textarea id="tentang_pengajar" name="tentang_pengajar" class="form-control <?php if (session('errors.tentang_pengajar')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Tentang Pengajar"><?= old('tentang_pengajar', $gurus->tentang_pengajar) ?></textarea>
                                            <div class="invalid-feedback">
                                                <?= session('errors.alamat'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Status Perkawinan</label><br>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status_perkawinan" id="status_menikah" value="Menikah" <?php if (old('status_perkawinan') === 'Menikah' || $gurus->status_perkawinan === 'Menikah') echo 'checked'; ?>>
                                                <label class="form-check-label" for="status_menikah">Menikah</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status_perkawinan" id="status_belum_menikah" value="Belum Menikah" <?php if (old('status_perkawinan') === 'Belum Menikah' || $gurus->status_perkawinan === 'Belum Menikah') echo 'checked'; ?>>
                                                <label class="form-check-label" for="status_belum_menikah">Belum Menikah</label>
                                            </div>
                                            <div class="invalid-feedback">
                                                <?= session('errors.status_perkawinan'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="jk">Jenis Kelamin</label>
                                            <select id="jk" name="jk" class="form-control <?php if (session('errors.jk')) : ?>is-invalid<?php endif ?>" autofocus>
                                                <option value="" selected disabled>Pilih Jenis Kelamin</option>
                                                <option value="1" <?= old('jk', $gurus->jk) == 'Laki-Laki' ? 'selected' : '' ?>>Laki-Laki</option>
                                                <option value="2" <?= old('jk', $gurus->jk) == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                <?= session('errors.jk'); ?>
                                            </div>
                                        </div>
                                        <div class=" form-group">
                                            <label for="no_telepon">No Telepon</label>
                                            <input type="number" id="no_telepon" name="no_telepon" class="form-control <?php if (session('errors.no_telepon')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan No.Tlp" value="<?= $gurus->no_telepon; ?>">
                                            <div class="invalid-feedback">
                                                <?= session('errors.no_telepon'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?= base_url('admin/daftarGuru'); ?>" class="btn btn-danger">Batal</a>
                                <button type="submit" value="Edit" class="btn btn-success float-right">Edit
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>