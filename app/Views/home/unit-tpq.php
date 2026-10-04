<?php

$kontenMap = $kontenMap ?? [];

$ambilKonten = static function (
    array $map,
    string $kode,
    array $fallback = []
): array {
    $data = $map[$kode] ?? [];

    $judul = trim(
        (string) ($data['judul'] ?? '')
    );

    $isi = trim(
        (string) ($data['isi'] ?? '')
    );

    $gambar = trim(
        (string) ($data['gambar'] ?? '')
    );

    return [
        'judul' => $judul !== ''
            ? $judul
            : (string) ($fallback['judul'] ?? ''),
        'isi' => $isi !== ''
            ? $isi
            : (string) ($fallback['isi'] ?? ''),
        'gambar' => $gambar !== ''
            ? $gambar
            : (string) ($fallback['gambar'] ?? ''),
    ];
};

$ambilGaleri = static function (
    array $map,
    callable $ambilKonten,
    array $fallback
): array {
    $hasil = [];

    foreach (
        $fallback
        as $kode => $dataFallback
    ) {
        $item = $ambilKonten(
            $map,
            $kode,
            $dataFallback
        );

        if (
            trim(
                (string) $item['gambar']
            ) === ''
        ) {
            continue;
        }

        $hasil[] = $item;
    }

    return $hasil;
};

$tpqDefault = 'Di TPQ Az-Zahra Perwira, kami percaya bahwa pendidikan Al-Qur\'an adalah fondasi utama dalam pembentukan karakter anak. Kami berperan penting dalam pembinaan akhlak anak, membimbing mereka tidak hanya untuk pandai membaca, tetapi juga memahami dan mengamalkan nilai-nilai luhur dalam kehidupan sehari-hari.

Proses pembelajaran kami dirancang dengan pendekatan yang menyentuh hati. Melalui cerita-cerita Islami yang inspiratif, nasihat yang bijak, serta pembiasaan ibadah sehari-hari, kami menanamkan nilai-nilai kebaikan seperti kejujuran, tanggung jawab, sopan santun, dan sikap saling menghormati. Kami menciptakan lingkungan belajar yang kondusif agar setiap anak merasa nyaman dalam berinteraksi dan tumbuh menjadi pribadi yang berakhlakul karimah.';

$rtqDefault = 'Rumah Tahfidz Quran (RTQ) Az-Zahra Perwira juga menyediakan ruang teduh bagi para santri untuk menitipkan hafalannya, menjaga bacaannya, dan memperdalam pemahamannya terhadap kalam Allah SWT.

Kami tidak hanya sekadar menargetkan kuantitas hafalan, tetapi lebih menitikberatkan pada kualitas bacaan (tahsin), ketepatan tajwid, dan internalisasi nilai-nilai Al-Qur\'an dalam akhlak sehari-hari. Didampingi oleh para pengajar yang kompeten di bidangnya, setiap santri dibimbing secara terstruktur sesuai dengan target Juz yang ditempuh, mulai dari Juz 30 hingga tahapan hafalan lanjutan lainnya.';

$judulHalaman = $ambilKonten(
    $kontenMap,
    'judul_halaman',
    [
        'judul' => 'TPQ-RTQ Az-Zahra Perwira',
    ]
);

$subjudulHalaman = $ambilKonten(
    $kontenMap,
    'subjudul_halaman',
    [
        'isi' => 'Membumikan Al-Qur\'an dalam Jiwa',
    ]
);

$tpq = $ambilKonten(
    $kontenMap,
    'tentang_tpq',
    [
        'judul' => 'Tentang TPQ (Taman Pendidikan Quran)',
        'isi' => $tpqDefault,
    ]
);

$rtq = $ambilKonten(
    $kontenMap,
    'tentang_rtq',
    [
        'judul' => 'Tentang RTQ (Rumah Tahfidz Quran)',
        'isi' => $rtqDefault,
    ]
);

$program = $ambilKonten(
    $kontenMap,
    'program_unit',
    [
        'judul' => 'Program Kelas',
    ]
);

$kegiatan = $ambilKonten(
    $kontenMap,
    'kegiatan_unit',
    [
        'judul' => 'Galeri Kegiatan',
    ]
);

$galeri = $ambilGaleri(
    $kontenMap,
    $ambilKonten,
    [
        'galeri_1' => [
            'judul' => 'Wisuda RTQ',
            'gambar' => 'assets/img/unit-tpq/tpq1.jpg',
        ],
        'galeri_2' => [
            'judul' => 'Lomba Ramadhan',
            'gambar' => 'assets/img/unit-tpq/tpq2.jpg',
        ],
        'galeri_3' => [
            'judul' => 'Murid RTQ',
            'gambar' => 'assets/img/unit-tpq/tpq3.jpg',
        ],
    ]
);
?>

