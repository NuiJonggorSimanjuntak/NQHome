<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $title; ?></h1>
                </div>
                <div class="col-sm-12">
                    <?php if (session()->getFlashdata('pesan')) : ?>
                        <div class="alert alert-success" role="alert">
                            <i class="fa-solid fa-circle-check"></i>
                            <?= session()->getFlashdata('pesan') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-sm-12">
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-warning" role="alert">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid" style="align-items: center;">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-12">
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

                                    <form>
                                        <?= csrf_field(); ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <select type="text" class="form-control form-control-lg" name="filter">
                                                        <option id="filterSelect" value="">Pilih</option>
                                                        <?php foreach ($tahunAjaran as $ta) : ?>
                                                            <?php
                                                            $value = $ta['tahun_ajaran'] . '-' . $ta['semester'];
                                                            ?>
                                                            <option value="<?= htmlspecialchars($value); ?>"><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button formaction="<?= base_url('admin/daftarJadwalPelajaran'); ?>" formmethod="get" type="submit" class="btn btn-outline-success" style="height: 3pc;"><i class="fa-solid fa-filter fa-2x"></i></button>
                                                        <button formaction="<?= base_url('admin/cetakJp'); ?>" formmethod="get" class="btn btn-outline-danger" style="height: 3pc;"><i class="fas fa-print fa-2x"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <br>
                                    <?php if (in_groups('admin')) : ?>
                                        <button class="btn btn-outline-primary mb-3" data-toggle="modal" style="color: deepskyblue;" data-target="#modal-add"><span><i class="fas fa-plus"></i> Tambah Jadwal Harian</span></button>
                                    <?php endif; ?>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;">No.</th>
                                                <th style="width: 15%;">Jam</th>
                                                <th style="width: 15%;">Tahun Ajaran</th>
                                                <th style="width: 15%;">Semester</th>
                                                <th style="width: 20%;">Kegiatan</th>
                                                <?php if (in_groups('admin')) : ?>
                                                    <th style="width: 20%;">Tenaga Pengajar</th>
                                                <?php endif; ?>
                                                <th style="width: 15%;">Ruang Kelas</th>
                                                <th style="width: 15%;">Gender</th>
                                                <?php if (in_groups('admin')) : ?>
                                                    <th style="text-align: center; width: 15%;">Action</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1 + (19 * ($currentPage - 1)); ?>
                                            <?php foreach ($data as $dt) : ?>
                                                <tr>
                                                    <td style="text-align: center;"><?= $i++; ?></td>
                                                    <td><?= $dt['jam']; ?></td>
                                                    <td><?= $dt['tahun_ajaran'] ?></td>
                                                    <td><?= $dt['semester'] ?></td>
                                                    <td><?= $dt['kegiatan']; ?></td>
                                                    <?php if (in_groups('admin')) : ?>
                                                        <td><?= $dt['name']; ?></td>
                                                    <?php endif; ?>
                                                    <td><?= $dt['nama_kelas']; ?></td>
                                                    <td><?= $dt['jenis_kelamin']; ?></td>
                                                    <?php if (in_groups('admin')) : ?>
                                                        <td style="text-align: center;">
                                                            <a href="<?= base_url('admin/editJP/' . $dt['id']); ?>"><button class="badge bg-warning"><span><i class="fas fa-edit"></i></span></button></a>
                                                            <form action="/admin/hapusJP/<?= $dt['id']; ?>" method="post" class="d-inline">
                                                                <?= csrf_field(); ?>
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <button type="submit" class="badge bg-danger" onclick="return confirm('apakah anda yakin')"><span><i class="fas fa-trash-alt"></i></span></button>
                                                            </form>
                                                        </td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer clearfix">
                                    <?= $pager->links('tbl_jadwal_pelajaran', 'paginations') ?>
                                    <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-add-label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content card-primary card-outline">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Form Tambah Jadwal Harian</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="resetMp" action="<?= url_to('admin/simpanJadwalPelajaran') ?>" method="post">
                                                    <?= csrf_field(); ?>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label for="jam">Jam</label>
                                                                            <div class="input-group">
                                                                                <input type="time" id="jam_mulai" name="jam_mulai" class="form-control <?php if (session('errors.jam_mulai')) : ?>is-invalid<?php endif ?>" value="<?= old('jam_mulai') ?>">
                                                                                <div class="input-group-prepend input-group-append">
                                                                                    <span class="input-group-text">-</span>
                                                                                </div>
                                                                                <input type="time" id="jam_selesai" name="jam_selesai" class="form-control <?php if (session('errors.jam_selesai')) : ?>is-invalid<?php endif ?>" value="<?= old('jam_selesai') ?>">
                                                                                <div class="invalid-feedback">
                                                                                    <?= session('errors.jam_mulai'); ?>
                                                                                </div>
                                                                                <div class="invalid-feedback">
                                                                                    <?= session('errors.jam_selesai'); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="kegiatan">Kegiatan</label>
                                                                            <input type="text" name="kegiatan" class="form-control <?php if (session('errors.kegiatan')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Kegiatan" value="<?= old('kegiatan'); ?>">
                                                                            <div class="invalid-feedback">
                                                                                <?= session('errors.kegiatan'); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="semester">Semester</label>
                                                                            <select id="semester" name="semester" class="form-control custom-select <?php if (session('errors.semester')) : ?>is-invalid<?php endif ?>" autofocus>
                                                                                <option value="" selected>Pilih semester</option>
                                                                                <option value="Ganjil" <?= (old('semester') == 'Ganjil') ? 'selected' : ''; ?>>Ganjil</option>
                                                                                <option value="Genap" <?= (old('semester') == 'Genap') ? 'selected' : ''; ?>>Genap</option>
                                                                            </select>
                                                                            <div class="invalid-feedback">
                                                                                <?= session('errors.semester'); ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label for="id_guru">Nama</label>
                                                                            <select id="id_guru" name="id_guru" class="form-control custom-select <?php if (session('errors.id_guru')) : ?>is-invalid<?php endif ?>" autofocus>
                                                                                <option value="" selected>Pilih Guru</option>
                                                                                <?php foreach ($gurus as $guru) : ?>
                                                                                    <option value="<?= $guru['id'] ?>" <?= old('id_guru') == $guru['id'] ? 'selected' : '' ?>><?= $guru['name']; ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                            <div class="invalid-feedback">
                                                                                <?= session('errors.id_guru'); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="tahun_ajaran">Tahun Ajaran</label>
                                                                            <input type="text" id="tahun_ajaran" name="tahun_ajaran" class="form-control <?php if (session('errors.tahun_ajaran')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Tahun Ajaran" value="<?= old('tahun_ajaran') ?>">
                                                                            <div class="invalid-feedback">
                                                                                <?= session('errors.tahun_ajaran'); ?>
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
                                                                                    <option value="<?= $kls['id'] ?>" <?= old('id_kelas') == $kls['id'] ? 'selected' : '' ?>><?= $kls['nama_kelas'] . '-' . $gender; ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                            <div class="invalid-feedback">
                                                                                <?= session('errors.id_kelas'); ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="d-flex justify-content-between">
                                                                            <a href="#" class="btn btn-danger reset-button"><i class="fas fa-redo"></i> Reset</a>
                                                                            <button type="submit" value="Simpan" class="btn btn-success float-right"><i class="fas fa-save"></i> Simpan
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>