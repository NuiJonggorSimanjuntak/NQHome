<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="col-sm-6">
                <h1><?= $title; ?></h1>
            </div>
            <div class="col-sm-12">
                <?php if (session()->getFlashdata('berhasil')) : ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->getFlashdata('berhasil') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-sm-12">
                <?php if (session()->getFlashdata('gagal')) : ?>
                    <div class="alert alert-warning" role="alert">
                        <?= session()->getFlashdata('gagal') ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card col-12">
                <div class="col-6 mb-3">
                    <br>
                    <select id="pilihKamera"></select>
                </div>
                <div class="col-6 mb-3">
                    <video style="width: 500px;" id="previewKamera">
                    </video>
                </div>
                <div class="col-6 mb-3">
                    <input style="width: 300px;" id="hasilscan" type="hidden" readonly>
                </div>
                <div class="col-6 mb-3">
                    <input style="width: 300px;" id="hasilscan" type="hidden" readonly>
                    <div id="verifikasiPesan" class="alert alert-danger" style="display: none;">
                        QR code tidak valid.
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
<?= $this->endSection(); ?>