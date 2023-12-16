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
            <form action="<?= base_url('admin/simpanKelas') ?>" method="post">
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
                                    <label for="nama_kelas">Nama Kelas</label>
                                    <input type="text" id="nama_kelas" name="nama_kelas" class="form-control <?php if (session('errors.nama_kelas')) : ?>is-invalid<?php endif  ?>" placeholder="Masukkan Nama Kelas" value="<?= old('nama_kelas'); ?>">
                                    <div class="invalid-feedback">
                                        <?= session('errors.nama_kelas'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kapasitas">Kapasitas</label>
                                    <input type="text" id="kapasitas" name="kapasitas" class="form-control <?php if (session('errors.kapasitas')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Kapasitas" value="<?= old('kapasitas'); ?>">
                                    <div class="invalid-feedback">
                                        <?= session('errors.kapasitas'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="id_guru">Wali Kelas</label>
                                    <select name="id_guru" class="form-control custon-select <?php if (session('errors.id_guru')) : ?>is-invalid<?php endif  ?>">
                                        <option selected disabled>--Pilih--</option>
                                        <?php foreach ($guru as $g) : ?>
                                            <option value="<?= $g['id']; ?>" <?= (old('id_guru') == $g['id']) ? 'selected' : ''; ?>><?= $g['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback"><?= session('errors.id_guru'); ?></div>
                                </div>
                                <div class="form-group">
                                    <label for="id_jk">Gender</label>
                                    <select name="id_jk" class="form-control custon-select <?php if (session('errors.id_jk')) : ?>is-invalid<?php endif  ?>">
                                        <option selected disabled>--Pilih--</option>
                                        <option value="1" <?= (old('id_jk') == '1') ? 'selected' : ''; ?>>Laki-Laki</option>
                                        <option value="2" <?= (old('id_jk') == '2') ? 'selected' : ''; ?>>Perempuan</option>
                                    </select>
                                    <div class="invalid-feedback"><?= session('errors.id_jk'); ?></div>
                                </div>
                                <div class="form-group">
                                    <a href="<?= base_url('admin/daftarKelas'); ?>" class="btn btn-danger">Batal</a>
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

<?php $this->endSection(); ?>