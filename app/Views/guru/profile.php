<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="justify-content: center; text-align: center;">
                <div class="col-sm-4" style="background-color: antiquewhite;">
                    <h1><strong><?= $title; ?></strong></h1>
                </div>
            </div>
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success"><?= session()->getFlashdata('pesan') ?></div>
            <?php endif; ?>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row" style="justify-content: center;">
                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                    <div class="card bg-light d-flex flex-fill">
                        <div class="card-header text-muted border-bottom-0">
                            <?php if (!empty($users['nik'])) : ?>
                                <?= $users['nik']; ?>
                            <?php endif; ?> 
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-6">
                                    <h2 class="lead"><b><?= $users['name']; ?></b></h2>
                                    <p class="text-muted text-sm"><b>Mapel: </b> <?= $users['nama_mp']; ?> </p>
                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <li class="small"><span class="fa-li"><i class="fa-solid fa-cake-candles"></i></span> Tgl. Lahir: <?= $users['tanggal_lahir']; ?></li>
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Alamat: <?= $users['alamat']; ?></li>
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> No. Telp: <?= $users['no_telepon']; ?></li>
                                        <li class="small"><span class="fa-li"><i class="fa-solid fa-graduation-cap"></i></span> Pendidikan Terakhir: <?= $users['pendidikan_terakhir']; ?></li>
                                    </ul>
                                </div>
                                <div class="col-6">
                                    <img class="profile-user-img" src="<?= base_url(); ?>/pas_photo/<?= $users['image']; ?>" alt="User profile picture" style="width: 170px; height: 200px;">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                <a href="<?= base_url('guru/detailProfile'); ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-user"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>