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
                                <img class="profile-user-img img-priview" src="<?= base_url(); ?>/pas_photo/<?= $santris->image; ?>" alt="User profile picture" style="width: 170px; height: 190px;">
                            </div>
                            <h3 class="profile-username text-center"><?= $santris->name; ?></h3>
                            <p class="text-muted text-center"><?= $santris->nis ?></p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Jenis Kelamin</b> <a class="float-right"><?= $santris->jenis_kelamin; ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Tanggal Lahir</b> <a class="float-right"><?= $santris->tanggal_lahir; ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Ruang Kelas</b> <a class="float-right text-<?= ($santris->nama_kelas == 'Kelas A') ? 'success' : (($santris->nama_kelas == 'Kelas B') ? 'warning' : 'danger'); ?>"><?= $santris->nama_kelas; ?></a>
                                </li>
                            </ul>
                            <a href="<?= base_url('admin/daftarSantri') ?>" class="btn btn-primary btn-block"><b>KEMBALI</b></a>
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
                                    <strong><i class="fa-solid fa-envelope"></i> Email</strong>
                                    <p class="text-muted">
                                        <i class="fa-solid fa-circle-dot"></i> <?= $santris->email; ?>
                                    </p>
                                    <hr>
                                    <strong><i class="fa-solid fa-user-tag"></i> Nama Lengkap</strong>
                                    <p class="text-muted">
                                        <i class="fa-solid fa-circle-dot"></i> <?= $santris->name; ?>
                                    </p>
                                    <hr>
                                    <strong><i class="fa-solid fa-graduation-cap"></i> Jenjang Pendidikan</strong>
                                    <p class="text-muted">
                                        <i class="fa-solid fa-circle-dot"></i> <?= $santris->tingkat; ?>
                                    </p>
                                    <hr>
                                    <strong><i class="fa-solid fa-chair"></i> Kelas</strong>
                                    <p class="text-muted">
                                        <i class="fa-solid fa-circle-dot"></i> Kelas <?= $santris->kelas; ?>
                                    </p>
                                    <hr>
                                    <strong><i class="fa-solid fa-calendar"></i> Tanggal Lahir</strong>
                                    <p class="text-muted">
                                        <i class="fa-solid fa-circle-dot"></i> <?= $santris->tanggal_lahir; ?>
                                    </p>
                                    <hr>
                                </div>

                                <div class="col-md-4">
                                    <strong><i class="fa-solid fa-location-dot"></i> Alamat</strong>
                                    <p class="text-muted">
                                        <i class="fa-solid fa-circle-dot"></i> <?= $santris->alamat; ?>
                                    </p>
                                    <hr>
                                    <strong><i class="fa-solid fa-calendar"></i> Awal Masuk</strong>
                                    <p class="text-muted">
                                        <i class="fa-solid fa-circle-dot"></i> <?= $santris->awal_masuk; ?>
                                    </p>
                                    <hr>
                                    <strong><i class="fa-solid fa-square-phone"></i> Nama Kontak Darurat</strong>
                                    <p class="text-muted">
                                        <i class="fa-solid fa-circle-dot"></i> <?= $santris->nama_kontak_darurat; ?>
                                    </p>
                                    <hr>
                                    <strong><i class="fa-solid fa-phone"></i> No. Telp</strong>
                                    <p class="text-muted">
                                        <i class="fa-solid fa-circle-dot"></i> <?= $santris->telepon_kontak_darurat; ?>
                                    </p>
                                    <hr>
                                    <strong><i class="fa-solid fa-venus-mars"></i> Jenis Kelamin</strong>
                                    <p class="text-muted">
                                        <i class="fa-solid fa-circle-dot"></i> <?= $santris->jenis_kelamin; ?>
                                    </p>
                                    <hr>
                                </div>

                                <div class="col-md-4">
                                    <strong><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Akademik</strong>
                                    <p class="text-muted">
                                        <i class="fa-solid fa-circle-dot"></i> <?= $santris->riwayat_akademik; ?>
                                    </p>
                                    <hr>
                                    <strong><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Kesehatan</strong>
                                    <p class="text-muted">
                                        <i class="fa-solid fa-circle-dot"></i> <?= $santris->riwayat_kesehatan; ?>
                                    </p>
                                    <hr>
                                    <strong><i class="fa-solid fa-users"></i> Nama Orang Tua</strong>
                                    <p class="text-muted">
                                        <i class="fa-solid fa-circle-dot"></i> <?= $santris->nama_ortu; ?>
                                    </p>
                                    <hr>
                                    <strong><i class="fa-solid fa-users"></i> Status Santri</strong>
                                    <p class="text-muted">
                                        <i class="fa-solid fa-circle-dot"></i> <?= $santris->status; ?>
                                    </p>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
</div>
</section>
<!-- </div> -->
<?= $this->endSection(); ?>