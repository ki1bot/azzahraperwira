<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ModelKontenHalaman;
use App\Services\KelolaHalamanService;
use App\Services\MediaHalamanService;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\KelolaHalaman as KonfigurasiKelolaHalaman;

class KelolaHalaman extends BaseController
{
    private ModelKontenHalaman $modelKonten;
    private KelolaHalamanService $layanan;
    private MediaHalamanService $media;

    public function __construct()
    {
        helper('konten');

        $this->modelKonten = new ModelKontenHalaman();
        $konfigurasi = new KonfigurasiKelolaHalaman();
        $this->media = new MediaHalamanService();

        $this->layanan = new KelolaHalamanService(
            $this->modelKonten,
            $konfigurasi,
            $this->media
        );
    }

    public function dashboard()
    {
        $daftarHalaman = $this->modelKonten->daftarHalaman();
        $ringkasanHalaman = [];
        $totalKonten = 0;
        $totalAktif = 0;
        $totalHalamanDinamis = 0;

        foreach ($daftarHalaman as $kodeHalaman => $namaHalaman) {
            $ringkasan = $this->modelKonten->ringkasan($kodeHalaman);
            $ringkasan['boleh_tambah'] = $this->layanan->bolehTambah($kodeHalaman);
            $ringkasanHalaman[$kodeHalaman] = $ringkasan;

            $totalKonten += (int) $ringkasan['total'];
            $totalAktif += (int) $ringkasan['aktif'];

            if ($ringkasan['boleh_tambah']) {
                $totalHalamanDinamis++;
            }
        }

        $data = [
            'judul' => 'Dashboard Admin',
            'daftarHalaman' => $daftarHalaman,
            'ringkasanHalaman' => $ringkasanHalaman,
            'totalKonten' => $totalKonten,
            'totalAktif' => $totalAktif,
            'totalHalamanDinamis' => $totalHalamanDinamis,
        ];

        return $this->tampilkan('admin/dashboard', $data);
    }

    public function index(string $kodeHalaman)
    {
        $namaHalaman = $this->layanan->namaHalaman($kodeHalaman);
        $this->layanan->pastikanKontenOtomatis($kodeHalaman);

        $daftarKonten = $this->modelKonten->semua($kodeHalaman);
        $bolehTambah = $this->layanan->bolehTambah($kodeHalaman);

        $data = [
            'judul' => 'Kelola ' . $namaHalaman,
            'kodeHalaman' => $kodeHalaman,
            'namaHalaman' => $namaHalaman,
            'daftarKonten' => $daftarKonten,
            'hakKonten' => $this->layanan->hakKonten(
                $kodeHalaman,
                $daftarKonten
            ),
            'ringkasan' => $this->modelKonten->ringkasan($kodeHalaman),
            'bolehTambah' => $bolehTambah,
            'halamanTetap' => ! $bolehTambah,
        ];

        return $this->tampilkan('admin/daftar_konten', $data);
    }

    public function tambah(string $kodeHalaman)
    {
        $namaHalaman = $this->layanan->namaHalaman($kodeHalaman);

        if (! $this->layanan->bolehTambah($kodeHalaman)) {
            return redirect()
                ->to($this->adminUrl($kodeHalaman))
                ->with(
                    'error',
                    'Halaman ' . $namaHalaman
                    . ' memiliki bagian yang sudah ditentukan. '
                    . 'Gunakan tombol Edit pada bagian yang ingin diubah.'
                );
        }

        $data = [
            'judul' => 'Tambah Data ' . $namaHalaman,
            'mode' => 'tambah',
            'kodeHalaman' => $kodeHalaman,
            'namaHalaman' => $namaHalaman,
            'namaBagian' => $kodeHalaman === 'tenaga-pengajar'
                ? 'Tenaga Pengajar Baru'
                : 'Informasi Baru',
            'konten' => null,
            'tipeUpload' => $this->layanan->tipeUploadDefault($kodeHalaman),
            'bolehTambah' => true,
            'halamanTetap' => false,
            'kodeDikunci' => false,
        ];

        return $this->tampilkan('admin/form_konten', $data);
    }

