<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <title><?= esc($title ?? 'Yayasan Azzahra Perwira') ?></title>

    <link rel="icon" type="image/png" href="<?= base_url('assets/img/bg-icon-title.jpg') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/tailwind.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/responsive.css') ?>">
</head>

<body class="bg-gray-50">
    <?= view('umum/header') ?>

    <?= view($content, [
        'title'           => $title ?? 'Yayasan Azzahra Perwira',
        'statusMenu'      => $statusMenu ?? '',
        'content'         => $content ?? '',
        'kodeHalaman'     => $kodeHalaman ?? '',
        'namaHalaman'     => $namaHalaman ?? '',
        'kontenHalaman'   => $kontenHalaman ?? [],
        'kontenMap'       => $kontenMap ?? [],
        'footerMap'       => $footerMap ?? [],
        'detailInformasi' => $detailInformasi ?? [],
    ]) ?>

    <?= view('umum/footer', [
        'footerMap' => $footerMap ?? [],
    ]) ?>
</body>

</html>