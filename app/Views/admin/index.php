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
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $jumlah_kelas; ?></h3>
                            <p>Jumlah Kelas</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-person-shelter"></i>
                        </div>
                        <a href="<?= base_url('admin/daftarKelas'); ?>" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= $jumlah_pengajar; ?></h3>
                            <p>Jumlah Guru</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-person-chalkboard"></i>
                        </div>
                        <a href="<?= base_url('admin/daftarGuru'); ?>" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $jumlah_santri; ?></h3>
                            <p>Jumlah Santri</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <a href="<?= base_url('admin/daftarSantri'); ?>" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3><?= $jumlah_mp; ?></h3>
                            <p>Mata Pelajaran</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <a href="<?= base_url('admin/daftarMp'); ?>" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Statistik Berdasarkan Gender</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="stackedBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>z
<script>
    $(function() {
        var areaChartData = {
            labels: ['', 'Guru', 'Santri', ''],
            datasets: [{
                    label: 'Laki-Laki',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: [0, <?= $GL; ?>, <?= $SL; ?>, 0],
                },
                {
                    label: 'Perempuan',
                    backgroundColor: 'rgba(210, 214, 222, 1)',
                    borderColor: 'rgba(210, 214, 222, 1)',
                    pointRadius: false,
                    pointColor: 'rgba(210, 214, 222, 1)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data: [0, <?= $GP; ?>, <?= $SP; ?>, 0]
                },
            ]
        }

        var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
        var stackedBarChartData = $.extend(true, {}, areaChartData)

        var stackedBarChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    stacked: true,
                    barPercentage: 0.5,
                    ticks: {
                        beginAtZero: true
                    }
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }

        new Chart(stackedBarChartCanvas, {
            type: 'bar',
            data: stackedBarChartData,
            options: stackedBarChartOptions
        })
    })
</script>

<?= $this->endSection(); ?>