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
                                    <div class="card-body" style="margin-top: -8px; margin-bottom: -26px;">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-lg" placeholder="Keyword pencarian.." name="keywordGuru">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-lg btn-default" name="">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama</th>
                                                <th>NIP</th>
                                                <th>Tanggal</th>
                                                <th>Jam Masuk</th>
                                                <th>Jam Keluar</th>
                                                <th style="text-align: center;">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($dataGuru as $guru) : ?>
                                                <tr>
                                                    <td style="text-align: center;"><?= $i++; ?></td>
                                                    <td><?= $guru['name']; ?></td>
                                                    <td><?= $guru['nip']; ?></td>
                                                    <td><?= $guru['tanggal']; ?></td>
                                                    <td><?= date('H:i', strtotime($guru['jam_masuk'])); ?></td>
                                                    <td><?= date('H:i', strtotime($guru['jam_keluar'])); ?></td>
                                                    <td style="text-align: center;">
                                                        <?php if ($guru['keterangan'] == 'hadir') : ?>
                                                            <i class="fa-solid fa-check" style="color: green;"></i>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3><?= $titleSantri; ?></h3>
                                </div>
                                <form action="" method="post">
                                    <div class="card-body" style="margin-top: -8px; margin-bottom: -26px;">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-lg" placeholder="Keyword pencarian.." name="keywordSantri">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-lg btn-default" name="">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama</th>
                                                <th>NIS</th>
                                                <th>Tanggal</th>
                                                <th>Jam Masuk</th>
                                                <th>Jam Keluar</th>
                                                <th style="text-align: center;">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($dataSantri as $santri) : ?>
                                                <tr>
                                                    <td style="text-align: center;"><?= $i++; ?></td>
                                                    <td><?= $santri['name']; ?></td>
                                                    <td><?= $santri['nis']; ?></td>
                                                    <td><?= $santri['tanggal']; ?></td>
                                                    <td><?= date('H:i', strtotime($santri['jam_masuk'])); ?></td>
                                                    <td><?= date('H:i', strtotime($santri['jam_keluar'])); ?></td>
                                                    <td style="text-align: center;">
                                                        <?php if ($santri['keterangan'] == 'hadir') : ?>
                                                            <i class="fa-solid fa-check" style="color: green;"></i>
                                                        <?php else : ?>
                                                            <i class="fa-solid fa-x" style="color: red;"></i>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
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