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
        <div class="container-fluid" style="align-items: center; width: 40pc;">
            <form action="/admin/updateJp/<?= $data->id; ?>" method="post">
                <?= csrf_field(); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Format Edit Data</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card-body">
                                    <div class="form-group" style="width: 40%;">
                                        <label for="jam">Jam</label>
                                        <div class="input-group">
                                            <input type="time" id="jam_mulai" name="jam_mulai" class="form-control <?php if (session('errors.jam_mulai')) : ?>is-invalid<?php endif ?>" value="<?= old('jam_mulai', $jam_mulai) ?>">
                                            <div class="input-group-prepend input-group-append">
                                                <span class="input-group-text">-</span>
                                            </div>
                                            <input type="time" id="jam_selesai" name="jam_selesai" class="form-control <?php if (session('errors.jam_selesai')) : ?>is-invalid<?php endif ?>" value="<?= old('jam_selesai', $jam_selesai) ?>">
                                            <div class="invalid-feedback">
                                                <?= session('errors.jam_mulai'); ?>
                                            </div>
                                            <div class="invalid-feedback">
                                                <?= session('errors.jam_selesai'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="id_guru">Guru</label>
                                        <select id="id_guru" name="id_guru" class="form-control <?php if (session('errors.id_guru')) : ?>is-invalid<?php endif ?>" autofocus>
                                            <option value="" selected>Pilih Guru</option>
                                            <?php foreach ($gurus as $guru) : ?>
                                                <option value="<?= $guru['id'] ?>" <?= old('id_guru', $data->id_guru) == $guru['id'] ? 'selected' : '' ?>><?= $guru['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= session('errors.id_guru'); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="kegiatan">Kegiatan</label>
                                        <input type="text" id="kegiatan" name="kegiatan" class="form-control <?php if (session('errors.kegiatan')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Kegiatan" value="<?= old('kegiatan', $data->kegiatan) ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.kegiatan'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tahun_ajaran">Tahun Ajaran</label>
                                        <input type="text" id="tahun_ajaran" name="tahun_ajaran" class="form-control <?php if (session('errors.tahun_ajaran')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Mata Pelajaran" value="<?= old('tahun_ajaran', $data->tahun_ajaran) ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.tahun_ajaran'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="semester">Semester</label>
                                        <select id="semester" name="semester" class="form-control <?php if (session('errors.semester')) : ?>is-invalid<?php endif ?>" autofocus>
                                            <option value="" selected>Pilih semester</option>
                                            <option value="Ganjil" <?= (old('semester', $data->semester) == 'Ganjil') ? 'selected' : ''; ?>>Ganjil</option>
                                            <option value="Genap" <?= (old('semester', $data->semester) == 'Genap') ? 'selected' : ''; ?>>Genap</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= session('errors.semester'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="id_kelas">Ruang Kelas</label>
                                        <select id="id_kelas" name="id_kelas" class="form-control custom-select <?php if (session('errors.id_kelas')) : ?>is-invalid<?php endif ?>" autofocus>
                                            <option value="" selected>Pilih Kelas</option>
                                            <?php foreach ($kelas as $kls) : ?>
                                                <?php
                                                $gender = $kls['id_jk'];
                                                if ($gender === '1') {
                                                    $gender = 'L';
                                                } else {
                                                    $gender = 'P';
                                                }
                                                ?>
                                                <option value="<?= $kls['id'] ?>" <?= old('id_kelas', $data->id_kelas) == $kls['id'] ? 'selected' : '' ?>><?= $kls['nama_kelas'] . '-' . $gender; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= session('errors.id_kelas'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card-body">
                                    <a href="<?= base_url('admin/daftarJadwalPelajaran'); ?>" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    <button type="submit" value="Simpan" class="btn btn-success float-right"><i class="fas fa-edit"></i> Edit
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var guruData = <?= json_encode($gurus) ?>;
            var idGuruSelect = document.getElementById('id_guru');
            var mpInput = document.getElementById('nama_mp');

            idGuruSelect.addEventListener('change', function() {
                var selectedId = idGuruSelect.value;
                var selectedGuru = guruData.find(function(guru) {
                    return guru.id == selectedId;
                });

                if (selectedGuru) {
                    mpInput.value = selectedGuru.mapel;
                } else {
                    mpInput.value = '';
                }
            });
        });
    </script>
</div>
<?= $this->endSection(); ?>