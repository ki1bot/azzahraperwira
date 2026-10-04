<?php

$kontenMap = $kontenMap ?? [];
$kontenHalaman = $kontenHalaman ?? [];

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

$judulHalaman = $ambilKonten(
    $kontenMap,
    'judul_halaman',
    [
        'judul' => 'Tenaga Pengajar',
    ]
);

$subjudulHalaman = $ambilKonten(
    $kontenMap,
    'subjudul_halaman',
    [
        'isi' => 'Profil Pendidik & Tenaga Kependidikan Profesional',
    ]
);

$kodeKhusus = [
    'judul_halaman',
    'subjudul_halaman',
];

$daftarPengajar = array_values(
    array_filter(
        $kontenHalaman,
        static function (
            $item
        ) use (
            $kodeKhusus
        ): bool {
            return ! in_array(
                (string) (
                    $item['kode_konten']
                    ?? ''
                ),
                $kodeKhusus,
                true
            );
        }
    )
);

$defaultPengajar = [
    [
        'kategori' => 'Pendidik Rumah Quran (RTQ)',
        'data' => [
            [
                'nama' => 'Galih Muharik, M.Pd',
                'lulusan' => 'S2',
                'jabatan' => 'Mudir & Guru Tahfidz',
                'foto' => 'Galih-Munarik.jpg',
            ],
            [
                'nama' => 'Ahmad Zaki Fannani',
                'lulusan' => 'Madrasah A’liyah',
                'jabatan' => 'Guru Tahfidz',
                'foto' => '',
            ],
            [
                'nama' => 'Nusaibah Az Zahri, S.Pd.I',
                'lulusan' => 'S1',
                'jabatan' => 'Guru Tahfidz Juz 30',
                'foto' => '',
            ],
            [
                'nama' => 'Siti Nurul Mu’minah',
                'lulusan' => 'D2',
                'jabatan' => 'Guru Tahfidz',
                'foto' => '',
            ],
            [
                'nama' => 'Shaffa Muthiara M.C, S.Ag',
                'lulusan' => 'S1',
                'jabatan' => 'Guru Tahfidz',
                'foto' => '',
            ],
            [
                'nama' => 'Nahda Tsabita, S.Ag',
                'lulusan' => 'S1',
                'jabatan' => 'Guru Tahfidz Juz 30',
                'foto' => '',
            ],
            [
                'nama' => 'Fahmia Nuha Tsabita, S.Pd',
                'lulusan' => 'S1',
                'jabatan' => 'Guru Tahfidz Juz 30',
                'foto' => '',
            ],
            [
                'nama' => 'Fairuz Silmi Nabilah, S.Psi',
                'lulusan' => 'S1',
                'jabatan' => 'Guru Tahfidz Juz 30',
                'foto' => '',
            ],
            [
                'nama' => 'Farhah Millati K, S.Pd',
                'lulusan' => 'S1',
                'jabatan' => 'Guru Tahfidz Juz 30',
                'foto' => '',
            ],
            [
                'nama' => 'Luthfiah Kamili, S.Pd',
                'lulusan' => 'S1',
                'jabatan' => 'Guru Tahfidz Juz 30',
                'foto' => '',
            ],
            [
                'nama' => 'Fauziyyatusy Syarif A',
                'lulusan' => 'S1',
                'jabatan' => 'Guru Tahfidz Juz 30',
                'foto' => '',
            ],
        ],
    ],
    [
        'kategori' => 'Pendidik TPQ',
        'data' => [
            [
                'nama' => 'Galih Muharik, M.Pd',
                'lulusan' => 'S2',
                'jabatan' => 'Mudir & Guru Tahfidz',
                'foto' => 'Galih-Munarik.jpg',
            ],
            [
                'nama' => 'Luthfiah Kamili, S.Pd',
                'lulusan' => 'S1',
                'jabatan' => 'Guru Tahfidz Juz 30',
                'foto' => '',
            ],
            [
                'nama' => 'Fahmia Nuha Tsabita, S.Pd',
                'lulusan' => 'S1',
                'jabatan' => 'Guru Tahfidz Juz 30',
                'foto' => '',
            ],
            [
                'nama' => 'Lucky Hidayati, S.Pd',
                'lulusan' => 'S1',
                'jabatan' => 'Guru',
                'foto' => '',
            ],
            [
                'nama' => 'Nadhifa Qurota A’ini',
                'lulusan' => 'Madrasah A’liyah',
                'jabatan' => 'Guru',
                'foto' => '',
            ],
        ],
    ],
    [
        'kategori' => 'Pendidik Day Care',
        'data' => [
            [
                'nama' => 'Fauziyyatusy Syarif A',
                'lulusan' => 'S1',
                'jabatan' => 'Guru Tahfidz Juz 30',
                'foto' => '',
            ],
        ],
    ],
];
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

    <main class="container mx-auto px-6 py-12">
        <?php if (
            ! empty(
                $daftarPengajar
            )
        ): ?>
            <?php
            $pengajarPerKategori = [];

            foreach (
                $daftarPengajar
                as $pengajar
            ) {
                $kategori = trim(
                    (string) (
                        $pengajar['kategori']
                        ?? ''
                    )
                );

                if ($kategori === '') {
                    $kategori = 'Daftar Tenaga Pengajar';
                }

                $pengajarPerKategori[$kategori][] = $pengajar;
            }
            ?>

            <?php foreach (
                $pengajarPerKategori
                as $kategori => $itemsPengajar
            ): ?>
                <section class="mb-16">
                    <h2 class="text-3xl font-bold text-az-green mb-8 border-l-4 border-az-gold pl-4">
                        <?= esc($kategori) ?>
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php foreach (
                            $itemsPengajar
                            as $pengajar
                        ): ?>
                            <?php
                            $foto = trim(
                                (string) (
                                    $pengajar['gambar']
                                    ?? ''
                                )
                            );
                            ?>

                            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 hover:shadow-lg transition text-center">
                                <div class="w-24 h-24 bg-slate-100 rounded-full mx-auto mb-4 flex items-center justify-center overflow-hidden border-2 border-az-gold shadow-sm">
                                    <?php if ($foto !== ''): ?>
                                        <img
                                            src="<?= esc(
                                                base_url(
                                                    $foto
                                                ),
                                                'attr'
                                            ) ?>"
                                            alt="<?= esc(
                                                $pengajar['judul']
                                                    ?? 'Tenaga Pengajar',
                                                'attr'
                                            ) ?>"
                                            class="w-full h-full object-cover"
                                        >
                                    <?php else: ?>
                                        <svg
                                            class="w-12 h-12 text-slate-400"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                clip-rule="evenodd"
                                            ></path>
                                        </svg>
                                    <?php endif; ?>
                                </div>

                                <h3 class="font-bold text-az-green">
                                    <?= esc(
                                        $pengajar['judul']
                                            ?? 'Nama Pengajar'
                                    ) ?>
                                </h3>

                                <?php if (
                                    ! empty(
                                        $pengajar['pendidikan']
                                    )
                                ): ?>
                                    <span class="inline-block bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full mt-2 mb-2">
                                        <?= esc(
                                            $pengajar['pendidikan']
                                        ) ?>
                                    </span>
                                <?php endif; ?>

                                <?php if (
                                    ! empty(
                                        $pengajar['isi']
                                    )
                                ): ?>
                                    <div class="text-sm text-gray-600 mt-2">
                                        <?= konten_format(
                                            $pengajar['isi']
                                        ) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        <?php else: ?>
            <?php foreach (
                $defaultPengajar
                as $grup
            ): ?>
                <section class="mb-16">
                    <h2 class="text-3xl font-bold text-az-green mb-8 border-l-4 border-az-gold pl-4">
                        <?= esc(
                            $grup['kategori']
                        ) ?>
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php foreach (
                            $grup['data']
                            as $staff
                        ): ?>
                            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 hover:shadow-lg transition text-center">
                                <div class="w-24 h-24 bg-slate-100 rounded-full mx-auto mb-4 flex items-center justify-center overflow-hidden border-2 border-az-gold shadow-sm">
                                    <?php if (
                                        ! empty(
                                            $staff['foto']
                                        )
                                    ): ?>
                                        <img
                                            src="<?= esc(
                                                base_url(
                                                    'assets/img/tenagaPengajar/'
                                                    . $staff['foto']
                                                ),
                                                'attr'
                                            ) ?>"
                                            alt="<?= esc(
                                                $staff['nama'],
                                                'attr'
                                            ) ?>"
                                            class="w-full h-full object-cover"
                                        >
                                    <?php else: ?>
                                        <svg
                                            class="w-12 h-12 text-slate-400"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                clip-rule="evenodd"
                                            ></path>
                                        </svg>
                                    <?php endif; ?>
                                </div>

                                <h3 class="font-bold text-az-green">
                                    <?= esc(
                                        $staff['nama']
                                    ) ?>
                                </h3>

                                <span class="inline-block bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full mt-2 mb-2">
                                    <?= esc(
                                        $staff['lulusan']
                                    ) ?>
                                </span>

                                <p class="text-sm text-gray-600">
                                    <?= esc(
                                        $staff['jabatan']
                                    ) ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>
</div>