<?php

namespace App\Models;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Model;

class ModelKontenHalaman extends Model
{
    protected $DBGroup = 'default';

    private array $daftarTabel = [
        'beranda' => 'halaman_beranda',
        'profile' => 'halaman_profile',
        'tenaga-pengajar' => 'halaman_tenaga_pengajar',
        'unit-kb-tk' => 'halaman_unit_kb_tk',
        'unit-tpq' => 'halaman_unit_tpq',
        'unit-dc' => 'halaman_unit_dc',
        'unit-lansia' => 'halaman_unit_lansia',
        'informasi' => 'halaman_informasi',
        'footer' => 'halaman_footer',
    ];

    public function daftarHalaman(): array
    {
        return [
            'beranda' => 'Beranda',
            'profile' => 'Profile',
            'tenaga-pengajar' => 'Tenaga Pengajar',
            'unit-kb-tk' => 'Unit KB/TK',
            'unit-tpq' => 'Unit TPQ',
            'unit-dc' => 'Unit Daycare',
            'unit-lansia' => 'Unit Lansia',
            'informasi' => 'Informasi',
            'footer' => 'Footer',
        ];
    }

    public function semua(string $kodeHalaman): array
    {
        return $this->db->table($this->namaTabel($kodeHalaman))
            ->orderBy('urutan', 'ASC')
            ->orderBy('id_konten', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function semuaAktif(string $kodeHalaman): array
    {
        return $this->db->table($this->namaTabel($kodeHalaman))
            ->where('status', 'aktif')
            ->orderBy('urutan', 'ASC')
            ->orderBy('id_konten', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function petaAktif(string $kodeHalaman): array
    {
        $data = $this->semuaAktif($kodeHalaman);
        $hasil = [];

        foreach ($data as $baris) {
            $kodeKonten = (string) ($baris['kode_konten'] ?? '');

            if ($kodeKonten === '') {
                continue;
            }

            $hasil[$kodeKonten] = $baris;
        }

        return $hasil;
    }

    public function satu(string $kodeHalaman, int $idKonten): ?array
    {
        return $this->db->table($this->namaTabel($kodeHalaman))
            ->where('id_konten', $idKonten)
            ->get()
            ->getRowArray();
    }

    public function satuBerdasarkanKode(string $kodeHalaman, string $kodeKonten): ?array
    {
        return $this->db->table($this->namaTabel($kodeHalaman))
            ->where('kode_konten', $kodeKonten)
            ->get()
            ->getRowArray();
    }

    public function kodeSudahAda(string $kodeHalaman, string $kodeKonten): bool
    {
        return $this->db->table($this->namaTabel($kodeHalaman))
            ->where('kode_konten', $kodeKonten)
            ->countAllResults() > 0;
    }

    public function urutanBerikutnya(string $kodeHalaman): int
    {
        $baris = $this->db->table($this->namaTabel($kodeHalaman))
            ->selectMax('urutan', 'urutan_maksimal')
            ->get()
            ->getRowArray();

        return ((int) ($baris['urutan_maksimal'] ?? 0)) + 1;
    }

    public function ringkasan(string $kodeHalaman): array
    {
        $namaTabel = $this->namaTabel($kodeHalaman);

        $total = $this->db->table($namaTabel)
            ->countAllResults();

        $aktif = $this->db->table($namaTabel)
            ->where('status', 'aktif')
            ->countAllResults();

        return [
            'total' => $total,
            'aktif' => $aktif,
            'nonaktif' => max(0, $total - $aktif),
        ];
    }

    public function tambah(string $kodeHalaman, array $data): bool
    {
        return $this->db->table($this->namaTabel($kodeHalaman))
            ->insert($data);
    }

    public function ubahBerdasarkanKode(
        string $kodeHalaman,
        string $kodeKonten,
        array $data
    ): bool {
        return $this->db->table($this->namaTabel($kodeHalaman))
            ->where('kode_konten', $kodeKonten)
            ->update($data);
    }

    public function hapusBerdasarkanKode(
        string $kodeHalaman,
        string $kodeKonten
    ): bool {
        return $this->db->table($this->namaTabel($kodeHalaman))
            ->where('kode_konten', $kodeKonten)
            ->delete();
    }

    private function namaTabel(string $kodeHalaman): string
    {
        if (! array_key_exists($kodeHalaman, $this->daftarTabel)) {
            throw PageNotFoundException::forPageNotFound(
                'Halaman tidak ditemukan.'
            );
        }

        return $this->daftarTabel[$kodeHalaman];
    }
}