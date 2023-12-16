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
            <form action="/guru/updateKetAbsen/<?= $data['id']; ?>" method="post">
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
                                    <label for="name">Nama Santri</label>
                                    <input type="text" id="name" name="name" class="form-control <?php if (session('errors.name')) : ?>is-invalid<?php endif  ?>" placeholder="Masukkan name" value="<?= $data['id']; ?>" readonly>
                                    <div class="invalid-feedback">
                                        <?= session('errors.name'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" id="tanggal" name="tanggal" class="form-control <?php if (session('errors.tanggal')) : ?>is-invalid<?php endif  ?>" placeholder="Masukkan name" value="<?= old('tanggal'); ?>" autofocus required>
                                    <div class="invalid-feedback">
                                        <?= session('errors.tanggal'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <select id="keterangan" name="keterangan" class="form-control <?php if (session('errors.keterangan')) : ?>is-invalid<?php endif ?>" autofocus required>
                                        <option value="" selected disabled>--Pilih--</option>
                                        <option value="izin" <?= (old('keterangan') == 'izin') ? 'selected' : ''; ?>>Izin</option>
                                        <option value="sakit" <?= (old('keterangan') == 'sakit') ? 'selected' : ''; ?>>Sakit</option>
                                        <option value="tanpa keterangan" <?= (old('keterangan') == 'tanpa keterangan') ? 'selected' : ''; ?>>Tanpa Keterangan</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= session('errors.keterangan'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <a href="<?= base_url('guru'); ?>" class="btn btn-danger">Batal</a>
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