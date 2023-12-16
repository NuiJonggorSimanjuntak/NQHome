<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="content-wrapper">

    <section class="content">
        <div class="container-fluid" style="align-items: center;">
            <br>
            <div class="row" style="justify-content: center;">
                <div class="col-8">
                    <div class="card card-maroon">
                        <div class="card-header">
                            <h3 class="card-title"><?= $field['nama_santri'] . '-' . $field['nis']; ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('guru/simpanNilai/' . $field['id']) ?>" method="post">
                                <?= csrf_field(); ?>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 1%; text-align: center;">No.</th>
                                            <th style="width: 5%; text-align: center;">Kode MP.</th>
                                            <th style="width: 20%;">Mata Pelajaran</th>
                                            <th style="text-align: center;">Nilai Tugas</th>
                                            <th style="text-align: center;">Nilai UTS</th>
                                            <th style="text-align: center;">Nilai UAS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data as $dt) : ?>
                                            <?php for ($j = 1; $j <= 5; $j++) : ?>
                                                <tr>
                                                    <th style="text-align: center;"><?= $j; ?></th>
                                                    <td style="text-align: center;"><?= $dt['kodeMp' . $j]; ?></td>
                                                    <td><?= $dt['namaMp' . $j]; ?></td>
                                                    <td style="width: 7%;">
                                                        <input type="text" name="nilai_<?= $j; ?>" style="width: 100%; text-align: center;" class="form-control <?php if (session('errors.nilai_' . $j)) : ?>is-invalid<?php endif ?>" value="<?= old('nilai_' . $j, ${"nilai_" . $j}); ?>">
                                                        <div class="invalid-feedback">
                                                            <?= session('errors.nilai_' . $j); ?>
                                                        </div>
                                                    </td>
                                                    <td style="width: 7%;">
                                                        <input type="text" name="uts_<?= $j; ?>" style="width: 100%; text-align: center;" class="form-control <?php if (session('errors.uts_' . $j)) : ?>is-invalid<?php endif ?>" value="<?= old('uts_' . $j, ${"uts_" . $j}); ?>">
                                                        <div class="invalid-feedback">
                                                            <?= session('errors.uts_' . $j); ?>
                                                        </div>
                                                    </td>
                                                    <td style="width: 7%;">
                                                        <input type="text" name="uas_<?= $j; ?>" style="width: 100%; text-align: center;" class="form-control <?php if (session('errors.uas_' . $j)) : ?>is-invalid<?php endif ?>" value="<?= old('uas_' . $j, ${"uas_" . $j}); ?>">
                                                        <div class="invalid-feedback">
                                                            <?= session('errors.uas_' . $j); ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endfor; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tbody>
                                        <tr>
                                            <th colspan="3" style="background-color: darkgray; opacity: 0.6; color: black;"></th>
                                            <th colspan="2" style="text-align: center;">Kelakuan</th>
                                            <td colspan="2">
                                                <select name="kelakuan" id="" class="form-control custom-select <?php if (session('errors.kelakuan')) : ?>is-invalid<?php endif ?>" style="text-align: center;">
                                                    <option selected disabled>Pilih</option>
                                                    <option value="A" <?= (old('kelakuan', $dt['kelakuan']) == 'A') ? 'selected' : ''; ?>>A</option>
                                                    <option value="B" <?= (old('kelakuan', $dt['kelakuan']) == 'B') ? 'selected' : ''; ?>>B</option>
                                                    <option value="B" <?= (old('kelakuan', $dt['kelakuan']) == 'C') ? 'selected' : ''; ?>>C</option>
                                                    <option value="D" <?= (old('kelakuan', $dt['kelakuan']) == 'D') ? 'selected' : ''; ?>>D</option>
                                                    <option value="E" <?= (old('kelakuan', $dt['kelakuan']) == 'E') ? 'selected' : ''; ?>>E</option>
                                                </select>
                                                <div class="invalid-feedback"><?= session('errors.kelakuan'); ?></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th colspan="3" style="background-color: darkgray; opacity: 0.6; color: black;"></th>
                                            <th colspan="2" style="text-align: center;">Kerajinan</th>
                                            <td colspan="2">
                                                <select name="kerajianan" id="" class="form-control custom-select <?php if (session('errors.kerajianan')) : ?>is-invalid<?php endif ?>" style="text-align: center;">
                                                    <option selected disabled>Pilih</option>
                                                    <option value="A" <?= (old('kerajianan', $dt['kerajianan']) == 'A') ? 'selected' : ''; ?>>A</option>
                                                    <option value="B" <?= (old('kerajianan', $dt['kerajianan']) == 'B') ? 'selected' : ''; ?>>B</option>
                                                    <option value="B" <?= (old('kerajianan', $dt['kerajianan']) == 'C') ? 'selected' : ''; ?>>C</option>
                                                    <option value="D" <?= (old('kerajianan', $dt['kerajianan']) == 'D') ? 'selected' : ''; ?>>D</option>
                                                    <option value="E" <?= (old('kerajianan', $dt['kerajianan']) == 'E') ? 'selected' : ''; ?>>E</option>
                                                </select>
                                                <div class="invalid-feedback"><?= session('errors.kerajianan'); ?></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th colspan="3" style="background-color: darkgray; opacity: 0.6; color: black;"></th>
                                            <th colspan="2" style="text-align: center;">Kerapian</th>
                                            <td colspan="2">
                                                <select name="kerapian" id="" class="form-control custom-select <?php if (session('errors.kerapian')) : ?>is-invalid<?php endif ?>" style="text-align: center;">
                                                    <option selected disabled>Pilih</option>
                                                    <option value="A" <?= (old('kerapian', $dt['kerapian']) == 'A') ? 'selected' : ''; ?>>A</option>
                                                    <option value="B" <?= (old('kerapian', $dt['kerapian']) == 'B') ? 'selected' : ''; ?>>B</option>
                                                    <option value="B" <?= (old('kerapian', $dt['kerapian']) == 'C') ? 'selected' : ''; ?>>C</option>
                                                    <option value="D" <?= (old('kerapian', $dt['kerapian']) == 'D') ? 'selected' : ''; ?>>D</option>
                                                    <option value="E" <?= (old('kerapian', $dt['kerapian']) == 'E') ? 'selected' : ''; ?>>E</option>
                                                </select>
                                                <div class="invalid-feedback"><?= session('errors.kerapian'); ?></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody>
                                        <tr>
                                            <td style="text-align: end;" colspan="6">
                                                <a href="<?= base_url('guru/transkrip_nilai'); ?>" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                <button type="submit" value="Simpan" class="btn btn-success"><i class="fa-solid fa-marker"></i> Nilai
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
<?= $this->endSection(); ?>