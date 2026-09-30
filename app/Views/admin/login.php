<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <title><?= esc($judul ?? 'Login Admin') ?> - Az-Zahra Perwira</title>

    <link rel="stylesheet" href="<?= base_url('assets/css/tailwind.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/font-awesome/css/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
    <script src="<?= base_url('js/admin.js') ?>" defer></script>
</head>

<body class="min-h-screen bg-slate-50 text-slate-700 antialiased">
    <main class="flex min-h-screen items-center justify-center px-4 py-8 sm:px-6">
        <div class="grid w-full max-w-5xl overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm lg:grid-cols-[0.9fr_1.1fr]">
            <section class="hidden bg-az-green p-10 text-white lg:flex lg:flex-col lg:justify-between">
                <div class="flex items-center gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-lg bg-white text-sm font-bold text-az-green">
                        AZ
                    </span>

                    <div>
                        <h1 class="text-base font-semibold">
                            Az-Zahra Perwira
                        </h1>

                        <p class="mt-0.5 text-xs text-emerald-100">
                            Admin Website
                        </p>
                    </div>
                </div>

                <div class="max-w-sm">
                    <h2 class="text-3xl font-semibold leading-tight">
                        Kelola isi website dengan lebih sederhana.
                    </h2>

                    <p class="mt-4 text-sm leading-6 text-emerald-100">
                        Perbarui profil yayasan, tenaga pengajar,
                        unit pendidikan, berita, dan informasi lainnya
                        dari satu tempat.
                    </p>

                    <div class="mt-8 space-y-3 text-sm text-emerald-50">
                        <div class="flex items-center gap-3">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-white/15">
                                <i
                                    class="fa fa-check text-[10px]"
                                    aria-hidden="true"
                                ></i>
                            </span>

                            <span>
                                Form mudah dipahami
                            </span>
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-white/15">
                                <i
                                    class="fa fa-check text-[10px]"
                                    aria-hidden="true"
                                ></i>
                            </span>

                            <span>
                                Tidak perlu mengisi ID atau kode konten
                            </span>
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-white/15">
                                <i
                                    class="fa fa-check text-[10px]"
                                    aria-hidden="true"
                                ></i>
                            </span>

                            <span>
                                Konten langsung mengikuti data website
                            </span>
                        </div>
                    </div>
                </div>

                <p class="text-xs text-emerald-100">
                    Yayasan Az-Zahra Perwira
                </p>
            </section>

            <section class="p-6 sm:p-10 lg:p-12">
                <div class="mx-auto max-w-md">
                    <div class="mb-8 lg:hidden">
                        <div class="flex items-center gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-az-green text-sm font-bold text-white">
                                AZ
                            </span>

                            <div>
                                <h1 class="text-sm font-semibold text-slate-900">
                                    Az-Zahra Perwira
                                </h1>

                                <p class="text-xs text-slate-500">
                                    Admin Website
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-7">
                        <p class="text-sm font-medium text-az-green">
                            Selamat Datang
                        </p>

                        <h2 class="mt-1 text-2xl font-semibold tracking-tight text-slate-900">
                            Masuk ke Admin
                        </h2>

                        <p class="mt-2 text-sm text-slate-500">
                            Gunakan akun admin yang sudah terdaftar.
                        </p>
                    </div>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="mb-5 flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            <i
                                class="fa fa-exclamation-circle mt-0.5"
                                aria-hidden="true"
                            ></i>

                            <div>
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="mb-5 flex items-start gap-3 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                            <i
                                class="fa fa-check-circle mt-0.5"
                                aria-hidden="true"
                            ></i>

                            <div>
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <form
                        action="<?= base_url('admin/login/index.php') ?>"
                        method="post"
                        class="space-y-5"
                        autocomplete="off"
                    >
                        <div>
                            <label
                                for="username"
                                class="mb-1.5 block text-sm font-medium text-slate-700"
                            >
                                Username
                            </label>

                            <div class="relative">
                                <i
                                    class="fa fa-user absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-slate-400"
                                    aria-hidden="true"
                                ></i>

                                <input
                                    type="text"
                                    name="username"
                                    id="username"
                                    class="w-full rounded-lg border border-slate-300 bg-white py-2.5 pl-10 pr-3.5 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-az-green focus:ring-2 focus:ring-emerald-100"
                                    value="<?= esc(
                                        old('username'),
                                        'attr'
                                    ) ?>"
                                    placeholder="Masukkan username"
                                    autocomplete="username"
                                    required
                                    autofocus
                                >
                            </div>
                        </div>

                        <div>
                            <label
                                for="password"
                                class="mb-1.5 block text-sm font-medium text-slate-700"
                            >
                                Password
                            </label>

                            <div class="relative">
                                <i
                                    class="fa fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-slate-400"
                                    aria-hidden="true"
                                ></i>

                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="w-full rounded-lg border border-slate-300 bg-white py-2.5 pl-10 pr-16 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-az-green focus:ring-2 focus:ring-emerald-100"
                                    placeholder="Masukkan password"
                                    autocomplete="current-password"
                                    required
                                >

                                <button
                                    type="button"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 rounded-md px-2 py-1 text-xs font-medium text-az-green hover:bg-emerald-50"
                                    data-toggle-password="password"
                                    aria-label="Tampilkan password"
                                >
                                    Lihat
                                </button>
                            </div>
                        </div>

                        <button
                            type="submit"
                            class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-lg bg-az-green px-4 text-sm font-medium text-white transition hover:bg-emerald-800"
                        >
                            Masuk ke Dashboard

                            <i
                                class="fa fa-arrow-right"
                                aria-hidden="true"
                            ></i>
                        </button>
                    </form>

                    <p class="mt-7 border-t border-slate-100 pt-5 text-center text-xs leading-5 text-slate-400">
                        Halaman ini hanya untuk pengelola website
                        Az-Zahra Perwira.
                    </p>
                </div>
            </section>
        </div>
    </main>
</body>
</html>