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
            <form action="<?= base_url('admin/simpanUsers') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
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
                                    <input type="text" id="username" name="username" class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>" autofocus>
                                    <div class="invalid-feedback">
                                        <?= session('errors.username'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
                                    <div class="invalid-feedback">
                                        <?= session('errors.email'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">Nama Lengkap</label>
                                    <input type="text" id="name" name="name" class="form-control <?php if (session('errors.name')) : ?>is-invalid<?php endif  ?>" placeholder="Nama Lengkap" value="<?= old('name'); ?>">
                                    <div class="invalid-feedback">
                                        <?= session('errors.name'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="role">Status</label>
                                    <select id="role" name="role" class="form-control custom-select <?php if (session('errors.role')) : ?>is-invalid<?php endif; ?>">
                                        <option selected disabled>--Pilih--</option>
                                        <option value="admin" <?= (old('role') == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                        <option value="guru" <?= (old('role') == 'guru') ? 'selected' : ''; ?>>Guru</option>
                                        <option value="santri" <?= (old('role') == 'santri') ? 'selected' : ''; ?>>Santri</option>
                                    </select>
                                    <div class="invalid-feedback"><?= session('errors.role'); ?></div>
                                </div>

                                <div class="form-group" id="santriInput" style="display: none;">
                                    <label for="nis">NIS (Nomor Induk Santri)</label>
                                    <input type="text" id="nis" name="nis" class="form-control <?php if (session('errors.nis')) : ?>is-invalid<?php endif  ?>" value="<?= $nis ?>" readonly>
                                    <label for="id_kelas">Ruang Kelas</label>
                                    <select name="id_kelas" class="form-control custon-select <?php if (session('errors.id_kelas')) : ?>is-invalid<?php endif  ?>">
                                        <option selected disabled>--Pilih--</option>
                                        <?php foreach ($kelas as $kls) : ?>
                                            <option value="<?= $kls['id']; ?> . <?= $kls['id_jk']; ?>" <?= (old('id_kelas') == $kls['id']) ? 'selected' : ''; ?>><?= $kls['nama_kelas'] . '-' . $kls['jenis_kelamin']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group" id="guruInput" style="display: none;">
                                    <label for="nik">NIK (Nomor Induk Keluarga)</label>
                                    <input type="text" id="nik" name="nik" class="form-control <?php if (session('errors.nik')) : ?>is-invalid<?php endif  ?>" value="<?= old('nik'); ?>">
                                    <div class="invalid-feedback"><?= session('errors.nik'); ?></div>
                                    <label for="nip">NIP (Nomor Induk Pengajar)</label>
                                    <input type="text" id="nip" name="nip" class="form-control <?php if (session('errors.nip')) : ?>is-invalid<?php endif  ?>" value="<?= $nip; ?>" readonly>
                                    <div class="invalid-feedback"><?= session('errors.nip'); ?></div>
                                    <label for="id_mp">Mata Pelajaran</label>
                                    <select name="id_mp" id="id_mp" class="form-control <?php if (session('errors.id_mp')) : ?>is-invalid<?php endif  ?>">
                                        <option selected disabled>--Pilih--</option>
                                        <?php foreach ($mp as $m) : ?>
                                            <option value="<?= $m['id']; ?>" <?= (old('id_mp') == $m['id']) ? 'selected' : ''; ?>><?= $m['kode_mp'] . ' - ' . $m['nama_mp']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback"><?= session('errors.id_mp'); ?></div>
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
                                <div class=" form-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" autocomplete="off">
                                    <div class="invalid-feedback">
                                        <?= session('errors.password'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <a href="<?= base_url('admin/daftarUsers'); ?>" class="btn btn-danger">Batal</a>
                                    <button type="submit" value="Simpan" class="btn btn-success float-right">Simpan
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