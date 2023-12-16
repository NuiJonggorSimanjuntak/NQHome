<header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center">

        <a href="" class="logo d-flex align-items-center">
            <img src="<?= base_url('assets/img/profile/logo.png'); ?>" alt="">
            <span></span>
        </a>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                <li><a class="nav-link scrollto" href="#about">About</a></li>
                <li><a class="nav-link scrollto" href="#event">Event</a></li>
                <li><a class="nav-link scrollto" href="#team">Team</a></li>
                <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
                <?php if (logged_in()) : ?>
                    <li><a class="nav-link scrollto" href="<?= base_url('logout'); ?>">Logout</a></li>
                <?php endif; ?>
            </ul>

            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>

    </div>
</header>