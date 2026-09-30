<!DOCTYPE html>
<html lang="id" data-admin-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title><?= esc($judul ?? 'Login Admin') ?> - Az-Zahra Perwira</title>

    <script src="<?= base_url('js/admin.js') ?>"></script>

    <link
        rel="stylesheet"
        href="<?= base_url('assets/font-awesome/css/font-awesome.min.css') ?>"
    >
    <link
        rel="stylesheet"
        href="<?= base_url('assets/css/admin.css') ?>"
    >
    <link
        rel="stylesheet"
        href="<?= base_url('assets/css/responsive.css') ?>"
    >
</head>

<body
    class="login-body"
    style="--login-bg-image: url('<?= base_url('assets/img/home/home.jpg') ?>');"
>
    <button
        type="button"
        class="theme-toggle"
        id="themeToggle"
        aria-label="Ganti tema"
    >
        <i
            class="fa fa-moon-o"
            id="themeIcon"
            aria-hidden="true"
        ></i>
        <span id="themeText">Mode Gelap</span>
    </button>

    <main class="login-shell">
        <section class="login-hero">
            <div class="login-brand">
                <span class="login-logo">AZ</span>

                <div>
                    <h1>Az-Zahra Perwira</h1>
                    <p>Panel Pengelola Website</p>
                </div>
            </div>

            <div class="login-copy">
                <span class="login-kicker">AREA ADMIN</span>

                <h2>
                    Kelola informasi website dengan lebih sederhana.
                </h2>

                <p>
                    Perbarui halaman, tenaga pengajar, berita,
                    galeri, dan informasi yayasan melalui satu panel.
                </p>

                <div class="login-feature-list">
                    <span>
                        <i class="fa fa-check" aria-hidden="true"></i>
                        Form lebih mudah dipahami
                    </span>

                    <span>
                        <i class="fa fa-check" aria-hidden="true"></i>
                        Tidak perlu mengisi ID atau kode konten
                    </span>

                    <span>
                        <i class="fa fa-check" aria-hidden="true"></i>
                        Perubahan langsung mengikuti data website
                    </span>
                </div>
            </div>
        </section>

        <section class="login-panel">
            <div class="panel-header">
                <span class="section-kicker">
                    Selamat Datang
                </span>

                <h2>Masuk ke Admin</h2>
                <p>
                    Gunakan akun admin yang sudah terdaftar.
                </p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error">
                    <i
                        class="fa fa-exclamation-circle"
                        aria-hidden="true"
                    ></i>

                    <div>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <i
                        class="fa fa-check-circle"
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
                class="form login-form"
                autocomplete="off"
            >
                <div class="form-group">
                    <label
                        for="username"
                        class="form-label"
                    >
                        Username
                    </label>

                    <div class="input-with-icon">
                        <i
                            class="fa fa-user"
                            aria-hidden="true"
                        ></i>

                        <input
                            type="text"
                            name="username"
                            id="username"
                            class="form-control"
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

                <div class="form-group">
                    <label
                        for="password"
                        class="form-label"
                    >
                        Password
                    </label>

                    <div class="password-field input-with-icon">
                        <i
                            class="fa fa-lock"
                            aria-hidden="true"
                        ></i>

                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            data-toggle-password="password"
                            aria-label="Tampilkan password"
                        >
                            Lihat
                        </button>
                    </div>
                </div>

                <button
                    type="submit"
                    class="btn btn-primary btn-block login-submit"
                >
                    Masuk ke Dashboard
                    <i
                        class="fa fa-arrow-right"
                        aria-hidden="true"
                    ></i>
                </button>
            </form>

            <p class="login-note">
                <i
                    class="fa fa-lock"
                    aria-hidden="true"
                ></i>
                Halaman ini hanya untuk pengelola website
                Az-Zahra Perwira.
            </p>
        </section>
    </main>
</body>
</html>