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
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-priview" src="<?= base_url(); ?>/pas_photo/<?= $users->image; ?>" alt="User profile picture" style="width: 170px; height: 190px;">
                            </div>
                            <h3 class="profile-username text-center"><?= $users->name; ?></h3>
                            <p class="text-muted text-center"><?= $users->nip ?></p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Jenis Kelamin</b> <a class="float-right"><?= $users->jenis_kelamin; ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Tanggal Lahir</b> <a class="float-right"><?= $users->tanggal_lahir; ?></a>
                                </li>
                            </ul>
                            <?php if (in_groups('admin')) : ?>
                                <a href="<?= base_url('admin/daftarGuru') ?>" class="btn btn-primary btn-block"><b>KEMBALI</b></a>
                            <?php else : ?>
                                <a href="<?= base_url('santri/jadwalPelajaran') ?>" class="btn btn-primary btn-block"><b>KEMBALI</b></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Tentang Saya</h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <strong><i class="fa-solid fa-graduation-cap"></i> NIK</strong>
                                    <p class="text-muted">
                                        <i class="fa-solid fa-circle-dot"></i> <?= $users->nik; ?>
                                    </p>
                                    <hr>
                                    <strong><i class="fa-solid fa-graduation-cap"></i> Pendidikan Terakhir</strong>
                                    <p class="text-muted">
                                        <i class="fa-solid fa-circle-dot"></i> <?= $users->pendidikan_terakhir; ?>
                                    </p>
                                    <hr>
                                    <strong><i class="fa-solid fa-phone mr-1"></i> No. Telepon</strong>
                                    <p class="text-muted">
                                        <i class="fa-solid fa-circle-dot"></i> <?= $users->no_telepon; ?>
                                    </p>
                                    <hr>
                                    <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                                    <p class="text-muted">
                                        <i class="fa-solid fa-circle-dot"></i> <?= $users->email; ?>
                                    </p>
                                    <hr>

                                </div>
                                <div class="col-md-4">
                                    <strong><i class="fas fa-file-alt mr-1"></i> Pengalaman Mengajar</strong>
                                    <p class="text-muted">
                                        <i class="fa-solid fa-circle-dot"></i> <?= $users->pengalaman_mengajar; ?>
                                    </p>
                                    <hr>
                                    <strong><i class="fas fa-file-alt mr-1"></i> Nama Lengkap</strong>
                                    <p class="text-muted">
                                        <i class="fa-solid fa-circle-dot"></i> <?= $users->name; ?>
                                    </p>
                                    <hr>
                                    <strong><i class="fas fa-user mr-1"></i> Tentang Pengajar</strong>
                                    <p class="text-muted">
                                        <i class="fa-solid fa-circle-dot"></i> <?= $users->tentang_pengajar; ?>
                                    </p>
                                    <hr>
                                    <strong><i class="fa-solid fa-ring"></i> Status Perkawinan</strong>
                                    <p class="text-muted">
                                        <i class="fa-solid fa-circle-dot"></i> <?= $users->status_perkawinan; ?>
                                    </p>
                                    <hr>
                                </div>

                                <div class="col-md-4">
                                    <strong><i class="fas fa-venus-mars mr-1"></i> Jenis Kelamin</strong>
                                    <p class="text-muted">
                                        <i class="fa-solid fa-circle-dot"></i> <?= $users->jenis_kelamin; ?>
                                    </p>
                                    <hr>
                                    <strong><i class="fas fa-user mr-1"></i> Tanggal Lahir</strong>
                                    <p class="text-muted">
                                        <i class="fa-solid fa-circle-dot"></i> <?= $users->tanggal_lahir; ?>
                                    </p>
                                    <hr>
                                    <strong><i class="fas fa-pencil-alt mr-1"></i> Alamat</strong>
                                    <p class="text-muted">
                                        <i class="fa-solid fa-circle-dot"></i> <?= $users->alamat; ?>
                                    </p>
                                    <hr>
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