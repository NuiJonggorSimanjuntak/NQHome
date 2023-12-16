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
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md">
                    <div class="card">
                        <div class="card-header">
                        </div>
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
                                        <th style="text-align: center;">No.</th>
                                        <th>Foto</th>
                                        <th>NIS</th>
                                        <th>Nama Lengkap</th>
                                        <th>Jenis Kelamin</th>
                                        <th style="text-align: center;">Jenjang Pendidikan</th>
                                        <th style="text-align: center;">Ruang Kelas</th>
                                        <th style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1 + (10 * ($currentPage - 1)); ?>
                                    <?php foreach ($users as $user) : ?>
                                        <tr>
                                            <td style="text-align: center;"><?= $i++; ?></td>
                                            <td style="text-align: center;"><img src="<?= base_url('pas_photo/' . $user['image']); ?>" alt="" style="width: 50px; height: 50px;"></td>
                                            <td><?= $user['nis']; ?></td>
                                            <td><?= $user['name']; ?></td>
                                            <td><?= $user['jenis_kelamin']; ?></td>
                                            <td style="text-align: center;"><?= $user['tingkat']; ?></td>
                                            <td style="text-align: center;"><?= $user['nama_kelas']; ?></td>
                                            <td style="text-align: center;">
                                                <a href="<?= base_url('admin/detailSantri/' . $user['id']); ?>"><button class="badge bg-info"><span><i class="fas fa-eye"></i> Detail</span></button></a>
                                                <a href="<?= base_url('admin/editSantri/' . $user['id']); ?>"><button class="badge bg-warning"><span><i class="fas fa-edit"></i>Edit</span></button></a>
                                                <form action="/admin/hapusSantri/<?= $user['id']; ?>" method="post" class="d-inline">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <!-- <button type="submit" class="badge bg-danger" onclick="return confirm('apakah anda yakin')"><span><i class="fas fa-trash-alt"></i>Hapus</span></button> -->
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            <?= $pager->links('tbl_santri', 'paginations') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
<?= $this->endSection(); ?>