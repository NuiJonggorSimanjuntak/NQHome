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
                <?php elseif (session()->getFlashdata('same')) : ?>
                    <div class="alert alert-warning" role="alert">
                        <?= session()->getFlashdata('same') ?>
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
                        <form action="/guru/simpanAbsen" method="POST" class="d-inline" id="guru-form">
                            <input type="hidden" name="dates" id="dates-input-guru">
                            <button type="submit" class="btn btn-outline-primary mx-2" id="save-button-guru">Simpan QR-Code Guru</button>
                        </form>
                        <form action="/santri/simpanAbsen" method="POST" class="d-inline" id="santri-form">
                            <input type="hidden" name="dates" id="dates-input-santri">
                            <button type="submit" class="btn btn-outline-primary mx-2" id="save-button-santri">Simpan QR-Code Santri</button>
                        </form>
                    </div>
                    <div class="month-list"></div>
                </div>
            </div>
            <div class="col-sm-5 light">
                <div class="calendar">
                    <div class="card-body">
                        <form action="<?= base_url('admin/cetakQR'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" id="edit-tanggal" name="tanggal" class="form-control <?php if (session('errors.tanggal')) : ?>is-invalid<?php endif; ?>" value="<?= !empty($absen['tanggal']) ? old('tanggal', $absen['tanggal']) : ''; ?>">
                                <div class="invalid-feedback">
                                    <?= session('errors.tanggal'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="entity">Entity</label>
                                <select id="entity" name="entity" class="form-control custom-select <?php if (session('errors.entity')) : ?>is-invalid<?php endif; ?>">
                                    <option selected disabled>--Pilih--</option>
                                    <option value="guru" <?= (old('entity', $entity) == 'guru') ? 'selected' : ''; ?>>Guru</option>
                                    <option value="santri" <?= (old('entity', $entity) == 'santri') ? 'selected' : ''; ?>>Santri</option>
                                </select>
                                <div class="invalid-feedback"><?= session('errors.entity'); ?></div>
                                <script>
                                    document.getElementById('entity').addEventListener('change', function() {
                                        this.form.submit();
                                    });
                                </script>
                            </div>
                            <div class="form-group">
                                <label for="jam_masuk">Jam Masuk</label>
                                <input type="time" id="jam_masuk" name="jam_masuk" class="form-control <?php if (session('errors.jam_masuk')) : ?>is-invalid<?php endif ?>" value="<?= !empty($absen['jam_masuk']) ? old('jam_masuk', $absen['jam_masuk']) : ''; ?>">
                                <div class="invalid-feedback">
                                    <?= session('errors.jam_masuk'); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="jam_keluar">Jam Pulang</label>
                                <input type="time" id="jam_keluar" name="jam_keluar" class="form-control <?php if (session('errors.jam_keluar')) : ?>is-invalid<?php endif ?>" value="<?= !empty($absen['jam_keluar']) ? old('jam_keluar', $absen['jam_keluar']) : ''; ?>">
                                <div class="invalid-feedback">
                                    <?= session('errors.jam_keluar'); ?>
                                </div>
                            </div>
                            <button type="submit" formmethod="post" formaction="<?= base_url('admin/generateQR'); ?>" class="btn btn-outline-success">QR-Code Generate</button>
                            <a href="<?= base_url('admin/cetakQR'); ?>" class="btn btn-danger reset-button"><i class="fas fa-redo"></i> Reset</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection(); ?>