    public function simpan(string $kodeHalaman)
    {
        if (! $this->isPost()) {
            return redirect()->to($this->adminUrl($kodeHalaman));
        }

        $namaHalaman = $this->layanan->namaHalaman($kodeHalaman);

        if (! $this->layanan->bolehTambah($kodeHalaman)) {
            return redirect()
                ->to($this->adminUrl($kodeHalaman))
                ->with(
                    'error',
                    'Halaman ini tidak menerima data tambahan. '
                    . 'Gunakan tombol Edit pada bagian yang sudah tersedia.'
                );
        }

        $kategoriWajib = $kodeHalaman === 'tenaga-pengajar';

        if (! $this->validasiFormKonten(true, $kategoriWajib)) {
            return $this->kembaliDenganErrorValidasi();
        }

        $judul = trim((string) $this->request->getPost('judul'));
        $kodeKonten = $this->layanan->buatKodeKontenBaru(
            $kodeHalaman,
            $judul
        );

        $tipeUpload = $this->layanan->tipeUpload(
            $kodeHalaman,
            $kodeKonten
        );

        if (! $this->validasiUpload($tipeUpload)) {
            return $this->kembaliDenganErrorValidasi();
        }

        $mediaBaru = $this->media->upload(
            $this->request,
            $tipeUpload
        );

        $data = $this->layanan->dataBaru(
            $this->request,
            $kodeHalaman,
            $kodeKonten,
            $tipeUpload,
            $mediaBaru
        );

        $this->modelKonten->tambah($kodeHalaman, $data);

        return redirect()
            ->to($this->adminUrl($kodeHalaman))
            ->with(
                'success',
                $namaHalaman . ' berhasil ditambahkan.'
            );
    }

    public function edit(string $kodeHalaman, string $referensiKonten)
    {
        $namaHalaman = $this->layanan->namaHalaman($kodeHalaman);

        $konten = $this->layanan->temukanKonten(
            $kodeHalaman,
            $referensiKonten
        );

        if (! $konten) {
            throw PageNotFoundException::forPageNotFound(
                'Konten tidak ditemukan.'
            );
        }

        $kodeKonten = (string) ($konten['kode_konten'] ?? '');
        $bolehTambah = $this->layanan->bolehTambah($kodeHalaman);

        $data = [
            'judul' => 'Edit ' . $this->layanan->namaBagian(
                $kodeHalaman,
                $kodeKonten
            ),
            'mode' => 'edit',
            'kodeHalaman' => $kodeHalaman,
            'namaHalaman' => $namaHalaman,
            'namaBagian' => $this->layanan->namaBagian(
                $kodeHalaman,
                $kodeKonten
            ),
            'konten' => $konten,
            'tipeUpload' => $this->layanan->tipeUpload(
                $kodeHalaman,
                $kodeKonten
            ),
            'bolehTambah' => $bolehTambah,
            'halamanTetap' => ! $bolehTambah,
            'kodeDikunci' => $this->layanan->kodeDikunci(
                $kodeHalaman,
                $kodeKonten
            ),
        ];

        return $this->tampilkan('admin/form_konten', $data);
    }

