<?php
helper('konten');

$daftarKonten = $daftarKonten ?? [];
$hakKonten = $hakKonten ?? [];
$ringkasan = $ringkasan ?? [
    'total' => 0,
    'aktif' => 0,
    'nonaktif' => 0,
];

$kodeHalaman = $kodeHalaman ?? '';
$namaHalaman = $namaHalaman ?? 'Halaman';
$bolehTambah = (bool) ($bolehTambah ?? false);

$ringkasTeks = static function (
    ?string $teks,
    int $maksimal = 150
): string {
    $teks = konten_plain($teks);

    if ($teks === '') {
        return '';
    }

    if (mb_strlen($teks) <= $maksimal) {
        return $teks;
    }

    return mb_substr($teks, 0, $maksimal) . '...';
};

$adminHalamanUrl = static function (
    string $kodeHalaman,
    string $aksi = '',
    ?string $kodeKonten = null
): string {
    $url = 'admin/' . trim($kodeHalaman, '/');

    if ($aksi !== '') {
        $url .= '/' . trim($aksi, '/');
    }

    if ($kodeKonten !== null && $kodeKonten !== '') {
        $url .= '/' . rawurlencode($kodeKonten);
    }

    return base_url($url . '/index.php');
};

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
?>

<div class="content-page-head">
    <div class="content-page-title">
        <span class="page-section-icon">
            <i
                class="fa <?= esc(
                    $ikonHalaman[$kodeHalaman] ?? 'fa-file-text-o',
                    'attr'
                ) ?>"
                aria-hidden="true"
            ></i>
        </span>

        <div>
            <span class="section-kicker">Konten Website</span>
            <h2><?= esc($namaHalaman) ?></h2>

            <p>
                <?php if ($bolehTambah): ?>
                    Anda dapat menambah data baru, mengubah data yang
                    sudah ada, menonaktifkan, atau menghapus data tambahan.
                <?php else: ?>
                    Bagian pada halaman ini sudah disiapkan sesuai tampilan
                    website. Pilih Edit pada bagian yang ingin diperbarui.
                <?php endif; ?>
            </p>
        </div>
    </div>

    <?php if ($bolehTambah): ?>
        <a
            href="<?= $adminHalamanUrl($kodeHalaman, 'tambah') ?>"
            class="btn btn-primary"
        >
            <i class="fa fa-plus" aria-hidden="true"></i>
            <?= $kodeHalaman === 'tenaga-pengajar'
                ? 'Tambah Pengajar'
                : 'Tambah Informasi'
            ?>
        </a>
    <?php endif; ?>
</div>

<div class="mini-stat-row">
    <div class="mini-stat">
        <span>Total Data</span>
        <strong><?= (int) ($ringkasan['total'] ?? 0) ?></strong>
    </div>

    <div class="mini-stat">
        <span>Aktif</span>
        <strong><?= (int) ($ringkasan['aktif'] ?? 0) ?></strong>
    </div>

    <div class="mini-stat">
        <span>Nonaktif</span>
        <strong><?= (int) ($ringkasan['nonaktif'] ?? 0) ?></strong>
    </div>
</div>

