<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
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
            <div class="row">
                <div class="col-md">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3><?= $titleGuru; ?></h3>
                                </div>
                                <form action="" method="post">
                                    <div class="card-body">
                                        <input type="date" id="dateGuru" name="dateGuru" class="form-control" value="">
                                    </div>
                                </form>
                                <script>
                                    var dateInput = document.getElementById('dateGuru');
                                    dateInput.addEventListener('change', function() {
                                        this.form.submit();
                                    });
                                </script>

                                <div class="card-body">
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
                                            <?php $i = 1 + (10 * ($currentPageGuru - 1)); ?>
                                            <?php foreach ($gurus as $guru) : ?>
                                                <tr>
                                                    <td style="text-align: center;"><?= $i++; ?></td>
                                                    <td><?= $guru['tanggal']; ?></td>
                                                    <td><?= date('H:i', strtotime($guru['jam_masuk'])); ?></td>
                                                    <td><?= date('H:i', strtotime($guru['jam_keluar'])); ?></td>
                                                    <td style="text-align: center;">
                                                        <button class="badge bg-info" data-toggle="modal" data-target="#modal-info-<?= $guru['id']; ?>"><span><i class="fas fa-eye"></i> Lihat</span></button>
                                                    </td>

                                                    <!-- Modal Lihat -->
                                                    <div class="modal fade" id="modal-info-<?= $guru['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-info-label" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content bg-info">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">QR CODE</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body" style="text-align: center;">
                                                                    <?php if (!empty($guru['qr_code'])) : ?>
                                                                        <img src="<?= base_url('qrcodesGuru/' . $guru['qr_code']); ?>" alt="QR Code">
                                                                    <?php else : ?>
                                                                        <p>QR belum di Generate</p>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="modal-footer justify-content-between">
                                                                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                                                    <a href="<?= base_url('guru/printpdf/' . $guru['id']); ?>"><button class="btn btn-outline-light">Cetak</button></a>
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
                                    <?= $pagerGuru->links('tbl_qrcode_guru', 'paginations') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3><?= $titleSantri; ?></h3>
                                </div>
                                <form action="" method="post">
                                    <div class="card-body">
                                        <input type="date" id="dateSantri" name="dateSantri" class="form-control" value="">
                                    </div>
                                </form>
                                <script>
                                    var dateInput = document.getElementById('dateSantri');
                                    dateInput.addEventListener('change', function() {
                                        this.form.submit();
                                    });
                                </script>
                                <div class="card-body">
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
                                            <?php $i = 1 + (10 * ($currentPageSantri - 1)); ?>
                                            <?php foreach ($santris as $santri) : ?>
                                                <tr>
                                                    <td style="text-align: center;"><?= $i++; ?></td>
                                                    <td><?= $santri['tanggal']; ?></td>
                                                    <td><?= date('H:i', strtotime($santri['jam_masuk'])); ?></td>
                                                    <td><?= date('H:i', strtotime($santri['jam_keluar'])); ?></td>
                                                    <td style="text-align: center;">
                                                        <button class="badge bg-info" data-toggle="modal" data-target="#modal-info-<?= $santri['id']; ?>"><span><i class="fas fa-eye"></i> Lihat</span></button>
                                                    </td>

                                                    <!-- Modal Lihat -->
                                                    <div class="modal fade" id="modal-info-<?= $santri['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-info-label" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content bg-info">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">QR CODE</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body" style="text-align: center;">
                                                                    <?php if (!empty($santri['qr_code'])) : ?>
                                                                        <img src="<?= base_url('qrcodesSantri/' . $santri['qr_code']); ?>" alt="QR Code">
                                                                    <?php else : ?>
                                                                        <p>QR belum di Generate</p>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="modal-footer justify-content-between">
                                                                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                                                    <a href="<?= base_url('santri/printpdf/' . $santri['id']); ?>"><button class="btn btn-outline-light">Cetak</button></a>
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
                                    <?= $pagerSantri->links('tbl_qrcode_santri', 'paginations') ?>
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