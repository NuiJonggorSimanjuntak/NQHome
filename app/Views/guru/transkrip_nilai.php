<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <h1><strong><?= $title; ?></strong></h1>
                </div>
                <div class="col-sm-12">
                    <?php if (session()->getFlashdata('pesan')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashdata('pesan') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-sm-12">
                    <?php if (session()->getFlashdata('warning')) : ?>
                        <div class="alert alert-warning" role="alert">
                            <?= session()->getFlashdata('warning') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="" method="post">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-lg" placeholder="Keyword pencarian.." name="keyword">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-lg btn-default" name="">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <br>
                            <?php if (in_groups('admin')) : ?>
                                <button class="btn btn-outline-primary mb-3" data-toggle="modal" style="color: deepskyblue;" data-target="#modal-add"><span><i class="fas fa-plus"></i> Tambah Transkrip Nilai</span></button>
                            <?php endif; ?>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>NIS (Nomor Induk Santri)</th>
                                        <th>Nama Santri</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Semester</th>
                                        <th>Guru yang Nilai</th>
                                        <th>Nilai Raport</th>
                                        <th>Grade</th>
                                        <th style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($data as $dt) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $dt['nis']; ?></td>
                                            <td><?= $dt['nama_santri']; ?></td>
                                            <td><?= $dt['tahun_ajaran']; ?></td>
                                            <td><?= $dt['semester']; ?></td>
                                            <td><?= $dt['nama_guru']; ?></td>
                                            <td>
                                                <?= $dt['rata_rata_nilai'] ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php
                                                $grade = $dt['grade'];

                                                if ($grade === 'A' || $grade === 'B' || $grade === 'C') {
                                                    echo '<span class="badge badge-success">' . $grade . '</span>';
                                                } elseif ($grade === 'D') {
                                                    echo '<span class="badge badge-warning">' . $grade . '</span>';
                                                } elseif ($grade === 'E') {
                                                    echo '<span class="badge badge-danger">' . $grade . '</span>';
                                                } else {
                                                    echo $grade;
                                                }
                                                ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <button class="badge bg-info" data-toggle="modal" data-target="#modal-info-<?= $dt['id']; ?>"><span><i class="fas fa-eye"></i></span></button>
                                                <?php if (in_groups('admin')) : ?>
                                                    <a href="<?= base_url('guru/editTranskripNilai/' . $dt['id']); ?>"><button class="badge bg-warning"><span><i class="fas fa-edit"></i></span></button></a>
                                                    <form action="<?= base_url('guru/hapusTranskripNilai/' . $dt['id']); ?>" method="post" class="d-inline">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="badge bg-danger" onclick="return confirm('apakah anda yakin')"><span><i class="fas fa-trash-alt"></i></span></button>
                                                    </form>
                                                <?php endif; ?>
                                                <?php if (in_groups('admin') || in_groups('guru')) : ?>
                                                    <a href="<?= base_url('guru/isiNilai/' . $dt['id']); ?>"><button class="badge bg-default"><span><i class="fa-solid fa-marker"></i></span></button></a>
                                                    <a href="<?= base_url('guru/raport/' . $dt['id']); ?>"><button class="badge bg-success"><span><i class="fa-solid fa-file-pdf"></i></span></button></a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>

                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            <?= $pager->links('tbl_transkrip_nilai', 'paginations') ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-add-label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content card-primary card-outline" style="width: 800px;">
                        <div class="modal-header">
                            <h4 class="modal-title">Form Tambah Transkrip Nilai</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <form id="resetMp" action="<?= base_url('guru/simpanNilaiSantri') ?>" method="post">
                                    <?= csrf_field(); ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="id_santri">Nama Santri</label>
                                                <div class="row">
                                                    <div class="col-7">
                                                        <select id="id_santri" name="id_santri" class="form-control <?php if (session('errors.id_santri')) : ?>is-invalid<?php endif ?>">
                                                            <option value="" selected disabled>Pilih Santri</option>
                                                            <?php foreach ($santri as $s) : ?>
                                                                <option value="<?= $s['id'] ?>" <?= (old('id_santri') == $s['id'] ? 'selected' : '') ?>><?= $s['name'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            <?= session('errors.id_santri'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-5">
                                                        <input type="text" id="nis" name="nis" class="form-control" placeholder="NIS" value="<?= old('nis'); ?>" readonly style="background-color: darkgrey; color: white;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="id_guru">Guru</label>
                                                <div class="row">
                                                    <div class="col-7">
                                                        <select id="id_guru" name="id_guru" class="form-control <?php if (session('errors.id_guru')) : ?>is-invalid<?php endif ?>">
                                                            <option value="" selected disabled>Pilih Guru</option>
                                                            <?php foreach ($guru as $g) : ?>
                                                                <option value="<?= $g['id'] ?>" <?= (old('id_guru') == $g['id'] ? 'selected' : '') ?>><?= $g['name'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            <?= session('errors.id_guru'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-5">
                                                        <input type="text" id="nip" name="nip" class="form-control" placeholder="NIP" value="<?= old('nip'); ?>" readonly style="background-color: darkgrey; color: white;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="id_jadwal_pelajaran">Tahun Ajaran</label>
                                                <div class="row">
                                                    <div class="col-7">
                                                        <select id="id_jadwal_pelajaran" name="id_jadwal_pelajaran" class="form-control <?php if (session('errors.id_jadwal_pelajaran')) : ?>is-invalid<?php endif ?>">
                                                            <option value="" selected disabled>Pilih Tahun Ajaran</option>
                                                            <?php foreach ($tahunAjaran as $ta) : ?>
                                                                <option value="<?= $ta['id'] ?>" <?= (old('id_jadwal_pelajaran') == $ta['id'] ? 'selected' : '') ?> style="background-color: <?= ($ta['semester'] == 'Ganjil') ? 'red' : 'yellow'; ?>;"><?= $ta['tahun_ajaran'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            <?= session('errors.id_jadwal_pelajaran'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="text" id="semester" name="semester" class="form-control" placeholder="Semester" value="<?= old('semester'); ?>" readonly style="background-color: darkgrey; color: white;">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php for ($i = 1; $i < 2; $i++) : ?>
                                                <div class="form-group">
                                                    <label for="tahun_ajaran">Mata Pelajaran <?= $i; ?></label>
                                                    <div class="row">
                                                        <div class="col-7">
                                                            <select id="id_mata_pelajaran_<?= $i; ?>" name="id_mata_pelajaran_<?= $i; ?>" class="form-control <?php if (session('errors.id_mata_pelajaran_' . $i)) : ?>is-invalid<?php endif ?>">
                                                                <option value="" selected disabled>Pilih Mata Pelajaran <?= $i; ?></option>
                                                                <?php foreach ($mataPelajaran as $mp) : ?>
                                                                    <option value="<?= $mp['id'] ?>" <?= (old('id_mata_pelajaran_' . $i) == $mp['id'] ? 'selected' : '') ?>><?= $mp['nama_mp'] ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                <?= session('errors.id_mata_pelajaran_' . $i); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <input type="text" id="kode_mp_<?= $i; ?>" name="kode_mp_<?= $i; ?>" placeholder="Kode MP" value="<?= old('kode_mp_' . $i); ?>" class="form-control" readonly style="background-color: darkgrey; color: white;">
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endfor; ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?php for ($i = 2; $i < 6; $i++) : ?>
                                                <div class="form-group">
                                                    <label for="tahun_ajaran">Mata Pelajaran <?= $i; ?></label>
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <select id="id_mata_pelajaran_<?= $i; ?>" name="id_mata_pelajaran_<?= $i; ?>" class="form-control <?php if (session('errors.id_mata_pelajaran_' . $i)) : ?>is-invalid<?php endif ?>">
                                                                <option value="" selected disabled>Pilih Mata Pelajaran <?= $i; ?></option>
                                                                <?php foreach ($mataPelajaran as $mp) : ?>
                                                                    <option value="<?= $mp['id'] ?>" <?= (old('id_mata_pelajaran_' . $i) == $mp['id'] ? 'selected' : '') ?>><?= $mp['nama_mp'] ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                <?= session('errors.id_mata_pelajaran_' . $i); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <input type="text" id="kode_mp_<?= $i; ?>" name="kode_mp_<?= $i; ?>" placeholder="Kode MP" value="<?= old('kode_mp_' . $i); ?>" class="form-control" readonly style="background-color: darkgrey; color: white;">
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <a href="#" class="btn btn-danger reset-button"><i class="fas fa-redo"></i> Reset</a>
                                        <button type="submit" value="Simpan" class="btn btn-success float-right"><i class="fas fa-save"></i> Simpan
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <?php foreach ($data as $dt) : ?>
        <div class="modal fade" id="modal-info-<?= $dt['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-info-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-secondary" style="width: max-content;">
                    <div class="modal-header">
                        <h4 class="modal-title">Daftar Nilai MP</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kode MP</th>
                                    <th>Nama MP</th>
                                    <th>Nilai Tugas</th>
                                    <th>Nilai UTS</th>
                                    <th>Nilai UAS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $tugasString = $dt['nilai'];
                                $utsString = $dt['uts'];
                                $uasString = $dt['uas'];
                                $nilaiArray = explode(",", $tugasString);
                                $utsArray = explode(",", $utsString);
                                $uasArray = explode(",", $uasString);

                                $formattedNilai = [];
                                $formattedUts = [];
                                $formattedUas = [];
                                foreach ($nilaiArray as $nilai) {
                                    $formattedNilai[] = $nilai;
                                }
                                foreach ($utsArray as $uts) {
                                    $formattedUts[] = $uts;
                                }
                                foreach ($uasArray as $uas) {
                                    $formattedUas[] = $uas;
                                }
                                ?>
                                <tr>
                                    <td>
                                        <?php for ($j = 1; $j <= 5; $j++) : ?>
                                            <?= $dt['kodeMp' . $j]; ?><br>
                                        <?php endfor; ?>
                                    </td>
                                    <td>
                                        <?php for ($j = 1; $j <= 5; $j++) : ?>
                                            <?= $dt['namaMp' . $j]; ?><br>
                                        <?php endfor; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php foreach ($formattedNilai as $key => $nilai) : ?>
                                            <?= $nilai ?><br>
                                        <?php endforeach; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php foreach ($formattedUts as $key => $nilai) : ?>
                                            <?= $nilai ?><br>
                                        <?php endforeach; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php foreach ($formattedUas as $key => $nilai) : ?>
                                            <?= $nilai ?><br>
                                        <?php endforeach; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

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

    <style>
        .form-control::placeholder {
            color: white;
        }
    </style>

</div>
<?= $this->endSection(); ?>