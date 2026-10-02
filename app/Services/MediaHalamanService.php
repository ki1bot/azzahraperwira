<?php

namespace App\Services;

use CodeIgniter\HTTP\IncomingRequest;
use RuntimeException;

class MediaHalamanService
{
    public function aturanValidasi(
        IncomingRequest $request,
        string $tipeUpload
    ): array {
        if ($tipeUpload === 'image') {
            $file = $request->getFile('gambar');

            if (
                ! $file
                || $file->getError() === UPLOAD_ERR_NO_FILE
            ) {
                return [];
            }

            return [
                'gambar' =>
                    'is_image[gambar]' .
                    '|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]' .
                    '|max_size[gambar,5120]',
            ];
        }

        if ($tipeUpload === 'file') {
            $file = $request->getFile('file_dokumen');

            if (
                ! $file
                || $file->getError() === UPLOAD_ERR_NO_FILE
            ) {
                return [];
            }

            return [
                'file_dokumen' =>
                    'ext_in[file_dokumen,pdf]' .
                    '|mime_in[file_dokumen,application/pdf,application/x-pdf]' .
                    '|max_size[file_dokumen,10240]',
            ];
        }

        return [];
    }

    public function upload(
        IncomingRequest $request,
        string $tipeUpload
    ): ?string {
        if ($tipeUpload === 'image') {
            return $this->uploadFile(
                $request,
                'gambar',
                'uploads/halaman'
            );
        }

        if ($tipeUpload === 'file') {
            return $this->uploadFile(
                $request,
                'file_dokumen',
                'uploads/file'
            );
        }

        return null;
    }

    public function hapus(?string $path): void
    {
        $path = trim((string) $path);

        if ($path === '') {
            return;
        }

        $fileHalaman = str_starts_with(
            $path,
            'uploads/halaman/'
        );

        $fileDokumen = str_starts_with(
            $path,
            'uploads/file/'
        );

        if (! $fileHalaman && ! $fileDokumen) {
            return;
        }

        $fullPath = FCPATH . $path;

        if (is_file($fullPath)) {
            unlink($fullPath);
        }
    }

    private function uploadFile(
        IncomingRequest $request,
        string $namaInput,
        string $folderPublik
    ): ?string {
        $file = $request->getFile($namaInput);

        if (
            ! $file
            || ! $file->isValid()
            || $file->hasMoved()
        ) {
            return null;
        }

        $folderPublik = trim($folderPublik, '/');
        $folderTujuan = FCPATH . $folderPublik;

        if (
            ! is_dir($folderTujuan)
            && ! mkdir($folderTujuan, 0775, true)
            && ! is_dir($folderTujuan)
        ) {
            throw new RuntimeException(
                'Folder upload tidak dapat dibuat.'
            );
        }

        $namaFile = $file->getRandomName();

        $file->move(
            $folderTujuan,
            $namaFile
        );

        return $folderPublik . '/' . $namaFile;
    }
}