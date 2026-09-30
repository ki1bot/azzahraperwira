<?php
$daftarHalaman = $daftarHalaman ?? [];
$ringkasanHalaman = $ringkasanHalaman ?? [];
$totalKonten = (int) ($totalKonten ?? 0);
$totalAktif = (int) ($totalAktif ?? 0);
$totalHalamanDinamis = (int) ($totalHalamanDinamis ?? 0);

$deskripsiHalaman = [
    'beranda' => 'Atur banner utama, brosur, dan video profil yang tampil di halaman depan.',
    'profile' => 'Perbarui profil yayasan, visi, misi, dan struktur organisasi.',
    'tenaga-pengajar' => 'Kelola daftar tenaga pengajar beserta kategori, pendidikan, jabatan, dan foto.',
    'unit-kb-tk' => 'Perbarui informasi program, fasilitas, ekstrakurikuler, dan galeri KB/TK.',
    'unit-tpq' => 'Perbarui informasi TPQ, RTQ, program, kegiatan, dan galeri.',
    'unit-dc' => 'Perbarui informasi Daycare, program, kegiatan, dan galeri.',
    'unit-lansia' => 'Perbarui informasi program, kegiatan, dan galeri Unit Lansia.',
    'informasi' => 'Kelola pengumuman, berita, brosur, dan informasi terbaru untuk pengunjung.',
    'footer' => 'Atur identitas, alamat, nomor WhatsApp, media sosial, dan copyright.',
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
?>

<div class="dashboard-intro">
    <div>
        <span class="section-kicker">Ringkasan</span>
        <h2>Kelola website dari satu tempat</h2>
        <p>
            Pilih bagian website yang ingin diperbarui.
            Nama menu dan form dibuat mengikuti isi website agar lebih
            mudah dipahami tanpa perlu mengetahui ID atau kode database.
        </p>
    </div>

    <a
        href="<?= site_url('home/beranda') ?>"
        target="_blank"
        rel="noopener noreferrer"
        class="btn btn-secondary"
    >
        <i class="fa fa-external-link" aria-hidden="true"></i>
        Lihat Website
    </a>
</div>

<div class="stat-grid">
    <article class="stat-card">
        <span class="stat-icon">
            <i class="fa fa-files-o" aria-hidden="true"></i>
        </span>

        <div>
            <span class="stat-label">Halaman Dikelola</span>
            <strong><?= count($daftarHalaman) ?></strong>
            <small>bagian website</small>
        </div>
    </article>

    <article class="stat-card">
        <span class="stat-icon">
            <i class="fa fa-list-alt" aria-hidden="true"></i>
        </span>

        <div>
            <span class="stat-label">Total Konten</span>
            <strong><?= $totalKonten ?></strong>
            <small>data tersimpan</small>
        </div>
    </article>

    <article class="stat-card">
        <span class="stat-icon">
            <i class="fa fa-check-circle-o" aria-hidden="true"></i>
        </span>

        <div>
            <span class="stat-label">Konten Aktif</span>
            <strong><?= $totalAktif ?></strong>
            <small>sedang ditampilkan</small>
        </div>
    </article>

    <article class="stat-card">
        <span class="stat-icon">
            <i class="fa fa-plus-square-o" aria-hidden="true"></i>
        </span>

        <div>
            <span class="stat-label">Data Dinamis</span>
            <strong><?= $totalHalamanDinamis ?></strong>
            <small>halaman bisa tambah data</small>
        </div>
    </article>
</div>

<div class="section-heading section-heading-row">
    <div>
        <span class="section-kicker">Menu Konten</span>
        <h2>Pilih halaman yang ingin dikelola</h2>
        <p>
            Setiap kartu menunjukkan jumlah data dan status konten
            pada halaman tersebut.
        </p>
    </div>
</div>

<?php if (! empty($daftarHalaman)): ?>
    <div class="page-grid">
        <?php foreach ($daftarHalaman as $kode => $nama): ?>
            <?php
            $ringkasan = $ringkasanHalaman[$kode] ?? [
                'total' => 0,
                'aktif' => 0,
                'nonaktif' => 0,
                'boleh_tambah' => false,
            ];
            ?>

            <article class="page-card">
                <div class="page-card-head">
                    <span class="page-card-icon">
                        <i
                            class="fa <?= esc(
                                $ikonHalaman[$kode] ?? 'fa-file-text-o',
                                'attr'
                            ) ?>"
                            aria-hidden="true"
                        ></i>
                    </span>

                    <span
                        class="badge <?= ! empty($ringkasan['boleh_tambah'])
                            ? 'badge-info'
                            : 'badge-neutral'
                        ?>"
                    >
                        <?= ! empty($ringkasan['boleh_tambah'])
                            ? 'Bisa tambah data'
                            : 'Edit bagian tetap'
                        ?>
                    </span>
                </div>

                <div class="page-card-body">
                    <h3><?= esc($nama) ?></h3>
                    <p>
                        <?= esc(
                            $deskripsiHalaman[$kode]
                            ?? 'Kelola konten halaman website.'
                        ) ?>
                    </p>
                </div>

                <div class="page-card-meta">
                    <span>
                        <strong><?= (int) ($ringkasan['total'] ?? 0) ?></strong>
                        data
                    </span>

                    <span>
                        <strong><?= (int) ($ringkasan['aktif'] ?? 0) ?></strong>
                        aktif
                    </span>

                    <?php if ((int) ($ringkasan['nonaktif'] ?? 0) > 0): ?>
                        <span>
                            <strong><?= (int) $ringkasan['nonaktif'] ?></strong>
                            nonaktif
                        </span>
                    <?php endif; ?>
                </div>

                <div class="card-action">
                    <a
                        href="<?= $adminHalamanUrl($kode) ?>"
                        class="btn btn-primary btn-block"
                    >
                        Kelola <?= esc($nama) ?>
                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="empty-state">
        <span class="empty-icon">
            <i class="fa fa-folder-open-o" aria-hidden="true"></i>
        </span>
        <h3>Belum ada halaman tersedia</h3>
        <p>Daftar halaman belum ditemukan.</p>
    </div>
<?php endif; ?>