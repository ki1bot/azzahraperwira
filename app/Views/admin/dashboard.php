<?php
$daftarHalaman = $daftarHalaman ?? [];
$ringkasanHalaman = $ringkasanHalaman ?? [];
$totalKonten = (int) ($totalKonten ?? 0);
$totalAktif = (int) ($totalAktif ?? 0);
$totalHalamanDinamis = (int) ($totalHalamanDinamis ?? 0);

$deskripsiHalaman = [
    'beranda' => 'Atur banner utama, brosur, dan video profil pada halaman depan.',
    'profile' => 'Perbarui profil yayasan, visi, misi, dan struktur organisasi.',
    'tenaga-pengajar' => 'Kelola data tenaga pengajar, pendidikan, jabatan, dan foto.',
    'unit-kb-tk' => 'Perbarui program, fasilitas, ekstrakurikuler, dan galeri KB/TK.',
    'unit-tpq' => 'Perbarui informasi TPQ, RTQ, program, kegiatan, dan galeri.',
    'unit-dc' => 'Perbarui informasi Daycare, program, kegiatan, dan galeri.',
    'unit-lansia' => 'Perbarui informasi program, kegiatan, dan galeri Unit Lansia.',
    'informasi' => 'Kelola pengumuman, berita, brosur, dan informasi terbaru.',
    'footer' => 'Atur identitas, alamat, WhatsApp, media sosial, dan copyright.',
];

$ikonHalaman = [
    'beranda' => 'fa-home',
    'profile' => 'fa-building-o',
    'tenaga-pengajar' => 'fa-users',
    'unit-kb-tk' => 'fa-child',
    'unit-tpq' => 'fa-book',
    'unit-dc' => 'fa-sun-o',
    'unit-lansia' => 'fa-heart-o',
    'informasi' => 'fa-newspaper-o',
    'footer' => 'fa-window-minimize',
];

$adminHalamanUrl = static function (string $kode): string {
    return base_url('admin/' . trim($kode, '/') . '/index.php');
};

$statCards = [
    [
        'label' => 'Halaman Dikelola',
        'value' => count($daftarHalaman),
        'note' => 'bagian website',
        'icon' => 'fa-files-o',
    ],
    [
        'label' => 'Total Konten',
        'value' => $totalKonten,
        'note' => 'data tersimpan',
        'icon' => 'fa-list-alt',
    ],
    [
        'label' => 'Konten Aktif',
        'value' => $totalAktif,
        'note' => 'sedang ditampilkan',
        'icon' => 'fa-check-circle-o',
    ],
    [
        'label' => 'Halaman Dinamis',
        'value' => $totalHalamanDinamis,
        'note' => 'bisa tambah data',
        'icon' => 'fa-plus-square-o',
    ],
];
?>

<section class="mb-6 flex flex-col gap-4 border-b border-slate-200 pb-6 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <p class="mb-1 text-sm font-medium text-az-green">Dashboard</p>
        <h2 class="text-2xl font-semibold tracking-tight text-slate-900">
            Ringkasan Website
        </h2>
        <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
            Pilih halaman yang ingin diperbarui. Semua bagian dikelola dengan nama yang sama seperti yang tampil di website.
        </p>
    </div>

    <a
        href="<?= site_url('home/beranda') ?>"
        target="_blank"
        rel="noopener noreferrer"
        class="inline-flex h-10 items-center justify-center gap-2 self-start rounded-lg border border-slate-300 bg-white px-4 text-sm font-medium text-slate-700 hover:bg-slate-50"
    >
        <i class="fa fa-external-link" aria-hidden="true"></i>
        Lihat Website
    </a>
</section>

<div class="mb-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <?php foreach ($statCards as $stat): ?>
        <article class="rounded-xl border border-slate-200 bg-white p-5">
            <div class="mb-4 flex items-center justify-between">
                <span class="text-sm font-medium text-slate-500">
                    <?= esc($stat['label']) ?>
                </span>

                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50 text-az-green">
                    <i class="fa <?= esc($stat['icon'], 'attr') ?>" aria-hidden="true"></i>
                </span>
            </div>

            <div class="flex items-baseline gap-2">
                <strong class="text-3xl font-semibold tracking-tight text-slate-900">
                    <?= (int) $stat['value'] ?>
                </strong>
                <span class="text-xs text-slate-400">
                    <?= esc($stat['note']) ?>
                </span>
            </div>
        </article>
    <?php endforeach; ?>
</div>

<section>
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-slate-900">
            Kelola Konten
        </h2>
        <p class="mt-1 text-sm text-slate-500">
            Buka halaman yang ingin Anda ubah.
        </p>
    </div>

    <?php if (! empty($daftarHalaman)): ?>
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            <?php foreach ($daftarHalaman as $kode => $nama): ?>
                <?php
                $ringkasan = $ringkasanHalaman[$kode] ?? [
                    'total' => 0,
                    'aktif' => 0,
                    'nonaktif' => 0,
                    'boleh_tambah' => false,
                ];
                ?>

                <article class="flex flex-col rounded-xl border border-slate-200 bg-white p-5">
                    <div class="mb-4 flex items-start justify-between gap-4">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                            <i
                                class="fa <?= esc($ikonHalaman[$kode] ?? 'fa-file-text-o', 'attr') ?>"
                                aria-hidden="true"
                            ></i>
                        </span>

                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[11px] font-medium text-slate-500">
                            <?= ! empty($ringkasan['boleh_tambah'])
                                ? 'Data dapat ditambah'
                                : 'Bagian tetap'
                            ?>
                        </span>
                    </div>

                    <div class="flex-1">
                        <h3 class="text-base font-semibold text-slate-900">
                            <?= esc($nama) ?>
                        </h3>

                        <p class="mt-1.5 text-sm leading-6 text-slate-500">
                            <?= esc($deskripsiHalaman[$kode] ?? 'Kelola konten halaman website.') ?>
                        </p>
                    </div>

                    <div class="mt-5 flex flex-wrap gap-x-4 gap-y-2 border-t border-slate-100 pt-4 text-xs text-slate-500">
                        <span>
                            <strong class="font-semibold text-slate-800">
                                <?= (int) ($ringkasan['total'] ?? 0) ?>
                            </strong>
                            data
                        </span>

                        <span>
                            <strong class="font-semibold text-slate-800">
                                <?= (int) ($ringkasan['aktif'] ?? 0) ?>
                            </strong>
                            aktif
                        </span>

                        <?php if ((int) ($ringkasan['nonaktif'] ?? 0) > 0): ?>
                            <span>
                                <strong class="font-semibold text-slate-800">
                                    <?= (int) $ringkasan['nonaktif'] ?>
                                </strong>
                                nonaktif
                            </span>
                        <?php endif; ?>
                    </div>

                    <a
                        href="<?= $adminHalamanUrl($kode) ?>"
                        class="mt-4 inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-az-green px-4 text-sm font-medium text-white hover:bg-emerald-800"
                    >
                        Kelola
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="rounded-xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center">
            <i class="fa fa-folder-open-o text-3xl text-slate-300" aria-hidden="true"></i>
            <h3 class="mt-3 text-sm font-semibold text-slate-900">
                Belum ada halaman tersedia
            </h3>
            <p class="mt-1 text-sm text-slate-500">
                Daftar halaman belum ditemukan.
            </p>
        </div>
    <?php endif; ?>
</section>