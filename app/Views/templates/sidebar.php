<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <br>
    <a href="#" class="brand-link">
        <img src="<?= base_url('pas_photo/' . user()->image); ?>" alt="" class="brand-image img-circle elevation-4" style="opacity: .8">
        <span class="brand-text font-weight-light"><small><?= user()->name; ?></small></span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php if (in_groups('admin')) : ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('admin'); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Dashboard Admin</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('guru'); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Dashboard Guru</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('admin/informasi'); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Dashboard Santri</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_groups('guru')) : ?>
                    <li class="nav-item">
                        <a href="<?= base_url('guru'); ?>" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('guru/profile'); ?>" class="nav-link">
                            <i class="nav-icon fas fa-address-card"></i>
                            <p>My Profile</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('guru/scanqr'); ?>" class="nav-link">
                            <i class="nav-icon fas fa-qrcode"></i>
                            <p>Scan Absen</p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (in_groups('santri')) : ?>
                    <li class="nav-item">
                        <a href="<?= base_url('santri'); ?>" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('santri/profile'); ?>" class="nav-link">
                            <i class="nav-icon fas fa-address-card"></i>
                            <p>My Profile</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('santri/scanqr'); ?>" class="nav-link">
                            <i class="nav-icon fas fa-qrcode"></i>
                            <p>Scan Absen</p>
                        </a>
                    </li>
                <?php endif; ?>

                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="../charts/chartjs.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Edit Profile</p>
                        </a>
                    </li>
                </ul>
                </li>

                <?php if (in_groups('admin')) : ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-address-card"></i>
                            <p>
                                Data Master
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('admin/daftarUsers'); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Daftar Users</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('admin/daftarGuru'); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Daftar Guru</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('admin/daftarSantri'); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Daftar Santri</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('admin/daftarKelas'); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Daftar Kelas</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('event/dataEvent'); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Daftar Event</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('admin/daftarMp'); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Daftar Mata Pelajaran</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('admin/daftarAbsen'); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Daftar Absen</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_groups('admin')) : ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-qrcode"></i>
                            <p>
                                Data QR-CODE
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('admin/cetakQR'); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Cetak QR-Code</p>
                                </a>
                            </li>
                        </ul>
                        <!-- <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('guru/absensi'); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Cetak Guru</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('santri/absensi'); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Cetak SISWA</p>
                                </a>
                            </li>
                        </ul> -->
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('admin/daftarQR'); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Daftar QR-Code</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-graduation-cap"></i>
                        <?php if (in_groups('admin') || in_groups('guru')) : ?>
                            <p>
                                Data Akademik
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        <?php else : ?>
                            <p>
                                Akademik
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        <?php endif; ?>
                    </a>
                    <?php if (in_groups('admin') || in_groups('guru')) : ?>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('admin/daftarJadwalPelajaran'); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Jadwal Harian</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('guru/transkrip_nilai'); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Transkrip Nilai</p>
                                </a>
                            </li>
                        </ul>
                    <?php endif; ?>
                    <?php if (in_groups('santri')) : ?>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('santri/jadwalPelajaran'); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>jadwal Harian</p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('santri/transkripNilai'); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Transkrip Nilai</p>
                                </a>
                            </li>
                        </ul>
                    <?php endif; ?>
                </li>

                <?php if (in_groups('admin')) : ?>
                    <li class="nav-item">
                        <a href="<?= base_url('dokumen'); ?>" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Dokumen</p>
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-qrcode"></i>
                            <p>
                                ScanQR
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('guru/scanqr'); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Scan Guru</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('santri/scanqr'); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Scan Santri</p>
                                </a>
                            </li>
                        </ul>
                    </li> -->
                <?php endif; ?>
                <li class="nav-item">
                    <a href="<?= base_url('logout'); ?>" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>