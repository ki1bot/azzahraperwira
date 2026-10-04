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
    class="sticky top-0 z-50 overflow-visible bg-white shadow-md"
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
            class="absolute left-0 top-full hidden w-full flex-col border-t border-slate-100 bg-white p-3 font-semibold shadow-lg md:static md:flex md:w-auto md:flex-row md:items-center md:space-x-6 md:overflow-visible md:border-0 md:bg-transparent md:p-0 md:shadow-none"
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
                id="unitLayananDropdown"
                class="relative overflow-visible"
            >
                <button
                    id="unitLayananButton"
                    type="button"
                    class="flex w-full items-center justify-between rounded-lg px-4 py-3 text-left transition hover:bg-emerald-50 hover:text-az-green md:w-auto md:p-0 md:hover:bg-transparent"
                    aria-expanded="false"
                    aria-haspopup="true"
                    aria-controls="unitLayananMenu"
                >
                    <span>
                        Unit Layanan
                    </span>

                    <i
                        id="unitLayananIcon"
                        class="fas fa-chevron-down ml-2 text-[10px] transition-transform duration-200"
                        aria-hidden="true"
                    ></i>
                </button>

                <div
                    id="unitLayananMenu"
                    class="hidden w-full rounded-lg bg-gray-50 py-1 md:absolute md:left-0 md:top-full md:z-[100] md:mt-4 md:w-52 md:overflow-visible md:border md:border-slate-100 md:border-t-4 md:border-t-az-green md:bg-white md:py-2 md:shadow-xl"
                    role="menu"
                    aria-labelledby="unitLayananButton"
                >
                    <a
                        href="<?= base_url('index.php/home/unitKBTK') ?>"
                        class="block whitespace-nowrap px-4 py-3 text-sm text-slate-700 transition hover:bg-emerald-50 hover:text-az-green md:py-2.5"
                        role="menuitem"
                    >
                        KB-TK
                    </a>

                    <a
                        href="<?= base_url('index.php/home/unitTPQ') ?>"
                        class="block whitespace-nowrap px-4 py-3 text-sm text-slate-700 transition hover:bg-emerald-50 hover:text-az-green md:py-2.5"
                        role="menuitem"
                    >
                        TPQ dan RTQ
                    </a>

                    <a
                        href="<?= base_url('index.php/home/unitDC') ?>"
                        class="block whitespace-nowrap px-4 py-3 text-sm text-slate-700 transition hover:bg-emerald-50 hover:text-az-green md:py-2.5"
                        role="menuitem"
                    >
                        Daycare
                    </a>

                    <a
                        href="<?= base_url('index.php/home/unitLansia') ?>"
                        class="block whitespace-nowrap px-4 py-3 text-sm text-slate-700 transition hover:bg-emerald-50 hover:text-az-green md:py-2.5"
                        role="menuitem"
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
        const menuButton = document.getElementById('menu-btn');
        const menu = document.getElementById('mobile-menu');

        const unitDropdown = document.getElementById(
            'unitLayananDropdown'
        );

        const unitButton = document.getElementById(
            'unitLayananButton'
        );

        const unitMenu = document.getElementById(
            'unitLayananMenu'
        );

        const unitIcon = document.getElementById(
            'unitLayananIcon'
        );

        const desktopMedia = window.matchMedia(
            '(min-width: 768px)'
        );

        if (
            !nav ||
            !menuButton ||
            !menu ||
            !unitDropdown ||
            !unitButton ||
            !unitMenu
        ) {
            return;
        }

        function mobileMenuIsOpen() {
            return !menu.classList.contains('hidden');
        }

        function unitMenuIsOpen() {
            return !unitMenu.classList.contains('hidden');
        }

        function setMobileMenu(open) {
            if (desktopMedia.matches) {
                menu.classList.add('hidden');

                menuButton.setAttribute(
                    'aria-expanded',
                    'false'
                );

                menuButton.setAttribute(
                    'aria-label',
                    'Buka menu navigasi'
                );

                return;
            }

            menu.classList.toggle(
                'hidden',
                !open
            );

            menuButton.setAttribute(
                'aria-expanded',
                open ? 'true' : 'false'
            );

            menuButton.setAttribute(
                'aria-label',
                open
                    ? 'Tutup menu navigasi'
                    : 'Buka menu navigasi'
            );

            if (!open) {
                setUnitMenu(false);
            }
        }

        function setUnitMenu(open) {
            unitMenu.classList.toggle(
                'hidden',
                !open
            );

            unitButton.setAttribute(
                'aria-expanded',
                open ? 'true' : 'false'
            );

            if (unitIcon) {
                unitIcon.classList.toggle(
                    'rotate-180',
                    open
                );
            }
        }

        menuButton.addEventListener(
            'click',
            function (event) {
                event.preventDefault();
                event.stopPropagation();

                setMobileMenu(
                    !mobileMenuIsOpen()
                );
            }
        );

        unitButton.addEventListener(
            'click',
            function (event) {
                event.preventDefault();
                event.stopPropagation();

                setUnitMenu(
                    !unitMenuIsOpen()
                );
            }
        );

        unitMenu
            .querySelectorAll('a')
            .forEach(function (link) {
                link.addEventListener(
                    'click',
                    function () {
                        setUnitMenu(false);

                        if (
                            !desktopMedia.matches
                        ) {
                            setMobileMenu(false);
                        }
                    }
                );
            });

        menu
            .querySelectorAll(':scope > a')
            .forEach(function (link) {
                link.addEventListener(
                    'click',
                    function () {
                        setUnitMenu(false);

                        if (
                            !desktopMedia.matches
                        ) {
                            setMobileMenu(false);
                        }
                    }
                );
            });

        document.addEventListener(
            'click',
            function (event) {
                if (
                    unitMenuIsOpen() &&
                    !unitDropdown.contains(
                        event.target
                    )
                ) {
                    setUnitMenu(false);
                }

                if (
                    !desktopMedia.matches &&
                    mobileMenuIsOpen() &&
                    !nav.contains(
                        event.target
                    )
                ) {
                    setMobileMenu(false);
                }
            }
        );

        document.addEventListener(
            'keydown',
            function (event) {
                if (
                    event.key !== 'Escape'
                ) {
                    return;
                }

                if (
                    unitMenuIsOpen()
                ) {
                    setUnitMenu(false);
                    unitButton.focus();

                    return;
                }

                if (
                    !desktopMedia.matches &&
                    mobileMenuIsOpen()
                ) {
                    setMobileMenu(false);
                    menuButton.focus();
                }
            }
        );

        function handleViewportChange() {
            setUnitMenu(false);

            if (
                desktopMedia.matches
            ) {
                menu.classList.add(
                    'hidden'
                );

                menuButton.setAttribute(
                    'aria-expanded',
                    'false'
                );

                menuButton.setAttribute(
                    'aria-label',
                    'Buka menu navigasi'
                );
            } else {
                setMobileMenu(false);
            }
        }

        if (
            typeof desktopMedia.addEventListener
            === 'function'
        ) {
            desktopMedia.addEventListener(
                'change',
                handleViewportChange
            );
        } else {
            desktopMedia.addListener(
                handleViewportChange
            );
        }
    });
</script>