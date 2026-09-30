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

$adminIndexUrl = static function (
    string $kodeHalaman
): string {
    return base_url(
        'admin/' . trim($kodeHalaman, '/') . '/index.php'
    );
};

$action = $isEdit
    ? $adminFormUrl(
        $kodeHalaman,
        'update',
        $kodeKonten
    )
    : $adminFormUrl(
        $kodeHalaman,
        'simpan'
    );

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
?>

<div class="form-page-head">
    <a
        href="<?= $adminIndexUrl($kodeHalaman) ?>"
        class="back-link"
    >
        <i class="fa fa-arrow-left" aria-hidden="true"></i>
        Kembali ke <?= esc($namaHalaman) ?>
    </a>

    <div class="section-heading">
        <span class="section-kicker">
            <?= $isEdit ? 'Perbarui Data' : 'Data Baru' ?>
        </span>

        <h2><?= esc($judulForm) ?></h2>

        <p>
            <?php if ($kodeDikunci): ?>
                Bagian ini sudah terhubung dengan tampilan website.
                Anda cukup mengubah isi yang diperlukan lalu simpan.
            <?php else: ?>
                Isi data di bawah ini. ID dan kode internal dibuat
                otomatis oleh sistem, jadi tidak perlu diisi secara manual.
            <?php endif; ?>
        </p>
    </div>
</div>

<form
    action="<?= esc($action, 'attr') ?>"
    method="post"
    enctype="multipart/form-data"
    class="admin-form"
