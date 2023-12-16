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
                    <?php endif; ?>
                </div>
                <div class="col-sm-12">
                    <?php if (session()->getFlashdata('warning')) : ?>
                        <div class="alert alert-warning" role="alert">
                            <?= session()->getFlashdata('warning') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
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
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Rata - Rata Nilai</th>
                                        <th>Mutu</th>
                                        <th style="text-align: center;">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($data as $dt) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $dt['tahun_ajaran'] . ' - ' . $dt['semester']; ?></td>
                                            <td><?= $dt['rata_rata_nilai']; ?></td>
                                            <td style="text-align: center;">
                                                <?php
                                                $grade = $dt['grade'];

                                                if ($grade === 'A' || $grade === 'B' || $grade === 'C') {
                                                    echo '<span class="badge badge-success">' . $grade . '</span>';
                                                } elseif ($grade === 'D') {
                                                    echo '<span class="badge badge-warning">' . $grade . '</span>';
                                                } elseif ($grade === 'E') {
                                                    echo '<span class="badge badge-danger">' . $grade . '</span>';
                                                } else {
                                                    echo $grade;
                                                }
                                                ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <button class="badge bg-info" data-toggle="modal" data-target="#modal-info-<?= $dt['id']; ?>"><span><i class="fas fa-eye"></i></span></button>
                                                <!-- <a target="_blank" href="<?= base_url('santri/cetakNilai/' . $dt['id']); ?>"><button class="badge bg-success"><span><i class="fa-solid fa-file-pdf"></i></span></button></a> -->
                                            </td>
                                        </tr>

                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            <?= $pager->links('tbl_transkrip_nilai', 'paginations') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php foreach ($data as $dt) : ?>
        <div class="modal fade" id="modal-info-<?= $dt['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-info-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-secondary" style="width: max-content;">
                    <div class="modal-header">
                        <h4 class="modal-title">Daftar Nilai MP</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kode MP</th>
                                    <th>Nama MP</th>
                                    <th>Nilai Tugas</th>
                                    <th>Nilai UAS</th>
                                    <th>Nilai UAS</th>
                                    <th>Nilai Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $tugasString = $dt['nilai'];
                                $utsString = $dt['uts'];
                                $uasString = $dt['uas'];
                                $akhirString = $dt['nilai_rapot'];
                                $nilaiArray = explode(",", $tugasString);
                                $utsArray = explode(",", $utsString);
                                $uasArray = explode(",", $uasString);
                                $akhirArray = explode(",", $akhirString);

                                $formattedNilai = [];
                                $formattedUts = [];
                                $formattedUas = [];
                                $formattedAkhir = [];
                                foreach ($nilaiArray as $nilai) {
                                    $formattedNilai[] = $nilai;
                                }
                                foreach ($utsArray as $uts) {
                                    $formattedUts[] = $uts;
                                }
                                foreach ($uasArray as $uas) {
                                    $formattedUas[] = $uas;
                                }
                                foreach ($akhirArray as $akhir) {
                                    $formattedAkhir[] = $akhir;
                                }
                                ?>
                                <tr>
                                    <td>
                                        <?php for ($j = 1; $j <= 5; $j++) : ?>
                                            <?= $dt['kodeMp' . $j]; ?><br>
                                        <?php endfor; ?>
                                    </td>
                                    <td>
                                        <?php for ($j = 1; $j <= 5; $j++) : ?>
                                            <?= $dt['namaMp' . $j]; ?><br>
                                        <?php endfor; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php foreach ($formattedNilai as $key => $nilai) : ?>
                                            <?= $nilai ?><br>
                                        <?php endforeach; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php foreach ($formattedUts as $key => $nilai) : ?>
                                            <?= $nilai ?><br>
                                        <?php endforeach; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php foreach ($formattedUas as $key => $nilai) : ?>
                                            <?= $nilai ?><br>
                                        <?php endforeach; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php foreach ($formattedAkhir as $key => $nilai) : ?>
                                            <?= $nilai ?><br>
                                        <?php endforeach; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <style>
        .form-control::placeholder {
            color: white;
        }
    </style>

</div>
<?= $this->endSection(); ?>