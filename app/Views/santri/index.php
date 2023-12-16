<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $title; ?></h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="far fa-chart-bar"></i>
                                            Nilai Santri/semester
                                        </h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <style>
                                        .data1 {
                                            width: 30px;
                                            height: 20px;
                                            background: #3c8db3;
                                            opacity: 0.7;
                                            border-radius: 20px;
                                            margin-right: 2px;
                                        }

                                        .data2 {
                                            width: 30px;
                                            height: 20px;
                                            background: #00c0ef;
                                            opacity: 0.7;
                                            border-radius: 20px;
                                            margin-left: 10px;
                                            margin-right: 2px;
                                        }

                                        .data3 {
                                            width: 30px;
                                            height: 20px;
                                            background: #9bd7fa;
                                            opacity: 0.7;
                                            border-radius: 20px;
                                            margin-left: 10px;
                                            margin-right: 2px;
                                        }

                                        .data4 {
                                            width: 30px;
                                            height: 20px;
                                            background: #6a9ca8;
                                            opacity: 0.7;
                                            border-radius: 20px;
                                            margin-left: 10px;
                                            margin-right: 2px;
                                        }

                                        .data1::before {
                                            content: "";
                                            position: absolute;
                                            top: 5px;
                                            left: 5px;
                                            width: 100%;
                                            height: 100%;
                                            filter: blur(10px);
                                            opacity: 0.7;
                                        }

                                        .data-container {
                                            display: flex;
                                            justify-content: center;
                                        }
                                    </style>
                                    <div class="card-body">
                                        <div class="data-container">
                                            <div class="data1"></div>
                                            <small>Nilai Tugas</small>
                                            <div class="data2"></div>
                                            <small>Nilai UTS</small>
                                            <div class="data3"></div>
                                            <small>Nilai UAS</small>
                                            <div class="data4"></div>
                                            <small>Nilai Akhir</small>
                                        </div>
                                        <div id="line-chart" style="height: 300px;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-12" id="accordion">
                                        <div class="card card-primary card-outline">
                                            <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
                                                <div class="card-header">
                                                    <h4 class="card-title w-100" style="text-align: center;">
                                                        <strong>VISI</strong>
                                                    </h4>
                                                </div>
                                            </a>
                                            <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                                <div class="card-body" style="text-align: center;">
                                                    "Yayasan Nurul Qomariyah Assakraan Belajar, beramal dan berakhlakul karimah."
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card card-primary card-outline">
                                            <a href="#collapseTwo" class="d-block w-100" data-toggle="collapse">
                                                <div class="card-header">
                                                    <h4 class="card-title w-100" style="text-align: center;">
                                                        <strong>MISI</strong>
                                                    </h4>
                                                </div>
                                            </a>
                                            <div class="collapse show" data-parent="#accordion" id="collapseTwo">
                                                <div class="card-body">
                                                    <p>1. Menumbuhkan nilai keimanan dan ketakwaan kepada Allah SWT.</p>
                                                    <p>2. Mewujudkan suasana Islam yang berlandaskan paham pancasila.</p>
                                                    <p>3. Menanamkan nilai spiritual, intelektual, emosional untuk menjadi manusia yang terampil, kreatif dan inovatif.</p>
                                                    <p>4. Mewujudkan penguasaan sains, teknologi informatika dan komunikasi serta memperluas dan pengembangan pola pikir anak didik.</p>
                                                    <p>5. Menanamkan nilai-nilai pendidikan yang berorientasi pada lingkungan dan sosial.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card card-primary card-outline">
                                            <a href="#collapseThree" class="d-block w-100" data-toggle="collapse">
                                                <div class="card-header">
                                                    <h4 class="card-title w-100" style="text-align: center;">
                                                        <strong>Tujuan</strong>
                                                    </h4>
                                                </div>
                                            </a>
                                            <div class="collapse show" data-parent="#accordion" id="collapseThree">
                                                <div class="card-body">
                                                    <p style="text-align: justify; line-height: 2; text-indent: 30px;">
                                                        Sedari awal mula berdirinya majelis, permasalahan dan rintangan yang dihadapi dan dilalui tidak menyurutkan habib untuk tetap mempertahankan dan menjalankan kegiatan majelis. Didirikannya majelis ini oleh habib tentu memiliki tujuan yang ingin dicapai. Tujuan dari majelis Nurul Qomariyah ini adalah untuk membentuk karakter masyarakat yang lebih dekat dengan Allah. Dimana habib Ali Zainal Abidin Alaydrus mengajak masyarakat untuk bersama-sama lebih memperbaiki diri dan menjadi lebih dekat dengan Allah.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-primary card-outline">
                                            <div class="card-body">
                                                <table class="table table-hover border">
                                                    <thead style="background-color: #99c4cf; opacity: 0.8;">
                                                        <tr>
                                                            <th>Informasi</th>
                                                            <th style="text-align: end;">Download</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($informasi as $info) : ?>
                                                            <tr>
                                                                <td><?= $info->keterangan; ?></td>
                                                                <td style="text-align: end;">
                                                                    <a href="<?= base_url('santri/downloadInformasi/' . $info->id_berkas); ?>"><i class="fa-solid fa-cloud-arrow-down fa-2xl"></i></a>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card card-primary card-outline">
                                            <div class="card-header">
                                                <h5 style="text-align: center;"><strong>Perhitungan Nilai Akhir</strong></h5>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-hover border">
                                                    <tr>
                                                        <th>Tugas</th>
                                                        <td>:</td>
                                                        <td>70%</td>
                                                    </tr>
                                                    <tr>
                                                        <th>UTS</th>
                                                        <td>:</td>
                                                        <td>10%</td>
                                                    </tr>
                                                    <tr>
                                                        <th>UAS</th>
                                                        <td>:</td>
                                                        <td>20%</td>
                                                    </tr>
                                                </table>
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

