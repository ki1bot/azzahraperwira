<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class KelolaHalaman extends BaseConfig
{
    public array $halamanBolehTambah = [
        'tenaga-pengajar',
        'informasi',
    ];

    public array $prefixKontenTambahan = [
        'tenaga-pengajar' => 'pengajar',
        'informasi' => 'informasi',
    ];

    public array $labelKonten = [
        'beranda' => [
            'hero' => 'Banner Utama',
            'brosur' => 'Brosur Pendaftaran',
            'video_profile' => 'Video Profil',
        ],
        'profile' => [
            'judul_halaman' => 'Judul Halaman',
            'subjudul_halaman' => 'Subjudul Halaman',
            'profil_yayasan' => 'Profil Yayasan',
            'visi_misi' => 'Visi',
            'misi' => 'Misi',
            'struktur_organisasi' => 'Struktur Organisasi',
        ],
        'tenaga-pengajar' => [
            'judul_halaman' => 'Judul Halaman',
            'subjudul_halaman' => 'Subjudul Halaman',
        ],
        'unit-kb-tk' => [
            'judul_halaman' => 'Judul Halaman',
            'subjudul_halaman' => 'Subjudul Halaman',
            'tentang_unit' => 'Tentang Unit',
            'program_unit' => 'Program Unit',
            'fasilitas_unit' => 'Fasilitas',
            'ekstrakurikuler' => 'Ekstrakurikuler',
            'galeri_1' => 'Galeri 1',
            'galeri_2' => 'Galeri 2',
            'galeri_3' => 'Galeri 3',
        ],
        'unit-tpq' => [
            'judul_halaman' => 'Judul Halaman',
            'subjudul_halaman' => 'Subjudul Halaman',
            'tentang_tpq' => 'Tentang TPQ',
            'tentang_rtq' => 'Tentang RTQ',
            'program_unit' => 'Program Unit',
            'kegiatan_unit' => 'Kegiatan Unit',
            'galeri_1' => 'Galeri 1',
            'galeri_2' => 'Galeri 2',
            'galeri_3' => 'Galeri 3',
        ],
        'unit-dc' => [
            'judul_halaman' => 'Judul Halaman',
            'subjudul_halaman' => 'Subjudul Halaman',
            'tentang_unit' => 'Tentang Daycare',
            'program_unit' => 'Program Daycare',
            'kegiatan_unit' => 'Kegiatan Daycare',
            'galeri_1' => 'Galeri 1',
            'galeri_2' => 'Galeri 2',
            'galeri_3' => 'Galeri 3',
        ],
        'unit-lansia' => [
            'judul_halaman' => 'Judul Halaman',
            'subjudul_halaman' => 'Subjudul Halaman',
            'tentang_unit' => 'Tentang Unit Lansia',
            'program_unit' => 'Program Lansia',
            'kegiatan_unit' => 'Kegiatan Lansia',
            'galeri_1' => 'Galeri 1',
            'galeri_2' => 'Galeri 2',
            'galeri_3' => 'Galeri 3',
        ],
        'informasi' => [
            'judul_halaman' => 'Judul Halaman',
            'subjudul_halaman' => 'Subjudul Halaman',
            'pengumuman' => 'Pengumuman Utama',
            'berita' => 'Judul Bagian Berita',
            'brosur' => 'Brosur Pendaftaran',
        ],
        'footer' => [
            'footer_identitas' => 'Identitas Yayasan',
            'footer_kontak_judul' => 'Judul Kontak',
            'footer_alamat' => 'Alamat',
            'footer_whatsapp_1' => 'WhatsApp 1',
            'footer_whatsapp_2' => 'WhatsApp 2',
            'footer_instagram' => 'Instagram',
            'footer_tiktok' => 'TikTok',
            'footer_copyright' => 'Copyright',
        ],
    ];

    public array $kodeKontenDikunci = [
        'beranda' => [
            'hero',
            'brosur',
            'video_profile',
        ],
        'profile' => [
            'judul_halaman',
            'subjudul_halaman',
            'profil_yayasan',
            'visi_misi',
            'misi',
            'struktur_organisasi',
        ],
        'tenaga-pengajar' => [
            'judul_halaman',
            'subjudul_halaman',
        ],
        'unit-kb-tk' => [
            'judul_halaman',
            'subjudul_halaman',
            'tentang_unit',
            'program_unit',
            'fasilitas_unit',
            'ekstrakurikuler',
            'galeri_1',
            'galeri_2',
            'galeri_3',
        ],
        'unit-tpq' => [
            'judul_halaman',
            'subjudul_halaman',
            'tentang_tpq',
            'tentang_rtq',
            'program_unit',
            'kegiatan_unit',
            'galeri_1',
            'galeri_2',
            'galeri_3',
        ],
        'unit-dc' => [
            'judul_halaman',
            'subjudul_halaman',
            'tentang_unit',
            'program_unit',
            'kegiatan_unit',
            'galeri_1',
            'galeri_2',
            'galeri_3',
        ],
        'unit-lansia' => [
            'judul_halaman',
            'subjudul_halaman',
            'tentang_unit',
            'program_unit',
            'kegiatan_unit',
            'galeri_1',
            'galeri_2',
            'galeri_3',
        ],
        'informasi' => [
            'judul_halaman',
            'subjudul_halaman',
            'pengumuman',
            'berita',
            'brosur',
        ],
        'footer' => [
            'footer_identitas',
            'footer_kontak_judul',
            'footer_alamat',
            'footer_whatsapp_1',
            'footer_whatsapp_2',
            'footer_instagram',
            'footer_tiktok',
            'footer_copyright',
        ],
    ];

    public array $kontenOtomatis = [
        'unit-kb-tk' => [
            [
                'kode_konten' => 'galeri_1',
                'judul' => 'Drumband',
                'isi' => '',
                'gambar' => 'assets/img/unit-kb-tk/drumband.jpg',
                'urutan' => 50,
                'status' => 'aktif',
            ],
            [
                'kode_konten' => 'galeri_2',
                'judul' => 'Menari',
                'isi' => '',
                'gambar' => 'assets/img/unit-kb-tk/menari.png',
                'urutan' => 51,
                'status' => 'aktif',
            ],
            [
                'kode_konten' => 'galeri_3',
                'judul' => 'Kegiatan KB-TK',
                'isi' => '',
                'gambar' => 'assets/img/unit-kb-tk/kelas.png',
                'urutan' => 52,
                'status' => 'aktif',
            ],
        ],
        'unit-tpq' => [
            [
                'kode_konten' => 'galeri_1',
                'judul' => 'Wisuda RTQ',
                'isi' => '',
                'gambar' => 'assets/img/unit-tpq/tpq1.jpg',
                'urutan' => 50,
                'status' => 'aktif',
            ],
            [
                'kode_konten' => 'galeri_2',
                'judul' => 'Lomba Ramadhan',
                'isi' => '',
                'gambar' => 'assets/img/unit-tpq/tpq2.jpg',
                'urutan' => 51,
                'status' => 'aktif',
            ],
            [
                'kode_konten' => 'galeri_3',
                'judul' => 'Murid RTQ',
                'isi' => '',
                'gambar' => 'assets/img/unit-tpq/tpq3.jpg',
                'urutan' => 52,
                'status' => 'aktif',
            ],
        ],
        'unit-dc' => [
            [
                'kode_konten' => 'galeri_1',
                'judul' => 'Galeri Daycare 1',
                'isi' => '',
                'gambar' => 'assets/img/home/home.jpg',
                'urutan' => 50,
                'status' => 'aktif',
            ],
            [
                'kode_konten' => 'galeri_2',
                'judul' => 'Galeri Daycare 2',
                'isi' => '',
                'gambar' => 'assets/img/home/home1.jpg',
                'urutan' => 51,
                'status' => 'aktif',
            ],
            [
                'kode_konten' => 'galeri_3',
                'judul' => 'Galeri Daycare 3',
                'isi' => '',
                'gambar' => 'assets/img/home/homedas.jpg',
                'urutan' => 52,
                'status' => 'aktif',
            ],
        ],
        'unit-lansia' => [
            [
                'kode_konten' => 'galeri_1',
                'judul' => 'Kegiatan Lansia 1',
                'isi' => '',
                'gambar' => 'assets/img/unit-lansia/kegiatan1.jpg',
                'urutan' => 50,
                'status' => 'aktif',
            ],
            [
                'kode_konten' => 'galeri_2',
                'judul' => 'Kegiatan Lansia 2',
                'isi' => '',
                'gambar' => 'assets/img/unit-lansia/kegiatan2.jpg',
                'urutan' => 51,
                'status' => 'aktif',
            ],
            [
                'kode_konten' => 'galeri_3',
                'judul' => 'Kegiatan Lansia 3',
                'isi' => '',
                'gambar' => 'assets/img/unit-lansia/kegiatan3.jpg',
                'urutan' => 52,
                'status' => 'aktif',
            ],
        ],
    ];

    public array $kodeKontenTanpaUpload = [
        'judul_halaman',
        'subjudul_halaman',
        'footer_kontak_judul',
        'footer_copyright',
        'program_unit',
        'fasilitas_unit',
        'ekstrakurikuler',
        'kegiatan_unit',
        'berita',
    ];

    public array $awalanKodeTanpaUpload = [
        'program_',
        'pilar_',
        'fasilitas_',
    ];
}