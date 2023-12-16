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
                                <button class="btn btn-outline-primary mb-3" data-toggle="modal" style="color: deepskyblue;" data-target="#modal-add"><span><i class="fas fa-plus"></i> Tambah Event</span></button>
                            <?php endif; ?>
                            <table class="table table-<?= (in_groups('admin') ? 'bordered' : 'hover borderx'); ?>">
                                <thead>
                                    <tr>
                                        <th style="text-align: center">No.</th>
                                        <th style="width: 20%">Judul</th>
                                        <th style="width: 30%">Deskripsi</th>
                                        <th>Gambar</th>
                                        <th>Status</th>
                                        <th style="text-align: center;">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1 + (10 * ($currentPage - 1)); ?>
                                    <?php foreach ($data as $dt) : ?>
                                        <tr>
                                            <td style="text-align: center;"><?= $i++; ?></td>
                                            <td><?= $dt['judul']; ?></td>
                                            <?php
                                            $deskripsi = $dt['deskripsi'];
                                            $words = str_word_count($deskripsi, 1);

                                            if (count($words) > 3) {
                                                $deskripsiPendek = implode(' ', array_slice($words, 0, 8)) . '...';
                                            } else {
                                                $deskripsiPendek = $deskripsi;
                                            }
                                            ?>
                                            <td><?= $deskripsiPendek; ?></td>
                                            <td><img src="<?= base_url('event/' . $dt['gambar']); ?>" alt="" style="width: 50px; height: 50px;"></td>
                                            <td style="text-align: center;">
                                                <form id="form<?= $dt['id']; ?>" action="<?= base_url('event/updateStatus/' . $dt['id']); ?>" method="post">
                                                    <?= csrf_field(); ?>
                                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                        <input type="checkbox" name="status" class="custom-control-input user-switch" id="userSwitch<?= $dt['id']; ?>" data-id="<?= $dt['id']; ?>" <?= ($dt['status'] == '1') ? 'checked' : ''; ?>>
                                                        <label class="custom-control-label" for="userSwitch<?= $dt['id']; ?>"></label>
                                                    </div>
                                                </form>

                                                <script>
                                                    document.querySelectorAll('.user-switch').forEach(userSwitch => {
                                                        userSwitch.addEventListener('change', function() {
                                                            const formId = `form${this.getAttribute('data-id')}`;
                                                            const form = document.getElementById(formId);

                                                            if (form) {
                                                                form.submit();
                                                            }
                                                        });
                                                    });
                                                </script>
                                            </td>
                                            <td style="text-align: center;">
                                                <button class="badge bg-warning" data-toggle="modal" data-target="#modal-edit-<?= $dt['id']; ?>"><span><i class="fas fa-edit"></i> Edit</span></button>
                                                <form action="<?= base_url('event/hapusEvent/' . $dt['id']); ?>" method="post" class="d-inline">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="badge bg-danger" onclick="return confirm('apakah anda yakin')"><span><i class="fas fa-trash-alt"></i>Hapus</span></button>
                                                </form>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="modal-edit-<?= $dt['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-edit-label" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content card-warning card-outline">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Form Edit Dokumen</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="post" action="<?= base_url('event/ubahEvent/' . $dt['id']); ?>" enctype="multipart/form-data">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="gambarLama" value="<?= $dt['gambar']; ?>">
                                                        <div class="modal-body">
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="judul">Judul</label>
                                                                    <input type="text" id="judul" name="judul" class="form-control <?php if (session('errors_simpan.judul')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Judul" value="<?= old('judul', $dt['judul']) ?>" autofocus>
                                                                    <div class="invalid-feedback">
                                                                        <?= session('errors_simpan.judul'); ?>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="deskripsi">Deskripsi</label>
                                                                    <textarea name="deskripsi" class="form-control <?php if (session('errors_ubah.deskripsi')) : ?>is-invalid<?php endif  ?>" id="deskripsi" rows="3"><?= old('deskripsi', $dt['deskripsi']); ?></textarea>
                                                                    <div class="invalid-feedback">
                                                                        <?= session('errors_ubah.deskripsi'); ?>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="gambar">Gambar</label>
                                                                    <div class="custom-file">
                                                                        <input type="file" id="gambar" name="gambar" class="custom-file-input <?php if (session('errors_ubah.gambar')) : ?>is-invalid<?php endif  ?>">
                                                                        <label class="custom-file-label" for="gambar"><?= $dt['gambar']; ?></label>
                                                                        <div class="invalid-feedback">
                                                                            <?= session('errors_ubah.gambar'); ?>
                                                                        </div>
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
                                                    <h4 class="modal-title">Form Tambah Event</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form method="post" action="<?= base_url('event/simpanEvent'); ?>" enctype="multipart/form-data">
                                                    <?= csrf_field(); ?>
                                                    <div class="modal-body">
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="judul">Judul</label>
                                                                <input type="text" id="judul" name="judul" class="form-control <?php if (session('errors_simpan.judul')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan Judul" value="<?= old('judul') ?>" autofocus>
                                                                <div class="invalid-feedback">
                                                                    <?= session('errors_simpan.judul'); ?>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="deskripsi">Deskripsi</label>
                                                                <textarea name="deskripsi" class="form-control <?php if (session('errors_simpan.deskripsi')) : ?>is-invalid<?php endif  ?>" id="deskripsi" rows="3"><?= old('deskripsi'); ?></textarea>
                                                                <div class="invalid-feedback">
                                                                    <?= session('errors_simpan.deskripsi'); ?>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="gambar">Gambar</label>
                                                                <div class="custom-file">
                                                                    <input type="file" id="gambar" name="gambar" class="custom-file-input <?php if (session('errors_simpan.gambar')) : ?>is-invalid<?php endif  ?>">
                                                                    <label class="custom-file-label" for="gambar">Pilih Dokumen..</label>
                                                                    <div class="invalid-feedback">
                                                                        <?= session('errors_simpan.gambar'); ?>
                                                                    </div>
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