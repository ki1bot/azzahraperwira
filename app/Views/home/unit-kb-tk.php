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

$teksTentangDefault = 'Masa usia dini adalah periode yang paling menentukan dalam kehidupan seseorang—sebuah golden age di mana setiap detik adalah kesempatan untuk menanamkan nilai-nilai kebaikan yang akan tumbuh menjadi karakter kokoh di masa depan.

Di KB-TK Az-Zahra Perwira, kami tidak sekadar mengajar; kami membersamai tumbuh kembang anak-anak dalam lingkungan yang penuh dengan kasih sayang, kegembiraan, dan nilai-nilai Islami yang kental.

Kami memahami bahwa setiap anak adalah individu unik yang memiliki potensi luar biasa. Oleh karena itu, kurikulum kami dirancang untuk mengintegrasikan ajaran Islam dalam seluruh aspek kegiatan. Kami berkomitmen untuk membentuk fondasi karakter dan keimanan anak sejak dini, memastikan bahwa proses belajar di sekolah sejalan dengan kurikulum pendidikan dan pembiasaan baik di rumah.';

$judulHalaman = $ambilKonten(
    $kontenMap,
    'judul_halaman',
    [
        'judul' => 'KB-TK Az-Zahra Perwira',
    ]
);

$subjudulHalaman = $ambilKonten(
    $kontenMap,
    'subjudul_halaman',
    [
        'isi' => 'Membangun Fondasi Karakter dan Keimanan Sejak Dini',
    ]
);

$tentang = $ambilKonten(
    $kontenMap,
    'tentang_unit',
    [
        'judul' => 'Tentang KB-TK',
        'isi' => $teksTentangDefault,
        'gambar' => 'assets/img/unit-kb-tk/kelas.png',
    ]
);

$program = $ambilKonten(
    $kontenMap,
    'program_unit',
    [
        'judul' => 'Program Kelas',
    ]
);

$fasilitas = $ambilKonten(
    $kontenMap,
    'fasilitas_unit',
    [
        'judul' => 'Pilar Pendidikan: Taqwa - Cerdas - Terampil',
    ]
);

$ekskul = $ambilKonten(
    $kontenMap,
    'ekstrakurikuler',
    [
        'judul' => 'Kegiatan Ekstrakurikuler',
    ]
);

$galeri = $ambilGaleri(
    $kontenMap,
    $ambilKonten,
    [
        'galeri_1' => [
            'judul' => 'Drumband',
            'gambar' => 'assets/img/unit-kb-tk/drumband.jpg',
        ],
        'galeri_2' => [
            'judul' => 'Menari',
            'gambar' => 'assets/img/unit-kb-tk/menari.png',
        ],
        'galeri_3' => [
            'judul' => 'Kegiatan KB-TK',
            'gambar' => 'assets/img/unit-kb-tk/kelas.png',
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
                        $tentang['judul']
                    ) ?>
                </h2>

                <div class="text-gray-600 leading-relaxed text-justify">
                    <?= konten_format(
                        $tentang['isi']
                    ) ?>
                </div>
            </div>

            <div class="h-80 w-full bg-slate-200 rounded-2xl overflow-hidden shadow-lg border-4 border-white">
                <img
                    src="<?= esc(
                        base_url(
                            $tentang['gambar']
                        ),
                        'attr'
                    ) ?>"
                    alt="<?= esc(
                        $tentang['judul'],
                        'attr'
                    ) ?>"
                    class="w-full h-full object-cover"
                >
            </div>
        </section>

        <section>
            <h3 class="text-2xl font-bold text-az-green mb-8 text-center">
                <?= esc(
                    $program['judul']
                ) ?>
            </h3>

            <?php if (
                $program['isi'] !== ''
            ): ?>
                <div class="bg-white p-8 rounded-xl shadow-md text-gray-600 leading-relaxed">
                    <?= konten_format(
                        $program['isi']
                    ) ?>
                </div>
            <?php else: ?>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-xl border-t-4 border-az-green shadow-md">
                        <h4 class="text-xl font-bold text-az-green">
                            KB
                        </h4>

                        <p class="text-sm text-gray-500 mb-2">
                            Usia 3.5 - 4 Tahun
                        </p>

                        <p class="text-sm font-semibold">
                            Senin - Kamis (07.30 - 10.00)
                        </p>
                    </div>

                    <div class="bg-white p-6 rounded-xl border-t-4 border-az-green shadow-md">
                        <h4 class="text-xl font-bold text-az-green">
                            TK A
                        </h4>

                        <p class="text-sm text-gray-500 mb-2">
                            Usia 4.5 - 5 Tahun
                        </p>

                        <p class="text-sm font-semibold">
                            Senin - Jum'at (07.00 - 11.00)
                        </p>
                    </div>

                    <div class="bg-white p-6 rounded-xl border-t-4 border-az-green shadow-md">
                        <h4 class="text-xl font-bold text-az-green">
                            TK B
                        </h4>

                        <p class="text-sm text-gray-500 mb-2">
                            Usia 5.5 - 6 Tahun
                        </p>

                        <p class="text-sm font-semibold">
                            Senin - Jum'at (07.00 - 11.30)
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </section>

        <section class="bg-az-green text-white p-8 md:p-12 rounded-3xl">
            <h3 class="text-3xl font-bold text-az-gold mb-10 text-center">
                <?= esc(
                    $fasilitas['judul']
                ) ?>
            </h3>

            <?php if (
                $fasilitas['isi'] !== ''
            ): ?>
                <div class="text-gray-200 leading-relaxed text-center max-w-4xl mx-auto">
                    <?= konten_format(
                        $fasilitas['isi']
                    ) ?>
                </div>
            <?php else: ?>
                <div class="grid md:grid-cols-3 gap-8">
                    <div>
                        <h4 class="text-xl font-bold mb-2">
                            TAQWA
                        </h4>

                        <p class="text-sm text-gray-200">
                            Berfokus pada pembentukan karakter spiritual dan moral anak agar tumbuh menjadi pribadi yang beriman dan berakhlak mulia.
                        </p>
                    </div>

                    <div>
                        <h4 class="text-xl font-bold mb-2">
                            CERDAS
                        </h4>

                        <p class="text-sm text-gray-200">
                            Mengacu pada pengembangan kemampuan kognitif atau daya pikir anak agar memiliki pondasi kuat untuk berpikir kritis dan memecahkan masalah.
                        </p>
                    </div>

                    <div>
                        <h4 class="text-xl font-bold mb-2">
                            TERAMPIL
                        </h4>

                        <p class="text-sm text-gray-200">
                            Menekankan pada pengembangan kemampuan fisik dan motorik anak agar memiliki keterampilan praktis yang bermanfaat dan mandiri.
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </section>

        <section class="space-y-8">
            <div class="bg-white p-8 rounded-xl border-2 border-dashed border-az-gold">
                <h4 class="text-xl font-bold text-az-green mb-4">
                    <?= esc(
                        $ekskul['judul']
                    ) ?>
                </h4>

                <?php if (
                    $ekskul['isi'] !== ''
                ): ?>
                    <div class="text-gray-600 leading-relaxed">
                        <?= konten_format(
                            $ekskul['isi']
                        ) ?>
                    </div>
                <?php else: ?>
                    <ul class="list-disc pl-5 text-gray-600 space-y-2">
                        <li>Tahfizh Juz 30</li>
                        <li>Drumband</li>
                        <li>Futsal</li>
                        <li>Menari</li>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <?php foreach (
                    $galeri
                    as $item
                ): ?>
                    <div class="h-64 bg-slate-200 rounded-xl overflow-hidden shadow-md">
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