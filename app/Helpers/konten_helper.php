<?php

if (! function_exists('konten_format')) {
    function konten_format(?string $teks): string
    {
        $teks = (string) $teks;

        if (trim($teks) === '') {
            return '';
        }

        $teks = str_replace(["\r\n", "\r"], "\n", $teks);

        $teks = htmlspecialchars(
            $teks,
            ENT_QUOTES | ENT_SUBSTITUTE,
            'UTF-8'
        );

        $kode = [];

        $teks = preg_replace_callback(
            '/`(.+?)`/s',
            static function (array $match) use (&$kode): string {
                $token = "\x1A" . count($kode) . "\x1A";

                $kode[$token] = '<code>'
                    . $match[1]
                    . '</code>';

                return $token;
            },
            $teks
        ) ?? $teks;

        $formatInline = null;

        $formatInline = static function (
            string $nilai
        ) use (
            &$formatInline
        ): string {
            $nilai = preg_replace_callback(
                '/\*\*\*(.+?)\*\*\*/s',
                static function (
                    array $match
                ) use (
                    &$formatInline
                ): string {
                    return '<strong><em>'
                        . $formatInline($match[1])
                        . '</em></strong>';
                },
                $nilai
            ) ?? $nilai;

            $nilai = preg_replace_callback(
                '/\*\*(.+?)\*\*/s',
                static function (
                    array $match
                ) use (
                    &$formatInline
                ): string {
                    return '<strong>'
                        . $formatInline($match[1])
                        . '</strong>';
                },
                $nilai
            ) ?? $nilai;

            $nilai = preg_replace_callback(
                '/__(.+?)__/s',
                static function (
                    array $match
                ) use (
                    &$formatInline
                ): string {
                    return '<u>'
                        . $formatInline($match[1])
                        . '</u>';
                },
                $nilai
            ) ?? $nilai;

            $nilai = preg_replace_callback(
                '/~~(.+?)~~/s',
                static function (
                    array $match
                ) use (
                    &$formatInline
                ): string {
                    return '<del>'
                        . $formatInline($match[1])
                        . '</del>';
                },
                $nilai
            ) ?? $nilai;

            $nilai = preg_replace_callback(
                '/(?<!\*)\*(?!\*)(.+?)(?<!\*)\*(?!\*)/s',
                static function (
                    array $match
                ) use (
                    &$formatInline
                ): string {
                    return '<em>'
                        . $formatInline($match[1])
                        . '</em>';
                },
                $nilai
            ) ?? $nilai;

            return $nilai;
        };

        $teks = $formatInline($teks);

        if ($kode !== []) {
            $teks = strtr(
                $teks,
                $kode
            );
        }

        return nl2br(
            $teks,
            false
        );
    }
}

if (! function_exists('konten_plain')) {
    function konten_plain(?string $teks): string
    {
        $teks = strip_tags(
            (string) $teks
        );

        $pola = [
            '/\*\*\*(.+?)\*\*\*/s',
            '/\*\*(.+?)\*\*/s',
            '/__(.+?)__/s',
            '/~~(.+?)~~/s',
            '/`(.+?)`/s',
            '/(?<!\*)\*(?!\*)(.+?)(?<!\*)\*(?!\*)/s',
        ];

        foreach ($pola as $regex) {
            $teks = preg_replace(
                $regex,
                '$1',
                $teks
            ) ?? $teks;
        }

        return trim($teks);
    }
}