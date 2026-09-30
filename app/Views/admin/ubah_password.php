<?php
$inputClass = 'w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 pr-16 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-az-green focus:ring-2 focus:ring-emerald-100';
?>

<div class="mb-6 border-b border-slate-200 pb-6">
    <a
        href="<?= base_url('admin/dashboard/index.php') ?>"
        class="mb-4 inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-900"
    >
        <i class="fa fa-arrow-left" aria-hidden="true"></i>
        Kembali ke Dashboard
    </a>

    <p class="text-sm font-medium text-az-green">Keamanan Akun</p>
    <h2 class="mt-1 text-2xl font-semibold tracking-tight text-slate-900">
        Ubah Password Admin
    </h2>
    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
        Gunakan password baru minimal 8 karakter dan hindari menggunakan password yang sama dengan sebelumnya.
    </p>
</div>

<form
    action="<?= base_url('admin/ubah-password/index.php') ?>"
    method="post"
    class="max-w-3xl space-y-5"
    autocomplete="off"
>
    <section class="rounded-xl border border-slate-200 bg-white p-5 sm:p-6">
        <div class="mb-5 border-b border-slate-100 pb-4">
            <h3 class="text-base font-semibold text-slate-900">
                Verifikasi Password
            </h3>
            <p class="mt-1 text-sm text-slate-500">
                Masukkan password lama lalu tentukan password baru.
            </p>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="password_lama" class="mb-1.5 block text-sm font-medium text-slate-700">
                    Password Lama
                    <span class="text-red-500">*</span>
                </label>

                <div class="relative">
                    <input
                        type="password"
                        name="password_lama"
                        id="password_lama"
                        class="<?= $inputClass ?>"
                        placeholder="Masukkan password lama"
                        autocomplete="current-password"
                        required
                    >

                    <button
                        type="button"
                        class="absolute right-2 top-1/2 -translate-y-1/2 rounded-md px-2 py-1 text-xs font-medium text-az-green hover:bg-emerald-50"
                        data-toggle-password="password_lama"
                        aria-label="Tampilkan password lama"
                    >
                        Lihat
                    </button>
                </div>
            </div>

            <div>
                <label for="password_baru" class="mb-1.5 block text-sm font-medium text-slate-700">
                    Password Baru
                    <span class="text-red-500">*</span>
                </label>

                <div class="relative">
                    <input
                        type="password"
                        name="password_baru"
                        id="password_baru"
                        class="<?= $inputClass ?>"
                        placeholder="Minimal 8 karakter"
                        autocomplete="new-password"
                        minlength="8"
                        required
                    >

                    <button
                        type="button"
                        class="absolute right-2 top-1/2 -translate-y-1/2 rounded-md px-2 py-1 text-xs font-medium text-az-green hover:bg-emerald-50"
                        data-toggle-password="password_baru"
                        aria-label="Tampilkan password baru"
                    >
                        Lihat
                    </button>
                </div>
            </div>

            <div>
                <label for="konfirmasi_password" class="mb-1.5 block text-sm font-medium text-slate-700">
                    Konfirmasi Password Baru
                    <span class="text-red-500">*</span>
                </label>

                <div class="relative">
                    <input
                        type="password"
                        name="konfirmasi_password"
                        id="konfirmasi_password"
                        class="<?= $inputClass ?>"
                        placeholder="Ulangi password baru"
                        autocomplete="new-password"
                        minlength="8"
                        required
                    >

                    <button
                        type="button"
                        class="absolute right-2 top-1/2 -translate-y-1/2 rounded-md px-2 py-1 text-xs font-medium text-az-green hover:bg-emerald-50"
                        data-toggle-password="konfirmasi_password"
                        aria-label="Tampilkan konfirmasi password"
                    >
                        Lihat
                    </button>
                </div>
            </div>
        </div>
    </section>

    <div class="flex justify-end gap-2">
        <a
            href="<?= base_url('admin/dashboard/index.php') ?>"
            class="inline-flex h-10 items-center justify-center rounded-lg border border-slate-300 bg-white px-4 text-sm font-medium text-slate-700 hover:bg-slate-50"
        >
            Batal
        </a>

        <button
            type="submit"
            class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-az-green px-4 text-sm font-medium text-white hover:bg-emerald-800"
        >
            <i class="fa fa-floppy-o" aria-hidden="true"></i>
            Simpan Password
        </button>
    </div>
</form>