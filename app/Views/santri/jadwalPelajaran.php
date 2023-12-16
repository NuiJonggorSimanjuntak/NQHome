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
                            <i class="fa-solid fa-circle-check"></i>
                            <?= session()->getFlashdata('pesan') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-sm-12">
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-warning" role="alert">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid" style="align-items: center;">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <form>
                                        <?= csrf_field(); ?>
                                        <div class="row">
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <select type="text" class="form-control form-control-lg" name="filter">
                                                        <option id="filterSelect" value="" selected disabled>Pilih</option>
                                                        <?php foreach ($tahunAjaran as $ta) : ?>
                                                            <?php
                                                            $value = $ta['tahun_ajaran'] . '-' . $ta['semester'];
                                                            ?>
                                                            <option value="<?= htmlspecialchars($value); ?>"><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <button formaction="<?= base_url('santri/jadwalPelajaran'); ?>" formmethod="post" type="submit" class="btn btn-outline-success" style="height: 3pc;"><i class="fa-solid fa-filter fa-2x"></i></button>
                                                <button formaction="<?= base_url('santri/cetakJp'); ?>" formmethod="get" formtarget="_blank" class="btn btn-outline-danger" style="height: 3pc;"><i class="fas fa-print fa-2x"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;">No.</th>
                                                <th>Jam</th>
                                                <th>Tahun Ajaran</th>
                                                <th>Semester</th>
                                                <th>Kegiatan</th>
                                                <th>Tenaga Pengajar</th>
                                                <th>Ruang Kelas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($data as $dt) : ?>
                                                <tr>
                                                <td style="text-align: center;"><?= $i++; ?></td>
                                                    <td><?= $dt['jam']; ?></td>
                                                    <td><?= $dt['tahun_ajaran'] ?></td>
                                                    <td><?= $dt['semester'] ?></td>
                                                    <td><?= $dt['kegiatan']; ?></td>
                                                    <td><?= $dt['name']; ?></td>
                                                    <td><?= $dt['nama_kelas']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer clearfix">
                                    <?= $pager->links('tbl_jadwal_pelajaran', 'paginations') ?>
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