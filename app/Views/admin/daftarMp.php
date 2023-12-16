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
                            <?= session()->getFlashdata('pesan') ?>
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
                                    <?php if (in_groups('admin')) : ?>
                                        <button class="btn btn-outline-primary mb-3" data-toggle="modal" style="color: deepskyblue;" data-target="#modal-add"><span><i class="fas fa-plus"></i> Tambah Mata Pelajaran</span></button>
                                    <?php endif; ?>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">No.</th>
                                                <th style="text-align: center;">Kode</th>
                                                <th>Mata Pelajaran</th>
                                                <th style="text-align: center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1 + (10 * ($currentPage - 1)); ?>
                                            <?php foreach ($data as $dt) : ?>
                                                <tr>
                                                    <td style="text-align: center;"><?= $i++; ?></td>
                                                    <td><?= $dt['kode_mp']; ?></td>
                                                    <td><?= $dt['nama_mp']; ?></td>
                                                    <td style="text-align: center;">
                                                        <button class="badge bg-warning" data-toggle="modal" data-target="#modal-edit-<?= $dt['id']; ?>"><span><i class="fas fa-edit"></i></span></button>
                                                        <form action="/admin/hapusMp/<?= $dt['id']; ?>" method="post" class="d-inline">
                                                            <?= csrf_field(); ?>
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <button type="submit" class="badge bg-danger" onclick="return confirm('apakah anda yakin')"><span><i class="fas fa-trash-alt"></i></span></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="modal-edit-<?= $dt['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-add-label" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content card-warning card-outline">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Form Edit Mata Pelajaran</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="/admin/updateMp/<?= $dt['id']; ?>" method="post">
                                                                <?= csrf_field(); ?>
                                                                <div class="modal-body">
                                                                    <div class="card-body">
                                                                        <div class="form-group">
                                                                            <label for="kode_mp">Kode</label>
                                                                            <input style="background-color: #778899;" type="text" id="kode_mp" name="kode_mp" class="form-control <?php if (session('errors_edit.kode_mp')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Kode" value="<?= old('kode_mp', $dt['kode_mp']) ?>" readonly>
                                                                            <div class="invalid-feedback">
                                                                                <?= session('errors_edit.kode_mp'); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="nama_mp">Mata Pelajaran</label>
                                                                            <input type="text" id="nama_mp" name="nama_mp" class="form-control <?php if (session('errors_edit.nama_mp')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Mata Pelajaran" value="<?= old('nama_mp', $dt['nama_mp']) ?>">
                                                                            <div class="invalid-feedback">
                                                                                <?= session('errors_edit.nama_mp'); ?>
                                                                            </div>
                                                                        </div>
                                                                        <a href="<?= base_url('admin/daftarMp'); ?>" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Kembali</a>
                                                                        <button type="submit" value="Simpan" class="btn btn-success float-right"><i class="fas fa-edit"></i> Edit
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?= $pager->links('tbl_mp', 'paginations') ?>
                                    <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-add-label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content card-primary card-outline">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Form Tambah Mata Pelajaran</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="resetMp" action="<?= url_to('admin/simpanMp') ?>" method="post">
                                                    <?= csrf_field(); ?>
                                                    <div class="modal-body">
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="kode_mp">Kode</label>
                                                                <input type="text" id="kode_mp" name="kode_mp" class="form-control <?php if (session('errors_simpan.kode_mp')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Kode" value="<?= $kode_mp; ?>" readonly>
                                                                <div class="invalid-feedback">
                                                                    <?= session('errors_simpan.kode_mp'); ?>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="nama_mp">Mata Pelajaran</label>
                                                                <input type="text" id="nama_mp" name="nama_mp" class="form-control <?php if (session('errors_simpan.nama_mp')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Mata Pelajaran" value="<?= old('nama_mp') ?>">
                                                                <div class="invalid-feedback">
                                                                    <?= session('errors_simpan.nama_mp'); ?>
                                                                </div>
                                                                <br>
                                                                <div class="d-flex justify-content-between">
                                                                    <a href="#" class="btn btn-danger reset-button"><i class="fas fa-redo"></i> Reset</a>
                                                                    <button type="submit" value="Simpan" class="btn btn-success float-right"><i class="fas fa-save"></i> Simpan
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
</div>
</section>

</div>
<?= $this->endSection(); ?>