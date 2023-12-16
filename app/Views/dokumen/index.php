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
                    <?php elseif (session()->getFlashdata('batal')) : ?>
                        <div class="alert alert-warning" role="alert">
                            <?= session()->getFlashdata('batal') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12" style="width: max-content;">
                    <div class="card card-primary card-outline">
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
                                <button class="btn btn-outline-primary mb-3" data-toggle="modal" style="color: deepskyblue;" data-target="#modal-add"><span><i class="fas fa-plus"></i> Tambah dokumen</span></button>
                            <?php endif; ?>
                            <table class="table table-<?= (in_groups('admin') ? 'bordered' : 'hover borderx'); ?>">
                                <thead>
                                    <tr>
                                        <th style="text-align: center">No.</th>
                                        <th>Nama Dokumen</th>
                                        <th>Keterangan</th>
                                        <?php if (in_groups('admin')) : ?>
                                            <th>Tanggal dibuat</th>
                                            <th>Tanggal diperbaharui</th>
                                        <?php endif; ?>
                                        <th style="text-align: center;">
                                            <?= (in_groups('admin') ? 'Tindakan' : 'UNDUH'); ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1 + (5 * ($currentPage - 1)); ?>
                                    <?php foreach ($data as $dt) : ?>
                                        <tr>
                                            <td style="text-align: center;"><?= $i++; ?></td>
                                            <td><?= $dt->nama_dokumen; ?></td>
                                            <td><?= $dt->keterangan; ?></td>
                                            <?php if (in_groups('admin')) : ?>
                                                <td><?= $dt->created_at; ?></td>
                                                <td><?= $dt->updated_at; ?></td>
                                            <?php endif; ?>
                                            <td style="text-align: center;">
                                                <?php if (in_groups('admin')) : ?>
                                                    <button class="badge bg-warning" data-toggle="modal" data-target="#modal-edit-<?= $dt->id; ?>"><span><i class="fas fa-edit"></i> Edit</span></button>
                                                    <form action="/dokumen/hapusDokumen/<?= $dt->id; ?>" method="post" class="d-inline">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="badge bg-danger" onclick="return confirm('apakah anda yakin')"><span><i class="fas fa-trash-alt"></i>Hapus</span></button>
                                                    </form>
                                                <?php endif; ?>
                                                <a href="<?= base_url('dokumen/downloadDokumen/' . $dt->id); ?>" target="_blank"><i class="fa-solid fa-cloud-arrow-down fa-2xl"></i></a>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="modal-edit-<?= $dt->id; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-edit-label" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content card-warning card-outline">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Form Edit Dokumen</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="post" action="<?= base_url('dokumen/ubahDokumen/' . $dt->id); ?>" enctype="multipart/form-data">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="berkasLama" value="<?= $dt->nama_dokumen; ?>">
                                                        <div class="modal-body">
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="nama_dokumen">nama_dokumen</label>
                                                                    <div class="custom-file">
                                                                        <input type="file" id="nama_dokumen" name="nama_dokumen" class="custom-file-input <?php if (session('errors_ubah.nama_dokumen')) : ?>is-invalid<?php endif  ?>">
                                                                        <label class="custom-file-label" for="nama_dokumen"><?= $dt->nama_dokumen; ?></label>
                                                                        <div class="invalid-feedback">
                                                                            <?= session('errors_ubah.nama_dokumen'); ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="keterangan">Keterangan</label>
                                                                    <textarea name="keterangan" class="form-control <?php if (session('errors_ubah.keterangan')) : ?>is-invalid<?php endif  ?>" id="keterangan" rows="3"><?= old('keterangan', $dt->keterangan); ?></textarea>
                                                                    <div class="invalid-feedback">
                                                                        <?= session('errors_ubah.keterangan'); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                            <input type="submit" class="btn btn-warning" value="Ubah" />
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                    <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-add-label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content card-primary card-outline">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Form Tambah Dokumen</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form method="post" action="<?= base_url('dokumen/simpanDokumen'); ?>" enctype="multipart/form-data">
                                                    <?= csrf_field(); ?>
                                                    <div class="modal-body">
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="nama_dokumen">Nama Dokumen</label>
                                                                <div class="custom-file">
                                                                    <input type="file" id="nama_dokumen" name="nama_dokumen" class="custom-file-input <?php if (session('errors_simpan.nama_dokumen')) : ?>is-invalid<?php endif  ?>">
                                                                    <label class="custom-file-label" for="nama_dokumen">Pilih Dokumen..</label>
                                                                    <div class="invalid-feedback">
                                                                        <?= session('errors_simpan.nama_dokumen'); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="keterangan">Keterangan</label>
                                                                <textarea name="keterangan" class="form-control <?php if (session('errors_simpan.keterangan')) : ?>is-invalid<?php endif  ?>" id="keterangan" rows="3"><?= old('keterangan'); ?></textarea>
                                                                <div class="invalid-feedback">
                                                                    <?= session('errors_simpan.keterangan'); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        <input type="submit" class="btn btn-primary" value="Upload" />
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </tbody>
                            </table>
                            <br>
                        </div>
                        <div class="card-footer clearfix">
                            <?= $pager->links('tbl_dokumen', 'paginations') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
<?= $this->endSection(); ?>