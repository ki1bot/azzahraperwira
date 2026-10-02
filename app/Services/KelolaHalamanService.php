<?php

namespace App\Services;

use App\Models\ModelKontenHalaman;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\IncomingRequest;
use Config\KelolaHalaman as KonfigurasiKelolaHalaman;

class KelolaHalamanService
{
    public function __construct(
        private ModelKontenHalaman $modelKonten,
        private KonfigurasiKelolaHalaman $konfigurasi,
        private MediaHalamanService $media
    ) {
    }

    public function namaHalaman(string $kodeHalaman): string
    {
        $daftarHalaman = $this->modelKonten->daftarHalaman();

        if (! isset($daftarHalaman[$kodeHalaman])) {
            throw PageNotFoundException::forPageNotFound(
                'Halaman tidak ditemukan.'
            );
        }

        return $daftarHalaman[$kodeHalaman];
    }

    public function bolehTambah(string $kodeHalaman): bool
    {
        return in_array(
            $kodeHalaman,
            $this->konfigurasi->halamanBolehTambah,
            true
        );
    }

    public function kodeDikunci(
        string $kodeHalaman,
        string $kodeKonten
    ): bool {
        return in_array(
            $kodeKonten,
            $this->konfigurasi->kodeKontenDikunci[$kodeHalaman] ?? [],
            true
        );
    }

    public function bolehHapus(
        string $kodeHalaman,
        string $kodeKonten
    ): bool {
        return $this->bolehTambah($kodeHalaman)
            && ! $this->kodeDikunci($kodeHalaman, $kodeKonten);
    }

    public function namaBagian(
        string $kodeHalaman,
        string $kodeKonten
    ): string {
        $label = $this->konfigurasi->labelKonten[$kodeHalaman][$kodeKonten]
            ?? null;

        if (is_string($label) && $label !== '') {
            return $label;
        }

        if ($kodeHalaman === 'tenaga-pengajar') {
            return 'Data Tenaga Pengajar';
        }

        if ($kodeHalaman === 'informasi') {
            return 'Informasi / Berita';
        }

        return 'Bagian Konten';
    }

    public function tipeUploadDefault(string $kodeHalaman): string
    {
        if (in_array(
            $kodeHalaman,
            [
                'tenaga-pengajar',
                'informasi',
            ],
            true
        )) {
            return 'image';
        }

        if (str_starts_with($kodeHalaman, 'unit-')) {
            return 'image';
        }

        return 'none';
    }

    public function tipeUpload(
        string $kodeHalaman,
        string $kodeKonten
    ): string {
        if ($kodeKonten === 'brosur') {
            return 'file';
        }

        if (in_array(
            $kodeKonten,
            $this->konfigurasi->kodeKontenTanpaUpload,
            true
        )) {
            return 'none';
        }

        foreach ($this->konfigurasi->awalanKodeTanpaUpload as $awalan) {
            if (str_starts_with($kodeKonten, $awalan)) {
                return 'none';
            }
        }

        return $kodeHalaman === 'footer'
            ? 'none'
            : 'image';
    }

    public function pastikanKontenOtomatis(string $kodeHalaman): void
    {
        $daftarKonten = $this->konfigurasi
            ->kontenOtomatis[$kodeHalaman] ?? [];

        foreach ($daftarKonten as $konten) {
            $kodeKonten = (string) (
                $konten['kode_konten'] ?? ''
            );

            if ($kodeKonten === '') {
                continue;
            }

            $kontenTersedia = $this->modelKonten->satuBerdasarkanKode(
                $kodeHalaman,
                $kodeKonten
            );

            if ($kontenTersedia !== null) {
                continue;
            }

            $berhasil = $this->modelKonten->tambah(
                $kodeHalaman,
                $konten
            );

            if (! $berhasil) {
                log_message(
                    'warning',
                    'Konten otomatis gagal dibuat pada halaman {halaman} dengan kode {kode}.',
                    [
                        'halaman' => $kodeHalaman,
                        'kode' => $kodeKonten,
                    ]
                );
            }
        }
    }

    public function hakKonten(
        string $kodeHalaman,
        array $daftarKonten
    ): array {
        $hakKonten = [];

        foreach ($daftarKonten as $konten) {
            $kodeKonten = (string) (
                $konten['kode_konten'] ?? ''
            );

            if ($kodeKonten === '') {
                continue;
            }

            $hakKonten[$kodeKonten] = [
                'nama_bagian' => $this->namaBagian(
                    $kodeHalaman,
                    $kodeKonten
                ),
                'tipe_upload' => $this->tipeUpload(
                    $kodeHalaman,
                    $kodeKonten
                ),
                'boleh_hapus' => $this->bolehHapus(
                    $kodeHalaman,
                    $kodeKonten
                ),
                'kode_dikunci' => $this->kodeDikunci(
                    $kodeHalaman,
                    $kodeKonten
                ),
            ];
        }

        return $hakKonten;
    }

    public function temukanKonten(
        string $kodeHalaman,
        string $referensiKonten
    ): ?array {
        $referensiKonten = rawurldecode(
            trim($referensiKonten)
        );

        if ($referensiKonten === '') {
            return null;
        }

        $konten = $this->modelKonten->satuBerdasarkanKode(
            $kodeHalaman,
            $referensiKonten
        );

        if ($konten !== null) {
            return $konten;
        }

        if (ctype_digit($referensiKonten)) {
            return $this->modelKonten->satu(
                $kodeHalaman,
                (int) $referensiKonten
            );
        }

        return null;
    }

