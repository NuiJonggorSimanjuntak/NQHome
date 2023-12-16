<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>NQHome</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <style>
        @page {
            size: A4
        }

        h1 {
            font-weight: bold;
            font-size: 20pt;
            text-align: center;
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

        .text-center {
            text-align: center;
        }

        .top-right {
            text-align: right;
        }
    </style>

</head>

<body class="A4">
    <section class="sheet padding-10mm">
        <div class="header">
            <?php date_default_timezone_set('Asia/Jakarta'); ?>
            <div class="top-right">
                <h6><?= date('d-m-Y'); ?></h6>
            </div>
        </div>
        <h1><?= $title; ?></h1>

        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tahun Ajaran</th>
                    <th>Semester</th>
                    <th>Jam</th>
                    <th>Kegiatan</th>
                    <th>Tenaga Pengajar</th>
                    <th>kelas</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($data as $dt) : ?>
                    <tr>
                        <td class="text-center"><?= $i++; ?></td>
                        <td><?= $dt['tahun_ajaran']; ?></td>
                        <td><?= $dt['semester']; ?></td>
                        <td><?= $dt['jam']; ?></td>
                        <td><?= $dt['kegiatan']; ?></td>
                        <td><?= $dt['name']; ?></td>
                        <td><?= $dt['nama_kelas']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</body>

</html>