<div class="form-page-head">
    <a
        href="<?= base_url('admin/dashboard/index.php') ?>"
        class="back-link"
    >
        <i class="fa fa-arrow-left" aria-hidden="true"></i>
        Kembali ke Dashboard
    </a>

    <div class="section-heading">
        <span class="section-kicker">
            Keamanan Akun
        </span>

        <h2>Ubah Password Admin</h2>

        <p>
            Gunakan password baru minimal 8 karakter dan jangan
            gunakan password yang sama dengan sebelumnya.
        </p>
    </div>
</div>

<form
    action="<?= base_url('admin/ubah-password/index.php') ?>"
    method="post"
    class="admin-form password-form"
    autocomplete="off"
>
    <section class="form-section">
        <div class="form-section-head">
            <span class="form-section-icon">
                <i class="fa fa-key" aria-hidden="true"></i>
            </span>

            <div>
                <h3>Verifikasi Password</h3>
                <p>
                    Masukkan password lama lalu tentukan
                    password baru.
                </p>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group full">
                <label
                    for="password_lama"
                    class="form-label"
                >
                    Password Lama
                    <span class="required-mark">*</span>
                </label>

                <div class="password-field">
                    <input
                        type="password"
                        name="password_lama"
                        id="password_lama"
                        class="form-control"
                        placeholder="Masukkan password lama"
                        autocomplete="current-password"
                        required
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        data-toggle-password="password_lama"
                        aria-label="Tampilkan password lama"
                    >
                        Lihat
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label
                    for="password_baru"
                    class="form-label"
                >
                    Password Baru
                    <span class="required-mark">*</span>
                </label>

                <div class="password-field">
                    <input
                        type="password"
                        name="password_baru"
                        id="password_baru"
                        class="form-control"
                        placeholder="Minimal 8 karakter"
                        autocomplete="new-password"
                        minlength="8"
                        required
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        data-toggle-password="password_baru"
                        aria-label="Tampilkan password baru"
                    >
                        Lihat
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label
                    for="konfirmasi_password"
                    class="form-label"
                >
                    Konfirmasi Password Baru
                    <span class="required-mark">*</span>
                </label>

                <div class="password-field">
                    <input
                        type="password"
                        name="konfirmasi_password"
                        id="konfirmasi_password"
                        class="form-control"
                        placeholder="Ulangi password baru"
                        autocomplete="new-password"
                        minlength="8"
                        required
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        data-toggle-password="konfirmasi_password"
                        aria-label="Tampilkan konfirmasi password"
                    >
                        Lihat
                    </button>
                </div>
            </div>
        </div>
    </section>

    <div class="form-actions form-actions-sticky">
        <a
            href="<?= base_url('admin/dashboard/index.php') ?>"
            class="btn btn-secondary"
        >
            Batal
        </a>

        <button
            type="submit"
            class="btn btn-primary"
        >
            <i class="fa fa-floppy-o" aria-hidden="true"></i>
            Simpan Password
        </button>
    </div>
</form>