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
                    <?php if (session()->getFlashdata('berhasil')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashdata('berhasil') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-sm-12">
                    <?php if (session()->getFlashdata('empty')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= session()->getFlashdata('empty') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-sm-12">
                    <?php if (session()->getFlashdata('same')) : ?>
                        <div class="alert alert-warning" role="alert">
                            <?= session()->getFlashdata('same') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row" style="width: max-content;">
                <div class="col-md">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <a href="/guru/tambahAbsen" class="btn btn-outline-primary mb-3" style="color: deepskyblue;"><i class="fas fa-plus"></i> Tambah QR CODE</a>
                            <a href="/guru/printpdfAll" class="btn btn-outline-danger mb-3"><i class="fas fa-print"></i> Print Semua</a>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <th style="text-align: center;">Generate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($users as $user) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $user['tanggal']; ?></td>
                                            <td><?= date('H:i', strtotime($user['jam_masuk'])); ?></td>
                                            <td><?= date('H:i', strtotime($user['jam_keluar'])); ?></td>
                                            <td style="text-align: center;">
                                                <?php if (!empty($user['qr_code'])) : ?>
                                                    <button class="badge bg-info" data-toggle="modal" data-target="#modal-info-<?= $user['id']; ?>"><span><i class="fas fa-eye"></i> Lihat</span></button>
                                                <?php else : ?>
                                                    <button class="badge bg-warning"><span><i class="fas fa-exclamation"></i> Generate</span></button>
                                                <?php endif; ?>
                                                <a href="<?= base_url('guru/editAbsen/' . $user['id']); ?>"><button class="badge bg-warning"><span><i class="fas fa-edit"></i> Edit</span></button></a>
                                                <form action="/guru/hapusAbsen/<?= $user['id']; ?>" method="post" class="d-inline">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="badge bg-danger"><span><i class="fas fa-trash-alt"></i> Hapus</span></button>
                                                </form>
                                            </td>

                                            <!-- Modal Lihat -->
                                            <div class="modal fade" id="modal-info-<?= $user['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-info-label" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content bg-info">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">QR CODE</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align: center;">
                                                            <?php if (!empty($user['qr_code'])) : ?>
                                                                <img src="<?= base_url('qrcodes/' . $user['qr_code']); ?>" alt="QR Code">
                                                            <?php else : ?>
                                                                <p>QR belum di Generate</p>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                                            <a href="<?= base_url('guru/printpdf/' . $user['id']); ?>"><button class="btn btn-outline-light">Cetak</button></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>