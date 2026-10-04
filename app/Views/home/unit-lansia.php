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

$tentangDefault = 'Masa senja adalah anugerah terindah jika diisi dengan ketenangan hati dan kedekatan dengan Sang Pencipta. Di Pondok Lansia dan Majelis Ta\'lim Az-Zahra Perwira, kami menyediakan ruang bagi para orang tua untuk menikmati masa emasnya dalam lingkungan yang penuh kekeluargaan, kesantunan, dan suasana islami yang teduh.

Kami memahami bahwa di usia ini, kebutuhan akan komunitas yang suportif dan ruang untuk terus belajar agama menjadi sangat krusial. Oleh karena itu, kami menghadirkan program yang dirancang khusus untuk menjaga kesehatan jiwa, memperluas wawasan keislaman, serta mempererat tali silaturahmi antar jamaah. Di sini, setiap tawa, setiap doa, dan setiap untaian ayat Al-Qur\'an menjadi sarana untuk menjemput ridho-Nya di sisa usia yang berharga.';

$judulHalaman = $ambilKonten(
    $kontenMap,
    'judul_halaman',
    [
        'judul' => 'Pondok Tahfidz Lansia dan Majelis Ta\'lim',
    ]
);

$subjudulHalaman = $ambilKonten(
    $kontenMap,
    'subjudul_halaman',
    [
        'isi' => 'Menapaki Usia Senja dengan Hati yang Terpaut pada Allah',
    ]
);

$tentang = $ambilKonten(
    $kontenMap,
    'tentang_unit',
    [
        'judul' => 'Tentang Unit Lansia dan Mejelis Ta\'lim',
        'isi' => $tentangDefault,
        'gambar' => 'assets/img/unit-lansia/kegiatan0.jpg',
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
            'judul' => 'Kegiatan Lansia 1',
            'gambar' => 'assets/img/unit-lansia/kegiatan1.jpg',
        ],
        'galeri_2' => [
            'judul' => 'Kegiatan Lansia 2',
            'gambar' => 'assets/img/unit-lansia/kegiatan2.jpg',
        ],
        'galeri_3' => [
            'judul' => 'Kegiatan Lansia 3',
            'gambar' => 'assets/img/unit-lansia/kegiatan3.jpg',
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

        <section class="py-8">
            <h3 class="text-3xl font-bold text-az-green mb-10 text-center">
                <?= esc(
                    $program['judul']
                ) ?>
            </h3>

            <?php if (
                $program['isi'] !== ''
            ): ?>
                <div class="bg-white p-8 rounded-2xl shadow-lg text-gray-600 leading-relaxed max-w-3xl mx-auto">
                    <?= konten_format(
                        $program['isi']
                    ) ?>
                </div>
            <?php else: ?>
                <div class="grid md:grid-cols-1 gap-4 max-w-lg mx-auto">
                    <div class="bg-white p-8 rounded-2xl border-t-4 border-az-green shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <h4 class="text-2xl font-bold text-az-green mb-2">
                            Pondok Tahfidz Lansia
                        </h4>

                        <p class="text-base text-gray-500 mb-6 font-medium">
                            Usia &gt; 25 Tahun
                        </p>

                        <div class="space-y-2">
                            <p class="text-lg font-semibold text-gray-800">
                                Rabu (18.00 - selesai)
                            </p>

                            <p class="text-lg font-semibold text-gray-800">
                                Sabtu (08.00 - 10.00)
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