    public function update(string $kodeHalaman, string $referensiKonten)
    {
        if (! $this->isPost()) {
            return redirect()->to($this->adminUrl($kodeHalaman));
        }

        $this->layanan->namaHalaman($kodeHalaman);

        $kontenLama = $this->layanan->temukanKonten(
            $kodeHalaman,
            $referensiKonten
        );

        if (! $kontenLama) {
            throw PageNotFoundException::forPageNotFound(
                'Konten tidak ditemukan.'
            );
        }

        $kodeKonten = (string) ($kontenLama['kode_konten'] ?? '');

        $kodeDikunci = $this->layanan->kodeDikunci(
            $kodeHalaman,
            $kodeKonten
        );

        $judulWajib = ! $kodeDikunci;

        $kategoriWajib = $kodeHalaman === 'tenaga-pengajar'
            && ! $kodeDikunci;

        if (! $this->validasiFormKonten($judulWajib, $kategoriWajib)) {
            return $this->kembaliDenganErrorValidasi();
        }

        $tipeUpload = $this->layanan->tipeUpload(
            $kodeHalaman,
            $kodeKonten
        );

        if (! $this->validasiUpload($tipeUpload)) {
            return $this->kembaliDenganErrorValidasi();
        }

        $mediaBaru = $this->media->upload(
            $this->request,
            $tipeUpload
        );

        $data = $this->layanan->dataUpdate(
            $this->request,
            $kodeHalaman,
            $kodeKonten,
            $tipeUpload,
            $mediaBaru,
            $kontenLama
        );

        $this->modelKonten->ubahBerdasarkanKode(
            $kodeHalaman,
            $kodeKonten,
            $data
        );

        return redirect()
            ->to($this->adminUrl($kodeHalaman))
            ->with(
                'success',
                'Perubahan berhasil disimpan.'
            );
    }

    public function hapus(string $kodeHalaman, string $referensiKonten)
    {
        if (! $this->isPost()) {
            return redirect()->to($this->adminUrl($kodeHalaman));
        }

        $this->layanan->namaHalaman($kodeHalaman);

        $konten = $this->layanan->temukanKonten(
            $kodeHalaman,
            $referensiKonten
        );

        if (! $konten) {
            throw PageNotFoundException::forPageNotFound(
                'Konten tidak ditemukan.'
            );
        }

        $kodeKonten = (string) ($konten['kode_konten'] ?? '');

        if (! $this->layanan->bolehHapus($kodeHalaman, $kodeKonten)) {
            return redirect()
                ->to($this->adminUrl($kodeHalaman))
                ->with(
                    'error',
                    'Bagian ini merupakan bagian utama halaman dan tidak dapat dihapus.'
                );
        }

        $this->layanan->hapus(
            $kodeHalaman,
            $kodeKonten,
            $konten
        );

        return redirect()
            ->to($this->adminUrl($kodeHalaman))
            ->with(
                'success',
                'Data berhasil dihapus.'
            );
    }

    private function tampilkan(string $view, array $data): string
    {
        return view('admin/tata_letak', [
            'judul' => $data['judul'],
            'isi_admin' => view($view, $data),
        ]);
    }

    private function isPost(): bool
    {
        return strtolower($this->request->getMethod()) === 'post';
    }

    private function validasiFormKonten(
        bool $judulWajib,
        bool $kategoriWajib = false
    ): bool {
        $aturanJudul = $judulWajib
            ? 'required|max_length[255]'
            : 'permit_empty|max_length[255]';

        $aturan = [
            'judul' => $aturanJudul,
            'isi' => 'permit_empty',
            'urutan' => 'permit_empty|integer|greater_than_equal_to[0]',
            'status' => 'required|in_list[aktif,nonaktif]',
        ];

        if ($kategoriWajib) {
            $aturan['kategori'] = 'required|max_length[255]';
        } elseif ($this->request->getPost('kategori') !== null) {
            $aturan['kategori'] = 'permit_empty|max_length[255]';
        }

        if ($this->request->getPost('pendidikan') !== null) {
            $aturan['pendidikan'] = 'permit_empty|max_length[255]';
        }

        return $this->validate($aturan);
    }

    private function validasiUpload(string $tipeUpload): bool
    {
        $aturan = $this->media->aturanValidasi(
            $this->request,
            $tipeUpload
        );

        return $aturan === [] || $this->validate($aturan);
    }

    private function kembaliDenganErrorValidasi()
    {
        return redirect()
            ->back()
            ->withInput()
            ->with(
                'error',
                implode('<br>', $this->validator->getErrors())
            );
    }

    private function adminUrl(string $kodeHalaman): string
    {
        return base_url(
            'admin/' . trim($kodeHalaman, '/') . '/index.php'
        );
    }
}