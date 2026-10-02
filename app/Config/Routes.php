<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

$routes->get('/', 'Home::index');

$routes->get('home', 'Home::index');
$routes->get('home/beranda', 'Home::beranda');
$routes->get('home/profile', 'Home::profile');
$routes->get('home/tenagaPengajar', 'Home::tenagaPengajar');
$routes->get('home/unitKBTK', 'Home::unitKBTK');
$routes->get('home/unitTPQ', 'Home::unitTPQ');
$routes->get('home/unitDC', 'Home::unitDC');
$routes->get('home/unitLansia', 'Home::unitLansia');
$routes->get('home/informasi', 'Home::informasi');
$routes->get(
    'home/informasi/detail/(:segment)',
    'Home::detailInformasi/$1'
);

$routes->get('index.php', 'Home::index');
$routes->get('index.php/home', 'Home::index');
$routes->get('index.php/home/beranda', 'Home::beranda');
$routes->get('index.php/home/profile', 'Home::profile');
$routes->get(
    'index.php/home/tenagaPengajar',
    'Home::tenagaPengajar'
);
$routes->get(
    'index.php/home/unitKBTK',
    'Home::unitKBTK'
);
$routes->get(
    'index.php/home/unitTPQ',
    'Home::unitTPQ'
);
$routes->get(
    'index.php/home/unitDC',
    'Home::unitDC'
);
$routes->get(
    'index.php/home/unitLansia',
    'Home::unitLansia'
);
$routes->get(
    'index.php/home/informasi',
    'Home::informasi'
);
$routes->get(
    'index.php/home/informasi/detail/(:segment)',
    'Home::detailInformasi/$1'
);

$routes->get(
    'admin/login/index.php',
    'Admin\Otentikasi::login'
);

$routes->post(
    'admin/login/index.php',
    'Admin\Otentikasi::prosesLogin'
);

$routes->group(
    'admin',
    ['filter' => 'filteradmin'],
    static function (RouteCollection $routes) {
        $routes->get(
            'dashboard/index.php',
            'Admin\KelolaHalaman::dashboard'
        );

        $routes->post(
            'logout/index.php',
            'Admin\Otentikasi::logout'
        );

        $routes->get(
            'ubah-password/index.php',
            'Admin\Otentikasi::ubahPassword'
        );

        $routes->post(
            'ubah-password/index.php',
            'Admin\Otentikasi::prosesUbahPassword'
        );

        $routes->get(
            'beranda/index.php',
            'Admin\KelolaHalaman::index/beranda'
        );

        $routes->get(
            'beranda/edit/(:segment)/index.php',
            'Admin\KelolaHalaman::edit/beranda/$1'
        );

        $routes->post(
            'beranda/update/(:segment)/index.php',
            'Admin\KelolaHalaman::update/beranda/$1'
        );

        $routes->get(
            'profile/index.php',
            'Admin\KelolaHalaman::index/profile'
        );

        $routes->get(
            'profile/edit/(:segment)/index.php',
            'Admin\KelolaHalaman::edit/profile/$1'
        );

        $routes->post(
            'profile/update/(:segment)/index.php',
            'Admin\KelolaHalaman::update/profile/$1'
        );

        $routes->get(
            'tenaga-pengajar/index.php',
            'Admin\KelolaHalaman::index/tenaga-pengajar'
        );

        $routes->get(
            'tenaga-pengajar/tambah/index.php',
            'Admin\KelolaHalaman::tambah/tenaga-pengajar'
        );

        $routes->post(
            'tenaga-pengajar/simpan/index.php',
            'Admin\KelolaHalaman::simpan/tenaga-pengajar'
        );

        $routes->get(
            'tenaga-pengajar/edit/(:segment)/index.php',
            'Admin\KelolaHalaman::edit/tenaga-pengajar/$1'
        );

        $routes->post(
            'tenaga-pengajar/update/(:segment)/index.php',
            'Admin\KelolaHalaman::update/tenaga-pengajar/$1'
        );

        $routes->post(
            'tenaga-pengajar/hapus/(:segment)/index.php',
            'Admin\KelolaHalaman::hapus/tenaga-pengajar/$1'
        );

        $routes->get(
            'unit-kb-tk/index.php',
            'Admin\KelolaHalaman::index/unit-kb-tk'
        );

        $routes->get(
            'unit-kb-tk/edit/(:segment)/index.php',
            'Admin\KelolaHalaman::edit/unit-kb-tk/$1'
        );

        $routes->post(
            'unit-kb-tk/update/(:segment)/index.php',
            'Admin\KelolaHalaman::update/unit-kb-tk/$1'
        );

        $routes->get(
            'unit-tpq/index.php',
            'Admin\KelolaHalaman::index/unit-tpq'
        );

        $routes->get(
            'unit-tpq/edit/(:segment)/index.php',
            'Admin\KelolaHalaman::edit/unit-tpq/$1'
        );

        $routes->post(
            'unit-tpq/update/(:segment)/index.php',
            'Admin\KelolaHalaman::update/unit-tpq/$1'
        );

        $routes->get(
            'unit-dc/index.php',
            'Admin\KelolaHalaman::index/unit-dc'
        );

        $routes->get(
            'unit-dc/edit/(:segment)/index.php',
            'Admin\KelolaHalaman::edit/unit-dc/$1'
        );

        $routes->post(
            'unit-dc/update/(:segment)/index.php',
            'Admin\KelolaHalaman::update/unit-dc/$1'
        );

        $routes->get(
            'unit-lansia/index.php',
            'Admin\KelolaHalaman::index/unit-lansia'
        );

        $routes->get(
            'unit-lansia/edit/(:segment)/index.php',
            'Admin\KelolaHalaman::edit/unit-lansia/$1'
        );

        $routes->post(
            'unit-lansia/update/(:segment)/index.php',
            'Admin\KelolaHalaman::update/unit-lansia/$1'
        );

        $routes->get(
            'informasi/index.php',
            'Admin\KelolaHalaman::index/informasi'
        );

        $routes->get(
            'informasi/tambah/index.php',
            'Admin\KelolaHalaman::tambah/informasi'
        );

        $routes->post(
            'informasi/simpan/index.php',
            'Admin\KelolaHalaman::simpan/informasi'
        );

        $routes->get(
            'informasi/edit/(:segment)/index.php',
            'Admin\KelolaHalaman::edit/informasi/$1'
        );

        $routes->post(
            'informasi/update/(:segment)/index.php',
            'Admin\KelolaHalaman::update/informasi/$1'
        );

        $routes->post(
            'informasi/hapus/(:segment)/index.php',
            'Admin\KelolaHalaman::hapus/informasi/$1'
        );

        $routes->get(
            'footer/index.php',
            'Admin\KelolaHalaman::index/footer'
        );

        $routes->get(
            'footer/edit/(:segment)/index.php',
            'Admin\KelolaHalaman::edit/footer/$1'
        );

        $routes->post(
            'footer/update/(:segment)/index.php',
            'Admin\KelolaHalaman::update/footer/$1'
        );
    }
);

if (
    file_exists(
        APPPATH
        . 'Config/'
        . ENVIRONMENT
        . '/Routes.php'
    )
) {
    require APPPATH
        . 'Config/'
        . ENVIRONMENT
        . '/Routes.php';
}