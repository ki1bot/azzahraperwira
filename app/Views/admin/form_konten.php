<?php
$mode = $mode ?? 'tambah';
$konten = $konten ?? null;
$kodeHalaman = $kodeHalaman ?? '';
$namaHalaman = $namaHalaman ?? 'Halaman';
$namaBagian = $namaBagian ?? 'Konten';
$kodeDikunci = (bool) ($kodeDikunci ?? false);
$tipeUpload = $tipeUpload ?? 'none';

$isEdit = $mode === 'edit' && ! empty($konten);
$isTenagaPengajar = $kodeHalaman === 'tenaga-pengajar';
$isInformasi = $kodeHalaman === 'informasi';
$kodeKonten = (string) ($konten['kode_konten'] ?? '');
$pakaiIsiTeks = $tipeUpload !== 'file';

$adminFormUrl = static function (
    string $kodeHalaman,
    string $aksi,
    ?string $kodeKonten = null
): string {
    $url = 'admin/'
        . trim($kodeHalaman, '/')
        . '/'
        . trim($aksi, '/');

    if ($kodeKonten !== null && $kodeKonten !== '') {
        $url .= '/' . rawurlencode($kodeKonten);
    }

    return base_url($url . '/index.php');
};

$adminIndexUrl = static function (string $kodeHalaman): string {
    return base_url(
        'admin/' . trim($kodeHalaman, '/') . '/index.php'
    );
};

$action = $isEdit
    ? $adminFormUrl($kodeHalaman, 'update', $kodeKonten)
    : $adminFormUrl($kodeHalaman, 'simpan');

$judulForm = $isEdit
    ? 'Edit ' . $namaBagian
    : 'Tambah ' . $namaBagian;

$teksTombol = $isEdit
    ? 'Simpan Perubahan'
    : 'Tambahkan Data';

$judulWajib = ! $isEdit || ! $kodeDikunci;

$judulLabel = 'Judul';
$isiLabel = 'Isi Konten';
$isiPlaceholder = 'Masukkan isi konten';
$mediaLabel = 'Gambar';

if ($isTenagaPengajar && ! $kodeDikunci) {
    $judulLabel = 'Nama Pengajar';
    $isiLabel = 'Jabatan / Tugas';
    $isiPlaceholder = 'Contoh: Guru Tahfidz Juz 30';
    $mediaLabel = 'Foto Pengajar';
} elseif ($isInformasi && ! $kodeDikunci) {
    $judulLabel = 'Judul Informasi';
    $isiLabel = 'Isi Informasi';
    $isiPlaceholder = 'Tulis isi informasi atau berita';
    $mediaLabel = 'Gambar Informasi';
}

$inputClass = 'w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-az-green focus:ring-2 focus:ring-emerald-100';
$labelClass = 'mb-1.5 block text-sm font-medium text-slate-700';
$helpClass = 'mt-1.5 text-xs leading-5 text-slate-500';
$sectionClass = 'rounded-xl border border-slate-200 bg-white p-5 sm:p-6';
?>

<div class="mb-6 border-b border-slate-200 pb-6">
    <a
        href="<?= $adminIndexUrl($kodeHalaman) ?>"
        class="mb-4 inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-900"
    >
        <i class="fa fa-arrow-left" aria-hidden="true"></i>
        Kembali ke <?= esc($namaHalaman) ?>
    </a>

    <p class="text-sm font-medium text-az-green">
        <?= $isEdit ? 'Perbarui Data' : 'Data Baru' ?>
    </p>

    <h2 class="mt-1 text-2xl font-semibold tracking-tight text-slate-900">
        <?= esc($judulForm) ?>
    </h2>

    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
        <?php if ($kodeDikunci): ?>
            Bagian ini sudah terhubung dengan tampilan website. Ubah informasi yang diperlukan lalu simpan.
        <?php else: ?>
            Isi data di bawah ini. ID dan kode internal dibuat otomatis oleh sistem.
        <?php endif; ?>
    </p>
</div>

<form
    action="<?= esc($action, 'attr') ?>"
    method="post"
    enctype="multipart/form-data"
    class="space-y-5"
