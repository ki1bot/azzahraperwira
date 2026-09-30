<?php
$judulHalaman = $judul ?? 'Admin';
$namaAdmin = session()->get('nama_admin') ?? 'Admin';
$usernameAdmin = session()->get('username_admin') ?? 'admin';
$uriString = uri_string();

$isActive = static function (string $kataKunci) use ($uriString): bool {
    return str_contains($uriString, $kataKunci);
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

$navClass = static function (bool $active): string {
    return $active
        ? 'flex items-center gap-3 rounded-lg bg-emerald-50 px-3 py-2.5 text-sm font-semibold text-az-green'
        : 'flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900';
};
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <title><?= esc($judulHalaman) ?> - Admin Az-Zahra Perwira</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'az-green': '#1a6e4d',
                        'az-gold': '#fbbf24'
                    }
                }
            }
        }
    </script>

    <link rel="stylesheet" href="<?= base_url('assets/font-awesome/css/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
    <script src="<?= base_url('js/admin.js') ?>" defer></script>
</head>
<body class="min-h-screen bg-slate-50 text-slate-700 antialiased">
    <div
        id="mobileAdminBackdrop"
        class="fixed inset-0 z-40 hidden bg-slate-900/40 lg:hidden"
    ></div>

    <aside
        id="adminSidebar"
        class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-slate-200 bg-white transition-transform duration-200 lg:translate-x-0"
    >
        <div class="flex h-20 items-center justify-between border-b border-slate-100 px-5">
            <a
                href="<?= base_url('admin/dashboard/index.php') ?>"
                class="flex min-w-0 items-center gap-3"
            >
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-az-green text-sm font-bold text-white">
                    AZ
                </span>

                <span class="min-w-0">
                    <strong class="block truncate text-sm font-semibold text-slate-900">
                        Az-Zahra Perwira
                    </strong>
                    <small class="mt-0.5 block text-xs text-slate-500">
                        Admin Website
                    </small>
                </span>
            </a>

            <button
                type="button"
                id="mobileAdminClose"
                class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 lg:hidden"
                aria-label="Tutup menu"
            >
                <i class="fa fa-times" aria-hidden="true"></i>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto px-4 py-5" aria-label="Navigasi admin">
            <div class="mb-6">
                <p class="mb-2 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-400">
                    Utama
                </p>

                <a
                    href="<?= base_url('admin/dashboard/index.php') ?>"
                    class="<?= $navClass($isActive('admin/dashboard')) ?>"
                >
                    <span class="flex w-5 justify-center text-slate-500">
                        <i class="fa fa-th-large" aria-hidden="true"></i>
                    </span>
                    <span>Dashboard</span>
                </a>
            </div>

            <div class="mb-6">
                <p class="mb-2 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-400">
                    Konten Website
                </p>

                <div class="space-y-1">
                    <?php foreach ($menuKonten as $menu): ?>
                        <a
                            href="<?= base_url($menu['url']) ?>"
                            class="<?= $navClass($isActive($menu['match'])) ?>"
                        >
                            <span class="flex w-5 justify-center text-slate-500">
                                <i class="fa <?= esc($menu['icon'], 'attr') ?>" aria-hidden="true"></i>
                            </span>
                            <span><?= esc($menu['label']) ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div>
                <p class="mb-2 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-400">
                    Unit Pendidikan
                </p>

                <div class="space-y-1">
                    <?php foreach ($menuUnit as $menu): ?>
                        <a
                            href="<?= base_url($menu['url']) ?>"
                            class="<?= $navClass($isActive($menu['match'])) ?>"
                        >
                            <span class="flex w-5 justify-center text-slate-500">
                                <i class="fa <?= esc($menu['icon'], 'attr') ?>" aria-hidden="true"></i>
                            </span>
                            <span><?= esc($menu['label']) ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </nav>

        <div class="border-t border-slate-100 p-4">
            <a
                href="<?= site_url('home/beranda') ?>"
                target="_blank"
                rel="noopener noreferrer"
                class="mb-3 flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900"
            >
                <span class="flex w-5 justify-center text-slate-500">
                    <i class="fa fa-external-link" aria-hidden="true"></i>
                </span>
                <span>Lihat Website</span>
            </a>

            <div class="flex items-center gap-3 rounded-lg bg-slate-50 p-3">
                <img
                    src="<?= base_url('assets/img/profile/profileAdmin.png') ?>"
                    alt="Admin"
                    class="h-9 w-9 rounded-full object-cover"
                >

                <div class="min-w-0 flex-1">
                    <strong class="block truncate text-sm font-semibold text-slate-900">
                        <?= esc($namaAdmin) ?>
                    </strong>
                    <span class="block truncate text-xs text-slate-500">
                        @<?= esc($usernameAdmin) ?>
                    </span>
                </div>

                <a
                    href="<?= base_url('admin/logout/index.php') ?>"
                    class="flex h-8 w-8 items-center justify-center rounded-md text-slate-500 hover:bg-white hover:text-red-600"
                    title="Logout"
                    aria-label="Logout"
                >
                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </aside>

    <div class="min-h-screen lg:ml-72">
        <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur">
            <div class="flex h-16 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
                <div class="flex min-w-0 items-center gap-3">
                    <button
                        type="button"
                        id="mobileAdminToggle"
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 lg:hidden"
                        aria-label="Buka menu"
                    >
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </button>

                    <div class="min-w-0">
                        <p class="hidden text-xs font-medium text-slate-400 sm:block">
                            Admin Website
                        </p>
                        <h1 class="truncate text-lg font-semibold text-slate-900 sm:text-xl">
                            <?= esc($judulHalaman) ?>
                        </h1>
                    </div>
                </div>

                <div class="relative">
                    <button
                        type="button"
                        id="adminProfileButton"
                        class="flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-2 py-1.5 text-sm text-slate-700 hover:bg-slate-50"
                        aria-label="Buka menu akun"
                        aria-expanded="false"
                    >
                        <img
                            src="<?= base_url('assets/img/profile/profileAdmin.png') ?>"
                            alt="Admin"
                            class="h-8 w-8 rounded-full object-cover"
                        >
                        <span class="hidden max-w-32 truncate font-medium sm:block">
                            <?= esc($namaAdmin) ?>
                        </span>
                        <i class="fa fa-angle-down text-slate-400" aria-hidden="true"></i>
                    </button>

                    <div
                        id="adminProfileDropdown"
                        class="absolute right-0 mt-2 hidden w-64 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg"
                    >
                        <div class="border-b border-slate-100 p-4">
                            <p class="text-sm font-semibold text-slate-900">
                                <?= esc($namaAdmin) ?>
                            </p>
                            <p class="mt-0.5 text-xs text-slate-500">
                                @<?= esc($usernameAdmin) ?>
                            </p>
                        </div>

                        <div class="p-2">
                            <a
                                href="<?= base_url('admin/ubah-password/index.php') ?>"
                                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900"
                            >
                                <i class="fa fa-key w-4 text-center text-slate-400" aria-hidden="true"></i>
                                <span>Ubah Password</span>
                            </a>

                            <a
                                href="<?= base_url('admin/logout/index.php') ?>"
                                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-red-600 hover:bg-red-50"
                            >
                                <i class="fa fa-sign-out w-4 text-center" aria-hidden="true"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="px-4 py-6 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="mb-5 flex items-start gap-3 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        <i class="fa fa-check-circle mt-0.5" aria-hidden="true"></i>
                        <div><?= session()->getFlashdata('success') ?></div>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="mb-5 flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <i class="fa fa-exclamation-circle mt-0.5" aria-hidden="true"></i>
                        <div><?= session()->getFlashdata('error') ?></div>
                    </div>
                <?php endif; ?>

                <?= $isi_admin ?? '' ?>
            </div>
        </main>
    </div>
</body>
</html>