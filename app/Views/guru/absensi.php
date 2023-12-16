<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="col-sm-6">
                <h1><strong><?= $title; ?></strong></h1>
            </div>
            <div class="col-sm-12">
                <?php if (session()->getFlashdata('berhasil')) : ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->getFlashdata('berhasil') ?>
                    </div>
                <?php elseif(session()->getFlashdata('same')) : ?>
                    <div class="alert alert-warning" role="alert">
                        <?= session()->getFlashdata('same') ?>
                    </div>
                <?php elseif(session()->getFlashdata('errors')) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= session()->getFlashdata('errors') ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-sm-6 light">
                <div class="calendar">
                    <div class="calendar-header">
                        <span class="month-picker" id="month-picker"></span>
                        <div class="year-picker">
                            <span class="year-change" id="prev-year">
                                <pre><</pre>
                            </span>
                            <span id="year"></span>
                            <span class="year-change" id="next-year">
                                <pre>></pre>
                            </span>
                        </div>
                    </div>
                    <div class="calendar-body">
                        <div class="calendar-week-day">
                            <div>Min</div>
                            <div>Sen</div>
                            <div>Sel</div>
                            <div>Rab</div>
                            <div>Kam</div>
                            <div>Jumt</div>
                            <div>Sab</div>
                        </div>
                        <div class="calendar-days"></div>
                    </div>
                    <div class="text-center mt-0">
                        <form action="/guru/simpanAbsen" method="POST" class="d-inline">
                            <input type="hidden" name="dates" id="dates-input">
                            <button type="submit" class="btn btn-outline-primary mx-2" id="save-button">Simpan</button>
                        </form>
                    </div>
                    <div class="month-list"></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card-body">
                    <form action="<?= base_url('guru/generateQR'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" id="edit-tanggal" name="tanggal" class="form-control <?php if (session('errors.tanggal')) : ?>is-invalid<?php endif  ?>" value="<?= old('tanggal'); ?>">
                            <div class="invalid-feedback">
                                <?= session('errors.tanggal'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="jam_masuk">Jam Masuk</label>
                            <input type="time" id="edit-jam-masuk" name="jam_masuk" class="form-control <?php if (session('errors.jam_masuk')) : ?>is-invalid<?php endif ?>" value="08:00">
                            <div class="invalid-feedback">
                                <?= session('errors.jam_masuk'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="jam_keluar">Jam Pulang</label>
                            <input type="time" id="edit-jam-keluar" name="jam_keluar" class="form-control <?php if (session('errors.jam_keluar')) : ?>is-invalid<?php endif ?>" value="18:00">
                            <div class="invalid-feedback">
                                <?= session('errors.jam_keluar'); ?>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-outline-success">Generate QR Code</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection(); ?>