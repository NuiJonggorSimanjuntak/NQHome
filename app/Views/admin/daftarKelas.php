<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-12">
                <div class="col-sm-6">
                    <h1><?= $title; ?></h1>
                </div>
                <div class="col-sm-12">
                    <?php if (session()->getFlashdata('pesan')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashdata('pesan') ?>
                        </div>
                    <?php elseif (session()->getFlashdata('batal')) : ?>
                        <div class="alert alert-warning" role="alert">
                            <?= session()->getFlashdata('batal') ?>
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
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <a href="/admin/tambahKelas" class="btn btn-outline-primary mb-3" style="color: deepskyblue;"><i class="fas fa-plus"></i> Tambah Kelas</a>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Kelas</th>
                                        <th>Wali Kelas</th>
                                        <th>Kapasitas</th>
                                        <th>Gender</th>
                                        <th style="text-align: center;">Generate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1 + (10 * ($currentPage - 1)); ?>
                                    <?php foreach ($kelas as $kls) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $kls['nama_kelas']; ?></td>
                                            <td><?= $kls['name']; ?></td>
                                            <td><?= $kls['kapasitas'] . ' orang'; ?></td>
                                            <td><?= $kls['gender']?></td>
                                            <td style="text-align: center;">
                                                <a href="<?= base_url('admin/editKelas/' . $kls['id']); ?>"><button class="badge bg-warning"><span><i class="fas fa-edit"></i> Edit</span></button></a>
                                                <form action="/admin/hapusKelas/<?= $kls['id']; ?>" method="post" class="d-inline">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="badge bg-danger"><span><i class="fas fa-trash-alt"></i> Hapus</span></button>
                                                </form>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?= $pager->links('tbl_kelas', 'paginations') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>