<div id="divUtama">
    <div class="bg-az-green py-16">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                <?= esc(
                    $judulHalaman['judul']
                ) ?>
            </h1>

            <div class="text-az-gold text-lg italic">
                <?= konten_format(
                    $subjudulHalaman['isi']
                ) ?>
            </div>
        </div>
    </div>

    <main class="container mx-auto px-6 py-12 space-y-16">
        <section class="grid md:grid-cols-2 gap-12 items-start">
            <div>
                <h2 class="text-3xl font-bold text-az-green mb-6">
                    <?= esc(
                        $tpq['judul']
                    ) ?>
                </h2>

                <div class="text-gray-600 leading-relaxed text-justify">
                    <?= konten_format(
                        $tpq['isi']
                    ) ?>
                </div>

                <?php if (
                    $tpq['gambar'] !== ''
                ): ?>
                    <div class="mt-6 h-64 bg-slate-200 rounded-2xl overflow-hidden shadow-lg border-4 border-white">
                        <img
                            src="<?= esc(
                                base_url(
                                    $tpq['gambar']
                                ),
                                'attr'
                            ) ?>"
                            alt="<?= esc(
                                $tpq['judul'],
                                'attr'
                            ) ?>"
                            class="w-full h-full object-cover"
                        >
                    </div>
                <?php endif; ?>
            </div>

            <div>
                <h2 class="text-3xl font-bold text-az-green mb-6">
                    <?= esc(
                        $rtq['judul']
                    ) ?>
                </h2>

                <div class="text-gray-600 leading-relaxed text-justify">
                    <?= konten_format(
                        $rtq['isi']
                    ) ?>
                </div>

                <?php if (
                    $rtq['gambar'] !== ''
                ): ?>
                    <div class="mt-6 h-64 bg-slate-200 rounded-2xl overflow-hidden shadow-lg border-4 border-white">
                        <img
                            src="<?= esc(
                                base_url(
                                    $rtq['gambar']
                                ),
                                'attr'
                            ) ?>"
                            alt="<?= esc(
                                $rtq['judul'],
                                'attr'
                            ) ?>"
                            class="w-full h-full object-cover"
                        >
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <section class="py-8">
            <h3 class="text-3xl font-bold text-az-green mb-10 text-center">
                <?= esc(
                    $program['judul']
                ) ?>
            </h3>

            <?php if (
                $program['isi'] !== ''
            ): ?>
                <div class="bg-white p-8 rounded-2xl shadow-lg text-gray-600 leading-relaxed max-w-4xl mx-auto">
                    <?= konten_format(
                        $program['isi']
                    ) ?>
                </div>
            <?php else: ?>
                <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                    <div class="bg-white p-8 rounded-2xl border-t-4 border-az-green shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <h4 class="text-2xl font-bold text-az-green mb-2">
                            TPQ
                        </h4>

                        <p class="text-base text-gray-500 mb-6 font-medium">
                            Usia 3.5 - 15 Tahun
                        </p>

                        <div class="space-y-2">
                            <p class="text-lg font-semibold text-gray-800">
                                Senin - Kamis (17.00 - 18.30)
                            </p>

                            <p class="text-lg font-semibold text-gray-800">
                                Senin - Kamis (18.30 - 20.00)
                            </p>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-2xl border-t-4 border-az-green shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <h4 class="text-2xl font-bold text-az-green mb-2">
                            RTQ
                        </h4>

                        <p class="text-base text-gray-500 mb-6 font-medium">
                            Usia 3.5 - 15 Tahun
                        </p>

                        <div class="space-y-2">
                            <p class="text-lg font-semibold text-gray-800">
                                Sabtu (08.00 - 10.30 & 12.30 - 15.00)
                            </p>

                            <p class="text-lg font-semibold text-gray-800">
                                Ahad (08.00 - 10.30)
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </section>

        <section>
            <h3 class="text-2xl font-bold text-az-green mb-8 text-center">
                <?= esc(
                    $kegiatan['judul']
                ) ?>
            </h3>

            <?php if (
                $kegiatan['isi'] !== ''
            ): ?>
                <div class="bg-white p-8 rounded-2xl shadow-lg text-gray-600 leading-relaxed mb-8">
                    <?= konten_format(
                        $kegiatan['isi']
                    ) ?>
                </div>
            <?php endif; ?>

            <div class="grid md:grid-cols-3 gap-8">
                <?php foreach (
                    $galeri
                    as $item
                ): ?>
                    <div class="h-72 bg-slate-200 rounded-xl overflow-hidden shadow-md">
                        <img
                            src="<?= esc(
                                base_url(
                                    $item['gambar']
                                ),
                                'attr'
                            ) ?>"
                            alt="<?= esc(
                                $item['judul'],
                                'attr'
                            ) ?>"
                            class="w-full h-full object-cover"
                        >
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
</div>