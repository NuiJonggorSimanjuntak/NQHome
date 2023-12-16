<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1><?= $title; ?></h1>
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-warning"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="content" id="centered-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post" class="d-inline">
                                <div class="form-group">
                                    <label for="keyword">Pilih Tanggal:</label>
                                    <input type="date" id="keyword" name="keyword" class="form-control">
                                </div>
                                <!-- <div class="form-group">
                                    <label for="id_kelas">Nama Kelas</label>
                                    <select id="id_kelas" name="id_kelas" class="form-control custom-select">
                                        <option selected disabled>--Pilih--</option>
                                        <?php foreach ($kelas as $kls) : ?>
                                            <option value="<?= $kls->id; ?>" <?= (old('id_kelas') == '1') ? 'selected' : ''; ?>><?= $kls->nama_kelas; ?>-<?= $kls->jenis_kelamin; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div> -->
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </form>
                            <a href="<?= base_url('guru'); ?>"><button class="btn btn-danger">Reset</button></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>NIS</th>
                                        <th>Nama Santri</th>
                                        <th>Kelas</th>
                                        <th>Gender</th>
                                        <th>Absen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($santri as $s) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $s['nis']; ?></td>
                                            <td><?= $s['name']; ?></td>
                                            <td><?= $s['nama_kelas']; ?></td>
                                            <td><?= $s['jenis_kelamin']; ?></td>
                                            <td>
                                                <a href="<?= base_url('guru/ketAbsen/' . $s['id']); ?>"><button class="badge bg-warning"><span><i class="fas fa-edit"></i>Absen</span></button></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (isset($filteredDate)) : ?>
                <div class="alert alert-info">Menampilkan data untuk tanggal: <?= $filteredDate; ?></div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <th colspan="2" style="text-align: center; width: 10%;">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($data as $dt) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $dt['nis']; ?></td>
                                            <td><?= $dt['name']; ?></td>
                                            <td><?= $dt['tanggal']; ?></td>
                                            <?php if (!empty($dt['tanggal']) && !empty($dt['keterangan'] == 'hadir')) : ?>
                                                <td><?= $dt['jam_masuk']; ?></td>
                                                <td><?= $dt['jam_keluar']; ?></td>
                                                <td style="text-align: center;" colspan="2">
                                                    <span class="badge badge-success"><i class="fas fa-check"></i></span>
                                                    <form action="<?= base_url('guru/hapusAbsen/' . $dt['id_absen']); ?>" method="post" class="d-inline">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="badge bg-danger" onclick="return confirm('apakah anda yakin')"><span><i class="fas fa-trash-alt"></i></span></button>
                                                    </form>
                                                </td>
                                            <?php else : ?>
                                                <td>-</td>
                                                <td>-</td>
                                                <td style="text-align: center;" colspan="<?= ($dt['keterangan'] == 'tanpa keterangan') ? '' : '2'; ?>">
                                                    <span class="badge badge-<?= ($dt['keterangan'] == 'tanpa keterangan') ? 'danger' : (($dt['keterangan'] == 'sakit') ? 'primary' : 'warning'); ?> d-inline"><i class="fas fa-<?= ($dt['keterangan'] == 'tanpa keterangan') ? 'times' : (($dt['keterangan'] == 'sakit') ? 'heartbeat' : 'envelope'); ?>"></i></span>
                                                    <form action="<?= base_url('guru/hapusAbsen/' . $dt['id_absen']); ?>" method="post" class="d-inline">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="badge bg-danger" onclick="return confirm('apakah anda yakin')"><span><i class="fas fa-trash-alt"></i></span></button>
                                                    </form>
                                                </td>
                                                <?php if ($dt['keterangan'] == 'tanpa keterangan') : ?>
                                                    <td style="text-align: center;">
                                                        <a href="<?= base_url('guru/wa/' . $dt['id']); ?>">
                                                            <span class="badge badge-success d-inline"><i class="fab fa-whatsapp"></i></span>
                                                        </a>
                                                    </td>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>