    public function buatKodeKontenBaru(
        string $kodeHalaman,
        string $judul
    ): string {
        $prefix = $this->konfigurasi
            ->prefixKontenTambahan[$kodeHalaman]
            ?? 'konten';

        $slug = $this->normalisasiKode($judul);

        if ($slug === '') {
            $slug = 'data';
        }

        $maksimalSlug = max(
            20,
            96 - strlen($prefix)
        );

        $slug = trim(
            substr(
                $slug,
                0,
                $maksimalSlug
            ),
            '_'
        );

        $kodeDasar = $prefix . '_' . $slug;
        $kodeKonten = $kodeDasar;
        $nomor = 2;

        while (
            $this->modelKonten->kodeSudahAda(
                $kodeHalaman,
                $kodeKonten
            )
        ) {
            $akhiran = '_' . $nomor;
            $batasDasar = 100 - strlen($akhiran);

            $kodeKonten = substr(
                $kodeDasar,
                0,
                $batasDasar
            ) . $akhiran;

            $nomor++;
        }

        return $kodeKonten;
    }

    public function normalisasiKode(string $kodeKonten): string
    {
        return url_title(
            trim($kodeKonten),
            '_',
            true
        );
    }

    public function dataBaru(
        IncomingRequest $request,
        string $kodeHalaman,
        string $kodeKonten,
        string $tipeUpload,
        ?string $mediaBaru
    ): array {
        $isi = (string) $request->getPost('isi');
        $gambar = '';

        if ($tipeUpload === 'file') {
            $isi = $mediaBaru ?? $isi;
        }

        if ($tipeUpload === 'image') {
            $gambar = $mediaBaru ?? '';
        }

        return $this->dataForm(
            $request,
            $kodeHalaman,
            $kodeKonten,
            $isi,
            $gambar,
            $this->modelKonten->urutanBerikutnya(
                $kodeHalaman
            )
        );
    }

    public function dataUpdate(
        IncomingRequest $request,
        string $kodeHalaman,
        string $kodeKonten,
        string $tipeUpload,
        ?string $mediaBaru,
        array $kontenLama
    ): array {
        $isi = (string) $request->getPost('isi');
        $gambar = (string) (
            $kontenLama['gambar'] ?? ''
        );

        if ($tipeUpload === 'file') {
            if ($mediaBaru !== null) {
                $isi = $mediaBaru;
            } else {
                $isi = (string) (
                    $kontenLama['isi'] ?? ''
                );
            }

            $gambar = '';
        }

        if (
            $tipeUpload === 'image'
            && $mediaBaru !== null
        ) {
            $gambar = $mediaBaru;
        }

        if ($tipeUpload === 'none') {
            $gambar = '';
        }

        return $this->dataForm(
            $request,
            $kodeHalaman,
            $kodeKonten,
            $isi,
            $gambar,
            (int) (
                $kontenLama['urutan'] ?? 0
            )
        );
    }

    public function bersihkanMediaSetelahUpdate(
        string $tipeUpload,
        ?string $mediaBaru,
        array $kontenLama
    ): void {
        if (
            $tipeUpload === 'file'
            && $mediaBaru !== null
        ) {
            $this->media->hapus(
                $kontenLama['isi'] ?? null
            );

            return;
        }

        if (
            $tipeUpload === 'image'
            && $mediaBaru !== null
        ) {
            $this->media->hapus(
                $kontenLama['gambar'] ?? null
            );

            return;
        }

        if ($tipeUpload === 'none') {
            $this->media->hapus(
                $kontenLama['gambar'] ?? null
            );
        }
    }

    public function hapus(
        string $kodeHalaman,
        string $kodeKonten,
        array $konten
    ): bool {
        $berhasil = $this->modelKonten
            ->hapusBerdasarkanKode(
                $kodeHalaman,
                $kodeKonten
            );

        if (! $berhasil) {
            return false;
        }

        $this->media->hapus(
            $konten['gambar'] ?? null
        );

        $this->media->hapus(
            $konten['isi'] ?? null
        );

        return true;
    }

    private function dataForm(
        IncomingRequest $request,
        string $kodeHalaman,
        string $kodeKonten,
        string $isi,
        string $gambar,
        int $urutanDefault
    ): array {
        $urutanPost = $request->getPost('urutan');

        $urutan = (
            $urutanPost === null
            || $urutanPost === ''
        )
            ? $urutanDefault
            : max(
                0,
                (int) $urutanPost
            );

        $data = [
            'kode_konten' => $kodeKonten,
            'judul' => trim(
                (string) $request->getPost('judul')
            ),
            'isi' => $isi,
            'gambar' => $gambar,
            'urutan' => $urutan,
            'status' => (string) $request->getPost(
                'status'
            ),
        ];

        if ($kodeHalaman === 'tenaga-pengajar') {
            $data['kategori'] = trim(
                (string) $request->getPost(
                    'kategori'
                )
            );

            $data['pendidikan'] = trim(
                (string) $request->getPost(
                    'pendidikan'
                )
            );
        }

        return $data;
    }
}