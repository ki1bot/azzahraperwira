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

$teksProfilDefault = 'Sejak berdiri pada tahun 1998, Yayasan Az-Zahra Perwira telah tumbuh menjadi pilar pendidikan yang berdedikasi di wilayah Bekasi Utara. Langkah formal kami semakin kokoh dengan diterbitkannya izin operasional pendidikan pada tahun 2009, yang menjadi tonggak dimulainya perjalanan KB-TK Az-Zahra Perwira dalam memberikan bimbingan bagi anak usia dini.

Dedikasi kami untuk menghadirkan standar pendidikan terbaik telah diakui melalui predikat akreditasi "A". Pencapaian ini merupakan amanah yang terus kami jaga dan perbarui hingga tahun 2027, sebagai wujud komitmen kami dalam memberikan layanan pendidikan yang berkualitas.

Lahir dari kepekaan terhadap dinamika sosial dan demografi warga di RW 012 Kelurahan Perwira, kami tergerak untuk menghadirkan wadah bagi generasi penerus. Kami percaya bahwa pendidikan bukan sekadar transfer ilmu, melainkan upaya membentuk pemimpin bangsa yang berakhlakul karimah. Dengan penuh ikhtiar, kami terus membimbing setiap anak agar tumbuh menjadi pribadi yang bertaqwa, cerdas, dan terampil, sebagai bekal meraih kebahagiaan hidup di dunia dan akhirat.';

$judulHalaman = $ambilKonten(
    $kontenMap,
    'judul_halaman',
    [
        'judul' => 'Profil Yayasan',
    ]
);

$subjudulHalaman = $ambilKonten(
    $kontenMap,
    'subjudul_halaman',
    [
        'isi' => 'Mengenal lebih dekat Yayasan Az-Zahra Perwira',
    ]
);

$profilYayasan = $ambilKonten(
    $kontenMap,
    'profil_yayasan',
    [
        'judul' => 'Tentang Kami',
        'isi' => $teksProfilDefault,
        'gambar' => 'assets/img/home/home3.jpg',
    ]
);

$visiMisi = $ambilKonten(
    $kontenMap,
    'visi_misi',
    [
        'judul' => 'Visi',
        'isi' => '"Menciptakan Generasi yang Taqwa, Cerdas, Terampil, Mandiri dengan bimbingan kasih sayang untuk menggapai kebahagian hidup di dunia & akhirat"',
    ]
);

$misi = $ambilKonten(
    $kontenMap,
    'misi',
    [
        'judul' => 'Misi',
    ]
);

$struktur = $ambilKonten(
    $kontenMap,
    'struktur_organisasi',
    [
        'judul' => 'Struktur Organisasi',
        'isi' => '*Diagram struktur organisasi ini resmi dan berlaku per tanggal saat ini.',
        'gambar' => 'assets/img/profile/struktur-organisasi.png',
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

    <main class="container mx-auto px-6 py-12 space-y-20">
        <section class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-az-green mb-6">
                    <?= esc(
                        $profilYayasan['judul']
                    ) ?>
                </h2>

                <div class="text-gray-600 leading-relaxed text-justify">
                    <?= konten_format(
                        $profilYayasan['isi']
                    ) ?>
                </div>
            </div>

            <div class="rounded-2xl overflow-hidden shadow-xl">
                <img
                    src="<?= esc(
                        base_url(
                            $profilYayasan['gambar']
                        ),
                        'attr'
                    ) ?>"
                    alt="<?= esc(
                        $profilYayasan['judul'],
                        'attr'
                    ) ?>"
                    class="w-full h-auto"
                >
            </div>
        </section>

        <section class="grid md:grid-cols-2 gap-8">
            <div class="bg-white p-8 rounded-xl shadow-md border-t-4 border-az-gold">
                <h3 class="text-2xl font-bold text-az-green mb-4">
                    <i class="fas fa-eye mr-2"></i><?= esc(
                        $visiMisi['judul']
                    ) ?>
                </h3>

                <div class="text-gray-700 italic text-lg">
                    <?= konten_format(
                        $visiMisi['isi']
                    ) ?>
                </div>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-md border-t-4 border-az-green">
                <h3 class="text-2xl font-bold text-az-green mb-4">
                    <i class="fas fa-bullseye mr-2"></i><?= esc(
                        $misi['judul']
                    ) ?>
                </h3>

                <div class="space-y-3 text-gray-700 leading-relaxed">
                    <?php if (
                        $misi['isi'] !== ''
                    ): ?>
                        <?= konten_format(
                            $misi['isi']
                        ) ?>
                    <?php else: ?>
                        <ul class="space-y-3 text-gray-700 list-disc pl-5">
                            <li>
                                Menyiapkan lingkungan belajar yang menumbuhkan keimanan dan ketakwaan pada Allah SWT.
                            </li>

                            <li>
                                Mengajarkan peserta didik untuk terbiasa menghafal Juz 30 membaca Iqro/Al-Quran dengan baik dan benar.
                            </li>

                            <li>
                                Menyiapkan Peserta Didik yang Taqwa, Cerdas, Terampil, Mandiri dan Berkepribadian melalui terciptanya Pelajar Pancasila dengan bimbingan kasih sayang.
                            </li>

                            <li>
                                Membiasakan peserta didik mengamalkan kalimat thayyibah, doa harian, mengikuti perilaku Rasulullah dalam hadist dan pembiasaan shalat yang benar.
                            </li>

                            <li>
                                Menghasilkan anak didik yang berkepribadian mantap dan unggul yaitu seimbang antara EQ, SQ, dan IQ.
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section class="py-2 bg-slate-50">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl font-bold text-az-green text-center mb-8 relative">
                    <?= esc(
                        $struktur['judul']
                    ) ?>

                    <span class="absolute bottom-[-15px] left-1/2 transform -translate-x-1/2 w-20 h-1 bg-az-gold rounded"></span>
                </h2>

                <div class="max-w-5xl mx-auto bg-white p-8 rounded-3xl shadow-2xl border-2 border-dashed border-az-gold/40 hover:border-az-green hover:shadow-emerald-200 transition-all duration-300">
                    <div class="relative overflow-hidden rounded-2xl group">
                        <img
                            src="<?= esc(
                                base_url(
                                    $struktur['gambar']
                                ),
                                'attr'
                            ) ?>"
                            alt="<?= esc(
                                $struktur['judul'],
                                'attr'
                            ) ?>"
                            class="w-full h-auto object-contain transition-transform duration-500 group-hover:scale-105"
                        >
                    </div>
                </div>

                <?php if (
                    $struktur['isi'] !== ''
                ): ?>
                    <div class="text-center text-xs text-slate-400 mt-8">
                        <?= konten_format(
                            $struktur['isi']
                        ) ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>
</div>