<?php if (! empty($daftarKonten)): ?>
    <div class="content-list">
        <?php foreach ($daftarKonten as $konten): ?>
            <?php
            $kodeKonten = (string) ($konten['kode_konten'] ?? '');
            $hak = $hakKonten[$kodeKonten] ?? [];
            $namaBagian = (string) (
                $hak['nama_bagian'] ?? 'Bagian Konten'
            );
            $tipeUpload = (string) (
                $hak['tipe_upload'] ?? 'none'
            );
            $bolehHapusKonten = (bool) (
                $hak['boleh_hapus'] ?? false
            );
            $kodeDikunci = (bool) (
                $hak['kode_dikunci'] ?? false
            );

            $judulKonten = trim(
                (string) ($konten['judul'] ?? '')
            );

            $isiRingkas = $ringkasTeks(
                $konten['isi'] ?? '',
                170
            );

            $judulUtama = $kodeDikunci
                ? $namaBagian
                : ($judulKonten !== ''
                    ? $judulKonten
                    : $namaBagian
                );
            ?>

            <article class="content-row">
                <div class="content-row-media">
                    <?php if (
                        $tipeUpload === 'image'
                        && ! empty($konten['gambar'])
                    ): ?>
                        <img
                            src="<?= esc(
                                base_url($konten['gambar']),
                                'attr'
                            ) ?>"
                            alt="<?= esc($judulUtama, 'attr') ?>"
                            class="content-thumb"
                            loading="lazy"
                        >
                    <?php elseif (
                        $tipeUpload === 'file'
                        && ! empty($konten['isi'])
                    ): ?>
                        <span class="content-file-icon">
                            <i
                                class="fa fa-file-pdf-o"
                                aria-hidden="true"
                            ></i>
                        </span>
                    <?php else: ?>
                        <span class="content-placeholder-icon">
                            <i
                                class="fa <?= $kodeDikunci
                                    ? 'fa-pencil-square-o'
                                    : 'fa-file-text-o'
                                ?>"
                                aria-hidden="true"
                            ></i>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="content-row-body">
                    <div class="content-row-title">
                        <div>
                            <?php if (! $kodeDikunci): ?>
                                <span class="content-type-label">
                                    <?= esc($namaBagian) ?>
                                </span>
                            <?php endif; ?>

                            <h3><?= esc($judulUtama) ?></h3>

                            <?php if (
                                $kodeDikunci
                                && $judulKonten !== ''
                                && $judulKonten !== $judulUtama
                            ): ?>
                                <p class="content-subtitle">
                                    <?= esc($judulKonten) ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div class="content-badges">
                            <?php if (
                                ($konten['status'] ?? '') === 'aktif'
                            ): ?>
                                <span class="badge badge-active">
                                    <i
                                        class="fa fa-circle"
                                        aria-hidden="true"
                                    ></i>
                                    Aktif
                                </span>
                            <?php else: ?>
                                <span class="badge badge-inactive">
                                    <i
                                        class="fa fa-circle"
                                        aria-hidden="true"
                                    ></i>
                                    Nonaktif
                                </span>
                            <?php endif; ?>

                            <?php if ($kodeDikunci): ?>
                                <span class="badge badge-neutral">
                                    Bagian tetap
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (
                        $kodeHalaman === 'tenaga-pengajar'
                        && ! $kodeDikunci
                    ): ?>
                        <div class="content-detail-grid">
                            <div>
                                <span>Kategori</span>
                                <strong>
                                    <?= esc(
                                        $konten['kategori'] ?? '-'
                                    ) ?>
                                </strong>
                            </div>

                            <div>
                                <span>Pendidikan</span>
                                <strong>
                                    <?= esc(
                                        $konten['pendidikan'] ?? '-'
                                    ) ?>
                                </strong>
                            </div>

                            <div>
                                <span>Jabatan</span>
                                <strong>
                                    <?= esc(
                                        $isiRingkas !== ''
                                            ? $isiRingkas
                                            : '-'
                                    ) ?>
                                </strong>
                            </div>
                        </div>
                    <?php elseif (
                        $isiRingkas !== ''
                        && $tipeUpload !== 'file'
                    ): ?>
                        <p class="content-excerpt">
                            <?= esc($isiRingkas) ?>
                        </p>
                    <?php endif; ?>

                    <div class="content-row-meta">
                        <span>
                            <i
                                class="fa fa-sort-numeric-asc"
                                aria-hidden="true"
                            ></i>
                            Urutan <?= (int) ($konten['urutan'] ?? 0) ?>
                        </span>

                        <?php if (
                            $tipeUpload === 'file'
                            && ! empty($konten['isi'])
                        ): ?>
                            <a
                                href="<?= esc(
                                    base_url($konten['isi']),
                                    'attr'
                                ) ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <i
                                    class="fa fa-external-link"
                                    aria-hidden="true"
                                ></i>
                                Lihat file
                            </a>
                        <?php elseif ($tipeUpload === 'image'): ?>
                            <span>
                                <i
                                    class="fa fa-picture-o"
                                    aria-hidden="true"
                                ></i>
                                <?= ! empty($konten['gambar'])
                                    ? 'Gambar tersedia'
                                    : 'Belum ada gambar'
                                ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="content-row-actions">
                    <a
                        href="<?= $adminHalamanUrl(
                            $kodeHalaman,
                            'edit',
                            $kodeKonten
                        ) ?>"
                        class="btn btn-secondary"
                    >
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit
                    </a>

                    <?php if ($bolehHapusKonten): ?>
                        <form
                            action="<?= $adminHalamanUrl(
                                $kodeHalaman,
                                'hapus',
                                $kodeKonten
                            ) ?>"
                            method="post"
                            onsubmit="return confirm('Hapus data ini? Tindakan ini tidak dapat dibatalkan.')"
                        >
                            <button
                                type="submit"
                                class="btn btn-danger btn-icon"
                                aria-label="Hapus data"
                                title="Hapus data"
                            >
                                <i
                                    class="fa fa-trash"
                                    aria-hidden="true"
                                ></i>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="empty-state">
        <span class="empty-icon">
            <i
                class="fa fa-folder-open-o"
                aria-hidden="true"
            ></i>
        </span>

        <?php if ($bolehTambah): ?>
            <h3>Belum ada data</h3>
            <p>
                Tambahkan data pertama untuk halaman
                <?= esc($namaHalaman) ?>.
            </p>

            <div class="empty-action">
                <a
                    href="<?= $adminHalamanUrl(
                        $kodeHalaman,
                        'tambah'
                    ) ?>"
                    class="btn btn-primary"
                >
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    Tambah Data
                </a>
            </div>
        <?php else: ?>
            <h3>Bagian halaman belum tersedia</h3>
            <p>
                Data awal untuk halaman ini belum ditemukan.
                Hubungi pengelola sistem untuk menyiapkan bagian
                halaman terlebih dahulu.
            </p>
        <?php endif; ?>
    </div>
<?php endif; ?>