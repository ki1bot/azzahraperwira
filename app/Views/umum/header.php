<div class="hidden bg-az-green px-4 py-2 text-sm text-white md:block">
    <div class="container mx-auto flex items-center justify-between gap-6">
        <span class="flex items-center gap-2">
            <a
                href="https://wa.me/6285215585570"
                target="_blank"
                rel="noopener noreferrer"
                class="wa-link inline-flex items-center gap-1.5"
            >
                <i
                    class="fab fa-whatsapp wa-icon"
                    aria-hidden="true"
                ></i>

                <span>
                    0852-1558-5570
                </span>
            </a>

            <span aria-hidden="true">
                |
            </span>

            <a
                href="https://wa.me/6287881701715"
                target="_blank"
                rel="noopener noreferrer"
                class="wa-link inline-flex items-center gap-1.5"
            >
                <i
                    class="fab fa-whatsapp wa-icon"
                    aria-hidden="true"
                ></i>

                <span>
                    0878-8170-1715
                </span>
            </a>
        </span>

        <span class="text-right">
            Selamat Datang di Website Resmi Yayasan Az-Zahra Perwira
        </span>
    </div>
</div>

<nav
    id="siteNavigation"
    class="sticky top-0 z-50 bg-white shadow-md"
>
    <div class="container mx-auto flex min-h-16 items-center justify-between gap-3 px-4 py-3 md:py-4">
        <a
            href="<?= base_url('index.php/home/beranda') ?>"
            class="min-w-0"
            aria-label="Halaman utama Az-Zahra Perwira"
        >
            <h1 class="truncate text-lg font-black italic text-az-green sm:text-xl md:text-2xl">
                AZ-ZAHRA PERWIRA
            </h1>
        </a>

        <button
            id="menu-btn"
            type="button"
            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg border border-slate-200 text-az-green transition hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-az-green focus:ring-offset-2 md:hidden"
            aria-label="Buka menu navigasi"
            aria-expanded="false"
            aria-controls="mobile-menu"
        >
            <svg
                class="h-6 w-6"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                aria-hidden="true"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                ></path>
            </svg>
        </button>

        <div
            id="mobile-menu"
            class="absolute left-0 top-full hidden w-full flex-col border-t border-slate-100 bg-white p-3 font-semibold shadow-lg md:static md:flex md:w-auto md:flex-row md:items-center md:space-x-6 md:border-0 md:bg-transparent md:p-0 md:shadow-none"
        >
            <a
                href="<?= base_url('index.php/home/beranda') ?>"
                class="block rounded-lg px-4 py-3 transition hover:bg-emerald-50 hover:text-az-green md:p-0 md:hover:bg-transparent"
            >
                Home
            </a>

            <a
                href="<?= base_url('index.php/home/profile') ?>"
                class="block rounded-lg px-4 py-3 transition hover:bg-emerald-50 hover:text-az-green md:p-0 md:hover:bg-transparent"
            >
                Profile
            </a>

            <a
                href="<?= base_url('index.php/home/tenagaPengajar') ?>"
                class="block rounded-lg px-4 py-3 transition hover:bg-emerald-50 hover:text-az-green md:p-0 md:hover:bg-transparent"
            >
                Tenaga Pengajar
            </a>

            <div
                class="relative"
                x-data="{ open: false }"
                @click.away="open = false"
            >
                <button
                    type="button"
                    @click="open = !open"
                    class="flex w-full items-center justify-between rounded-lg px-4 py-3 text-left transition hover:bg-emerald-50 hover:text-az-green md:p-0 md:hover:bg-transparent"
                >
                    <span>
                        Unit Layanan
                    </span>

                    <span
                        class="ml-2 text-xs"
                        aria-hidden="true"
                    >
                        ▾
                    </span>
                </button>

                <div
                    x-show="open"
                    x-transition
                    class="z-50 mt-1 w-full rounded-lg bg-gray-50 md:absolute md:mt-2 md:w-48 md:border-t-4 md:border-az-green md:bg-white md:py-2 md:shadow-xl"
                >
                    <a
                        href="<?= base_url('index.php/home/unitKBTK') ?>"
                        class="block px-4 py-3 hover:bg-emerald-100 md:py-2"
                    >
                        KB-TK
                    </a>

                    <a
                        href="<?= base_url('index.php/home/unitTPQ') ?>"
                        class="block px-4 py-3 hover:bg-emerald-100 md:py-2"
                    >
                        TPQ dan RTQ
                    </a>

                    <a
                        href="<?= base_url('index.php/home/unitDC') ?>"
                        class="block px-4 py-3 hover:bg-emerald-100 md:py-2"
                    >
                        Daycare
                    </a>

                    <a
                        href="<?= base_url('index.php/home/unitLansia') ?>"
                        class="block px-4 py-3 hover:bg-emerald-100 md:py-2"
                    >
                        Pondok Lansia
                    </a>
                </div>
            </div>

            <a
                href="<?= base_url('index.php/home/informasi') ?>"
                class="block rounded-lg px-4 py-3 transition hover:bg-emerald-50 hover:text-az-green md:p-0 md:hover:bg-transparent"
            >
                Informasi
            </a>

            <a
                href="<?= base_url('admin/login/index.php') ?>"
                class="mt-1 inline-flex min-h-11 w-full items-center justify-center rounded-lg bg-az-green px-5 text-sm font-bold text-white transition hover:bg-emerald-700 md:ml-1 md:mt-0 md:w-auto"
            >
                Login
            </a>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nav = document.getElementById('siteNavigation');
        const button = document.getElementById('menu-btn');
        const menu = document.getElementById('mobile-menu');
        const desktopMedia = window.matchMedia('(min-width: 768px)');

        if (!button || !menu || !nav) {
            return;
        }

        function isOpen() {
            return !menu.classList.contains('hidden');
        }

        function setOpen(open) {
            if (desktopMedia.matches) {
                menu.classList.add('hidden');
                button.setAttribute('aria-expanded', 'false');
                button.setAttribute('aria-label', 'Buka menu navigasi');
                return;
            }

            menu.classList.toggle('hidden', !open);

            button.setAttribute(
                'aria-expanded',
                open ? 'true' : 'false'
            );

            button.setAttribute(
                'aria-label',
                open ? 'Tutup menu navigasi' : 'Buka menu navigasi'
            );
        }

        button.addEventListener('click', function (event) {
            event.stopPropagation();

            setOpen(!isOpen());
        });

        menu.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                if (!desktopMedia.matches) {
                    setOpen(false);
                }
            });
        });

        document.addEventListener('click', function (event) {
            if (
                !desktopMedia.matches &&
                isOpen() &&
                !nav.contains(event.target)
            ) {
                setOpen(false);
            }
        });

        document.addEventListener('keydown', function (event) {
            if (
                event.key === 'Escape' &&
                !desktopMedia.matches
            ) {
                setOpen(false);
            }
        });

        if (typeof desktopMedia.addEventListener === 'function') {
            desktopMedia.addEventListener('change', function () {
                setOpen(false);
            });
        } else {
            desktopMedia.addListener(function () {
                setOpen(false);
            });
        }
    });
</script>