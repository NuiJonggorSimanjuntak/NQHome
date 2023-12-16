<?= $this->extend('auth/templates/index'); ?>

<?= $this->section('content'); ?>

<header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center">
        <a href="" class="logo d-flex align-items-center">
            <img src="<?= base_url('assets/img/profile/logo.png'); ?>" alt="">
            <span></span>
        </a>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a href="<?= base_url('/'); ?>"><strong><?= $title; ?></strong></a></li>
            </ul>
        </nav>

    </div>
</header>
<section>
    <div class="container">
        <div class="row">
            <?php foreach ($data as $dt) : ?>
                <div class="col-lg-6 d-flex align-items-center justify-content-center">
                    <img src="<?= base_url('event/' . $dt['gambar']); ?>" style="height: auto; width: 55%;">
                </div>
                <div class="col-lg-6 d-flex justify-content-center">
                    <div class="content">
                        <h3><?= $dt['judul']; ?></h3>
                        <p style="text-align: justify; line-height: 2; text-indent: 30px;">
                            <?= $dt['deskripsi']; ?>
                        </p>
                    </div>
                </div>
                <hr>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<footer id="footer" class="footer">

    <div class="container">
        <div class="copyright">
            <strong>Copyright &copy; <?= date('Y'); ?> <a href="http://localhost:8080">NQHome</a></strong>
        </div>
    </div>
</footer>

<?= $this->endSection(); ?>