>
    <section class="form-section">
        <div class="form-section-head">
            <span class="form-section-icon">
                <i
                    class="fa fa-pencil-square-o"
                    aria-hidden="true"
                ></i>
            </span>

            <div>
                <h3>Informasi Utama</h3>
                <p>
                    Isi informasi yang akan ditampilkan kepada
                    pengunjung website.
                </p>
            </div>
        </div>

        <div class="form-grid">
            <?php if (
                $isTenagaPengajar
                && ! $kodeDikunci
            ): ?>
                <div class="form-group">
                    <label
                        for="kategori"
                        class="form-label"
                    >
                        Kategori Pengajar
                        <span class="required-mark">*</span>
                    </label>

                    <input
                        type="text"
                        name="kategori"
                        id="kategori"
                        class="form-control"
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

                    <div class="form-help">
                        Kategori digunakan untuk mengelompokkan
                        pengajar pada halaman website.
                    </div>
                </div>

                <div class="form-group">
                    <label
                        for="pendidikan"
                        class="form-label"
                    >
                        Pendidikan / Lulusan
                    </label>

                    <input
                        type="text"
                        name="pendidikan"
                        id="pendidikan"
                        class="form-control"
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

            <div
                class="form-group <?= $isTenagaPengajar
                    && ! $kodeDikunci
                    ? ''
                    : 'full'
                ?>"
            >
                <label
                    for="judul"
                    class="form-label"
                >
                    <?= esc($judulLabel) ?>

                    <?php if ($judulWajib): ?>
                        <span class="required-mark">*</span>
                    <?php endif; ?>
                </label>

                <input
                    type="text"
                    name="judul"
                    id="judul"
                    class="form-control"
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
                    <div class="form-help">
                        Judul boleh dikosongkan jika bagian website
                        ini hanya menggunakan isi teks.
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($pakaiIsiTeks): ?>
                <div class="form-group full">
                    <div class="label-row">
                        <label
                            for="isi"
                            class="form-label"
                        >
                            <?= esc($isiLabel) ?>
                        </label>

                        <span class="optional-text">
                            Opsional jika bagian tidak memerlukan teks
                        </span>
                    </div>

                    <div
                        class="editor-toolbar"
                        data-editor-toolbar="isi"
                        aria-label="Format teks"
                    >
                        <button
                            type="button"
                            class="editor-button"
                            data-format="bold"
                            title="Tebal"
                        >
                            <i class="fa fa-bold" aria-hidden="true"></i>
                            <span>Tebal</span>
                        </button>

                        <button
                            type="button"
                            class="editor-button"
                            data-format="italic"
                            title="Miring"
                        >
                            <i class="fa fa-italic" aria-hidden="true"></i>
                            <span>Miring</span>
                        </button>

                        <button
                            type="button"
                            class="editor-button"
                            data-format="underline"
                            title="Garis bawah"
                        >
                            <i
                                class="fa fa-underline"
                                aria-hidden="true"
                            ></i>
                            <span>Garis bawah</span>
                        </button>

                        <button
                            type="button"
                            class="editor-button"
                            data-format="strike"
                            title="Coret"
                        >
                            <i
                                class="fa fa-strikethrough"
                                aria-hidden="true"
                            ></i>
                            <span>Coret</span>
                        </button>
                    </div>

                    <textarea
                        name="isi"
                        id="isi"
                        class="form-control form-textarea"
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

                    <div class="form-help">
                        Gunakan tombol format jika ingin menebalkan,
                        memiringkan, memberi garis bawah, atau mencoret
                        teks tertentu.
                    </div>
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
        <section class="form-section">
            <div class="form-section-head">
                <span class="form-section-icon">
                    <i
                        class="fa fa-picture-o"
                        aria-hidden="true"
                    ></i>
                </span>

                <div>
                    <h3><?= esc($mediaLabel) ?></h3>
                    <p>
                        Pilih JPG, JPEG, atau PNG dengan ukuran
                        maksimal 5 MB.
                    </p>
                </div>
            </div>

            <div class="media-form-grid">
                <div class="form-group">
                    <label
                        for="gambar"
                        class="form-label"
                    >
                        <?= esc($mediaLabel) ?>
                    </label>

                    <label
                        class="file-picker"
                        for="gambar"
                    >
                        <span class="file-picker-icon">
                            <i
                                class="fa fa-cloud-upload"
                                aria-hidden="true"
                            ></i>
                        </span>

                        <span class="file-picker-copy">
                            <strong>
                                Pilih gambar dari perangkat
                            </strong>
                            <small id="gambarFileName">
                                Belum ada file baru dipilih
                            </small>
                        </span>
                    </label>

                    <input
                        type="file"
                        name="gambar"
                        id="gambar"
                        class="file-input-hidden"
                        accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                        data-file-name-target="gambarFileName"
                        data-image-preview="gambarPreview"
                    >

                    <div class="form-help">
                        Jika tidak memilih gambar baru saat edit,
                        gambar lama tetap digunakan.
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Pratinjau
                    </label>

                    <div
                        class="media-preview-box"
                        id="gambarPreview"
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
                                class="preview-img"
                            >
                        <?php else: ?>
                            <div class="media-preview-empty">
                                <i
                                    class="fa fa-picture-o"
                                    aria-hidden="true"
                                ></i>
                                <span>Belum ada gambar</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($tipeUpload === 'file'): ?>
        <section class="form-section">
            <div class="form-section-head">
                <span class="form-section-icon">
                    <i
                        class="fa fa-file-pdf-o"
                        aria-hidden="true"
                    ></i>
                </span>

                <div>
                    <h3>File Brosur</h3>
                    <p>
                        Gunakan file PDF dengan ukuran maksimal 10 MB.
                    </p>
                </div>
            </div>

            <div class="media-form-grid">
                <div class="form-group">
                    <label
                        class="file-picker"
                        for="file_dokumen"
                    >
                        <span class="file-picker-icon">
                            <i
                                class="fa fa-cloud-upload"
                                aria-hidden="true"
                            ></i>
                        </span>

                        <span class="file-picker-copy">
                            <strong>Pilih file PDF</strong>
                            <small id="dokumenFileName">
                                Belum ada file baru dipilih
                            </small>
                        </span>
                    </label>

                    <input
                        type="file"
                        name="file_dokumen"
                        id="file_dokumen"
                        class="file-input-hidden"
                        accept="application/pdf,.pdf"
                        data-file-name-target="dokumenFileName"
                    >

                    <div class="form-help">
                        Jika tidak memilih file baru saat edit,
                        file lama tetap digunakan.
                    </div>
                </div>

                <div class="current-file-card">
                    <span class="current-file-icon">
                        <i
                            class="fa fa-file-pdf-o"
                            aria-hidden="true"
                        ></i>
                    </span>

                    <div>
                        <span>File saat ini</span>

                        <?php if (! empty($konten['isi'])): ?>
                            <strong>Brosur tersedia</strong>

                            <a
                                href="<?= esc(
                                    base_url($konten['isi']),
                                    'attr'
                                ) ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                Buka file
                                <i
                                    class="fa fa-external-link"
                                    aria-hidden="true"
                                ></i>
                            </a>
                        <?php else: ?>
                            <strong>Belum ada file</strong>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="form-section">
        <div class="form-section-head">
            <span class="form-section-icon">
                <i
                    class="fa fa-sliders"
                    aria-hidden="true"
                ></i>
            </span>

            <div>
                <h3>Pengaturan Tampilan</h3>
                <p>
                    Atur posisi dan status data pada website.
                </p>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label
                    for="urutan"
                    class="form-label"
                >
                    Urutan Tampil
                </label>

                <input
                    type="number"
                    name="urutan"
                    id="urutan"
                    class="form-control"
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

                <div class="form-help">
                    Angka lebih kecil tampil lebih dulu.
                    Kosongkan saat menambah data agar sistem
                    menempatkannya otomatis di urutan terakhir.
                </div>
            </div>

            <div class="form-group">
                <label
                    for="status"
                    class="form-label"
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
                    class="form-control"
                    required
                >
                    <option
                        value="aktif"
                        <?= $status === 'aktif'
                            ? 'selected'
                            : ''
                        ?>
                    >
                        Aktif - tampil di website
                    </option>

                    <option
                        value="nonaktif"
                        <?= $status === 'nonaktif'
                            ? 'selected'
                            : ''
                        ?>
                    >
                        Nonaktif - disembunyikan sementara
                    </option>
                </select>
            </div>
        </div>
    </section>

    <div class="form-actions form-actions-sticky">
        <a
            href="<?= $adminIndexUrl($kodeHalaman) ?>"
            class="btn btn-secondary"
        >
            Batal
        </a>

        <button
            type="submit"
            class="btn btn-primary"
        >
            <i
                class="fa fa-floppy-o"
                aria-hidden="true"
            ></i>
            <?= esc($teksTombol) ?>
        </button>
    </div>
</form>