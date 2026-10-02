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

    return mb_substr(
        $teks,
        0,
        $maksimal
    ) . '...';
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

    if (
        $kodeKonten !== null
        && $kodeKonten !== ''
    ) {
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
    'footer' => 'fa-list-alt',
];

$teksTambah = $kodeHalaman === 'tenaga-pengajar'
    ? 'Tambah Pengajar'
    : 'Tambah Informasi';
?>

<section class="mb-6 flex flex-col gap-4 border-b border-slate-200 pb-6 sm:flex-row sm:items-start sm:justify-between">
    <div class="flex items-start gap-3">
        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-az-green">
            <i
                class="fa <?= esc(
                    $ikonHalaman[$kodeHalaman]
                    ?? 'fa-file-text-o',
                    'attr'
                ) ?>"
                aria-hidden="true"
            ></i>
        </span>

        <div>
            <p class="text-sm font-medium text-az-green">
                Konten Website
            </p>

            <h2 class="mt-0.5 text-2xl font-semibold tracking-tight text-slate-900">
                <?= esc($namaHalaman) ?>
            </h2>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                <?php if ($bolehTambah): ?>
                    Tambah, ubah, nonaktifkan, atau hapus data yang tampil pada halaman ini.
                <?php else: ?>
                    Pilih bagian yang ingin diperbarui.
                <?php endif; ?>
            </p>
        </div>
    </div>

    <?php if ($bolehTambah): ?>
        <a
            href="<?= $adminHalamanUrl(
                $kodeHalaman,
                'tambah'
            ) ?>"
            class="inline-flex h-10 items-center justify-center gap-2 self-start rounded-lg bg-az-green px-4 text-sm font-medium text-white transition hover:bg-emerald-800"
        >
            <i
                class="fa fa-plus"
                aria-hidden="true"
            ></i>

            <?= esc($teksTambah) ?>
        </a>
    <?php endif; ?>
</section>

<div class="mb-6 grid grid-cols-1 gap-3 sm:grid-cols-3">
    <div class="rounded-lg border border-slate-200 bg-white px-4 py-3">
        <span class="block text-xs text-slate-500">
            Total Data
        </span>

        <strong class="mt-1 block text-xl font-semibold text-slate-900">
            <?= (int) ($ringkasan['total'] ?? 0) ?>
        </strong>
    </div>

    <div class="rounded-lg border border-slate-200 bg-white px-4 py-3">
        <span class="block text-xs text-slate-500">
            Aktif
        </span>

        <strong class="mt-1 block text-xl font-semibold text-slate-900">
            <?= (int) ($ringkasan['aktif'] ?? 0) ?>
        </strong>
    </div>

    <div class="rounded-lg border border-slate-200 bg-white px-4 py-3">
        <span class="block text-xs text-slate-500">
            Nonaktif
        </span>

        <strong class="mt-1 block text-xl font-semibold text-slate-900">
            <?= (int) ($ringkasan['nonaktif'] ?? 0) ?>
        </strong>
    </div>
</div>

