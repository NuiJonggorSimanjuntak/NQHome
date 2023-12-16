<?= $this->extend('auth/templates/index'); ?>

<?= $this->section('content'); ?>

<?= $this->include('auth/templates/header'); ?>

<section id="hero" class="hero d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 d-flex flex-column justify-content-center">

                <h1 data-aos="fade-up">YAYASAN NURUL QOMARIYAH ASSAKRAAN</h1>
                <h5 data-aos="fade-up" data-aos-delay="400">Jl. Jeruk Blok C1 No.2-3</h5>
                <h5 data-aos="fade-up" data-aos-delay="400">Perumahan Ciledug Indah 2 Pedurenan, Karang Tengah Kota Tangerang, Banten</h5>
                <div data-aos="fade-up" data-aos-delay="600">
                    <div class="text-center text-lg-start">
                        <?php if (logged_in()) : ?>
                            <?php if (in_groups('admin')) : ?>
                                <a href="<?= base_url('admin'); ?>" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                                    <span>Dashboard</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            <?php elseif (in_groups('guru')) : ?>
                                <a href="<?= base_url('guru'); ?>" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                                    <span>Dashboard</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            <?php elseif (in_groups('santri')) : ?>
                                <a href="<?= base_url('santri'); ?>" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                                    <span>Dashboard</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            <?php endif; ?>
                        <?php else : ?>
                            <a href="<?= base_url('login'); ?>" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                                <span>login</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">
                <img src="<?= base_url('assets/img/profile/tampilandepan.jpeg');  ?>" class="img-fluid" alt="">
            </div>
        </div>
    </div>

</section>

<main id="main">
    <section id="about" class="about">
        <div class="container" data-aos="fade-up">
            <div class="row gx-0">
                <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="content">
                        <h2>Who We Are</h2>
                        <p style="text-align: justify; line-height: 2; text-indent: 30px;">
                            Yayasan Nurul Qomariyah Assakraan adalah instansi pendidikan agama yg beralamatkan di Jl. Jeruk Blok C1 No. 2-3 Perumahan Ciledug Indah 2, Pedurenan, Karang Tengah Kota Tangerang Banten. Berdiri sejak 2006 sampai sekarang, Yayasan ini bergerak dibidang pendidikan agama khususnya untuk warga sekitar yayasan tersebut. Yayasan ini juga didirikan dan dipimpin langsung oleh <strong>Al Habib Ali Zainal Abidin bin Hamid Alaydrus</strong>. Dimana beliau berasal dari Jawa Timur lahir pada tanggal 14 Januari 1975 bertepatan dengan tanggal 1 Muharram. Dari pernikahan Habib Hamid bin Husen Al-aydrus dengan Syarifah Qomariyah Alaydrus, yang akhirnya nama Qomariyah diabadikan sebagai nama majelis Nurul Qomariyah, sebagai salah satu kecintaan kepada Uminya.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200" style="justify-content: center;">
                    <img src="<?= base_url('assets/img/profile/logo.png'); ?>" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <section id="event" class="about">
        <div class="container" data-aos="fade-up">
            <div class="row gx-0">
                <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200" style="justify-content: center;">
                    <img src="<?= base_url('event/' . $data->gambar); ?>" class="img-fluid">
                </div>
                <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="content">
                        <h2><?= $data->judul; ?></h2>
                        <p style="text-align: justify; line-height: 2; text-indent: 30px;">
                            <?= $data->deskripsi; ?>
                            <a href="<?= base_url('/home/event'); ?>">see more..</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="team" class="team">
        <div class="container" data-aos="fade-up">
            <header class="section-header">
                <h2>OUR TEAM</h2>
                <p>TEAM WORK</p>
            </header>
            <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="200">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="profile mt-auto">
                                <img src="<?= base_url('assets/img/profile/testimonials/pembina.jpg'); ?>" class="img-fluid" alt="">
                                <h3>Al-Habib Ali Zainal Abidin Bin Hamid Alaydrus</h3>
                                <h4>Pembina</h4>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="profile mt-auto">
                                <img src="<?= base_url('assets/img/profile/testimonials/default.jpg'); ?>" class="img-fluid" alt="">
                                <h3>Abdul Ghofur</h3>
                                <h4>Ketua Umum</h4>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="profile mt-auto">
                                <img src="<?= base_url('assets/img/profile/testimonials/wakil ketua.jpg'); ?>" class="img-fluid" alt="">
                                <h3>Randy Ari Sopya</h3>
                                <h4>Wakil Ketua</h4>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="profile mt-auto">
                                <img src="<?= base_url('assets/img/profile/testimonials/sekretaris.jpg'); ?>" class="img-fluid" alt="">
                                <h3>Miftahus Shurur</h3>
                                <h4>Sekretaris</h4>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="profile mt-auto">
                                <img src="<?= base_url('assets/img/profile/testimonials/default.jpg'); ?>" class="img-fluid" alt="">
                                <h3>Syamsul Arifin</h3>
                                <h4>Bendahara</h4>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="profile mt-auto">
                                <img src="<?= base_url('assets/img/profile/testimonials/div.multimedia.jpg'); ?>" class="img-fluid" alt="">
                                <h3>Ahmad Raihan Gymnastiar</h3>
                                <h4>Kadiv.Multimedia</h4>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="profile mt-auto">
                                <img src="<?= base_url('assets/img/profile/testimonials/div.keamanan.jpg'); ?>" class="img-fluid" alt="">
                                <h3>Muhammad Haidar</h3>
                                <h4>Kadiv.Keamanan</h4>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="profile mt-auto">
                                <img src="<?= base_url('assets/img/profile/testimonials/div.humas.jpg'); ?>" class="img-fluid" alt="">
                                <h3>Dedi</h3>
                                <h4>Kadiv.HUMAS</h4>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->
                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>

    </section>

    <section id="contact" class="contact">

        <div class="container" data-aos="fade-up">

            <header class="section-header">
                <h2>Contact</h2>
                <p>Contact Us</p>
            </header>

            <div class="row gy-4">

                <div class="col-lg-12">

                    <div class="row gy-4">
                        <div class="col-md-3">
                            <div class="info-box">
                                <i class="bi bi-geo-alt"></i>
                                <h3>Address</h3>
                                <p> Perumahan Ciledug Indah 2 Blok C1 No. 2-3, Jl. Jeruk, Pedurenan, Karang Tengah<br> RT.002/RW.011, Pedurenan, Kec. Karang Tengah, Kota Tangerang, Banten 15157</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <i class="bi bi-telephone"></i>
                                <h3>Call Us</h3>
                                <p>0859-4565-1919<br>0813-1880-5160</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <i class="bi bi-envelope"></i>
                                <h3>Email Us</h3>
                                <p>sakraannq@gmail.com
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <i class="bi bi-clock"></i>
                                <h3>Open Hours</h3>
                                <p>Monday - Saturday<br>9:00AM - 05:00PM</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </section>
</main>

<?= $this->include('auth/templates/footer'); ?>

<?= $this->endSection(); ?>