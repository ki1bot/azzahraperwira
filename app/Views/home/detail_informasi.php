<?php

$detailInformasi = $detailInformasi ?? [];

$judul = trim(
    (string) (
        $detailInformasi['judul']
        ?? ''
    )
);

$isi = trim(
    (string) (
        $detailInformasi['isi']
        ?? ''
    )
);

$gambar = trim(
    (string) (
        $detailInformasi['gambar']
        ?? ''
    )
);

$judul = $judul !== ''
    ? $judul
    : 'Detail Informasi';

$urlKembali = base_url(
    'index.php/home/informasi'
);
?>

<section class="bg-az-green py-12 md:py-16">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="max-w-4xl mx-auto text-center">
            <p class="mb-3 text-sm font-bold tracking-widest text-az-gold uppercase">
                Informasi dan Kegiatan
            </p>

            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold leading-tight text-white">
                <?= esc($judul) ?>
            </h1>
        </div>
    </div>
</section>

<main class="container mx-auto px-4 sm:px-6 py-10 md:py-14">
    <div class="max-w-5xl mx-auto">
        <div class="mb-6">
            <a
                href="<?= esc(
                    $urlKembali,
                    'attr'
                ) ?>"
                class="inline-flex items-center gap-2 text-az-green font-bold hover:underline focus:outline-none focus:ring-2 focus:ring-az-green focus:ring-offset-2 rounded-md"
            >
                <span aria-hidden="true">
                    ←
                </span>

                <span>
                    Kembali ke Informasi
                </span>
            </a>
        </div>

        <article class="bg-white rounded-2xl md:rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
            <?php if ($gambar !== ''): ?>
                <figure class="relative w-full bg-slate-100 overflow-hidden">
                    <div class="relative w-full aspect-[16/9]">
                        <img
                            src="<?= esc(
                                base_url($gambar),
                                'attr'
                            ) ?>"
                            alt="<?= esc(
                                $judul,
                                'attr'
                            ) ?>"
                            class="absolute inset-0 block w-full h-full object-cover object-center"
                            decoding="async"
                        >
                    </div>
                </figure>
            <?php endif; ?>

            <div class="p-6 sm:p-8 md:p-12">
                <header class="mb-8 pb-8 border-b border-gray-200">
                    <span class="inline-flex items-center px-4 py-2 mb-5 rounded-full bg-emerald-50 text-az-green text-sm font-bold">
                        Informasi Terbaru
                    </span>

                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold leading-tight text-az-green">
                        <?= esc($judul) ?>
                    </h2>
                </header>

                <?php if ($isi !== ''): ?>
                    <div class="text-base sm:text-lg text-gray-700 leading-8 break-words">
                        <?= konten_format(
                            $isi
                        ) ?>
                    </div>
                <?php else: ?>
                    <div class="rounded-2xl bg-gray-50 border border-gray-200 p-6 text-gray-600">
                        Informasi lengkap untuk kegiatan ini belum tersedia.
                    </div>
                <?php endif; ?>

                <footer class="mt-10 pt-8 border-t border-gray-200">
                    <a
                        href="<?= esc(
                            $urlKembali,
                            'attr'
                        ) ?>"
                        class="inline-flex w-full sm:w-auto items-center justify-center gap-2 bg-az-green text-white font-bold px-7 py-3 rounded-full hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-az-green focus:ring-offset-2 transition duration-300"
                    >
                        <span aria-hidden="true">
                            ←
                        </span>

                        <span>
                            Kembali ke Informasi
                        </span>
                    </a>
                </footer>
            </div>
        </article>
    </div>
</main>