<?php if (! empty($daftarKonten)): ?>
    <div class="space-y-3">
        <?php foreach ($daftarKonten as $konten): ?>
            <?php
            $kodeKonten = (string) (
                $konten['kode_konten'] ?? ''
            );

            $hak = $hakKonten[$kodeKonten] ?? [];

            $namaBagian = (string) (
                $hak['nama_bagian']
                ?? 'Bagian Konten'
            );

            $tipeUpload = (string) (
                $hak['tipe_upload']
                ?? 'none'
            );

            $bolehHapusKonten = (bool) (
                $hak['boleh_hapus']
                ?? false
            );

            $kodeDikunci = (bool) (
                $hak['kode_dikunci']
                ?? false
            );

            $judulKonten = trim(
                (string) (
                    $konten['judul']
                    ?? ''
                )
            );

            $isiRingkas = $ringkasTeks(
                $konten['isi'] ?? '',
                170
            );

            $judulUtama = $kodeDikunci
                ? $namaBagian
                : (
                    $judulKonten !== ''
                        ? $judulKonten
                        : $namaBagian
                );
            ?>

            <article class="rounded-xl border border-slate-200 bg-white p-4 sm:p-5">
                <div class="flex flex-col gap-4 md:flex-row md:items-start">
                    <div class="h-44 w-full shrink-0 overflow-hidden rounded-lg bg-slate-100 md:h-24 md:w-28">
                        <?php if (
                            $tipeUpload === 'image'
                            && ! empty($konten['gambar'])
                        ): ?>
                            <img
                                src="<?= esc(
                                    base_url(
                                        $konten['gambar']
                                    ),
                                    'attr'
                                ) ?>"
                                alt="<?= esc(
                                    $judulUtama,
                                    'attr'
                                ) ?>"
                                class="h-full w-full object-cover"
                                loading="lazy"
                            >
                        <?php elseif (
                            $tipeUpload === 'file'
                            && ! empty($konten['isi'])
                        ): ?>
                            <span class="flex h-full w-full items-center justify-center text-2xl text-red-500">
                                <i
                                    class="fa fa-file-pdf-o"
                                    aria-hidden="true"
                                ></i>
                            </span>
                        <?php else: ?>
                            <span class="flex h-full w-full items-center justify-center text-xl text-slate-400">
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

                    <div class="min-w-0 flex-1">
                        <div class="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
                            <div class="min-w-0">
                                <?php if (! $kodeDikunci): ?>
                                    <span class="text-[11px] font-medium uppercase tracking-wide text-slate-400">
                                        <?= esc($namaBagian) ?>
                                    </span>
                                <?php endif; ?>

                                <h3 class="mt-0.5 text-base font-semibold text-slate-900">
                                    <?= esc($judulUtama) ?>
                                </h3>

                                <?php if (
                                    $kodeDikunci
                                    && $judulKonten !== ''
                                    && $judulKonten !== $judulUtama
                                ): ?>
                                    <p class="mt-1 text-sm text-slate-500">
                                        <?= esc($judulKonten) ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="flex shrink-0 flex-wrap items-center gap-2 lg:justify-end">
                                <?php if (
                                    ($konten['status'] ?? '')
                                    === 'aktif'
                                ): ?>
                                    <span class="inline-flex h-9 items-center gap-1.5 rounded-lg bg-emerald-50 px-3 text-xs font-medium text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex h-9 items-center gap-1.5 rounded-lg bg-slate-100 px-3 text-xs font-medium text-slate-500">
                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                        Nonaktif
                                    </span>
                                <?php endif; ?>

                                <?php if ($kodeDikunci): ?>
                                    <span class="inline-flex h-9 items-center rounded-lg bg-slate-100 px-3 text-xs font-medium text-slate-500">
                                        Bagian tetap
                                    </span>
                                <?php endif; ?>

                                <a
                                    href="<?= $adminHalamanUrl(
                                        $kodeHalaman,
                                        'edit',
                                        $kodeKonten
                                    ) ?>"
                                    class="inline-flex h-9 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                                >
                                    <i
                                        class="fa fa-pencil"
                                        aria-hidden="true"
                                    ></i>

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
                                        <?= csrf_field() ?>

                                        <button
                                            type="submit"
                                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-red-200 bg-white text-red-600 transition hover:bg-red-50"
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
                        </div>

                        <?php if (
                            $kodeHalaman === 'tenaga-pengajar'
                            && ! $kodeDikunci
                        ): ?>
                            <div class="mt-4 grid gap-3 text-sm sm:grid-cols-3">
                                <div>
                                    <span class="block text-xs text-slate-400">
                                        Kategori
                                    </span>

                                    <strong class="mt-0.5 block font-medium text-slate-700">
                                        <?= esc(
                                            $konten['kategori']
                                            ?? '-'
                                        ) ?>
                                    </strong>
                                </div>

                                <div>
                                    <span class="block text-xs text-slate-400">
                                        Pendidikan
                                    </span>

                                    <strong class="mt-0.5 block font-medium text-slate-700">
                                        <?= esc(
                                            $konten['pendidikan']
                                            ?? '-'
                                        ) ?>
                                    </strong>
                                </div>

                                <div>
                                    <span class="block text-xs text-slate-400">
                                        Jabatan
                                    </span>

                                    <strong class="mt-0.5 block font-medium text-slate-700">
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
                            <p class="mt-3 text-sm leading-6 text-slate-500">
                                <?= esc($isiRingkas) ?>
                            </p>
                        <?php endif; ?>

                        <div class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-2 border-t border-slate-100 pt-3 text-xs text-slate-400">
                            <span>
                                <i
                                    class="fa fa-sort-numeric-asc mr-1"
                                    aria-hidden="true"
                                ></i>

                                Urutan <?= (int) (
                                    $konten['urutan']
                                    ?? 0
                                ) ?>
                            </span>

                            <?php if (
                                $tipeUpload === 'file'
                                && ! empty($konten['isi'])
                            ): ?>
                                <a
                                    href="<?= esc(
                                        base_url(
                                            $konten['isi']
                                        ),
                                        'attr'
                                    ) ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="font-medium text-az-green hover:underline"
                                >
                                    <i
                                        class="fa fa-external-link mr-1"
                                        aria-hidden="true"
                                    ></i>

                                    Lihat file
                                </a>
                            <?php elseif (
                                $tipeUpload === 'image'
                            ): ?>
                                <span>
                                    <i
                                        class="fa fa-picture-o mr-1"
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
                </div>
            </article>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="rounded-xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center">
        <i
            class="fa fa-folder-open-o text-3xl text-slate-300"
            aria-hidden="true"
        ></i>

        <?php if ($bolehTambah): ?>
            <h3 class="mt-3 text-sm font-semibold text-slate-900">
                Belum ada data
            </h3>

            <p class="mt-1 text-sm text-slate-500">
                Tambahkan data pertama untuk halaman
                <?= esc($namaHalaman) ?>.
            </p>

            <a
                href="<?= $adminHalamanUrl(
                    $kodeHalaman,
                    'tambah'
                ) ?>"
                class="mt-4 inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-az-green px-4 text-sm font-medium text-white transition hover:bg-emerald-800"
            >
                <i
                    class="fa fa-plus"
                    aria-hidden="true"
                ></i>

                Tambah Data
            </a>
        <?php else: ?>
            <h3 class="mt-3 text-sm font-semibold text-slate-900">
                Bagian halaman belum tersedia
            </h3>

            <p class="mt-1 text-sm text-slate-500">
                Data awal untuk halaman ini belum ditemukan.
                Hubungi pengelola sistem untuk menyiapkannya.
            </p>
        <?php endif; ?>
    </div>
<?php endif; ?>