<script>
    $(function() {
        var data1 = <?= json_encode($tugas) ?>;
        var data2 = <?= json_encode($uts) ?>;
        var data3 = <?= json_encode($uas) ?>;
        var data4 = <?= json_encode($raport) ?>;

        function transformData(inputData) {
            var transformedData = [];
            for (var i = 0; i < inputData.length; i++) {
                var x = i + 1;
                var y = inputData[i];
                transformedData.push([x, y]);
            }
            return transformedData;
        }

        var transformedData1 = transformData(data1);
        var transformedData2 = transformData(data2);
        var transformedData3 = transformData(data3);
        var transformedData4 = transformData(data4);

        var line_data1 = {
            label: 'Nilai Tugas',
            data: data1,
            color: '#3c8dbc',
            lines: {
                fill: true
            }
        };

        var line_data2 = {
            label: 'Nilai UTS',
            data: data2,
            color: '#00c0ef',
            lines: {
                fill: true
            }
        };

        var line_data3 = {
            label: 'Nilai UAS',
            data: data3,
            color: '#9bd7fa',
            lines: {
                fill: true
            }
        };

        var line_data4 = {
            label: 'Nilai Akhir',
            data: data4,
            color: '#6a9ca8',
            lines: {
                fill: true
            }
        };

        <?php
        $ticksData = [];
        if ($data != null) {
            for ($i = 1; $i <= 5; $i++) {
                $namaMataPelajaran = $data->{'namaMp' . $i};
                $ticksData[] = [$i, $namaMataPelajaran];
            }
        }
        ?>

        var lineChartOptions = {
            grid: {
                hoverable: true,
                borderWidth: 1,
                borderColor: '#f3f3f3',
                tickColor: '#f3f3f3'
            },
            series: {
                shadowSize: 0,
                lines: {
                    show: true
                },
                points: {
                    show: true
                }
            },
            colors: ['#3c8dbc', '#00c0ef'],
            yaxis: {
                show: true
            },
            xaxis: {
                show: true,
                ticks: <?= json_encode($ticksData) ?>
            }
        };

        $.plot('#line-chart', [line_data1, line_data2, line_data3, line_data4], lineChartOptions);

        var tooltip = $('<div class="tooltip-inner" id="line-chart-tooltip"></div>').css({
            position: 'absolute',
            display: 'none',
            opacity: 0.8
        }).appendTo('body');

        $('#line-chart').bind('plothover', function(event, pos, item) {
            if (item) {
                var x = item.datapoint[0].toFixed(2);
                var y = item.datapoint[1].toFixed(2);
                var label = item.series.label || item.series.label;

                tooltip.html(label + ': ' + y)
                    .css({
                        top: item.pageY + 5,
                        left: item.pageX + 5
                    })
                    .fadeIn(200);
            } else {
                tooltip.hide();
            }
        });
    });
</script>

<?= $this->endSection(); ?>