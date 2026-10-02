<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ModelAdminPengguna;
use Throwable;

class Otentikasi extends BaseController
{
    private function loginUrl(): string
    {
        return base_url(
            'admin/login/index.php'
        );
    }

    private function dashboardUrl(): string
    {
        return base_url(
            'admin/dashboard/index.php'
        );
    }

    private function ubahPasswordUrl(): string
    {
        return base_url(
            'admin/ubah-password/index.php'
        );
    }

    public function login()
    {
        if (session()->get('admin_masuk')) {
            return redirect()->to(
                $this->dashboardUrl()
            );
        }

        return view(
            'admin/login',
            [
                'judul' => 'Login Admin',
            ]
        );
    }

    public function prosesLogin()
    {
        if (
            strtolower(
                $this->request->getMethod()
            ) !== 'post'
        ) {
            return redirect()->to(
                $this->loginUrl()
            );
        }

        $aturan = [
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' =>
                        'Username wajib diisi.',
                ],
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' =>
                        'Password wajib diisi.',
                ],
            ],
        ];

        if (! $this->validate($aturan)) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    implode(
                        '<br>',
                        $this->validator
                            ->getErrors()
                    )
                );
        }

        $username = trim(
            (string) $this->request
                ->getPost('username')
        );

        $password = (string) $this->request
            ->getPost('password');

        $modelAdmin = new ModelAdminPengguna();

        $admin = $modelAdmin
            ->ambilBerdasarkanUsername(
                $username
            );

        if (
            ! $admin
            || ! password_verify(
                $password,
                $admin['password']
            )
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Username atau password salah.'
                );
        }

        session()->regenerate(true);

        session()->set([
            'admin_masuk' => true,
            'id_admin' => $admin['id_admin'],
            'nama_admin' => $admin['nama_lengkap'],
            'username_admin' => $admin['username'],
        ]);

        return redirect()->to(
            $this->dashboardUrl()
        );
    }

    public function ubahPassword()
    {
        return view(
            'admin/tata_letak',
            [
                'judul' => 'Ubah Password',
                'isi_admin' => view(
                    'admin/ubah_password',
                    [
                        'judul' =>
                            'Ubah Password',
                    ]
                ),
            ]
        );
    }

    public function prosesUbahPassword()
    {
        if (
            strtolower(
                $this->request->getMethod()
            ) !== 'post'
        ) {
            return redirect()->to(
                $this->ubahPasswordUrl()
            );
        }

        $aturan = [
            'password_lama' => [
                'rules' => 'required',
                'errors' => [
                    'required' =>
                        'Password lama wajib diisi.',
                ],
            ],
            'password_baru' => [
                'rules' =>
                    'required|min_length[8]',
                'errors' => [
                    'required' =>
                        'Password baru wajib diisi.',
                    'min_length' =>
                        'Password baru minimal 8 karakter.',
                ],
            ],
            'konfirmasi_password' => [
                'rules' =>
                    'required|matches[password_baru]',
                'errors' => [
                    'required' =>
                        'Konfirmasi password wajib diisi.',
                    'matches' =>
                        'Konfirmasi password tidak sama dengan password baru.',
                ],
            ],
        ];

        if (! $this->validate($aturan)) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    implode(
                        '<br>',
                        $this->validator
                            ->getErrors()
                    )
                );
        }

        $idAdmin = (int) session()
            ->get('id_admin');

        if ($idAdmin <= 0) {
            session()->destroy();

            return redirect()
                ->to(
                    $this->loginUrl()
                )
                ->with(
                    'error',
                    'Sesi admin tidak valid. Silakan login ulang.'
                );
        }

        $modelAdmin = new ModelAdminPengguna();

        $admin = $modelAdmin
            ->ambilBerdasarkanId(
                $idAdmin
            );

        if (! $admin) {
            session()->destroy();

            return redirect()
                ->to(
                    $this->loginUrl()
                )
                ->with(
                    'error',
                    'Akun admin tidak ditemukan atau sudah tidak aktif.'
                );
        }

        $passwordLama = (string) $this->request
            ->getPost('password_lama');

        $passwordBaru = (string) $this->request
            ->getPost('password_baru');

        if (
            ! password_verify(
                $passwordLama,
                $admin['password']
            )
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Password lama salah.'
                );
        }

        if (
            password_verify(
                $passwordBaru,
                $admin['password']
            )
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Password baru tidak boleh sama dengan password lama.'
                );
        }

        $hashPasswordBaru = password_hash(
            $passwordBaru,
            PASSWORD_DEFAULT
        );

        try {
            $berhasil = $modelAdmin
                ->ubahPassword(
                    $idAdmin,
                    $hashPasswordBaru
                );
        } catch (Throwable $e) {
            log_message(
                'error',
                'Gagal mengubah password admin {id}: {message}',
                [
                    'id' => $idAdmin,
                    'message' => $e->getMessage(),
                ]
            );

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Password gagal diubah. Silakan coba kembali.'
                );
        }

        if (! $berhasil) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Password gagal diubah. Silakan coba kembali.'
                );
        }

        session()->regenerate(true);

        return redirect()
            ->to(
                $this->ubahPasswordUrl()
            )
            ->with(
                'success',
                'Password admin berhasil diubah.'
            );
    }

    public function logout()
    {
        session()->remove([
            'admin_masuk',
            'id_admin',
            'nama_admin',
            'username_admin',
        ]);

        session()->regenerate(true);

        return redirect()
            ->to(
                $this->loginUrl()
            )
            ->with(
                'success',
                'Logout berhasil.'
            );
    }
}