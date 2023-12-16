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
            <form action="<?= url_to('santri/simpanAbsen') ?>" method="post">
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
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" id="tanggal" name="tanggal" class="form-control <?php if (session('errors.tanggal')) : ?>is-invalid<?php endif  ?>" placeholder="Masukkan tanggal" value="<?= old('tanggal'); ?>">
                                    <div class="invalid-feedback">
                                        <?= session('errors.tanggal'); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="jam_masuk">Jam Masuk</label>
                                    <input type="time" id="jam_masuk" name="jam_masuk" class="form-control <?php if (session('errors.jam_masuk')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Jam Masuk" value="<?= old('jam_masuk'); ?>">
                                    <div class="invalid-feedback">
                                        <?= session('errors.jam_masuk'); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="jam_keluar">Jam Pulang</label>
                                    <input type="time" id="jam_keluar" name="jam_keluar" class="form-control <?php if (session('errors.jam_keluar')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Jam Keluar" value="<?= old('jam_keluar'); ?>">
                                    <div class="invalid-feedback">
                                        <?= session('errors.jam_keluar'); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <a href="<?= base_url('santri/absensi'); ?>" class="btn btn-danger">Batal</a>
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