<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
            <span>Selamat datang, <?= user()->name; ?></span>
            <img class="img-profile rounded-circle" src="<?= base_url(); ?>/pas_photo/<?= user()->image; ?>" alt="" width="20" height="20">
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <div class="dropdown-divider"></div>
            <a href="<?= base_url('yayasan'); ?>" class="dropdown-item">
                <i class="fas fa-school mr-2"></i> Profile Yayasan
            </a>
            <?php if (in_groups('admin')) : ?>
                <a href="<?= base_url('admin'); ?>" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> My Profile
                </a>
            <?php elseif (in_groups('guru')) : ?>
                <a href="<?= base_url('guru/profile'); ?>" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> My Profile
                </a>
            <?php elseif (in_groups('santri')) : ?>
                <a href="<?= base_url('santri'); ?>" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> My Profile
                </a>
            <?php else : ?>
                <a href="<?= base_url('ortu'); ?>" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> My Profile
                </a>
            <?php endif; ?>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal-secondary">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </a>
        </div>
        <style>
            .dropdown-menu {
                min-width: 100px;
            }
        </style>
    </ul>
</nav>

<!-- Logout modal -->
<div class="modal fade" id="modal-secondary">
    <div class="modal-dialog">
        <div class="modal-content bg-secondary">
            <div class="modal-header">
                <h4 class="modal-title">Ready to Leave?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Select "Logout" below if you are ready to end your current session.</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancel</button>
                <a class="btn btn-outline-light" href="<?= base_url('logout'); ?>">Logout</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- End logout modal -->