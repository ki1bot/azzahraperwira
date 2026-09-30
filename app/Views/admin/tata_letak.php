<?php
$judulHalaman = $judul ?? 'Admin';
$namaAdmin = session()->get('nama_admin') ?? 'Admin';
$usernameAdmin = session()->get('username_admin') ?? 'admin';
$uriString = uri_string();

$adminAktif = static function (string $kataKunci) use ($uriString): string {
    return str_contains($uriString, $kataKunci) ? 'active' : '';
};

$menuKonten = [
    ['url' => 'admin/beranda/index.php', 'match' => 'admin/beranda', 'icon' => 'fa-home', 'label' => 'Beranda'],
    ['url' => 'admin/profile/index.php', 'match' => 'admin/profile', 'icon' => 'fa-building-o', 'label' => 'Profile'],
    ['url' => 'admin/tenaga-pengajar/index.php', 'match' => 'admin/tenaga-pengajar', 'icon' => 'fa-users', 'label' => 'Tenaga Pengajar'],
    ['url' => 'admin/informasi/index.php', 'match' => 'admin/informasi', 'icon' => 'fa-newspaper-o', 'label' => 'Informasi'],
    ['url' => 'admin/footer/index.php', 'match' => 'admin/footer', 'icon' => 'fa-window-minimize', 'label' => 'Footer'],
];

$menuUnit = [
    ['url' => 'admin/unit-kb-tk/index.php', 'match' => 'admin/unit-kb-tk', 'icon' => 'fa-child', 'label' => 'KB / TK'],
    ['url' => 'admin/unit-tpq/index.php', 'match' => 'admin/unit-tpq', 'icon' => 'fa-book', 'label' => 'TPQ'],
    ['url' => 'admin/unit-dc/index.php', 'match' => 'admin/unit-dc', 'icon' => 'fa-sun-o', 'label' => 'Daycare'],
    ['url' => 'admin/unit-lansia/index.php', 'match' => 'admin/unit-lansia', 'icon' => 'fa-heart-o', 'label' => 'Lansia'],
];
?>
<!DOCTYPE html>
<html lang="id" data-admin-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title><?= esc($judulHalaman) ?> - Admin Az-Zahra Perwira</title>
    <script src="<?= base_url('js/admin.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('assets/font-awesome/css/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/responsive.css') ?>">
</head>
<body>
    <div class="mobile-admin-backdrop" id="mobileAdminBackdrop"></div>

    <div class="admin-shell">
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-head">
                <a href="<?= base_url('admin/dashboard/index.php') ?>" class="brand-box">
                    <span class="brand-logo">AZ</span>
                    <span class="brand-copy">
                        <strong>Az-Zahra Perwira</strong>
                        <small>Panel Pengelola Website</small>
                    </span>
                </a>

                <button type="button" class="mobile-admin-close" id="mobileAdminClose" aria-label="Tutup menu">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>

            <nav class="sidebar-nav" aria-label="Navigasi admin">
                <div class="nav-group">
                    <p class="nav-label">Ringkasan</p>
                    <a href="<?= base_url('admin/dashboard/index.php') ?>" class="<?= $adminAktif('admin/dashboard') ?>">
                        <span class="nav-icon"><i class="fa fa-th-large" aria-hidden="true"></i></span>
                        <span>Dashboard</span>
                    </a>
                </div>

                <div class="nav-group">
                    <p class="nav-label">Konten Website</p>

                    <?php foreach ($menuKonten as $menu): ?>
                        <a href="<?= base_url($menu['url']) ?>" class="<?= $adminAktif($menu['match']) ?>">
                            <span class="nav-icon">
                                <i class="fa <?= esc($menu['icon'], 'attr') ?>" aria-hidden="true"></i>
                            </span>
                            <span><?= esc($menu['label']) ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>

                <div class="nav-group">
                    <p class="nav-label">Unit Pendidikan</p>

                    <?php foreach ($menuUnit as $menu): ?>
                        <a href="<?= base_url($menu['url']) ?>" class="<?= $adminAktif($menu['match']) ?>">
                            <span class="nav-icon">
                                <i class="fa <?= esc($menu['icon'], 'attr') ?>" aria-hidden="true"></i>
                            </span>
                            <span><?= esc($menu['label']) ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </nav>

            <div class="sidebar-bottom">
                <a
                    href="<?= site_url('home/beranda') ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="visit-site-link"
                >
                    <span class="nav-icon">
                        <i class="fa fa-external-link" aria-hidden="true"></i>
                    </span>

                    <span>
                        <strong>Lihat Website</strong>
                        <small>Buka tampilan publik</small>
                    </span>
                </a>

                <div class="sidebar-user">
                    <img
                        src="<?= base_url('assets/img/profile/profileAdmin.png') ?>"
                        alt="Admin"
                    >

                    <div>
                        <strong><?= esc($namaAdmin) ?></strong>
                        <span>@<?= esc($usernameAdmin) ?></span>
                    </div>

                    <a
                        href="<?= base_url('admin/logout/index.php') ?>"
                        class="sidebar-logout"
                        title="Logout"
                        aria-label="Logout"
                    >
                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </aside>

        <main class="admin-main">
            <header class="topbar">
                <div class="topbar-title-wrap">
                    <button
                        type="button"
                        class="mobile-admin-toggle"
                        id="mobileAdminToggle"
                        aria-label="Buka menu"
                    >
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </button>

                    <div>
                        <p class="page-eyebrow">Administrasi Website</p>
                        <h1 class="page-title"><?= esc($judulHalaman) ?></h1>
                    </div>
                </div>

                <div class="topbar-actions">
                    <button
                        type="button"
                        class="btn btn-secondary btn-icon-text"
                        id="themeToggle"
                    >
                        <i
                            class="fa fa-moon-o"
                            id="themeIcon"
                            aria-hidden="true"
                        ></i>
                        <span id="themeText">Mode Gelap</span>
                    </button>

                    <div class="admin-profile-wrapper">
                        <button
                            type="button"
                            class="admin-profile-button"
                            id="adminProfileButton"
                            aria-label="Buka menu akun"
                        >
                            <img
                                src="<?= base_url('assets/img/profile/profileAdmin.png') ?>"
                                alt="Admin"
                                class="admin-profile-img"
                            >
                            <span class="profile-name"><?= esc($namaAdmin) ?></span>
                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </button>

                        <div
                            class="admin-profile-dropdown"
                            id="adminProfileDropdown"
                        >
                            <div class="admin-profile-info">
                                <img
                                    src="<?= base_url('assets/img/profile/profileAdmin.png') ?>"
                                    alt="Admin"
                                    class="admin-profile-dropdown-img"
                                >

                                <div>
                                    <strong><?= esc($namaAdmin) ?></strong>
                                    <span>@<?= esc($usernameAdmin) ?></span>
                                </div>
                            </div>

                            <div class="admin-profile-menu">
                                <a href="<?= base_url('admin/ubah-password/index.php') ?>">
                                    <i class="fa fa-key" aria-hidden="true"></i>
                                    <span>Ubah Password</span>
                                </a>

                                <a
                                    href="<?= base_url('admin/logout/index.php') ?>"
                                    class="danger"
                                >
                                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                    <div><?= session()->getFlashdata('success') ?></div>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error">
                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                    <div><?= session()->getFlashdata('error') ?></div>
                </div>
            <?php endif; ?>

            <section class="content-card">
                <?= $isi_admin ?? '' ?>
            </section>
        </main>
    </div>
</body>
</html>