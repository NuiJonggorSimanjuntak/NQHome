<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NQHome</title>

    <style type="text/css">
        body {
            font-family: arial;
        }

        .doc {
            background-color: white;
            height: auto;
            border-bottom: 5px solid #000;
            padding: 2px;
        }

        .tengah {
            text-align: center;
            line-height: 1;
        }

        .tengah h6 {
            color: grey;
        }

        .judul {
            padding-top: 20px;
            text-align: center;
        }

        .laporan table {
            padding-top: 20px;
            width: 100%;
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

        table {
            border-collapse: collapse;
            width: 100%;
        }

        .table th {
            padding: 8px 8px;
            border: 1px solid #000000;
            background-color: cadetblue;
            color: white;
        }

        .table td {
            padding: 3px 3px;
            border: 1px solid #000000;
        }

        .laporan {
            background-image: url(data:image/png;base64,<?= base64_encode(file_get_contents('dist/img/bg.png')); ?>);
            background-size: cover;
            background-position: center;
            opacity: 0.4;
        }
    </style>

</head>

<body>
    <div class="doc">
        <table width="100%">
            <tr>
                <td><img src="data:image/png;base64,<?= base64_encode(file_get_contents('dist/img/logo.jpg')); ?>" width="120px"></td>
                <td class="tengah">
                    <h2>YAYASAN NURUL QOMARIYAH ASSAKRAAN TAHUN AJARAN <?= $data['tahun_ajaran']; ?></h2>
                    <h6>Jl. Jeruk Block C1 No. 2-3 di Perumahan Ciledug Indah 2 <br> Pedurenan Karang Tengah Kota Tangerang, Banten</h6>
                </td>
            </tr>
        </table>
    </div>
    <div style="text-align: center; padding-top: 10px;">
        <div style="display: inline-block; position: relative;">
            <h4 style="margin: 0; padding: 0;">LAPORAN HASIL BELAJAR</h4>
        </div>
    </div>
    <div class="laporan">
        <table>
            <tr>
                <td style="width: 15%;">Nama</td>
                <td style="width: 4%; text-align: center;">:</td>
                <td style="width: 40%;"><?= $data['nama_santri']; ?></td>
                <td style="width: 27%;">Kelas</td>
                <td style="width: 4%; text-align: center;">:</td>
                <td><?= $data['kelas']; ?></td>
            </tr>
            <tr>
                <td>NIS</td>
                <td style="width: 4%; text-align: center;">:</td>
                <td><?= $data['nis']; ?></td>
                <td>Semester</td>
                <td style="width: 4%; text-align: center;">:</td>
                <td><?= $data['semester']; ?></td>
            </tr>
        </table>

        <table class="table">
            <thead>
                <tr>
                    <th rowspan="2" style="width: 37%;">Mata Pelajaran</th>
                    <th colspan="2">Hasil Tes</th>
                    <th rowspan="2">Grade</th>
                </tr>
                <tr>
                    <th style="text-align: center; ">Nilai</th>
                    <th style="text-align: center; width: 30%;">Tulisan</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 1; $i <= 5; $i++) : ?>
                    <tr>
                        <td style="">
                            <?= $data['namaMp' . $i]; ?>
                        </td>
                        <td style=" text-align: center;">
                            <?= $nilai['nilai_' . $i] ?>
                        </td>
                        <td style=" text-align: center;">
                            <?= $tulisan['tulisan_' . $i]; ?>
                        </td>
                        <td style=" text-align: center;">
                            <?= $grade['grade_' . $i]; ?>
                        </td>
                    </tr>
                <?php endfor; ?>
            </tbody>
            <thead>
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
                    <td><strong>Nilai Keseluruhan</strong></td>
                    <td style=" text-align: center;"><?= $data['total_nilai']; ?></td>
                    <td style=" width: 20%; text-align: center;" colspan="2"><?= $ket; ?></td>
                </tr>
                <tr>
                    <td><strong>Nilai Rata-Rata</strong></td>
                    <td style=" text-align: center;"><?= $data['rata_rata_nilai']; ?></td>
                    <td style="; width: 20%; text-align: center;" colspan="2"><?= $ket; ?></td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Rangking</strong></td>
                    <td colspan="2" style="text-align: center;"><?= $peringkat; ?></td>
                </tr>
            </thead>
        </table>

        <div style="justify-content: space-between; display: flex;">
            <table class="table" style="width: 40%; float: left;">
                <thead">
                    <tr>
                        <th style="text-align: center;" colspan="2">ABSENSI</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width: 50%;">Izin</td>
                            <td style="text-align: center;"><?= $ketTdkHadir['iznKet']; ?></td>
                        </tr>
                        <tr>
                            <td style="">Sakit</td>
                            <td style="text-align: center;"><?= $ketTdkHadir['sktKet']; ?></td>
                        </tr>
                        <tr>
                            <td style="">Tanpa keterangan</td>
                            <td style="text-align: center;"><?= $ketTdkHadir['tnpKet']; ?></td>
                        </tr>
                    </tbody>
            </table>
            <table class="table" style="width: 40%; float: right;">
                <thead>
                    <tr>
                        <th style="text-align: center;" colspan="2">KEPRIBADIAN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width: 50%">Kelakuan</td>
                        <td style="text-align: center;"><?= $data['kelakuan'] ?></td>
                    </tr>
                    <tr>
                        <td>Kerajinan</td>
                        <td style="text-align: center;"><?= $data['kerajianan'] ?></td>
                    </tr>
                    <tr>
                        <td>Kerapian</td>
                        <td style="text-align: center;"><?= $data['kerapian'] ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <table>
            <tbody>
                <tr>
                    <td style="width: 35%;"></td>
                    <td style="text-align: center; height: 160px;">
                        <p>Pengasuh Pondok Pesantren</p>
                        <p style="height: 25px;"></p>
                        <p style="margin-bottom: 0%;"><strong>(Habib Ali Zainal Abidin)</strong></p>
                    </td>
                    <td style="width: 35%;"></td>
                </tr>
            </tbody>
        </table>

        <table>
            <tbody>
                <tr>
                    <td style="width: 35%; height: 160px; text-align: center;">
                        <p>Mengetahui<br>Orang Tua/Wali</p>
                        <p style="height: 20px;"></p>
                        <p style="margin-bottom: 0%;"><strong>(.....................)</strong></p>
                    </td>
                    <td></td>
                    <td style="width: 35%; height: 160px; text-align: center;">
                        <p>Wali Kelas</p>
                        <p style="height: 20px;"></p>
                        <p style="margin-bottom: 0%;"><br><strong>(.....................)</strong></p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>