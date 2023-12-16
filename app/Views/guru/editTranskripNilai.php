<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="justify-content: center; text-align: center;">
                <div class="col-sm-12">
                    <h1><?= $title; ?></h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <form action="<?= base_url('guru/updateTranskripNilai/' . $data['id']); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="row" style="justify-content: center;">
                    <div class="col-md-8">
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
                                <form action="<?= base_url('guru/simpanNilaiSantri') ?>" method="post">
                                    <?= csrf_field(); ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="id_santri">Nama Santri</label>
                                                <div class="row">
                                                    <div class="col-8">
                                                        <input type="text" id="id_santri" name="id_santri" class="form-control <?php if (session('errors.id_santri')) : ?>is-invalid<?php endif ?>" placeholder="Nama Santri" value="<?= old('id_santri', $data['name']); ?>" readonly>
                                                        <div class="invalid-feedback">
                                                            <?= session('errors.id_santri'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="text" id="nis" name="nis" class="form-control <?php if (session('errors.nis')) : ?>is-invalid<?php endif ?>" placeholder="NIS" value="<?= old('nis', $data['nis']); ?>" readonly style="background-color: darkgrey; color: white;">
                                                        <div class="invalid-feedback">
                                                            <?= session('errors.nis'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="id_guru">Guru</label>
                                                <div class="row">
                                                    <div class="col-8">
                                                        <select id="id_guru" name="id_guru" class="form-control <?php if (session('errors.id_guru')) : ?>is-invalid<?php endif ?>">
                                                            <option value="" selected disabled>Pilih Guru</option>
                                                            <?php foreach ($guru as $g) : ?>
                                                                <option value="<?= $g['id'] ?>" <?= (old('id_guru', $data['id_guru']) == $g['id'] ? 'selected' : '') ?>><?= $g['name'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            <?= session('errors.id_guru'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="text" id="nip" name="nip" class="form-control" placeholder="NIP" value="<?= old('nip', $data['nip']); ?>" readonly style="background-color: darkgrey; color: white;">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="id_jadwal_pelajaran">Tahun Ajaran</label>
                                                <div class="row">
                                                    <div class="col-8">
                                                        <select id="id_jadwal_pelajaran" name="id_jadwal_pelajaran" class="form-control <?php if (session('errors.id_jadwal_pelajaran')) : ?>is-invalid<?php endif ?>">
                                                            <option value="" selected>Pilih Tahun Ajaran</option>
                                                            <?php foreach ($tahunAjaran as $ta) : ?>
                                                                <option value="<?= $ta['id'] ?>" <?= (old('id_jadwal_pelajaran', $data['id_jadwal_pelajaran']) == $ta['id'] ? 'selected' : '') ?>><?= $ta['tahun_ajaran'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            <?= session('errors.id_jadwal_pelajaran'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="text" id="semester" name="semester" class="form-control" placeholder="Semester" value="<?= old('semester', $data['semester']); ?>" readonly style="background-color: darkgrey; color: white;">
                                                    </div>
                                                </div>
                                            </div>

                                            <?php for ($i = 1; $i <= 1; $i++) : ?>
                                                <div class="form-group">
                                                    <label for="tahun_ajaran">Mata Pelajaran <?= $i; ?></label>
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <select id="id_mata_pelajaran_<?= $i; ?>" name="id_mata_pelajaran_<?= $i; ?>" class="form-control <?php if (session('errors.id_mata_pelajaran_' . $i)) : ?>is-invalid<?php endif ?>">
                                                                <option value="" selected>Pilih Mata Pelajaran <?= $i; ?></option>
                                                                <?php foreach ($mataPelajaran as $mp) : ?>
                                                                    <option value="<?= $mp['id'] ?>" <?= (old('id_mata_pelajaran_' . $i, $data['id_mp' . $i]) == $mp['id'] ? 'selected' : '') ?>><?= $mp['nama_mp'] ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                <?= session('errors.id_mata_pelajaran_' . $i); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <input type="text" id="kode_mp_<?= $i; ?>" name="kode_mp_<?= $i; ?>" class="form-control" value="<?= old('kode_mp_' . $i, $data['kodeMp' . $i]); ?>" readonly style="background-color: darkgrey; color: white;">
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endfor; ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?php for ($i = 2; $i <= 5; $i++) : ?>
                                                <div class="form-group">
                                                    <label for="tahun_ajaran">Mata Pelajaran <?= $i; ?></label>
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <select id="id_mata_pelajaran_<?= $i; ?>" name="id_mata_pelajaran_<?= $i; ?>" class="form-control <?php if (session('errors.id_mata_pelajaran_' . $i)) : ?>is-invalid<?php endif ?>">
                                                                <option value="" selected>Pilih Mata Pelajaran <?= $i; ?></option>
                                                                <?php foreach ($mataPelajaran as $mp) : ?>
                                                                    <option value="<?= $mp['id'] ?>" <?= (old('id_mata_pelajaran_' . $i, $data['id_mp' . $i]) == $mp['id'] ? 'selected' : '') ?>><?= $mp['nama_mp'] ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                <?= session('errors.id_mata_pelajaran_' . $i); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <input type="text" id="kode_mp_<?= $i; ?>" name="kode_mp_<?= $i; ?>" class="form-control" value="<?= old('kode_mp_' . $i, $data['kodeMp' . $i]); ?>" readonly style="background-color: darkgrey; color: white;">
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <a href="<?= base_url('guru/transkrip_nilai'); ?>" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Kembali</a>
                                        <button type="submit" value="Simpan" class="btn btn-success float-right"><i class="fas fa-edit"></i> Ubah
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var guruData = <?= json_encode($guru) ?>;
        var idGuruSelect = document.getElementById('id_guru');
        var nipInput = document.getElementById('nip');

        idGuruSelect.addEventListener('change', function() {
            var selectedId = idGuruSelect.value;
            var selectedGuru = guruData.find(function(guru) {
                return guru.id == selectedId;
            });

            if (selectedGuru) {
                nipInput.value = selectedGuru.nip;
            } else {
                nipInput.value = '';
            }
        });

        var santriData = <?= json_encode($santri) ?>;
        var idSantriSelect = document.getElementById('id_santri');
        var nisInput = document.getElementById('nis');

        idSantriSelect.addEventListener('change', function() {
            var selectedId = idSantriSelect.value;
            var selectedSantri = santriData.find(function(santri) {
                return santri.id == selectedId;
            });

            if (selectedSantri) {
                nisInput.value = selectedSantri.nis;
            } else {
                nisInput.value = '';
            }
        });

        var tahunAjaranData = <?= json_encode($tahunAjaran) ?>;
        var idJadwalPelajaranSelect = document.getElementById('id_jadwal_pelajaran');
        var semesterInput = document.getElementById('semester');

        idJadwalPelajaranSelect.addEventListener('change', function() {
            var selectedId = idJadwalPelajaranSelect.value;
            var selectedTahunAjaran = tahunAjaranData.find(function(ta) {
                return ta.id == selectedId;
            });

            if (selectedTahunAjaran) {
                semesterInput.value = selectedTahunAjaran.semester;
            } else {
                semesterInput.value = '';
            }
        });

        var mataPelajaranData = <?= json_encode($mataPelajaran) ?>;
        <?php for ($i = 1; $i <= 5; $i++) : ?>
            var idMataPelajaran<?= $i; ?>Select = document.getElementById('id_mata_pelajaran_<?= $i; ?>');
            var kodeMp<?= $i; ?>Input = document.getElementById('kode_mp_<?= $i; ?>');

            idMataPelajaran<?= $i; ?>Select.addEventListener('change', function() {
                var selectedId = idMataPelajaran<?= $i; ?>Select.value;
                var selectedMataPelajaran = mataPelajaranData.find(function(mp) {
                    return mp.id == selectedId;
                });

                if (selectedMataPelajaran) {
                    kodeMp<?= $i; ?>Input.value = selectedMataPelajaran.kode_mp;
                } else {
                    kodeMp<?= $i; ?>Input.value = '';
                }
            });

        <?php endfor; ?>
    });
</script>

<?php $this->endSection(); ?>