>
    <?= csrf_field() ?>

    <section class="<?= $sectionClass ?>">
        <div class="mb-5 border-b border-slate-100 pb-4">
            <h3 class="text-base font-semibold text-slate-900">
                Informasi Utama
            </h3>

            <p class="mt-1 text-sm text-slate-500">
                Isi informasi yang akan ditampilkan kepada pengunjung website.
            </p>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <?php if ($isTenagaPengajar && ! $kodeDikunci): ?>
                <div>
                    <label
                        for="kategori"
                        class="<?= $labelClass ?>"
                    >
                        Kategori Pengajar
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        name="kategori"
                        id="kategori"
                        class="<?= $inputClass ?>"
                        value="<?= esc(
                            old(
                                'kategori',
                                $konten['kategori'] ?? ''
                            ),
                            'attr'
                        ) ?>"
                        placeholder="Contoh: Pendidik Rumah Quran (RTQ)"
                        required
                    >

                    <p class="<?= $helpClass ?>">
                        Kategori digunakan untuk mengelompokkan pengajar pada halaman website.
                    </p>
                </div>

                <div>
                    <label
                        for="pendidikan"
                        class="<?= $labelClass ?>"
                    >
                        Pendidikan / Lulusan
                    </label>

                    <input
                        type="text"
                        name="pendidikan"
                        id="pendidikan"
                        class="<?= $inputClass ?>"
                        value="<?= esc(
                            old(
                                'pendidikan',
                                $konten['pendidikan'] ?? ''
                            ),
                            'attr'
                        ) ?>"
                        placeholder="Contoh: S1, S2, D2, Madrasah A’liyah"
                    >
                </div>
            <?php endif; ?>

            <div class="<?= $isTenagaPengajar && ! $kodeDikunci ? '' : 'sm:col-span-2' ?>">
                <label
                    for="judul"
                    class="<?= $labelClass ?>"
                >
                    <?= esc($judulLabel) ?>

                    <?php if ($judulWajib): ?>
                        <span class="text-red-500">*</span>
                    <?php endif; ?>
                </label>

                <input
                    type="text"
                    name="judul"
                    id="judul"
                    class="<?= $inputClass ?>"
                    value="<?= esc(
                        old(
                            'judul',
                            $konten['judul'] ?? ''
                        ),
                        'attr'
                    ) ?>"
                    placeholder="<?= esc(
                        $isTenagaPengajar && ! $kodeDikunci
                            ? 'Masukkan nama lengkap pengajar'
                            : (
                                $isInformasi && ! $kodeDikunci
                                    ? 'Masukkan judul informasi'
                                    : 'Masukkan judul jika bagian ini memerlukannya'
                            ),
                        'attr'
                    ) ?>"
                    <?= $judulWajib ? 'required' : '' ?>
                >

                <?php if (! $judulWajib): ?>
                    <p class="<?= $helpClass ?>">
                        Judul boleh dikosongkan jika bagian website ini hanya menggunakan isi teks.
                    </p>
                <?php endif; ?>
            </div>

            <?php if ($pakaiIsiTeks): ?>
                <div class="sm:col-span-2">
                    <div class="mb-1.5 flex flex-wrap items-center justify-between gap-2">
                        <label
                            for="isi"
                            class="text-sm font-medium text-slate-700"
                        >
                            <?= esc($isiLabel) ?>
                        </label>

                        <span class="text-xs text-slate-400">
                            Opsional jika bagian tidak memerlukan teks
                        </span>
                    </div>

                    <div
                        class="mb-2 flex flex-wrap gap-1 rounded-lg border border-slate-200 bg-slate-50 p-1.5"
                        data-editor-toolbar="isi"
                        aria-label="Format teks"
                    >
                        <button
                            type="button"
                            class="inline-flex h-8 items-center gap-1.5 rounded-md px-2.5 text-xs font-medium text-slate-600 hover:bg-white hover:text-slate-900"
                            data-format="bold"
                            title="Tebal"
                        >
                            <i class="fa fa-bold" aria-hidden="true"></i>
                            <span>Tebal</span>
                        </button>

                        <button
                            type="button"
                            class="inline-flex h-8 items-center gap-1.5 rounded-md px-2.5 text-xs font-medium text-slate-600 hover:bg-white hover:text-slate-900"
                            data-format="italic"
                            title="Miring"
                        >
                            <i class="fa fa-italic" aria-hidden="true"></i>
                            <span>Miring</span>
                        </button>

                        <button
                            type="button"
                            class="inline-flex h-8 items-center gap-1.5 rounded-md px-2.5 text-xs font-medium text-slate-600 hover:bg-white hover:text-slate-900"
                            data-format="underline"
                            title="Garis bawah"
                        >
                            <i class="fa fa-underline" aria-hidden="true"></i>
                            <span>Garis bawah</span>
                        </button>

                        <button
                            type="button"
                            class="inline-flex h-8 items-center gap-1.5 rounded-md px-2.5 text-xs font-medium text-slate-600 hover:bg-white hover:text-slate-900"
                            data-format="strike"
                            title="Coret"
                        >
                            <i class="fa fa-strikethrough" aria-hidden="true"></i>
                            <span>Coret</span>
                        </button>
                    </div>

                    <textarea
                        name="isi"
                        id="isi"
                        class="<?= $inputClass ?> min-h-44 resize-y leading-6"
                        placeholder="<?= esc(
                            $isiPlaceholder,
                            'attr'
                        ) ?>"
                    ><?= esc(
                        old(
                            'isi',
                            $konten['isi'] ?? ''
                        )
                    ) ?></textarea>

                    <p class="<?= $helpClass ?>">
                        Tombol format membantu menandai teks tebal, miring, garis bawah, atau coret.
                    </p>
                </div>
            <?php else: ?>
                <input
                    type="hidden"
                    name="isi"
                    value="<?= esc(
                        old(
                            'isi',
                            $konten['isi'] ?? ''
                        ),
                        'attr'
                    ) ?>"
                >
            <?php endif; ?>
        </div>
    </section>

    <?php if ($tipeUpload === 'image'): ?>
        <section class="<?= $sectionClass ?>">
            <div class="mb-5 border-b border-slate-100 pb-4">
                <h3 class="text-base font-semibold text-slate-900">
                    <?= esc($mediaLabel) ?>
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Gunakan JPG, JPEG, PNG, atau WebP dengan ukuran maksimal 5 MB.
                </p>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label
                        for="gambar"
                        class="<?= $labelClass ?>"
                    >
                        <?= esc($mediaLabel) ?>
                    </label>

                    <label
                        for="gambar"
                        class="flex min-h-28 cursor-pointer items-center gap-3 rounded-lg border border-dashed border-slate-300 bg-slate-50 p-4 hover:border-az-green hover:bg-emerald-50/40"
                    >
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white text-az-green shadow-sm">
                            <i
                                class="fa fa-cloud-upload"
                                aria-hidden="true"
                            ></i>
                        </span>

                        <span class="min-w-0">
                            <strong class="block text-sm font-medium text-slate-700">
                                Pilih gambar dari perangkat
                            </strong>

                            <small
                                id="gambarFileName"
                                class="mt-1 block truncate text-xs text-slate-500"
                            >
                                Belum ada file baru dipilih
                            </small>
                        </span>
                    </label>

                    <input
                        type="file"
                        name="gambar"
                        id="gambar"
                        class="hidden"
                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                        data-file-name-target="gambarFileName"
                        data-image-preview="gambarPreview"
                    >

                    <p class="<?= $helpClass ?>">
                        Saat edit, gambar lama tetap digunakan jika Anda tidak memilih gambar baru.
                    </p>
                </div>

                <div>
                    <span class="<?= $labelClass ?>">
                        Pratinjau
                    </span>

                    <div
                        id="gambarPreview"
                        class="flex min-h-48 items-center justify-center overflow-hidden rounded-lg border border-slate-200 bg-slate-50 p-3"
                    >
                        <?php if (! empty($konten['gambar'])): ?>
                            <img
                                src="<?= esc(
                                    base_url($konten['gambar']),
                                    'attr'
                                ) ?>"
                                alt="<?= esc(
                                    $konten['judul']
                                    ?? $namaBagian,
                                    'attr'
                                ) ?>"
                                class="h-full max-h-80 w-full rounded-lg object-contain"
                            >
                        <?php else: ?>
                            <div class="text-center text-slate-400">
                                <i
                                    class="fa fa-picture-o text-3xl"
                                    aria-hidden="true"
                                ></i>

                                <span class="mt-2 block text-xs">
                                    Belum ada gambar
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($tipeUpload === 'file'): ?>
        <section class="<?= $sectionClass ?>">
            <div class="mb-5 border-b border-slate-100 pb-4">
                <h3 class="text-base font-semibold text-slate-900">
                    File Brosur
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Gunakan file PDF dengan ukuran maksimal 10 MB.
                </p>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label
                        for="file_dokumen"
                        class="flex min-h-28 cursor-pointer items-center gap-3 rounded-lg border border-dashed border-slate-300 bg-slate-50 p-4 hover:border-az-green hover:bg-emerald-50/40"
                    >
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white text-az-green shadow-sm">
                            <i
                                class="fa fa-cloud-upload"
                                aria-hidden="true"
                            ></i>
                        </span>

                        <span class="min-w-0">
                            <strong class="block text-sm font-medium text-slate-700">
                                Pilih file PDF
                            </strong>

                            <small
                                id="dokumenFileName"
                                class="mt-1 block truncate text-xs text-slate-500"
                            >
                                Belum ada file baru dipilih
                            </small>
                        </span>
                    </label>

                    <input
                        type="file"
                        name="file_dokumen"
                        id="file_dokumen"
                        class="hidden"
                        accept="application/pdf,.pdf"
                        data-file-name-target="dokumenFileName"
                    >

                    <p class="<?= $helpClass ?>">
                        Saat edit, file lama tetap digunakan jika Anda tidak memilih file baru.
                    </p>
                </div>

                <div class="flex min-h-28 items-center gap-3 rounded-lg border border-slate-200 bg-slate-50 p-4">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-50 text-red-500">
                        <i
                            class="fa fa-file-pdf-o"
                            aria-hidden="true"
                        ></i>
                    </span>

                    <div>
                        <span class="block text-xs text-slate-400">
                            File saat ini
                        </span>

                        <?php if (! empty($konten['isi'])): ?>
                            <strong class="mt-1 block text-sm font-medium text-slate-800">
                                Brosur tersedia
                            </strong>

                            <a
                                href="<?= esc(
                                    base_url($konten['isi']),
                                    'attr'
                                ) ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="mt-1 inline-flex items-center gap-1.5 text-xs font-medium text-az-green hover:underline"
                            >
                                Buka file

                                <i
                                    class="fa fa-external-link"
                                    aria-hidden="true"
                                ></i>
                            </a>
                        <?php else: ?>
                            <strong class="mt-1 block text-sm font-medium text-slate-700">
                                Belum ada file
                            </strong>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="<?= $sectionClass ?>">
        <div class="mb-5 border-b border-slate-100 pb-4">
            <h3 class="text-base font-semibold text-slate-900">
                Pengaturan Tampilan
            </h3>

            <p class="mt-1 text-sm text-slate-500">
                Atur posisi dan status data pada website.
            </p>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label
                    for="urutan"
                    class="<?= $labelClass ?>"
                >
                    Urutan Tampil
                </label>

                <input
                    type="number"
                    name="urutan"
                    id="urutan"
                    class="<?= $inputClass ?>"
                    value="<?= esc(
                        old(
                            'urutan',
                            $konten['urutan'] ?? ''
                        ),
                        'attr'
                    ) ?>"
                    min="0"
                    placeholder="Otomatis"
                >

                <p class="<?= $helpClass ?>">
                    Angka lebih kecil tampil lebih dulu. Saat menambah data, kosongkan agar sistem menaruhnya di urutan terakhir.
                </p>
            </div>

            <div>
                <label
                    for="status"
                    class="<?= $labelClass ?>"
                >
                    Status Tampil
                </label>

                <?php
                $status = old(
                    'status',
                    $konten['status'] ?? 'aktif'
                );
                ?>

                <select
                    name="status"
                    id="status"
                    class="<?= $inputClass ?>"
                    required
                >
                    <option
                        value="aktif"
                        <?= $status === 'aktif' ? 'selected' : '' ?>
                    >
                        Aktif - tampil di website
                    </option>

                    <option
                        value="nonaktif"
                        <?= $status === 'nonaktif' ? 'selected' : '' ?>
                    >
                        Nonaktif - disembunyikan sementara
                    </option>
                </select>
            </div>
        </div>
    </section>

    <div class="sticky bottom-3 z-20 flex justify-end gap-2 rounded-xl border border-slate-200 bg-white/95 p-3 shadow-lg backdrop-blur">
        <a
            href="<?= $adminIndexUrl($kodeHalaman) ?>"
            class="inline-flex h-10 items-center justify-center rounded-lg border border-slate-300 bg-white px-4 text-sm font-medium text-slate-700 hover:bg-slate-50"
        >
            Batal
        </a>

        <button
            type="submit"
            class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-az-green px-4 text-sm font-medium text-white hover:bg-emerald-800"
        >
            <i
                class="fa fa-floppy-o"
                aria-hidden="true"
            ></i>

            <?= esc($teksTombol) ?>
        </button>
    </div>
</form>