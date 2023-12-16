<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<style type="text/css">
    body {
        font-family: arial;
        background-color: #ccc
    }

    .doc {
        width: 1000px;
        margin: 0 auto;
        background-color: #fff;
        height: auto;
        padding: 50px;
    }

    .tengah {
        text-align: center;
        line-height: 5px;
    }

    .text-center {
        text-align: center;
    }

    .table-no-border {
        border-collapse: collapse;
        font-size: 20px;
    }

    .table-no-border td,
    .table-no-border th {
        border: none;
        padding: 5px;
    }
</style>

<div class="content-wrapper">

    <section class="content-header tengah">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1><?= $title; ?></h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="doc">
                        <table width="100%" style="border-bottom: 5px solid #000; padding: 2px;">
                            <tr>
                                <td>
                                    <img src="<?= base_url('dist/img/logo.jpg'); ?>" width="170px">
                                </td>
                                <td class="text-center">
                                    <h2>YAYASAN NURUL QOMARIYAH ASSAKRAAN</h2></b>
                                    <h6 style="color: darkgrey;">Jl. Jeruk Block C1 No. 2-3 di Perumahan Ciledug Indah 2<br></b>Pedurenan Karang Tengah Kota Tangerang, Banten</h6></b>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <div style="text-align: center;">
                            <div style="display: inline-block; position: relative;">
                                <h4 style="margin: 0; padding: 0;">LAPORAN HASIL BELAJAR</h4>
                                <div style="position: absolute; bottom: -5px; left: 0; right: 0; height: 1px; background-color: black;"></div>
                            </div>
                        </div>
                        <br>
                        <div class="row" style="background-image: url(<?= base_url('dist/img/bg.png'); ?>); background-size: cover; background-position: center; opacity: 0.6;">
                            <div class="col-md-12">
                                <table class="table table-no-border">
                                    <tbody>
                                        <tr>
                                            <td style="width: 15%;">Nama</td>
                                            <td style="width: 4%; text-align: center;">:</td>
                                            <th style="width: 30%;"><?= $data['nama_santri']; ?></th>
                                            <td style="width: 27%;">Kelas</td>
                                            <td style="width: 4%; text-align: center;">:</td>
                                            <td><?= $data['kelas']; ?></td>
                                        </tr>
                                        <br>
                                        <tr>
                                            <td>NIS</td>
                                            <td style="width: 4%; text-align: center;">:</td>
                                            <td><?= $data['nis']; ?></td>
                                            <td>Tahun Ajaran - Semester</td>
                                            <td style="width: 4%; text-align: center;">:</td>
                                            <td><?= $data['tahun_ajaran'] . ' - ' . $data['semester']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-bordered" style="border: 2px solid #000;">
                                    <thead style="background-color: darkgray; color: #000; border: 2px solid #000;">
                                        <tr>
                                            <th style="text-align: center; vertical-align: middle; border: 2px solid #000; width: 30%;" rowspan="2">Mata Pelajaran</th>
                                            <th style="text-align: center; border: 2px solid #000;" colspan="2">Hasil Tes</th>
                                            <th style="text-align: center; vertical-align: middle; border: 2px solid #000;" rowspan="2">Grade</th>
                                        </tr>
                                        <tr style="border: 2px solid #000;">
                                            <th style="text-align: center; border: 2px solid #000;">Nilai</th>
                                            <th style="text-align: center; border: 2px solid #000;">Tulisan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                                            <tr>
                                                <td style="border: 2px solid #000;">
                                                    <?= $data['namaMp' . $i]; ?>
                                                </td>
                                                <td style="border: 2px solid #000; text-align: center;">
                                                    <?= $nilai['nilai_' . $i] ?>
                                                </td>
                                                <td style="border: 2px solid #000; text-align: center;">
                                                    <?= $tulisan['tulisan_' . $i]; ?>
                                                </td>
                                                <td style="border: 2px solid #000; text-align: center;">
                                                    <?= $grade['grade_' . $i]; ?>
                                                </td>
                                            </tr>
                                        <?php endfor; ?>
                                    </tbody>
                                    <thead style="border: 2px solid #000;">
                                        <?php
                                        $rata_nilai = $data['rata_rata_nilai'];
                                        if ($rata_nilai >= 85) {
                                            $ket = 'Sangat Baik';
                                        } elseif ($rata_nilai >= 75 && $rata_nilai < 85) {
                                            $ket = 'Baik';
                                        } elseif ($rata_nilai >= 65 && $rata_nilai < 75) {
                                            $ket = 'Cukup Baik';
                                        } else {
                                            $ket = 'Kurang Baik';
                                        }

                                        ?>
                                        <tr>
                                            <th style="border: 2px solid #000;" colspan="2">Nilai Keseluruhan</th>
                                            <td style="border: 2px solid #000; text-align: center;"><?= $data['total_nilai']; ?></td>
                                            <td style="border: 2px solid #000; width: 20%; text-align: center;"><?= $ket; ?></td>
                                        </tr>
                                        <tr>
                                            <th style="border: 2px solid #000;" colspan="2">Nilai Rata-Rata</th>
                                            <td style="border: 2px solid #000; text-align: center;"><?= $data['rata_rata_nilai']; ?></td>
                                            <td style="border: 2px solid #000;; width: 20%; text-align: center;"><?= $ket; ?></td>
                                        </tr>
                                        <tr>
                                            <th style="border: 2px solid #000;" colspan="2">Rangking</th>
                                            <td style="border: 2px solid #000; text-align: center;" colspan="2"><?= $peringkat; ?></td>
                                        </tr>
                                    </thead>
                                </table>
                                <br>
                                <div class="row">
                                    <div class="col-md-5">
                                        <table class="table table-bordered">
                                            <thead style="background-color: darkgray; color: #000; border: 2px solid #000;">
                                                <tr>
                                                    <th style="border: 2px solid #000; text-align: center;" colspan="2">ABSENSI</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="border: 2px solid #000; width: 50%;">Izin</td>
                                                    <td style="border: 2px solid #000; text-align: center;">
                                                        <?= $ketTdkHadir['sktKet']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 2px solid #000;">Sakit</td>
                                                    <td style="border: 2px solid #000; text-align: center;">
                                                        <?= $ketTdkHadir['iznKet']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 2px solid #000;">Tanpa keterangan</td>
                                                    <td style="border: 2px solid #000; text-align: center;">
                                                        <?= $ketTdkHadir['tnpKet']; ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-5">
                                        <table class="table table-bordered" style="border: 2px solid #000;">
                                            <thead style="background-color: darkgray; color: #000; border: 2px solid #000;">
                                                <tr>
                                                    <th style="border: 2px solid #000; text-align: center;" colspan="2">KEPRIBADIAN</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="border: 2px solid #000; width: 50%">Kelakuan</td>
                                                    <td style="border: 2px solid #000; text-align: center;">
                                                        <?= $data['kelakuan'] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 2px solid #000;">Kerajinan</td>
                                                    <td style="border: 2px solid #000; text-align: center;">
                                                        <?= $data['kerajianan'] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 2px solid #000;">Kerapian</td>
                                                    <td style="border: 2px solid #000; text-align: center;">
                                                        <?= $data['kerapian'] ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-no-border">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 35%;"></td>
                                                    <td style="text-align: center; height: 160px;">
                                                        <p>Pengasuh Pondok Pesantren</p>
                                                        <p><img src="<?= base_url('dist/img/ttd.png'); ?> " alt="" style="width: 150px; height: auto;"></p>
                                                        <p style="margin-bottom: 0%;"><strong>(Habib Ali Zainal Abidin)</strong></p>
                                                    </td>
                                                    <td style="width: 35%;"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-no-border">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 35%; height: 160px; text-align: center;">
                                                        <p>Mengetahui<br>Orang Tua/Wali</p>
                                                        <p><img src="" alt="" style="width: 150px; height: auto;"></p>
                                                        <p style="margin-bottom: 0%;"><strong>(.....................)</strong></p>
                                                    </td>
                                                    <td></td>
                                                    <td style="width: 35%; height: 160px; text-align: center;">
                                                        <p>Wali Kelas</p>
                                                        <p><img src="" alt="" style="width: 150px; height: auto;"></p>
                                                        <p style="margin-bottom: 0%;"><br><strong>(.....................)</strong></p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <a href="<?= base_url('guru/transkrip_nilai'); ?>" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    <a href="<?= base_url('guru/cetakRaport/' . $data['id']); ?>" target="_blank" class="btn btn-success float-right"><i class="fas fa-file-pdf"></i> Cetak</a>
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