<?php

namespace Config;

use Myth\Auth\Collectors\Auth;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/', 'Home::index');
$routes->get('/yayasan', 'Home::yayasan');

// $routes->get('/santri', 'Santri::index', ['filter' => 'role:santri']);

$routes->get('/admin', 'Admin::index', ['filter' => 'role:admin']);
$routes->get('/admin/index', 'Admin::index', ['filter' => 'role:admin']);
$routes->get('/admin/daftarSantri', 'Admin::daftarSantri', ['filter' => 'role:admin']);
$routes->post('/admin/daftarSantri', 'Admin::daftarSantri', ['filter' => 'role:admin']);
$routes->delete('/admin/hapusSantri/(:num)', 'Admin::hapusSantri/$1', ['filter' => 'role:admin']);
$routes->get('/admin/editSantri/(:num)', 'Admin::editSantri/$1', ['filter' => 'role:admin']);
$routes->post('/admin/updateSantri/(:num)', 'Admin::updateSantri/$1', ['filter' => 'role:admin']);
$routes->get('/admin/detailSantri/(:num)', 'Admin::detailSantri/$1', ['filter' => 'role:admin']);
$routes->get('/admin/daftarGuru', 'Admin::daftarGuru', ['filter' => 'role:admin']);
$routes->get('/admin/daftarGuru', 'Admin::daftarGuru', ['filter' => 'role:admin']);
$routes->post('/admin/daftarGuru', 'Admin::daftarGuru', ['filter' => 'role:admin']);
$routes->get('/admin/detailGuru/(:num)', 'Admin::detailGuru/$1');
$routes->delete('/admin/hapusGuru/(:num)', 'Admin::hapusGuru/$1', ['filter' => 'role:admin']);
$routes->get('/admin/editGuru/(:num)', 'Admin::editGuru/$1', ['filter' => 'role:admin']);
$routes->post('/admin/updateGuru/(:num)', 'Admin::updateGuru/$1', ['filter' => 'role:admin']);
$routes->get('/admin/daftarUsers', 'Admin::daftarUsers', ['filter' => 'role:admin']);
$routes->post('/admin/daftarUsers', 'Admin::daftarUsers', ['filter' => 'role:admin']);
$routes->get('/admin/tambahUsers', 'Admin::tambahUsers', ['filter' => 'role:admin']);
$routes->post('/admin/simpanUsers', 'Admin::simpanUsers', ['filter' => 'role:admin']);
$routes->post('/admin/updateUsers/(:num)', 'Admin::updateUsers/$1', ['filter' => 'role:admin']);
$routes->delete('/admin/hapusUsers/(:num)', 'Admin::hapusUsers/$1', ['filter' => 'role:admin']);
$routes->get('/admin/edit/(:num)', 'Admin::editUsers/$1', ['filter' => 'role:admin']);
$routes->get('/admin/daftarMp', 'Admin::mp');
$routes->post('/admin/daftarMp', 'Admin::mp');
$routes->post('/admin/simpanMp', 'Admin::simpanMp');
$routes->get('/admin/editMp/(:num)', 'Admin::editMp/$1');
$routes->post('/admin/updateMp/(:num)', 'Admin::updateMp/$1');
$routes->delete('/admin/hapusMp/(:num)', 'Admin::hapusMp/$1');
$routes->get('/admin/daftarJadwalPelajaran', 'Admin::daftarJadwalPelajaran');
$routes->post('/admin/daftarJadwalPelajaran', 'Admin::daftarJadwalPelajaran');
$routes->post('/admin/simpanJadwalPelajaran', 'Admin::simpanJadwalPelajaran', ['filter' => 'role:admin']);
$routes->delete('/admin/hapusJP/(:num)', 'Admin::hapusJP/$1');
$routes->get('/admin/editJP/(:num)', 'Admin::editJP/$1');
$routes->post('/admin/updateJp/(:num)', 'Admin::updateJp/$1');
$routes->get('/admin/cetakJp', 'Admin::cetakJp');
$routes->post('/admin/cetakJp', 'Admin::cetakJp');
$routes->get('/admin/informasi', 'Admin::informasi', ['filter' => 'role:admin']);
$routes->post('/admin/informasi', 'Admin::informasi', ['filter' => 'role:admin']);
$routes->post('/admin/simpanInformasi', 'Admin::simpanInformasi', ['filter' => 'role:admin']);
$routes->delete('/admin/hapusInformasi/(:num)', 'Admin::hapusInformasi/$1', ['filter' => 'role:admin']);
$routes->post('/admin/ubahInformasi/(:num)', 'Admin::ubahInformasi/$1', ['filter' => 'role:admin']);
$routes->get('/admin/daftarKelas', 'Admin::daftarKelas');
$routes->get('/admin/tambahKelas', 'Admin::tambahKelas');
$routes->post('/admin/simpanKelas', 'Admin::simpanKelas');
$routes->get('/admin/editKelas/(:num)', 'Admin::editKelas/$1');
$routes->delete('/admin/hapusKelas/(:num)', 'Admin::hapusKelas/$1');
$routes->post('/admin/updateKelas/(:num)', 'Admin::updateKelas/$1');
$routes->post('admin/updateStatus/(:num)', 'Admin::updateStatus/$1');
$routes->get('admin/daftarQR', 'Admin::daftarQR', ['filter' => 'role:admin']);
$routes->post('admin/daftarQR', 'Admin::daftarQR', ['filter' => 'role:admin']);
$routes->get('admin/cetakQR', 'Admin::cetakQR', ['filter' => 'role:admin']);
$routes->post('admin/cetakQR', 'Admin::cetakQR', ['filter' => 'role:admin']);
$routes->post('/admin/generateQR', 'Admin::generateQR', ['filter' => 'role:admin']);
$routes->get('/admin/daftarAbsen', 'Admin::daftarAbsen', ['filter' => 'role:admin']);
$routes->post('/admin/daftarAbsen', 'Admin::daftarAbsen', ['filter' => 'role:admin']);

$routes->get('/guru', 'Guru::index', ['filter' => 'role:guru, admin']);
$routes->post('/guru', 'Guru::index');
$routes->delete('/guru/hapusAbsen/(:num)', 'Guru::hapusAbsen/$1');
$routes->get('/guru/absensi', 'AbsensiGuru::index', ['filter' => 'role:admin']);
$routes->get('/guru/scanqr', 'AbsensiGuru::scanqr', ['filter' => 'role:guru']);
$routes->get('/guru/tambahAbsen', 'AbsensiGuru::tambahAbsen', ['filter' => 'role:admin']);
$routes->get('/guru/editAbsen/(:num)', 'AbsensiGuru::editAbsen/$1', ['filter' => 'role:admin']);
$routes->post('/guru/simpanAbsen', 'AbsensiGuru::simpanAbsen', ['filter' => 'role:admin']);
$routes->post('/guru/updateAbsen/(:num)', 'AbsensiGuru::updateAbsen/$1', ['filter' => 'role:admin']);
$routes->delete('/guru/hapusAbsen/(:num)', 'AbsensiGuru::hapusAbsen/$1', ['filter' => 'role:admin']);
$routes->get('/guru/hasilScanGuru/(:segment)', 'AbsensiGuru::hasilScanGuru/$1', ['filter' => 'role:guru']);
$routes->get('/guru/printpdf/(:num)', 'AbsensiGuru::printpdf/$1', ['filter' => 'role:admin']);
$routes->get('/guru/printpdfAll', 'AbsensiGuru::printpdfAll', ['filter' => 'role:admin']);
$routes->get('/guru/wa/(:num)', 'Guru::wa/$1');
$routes->get('/guru/transkrip_nilai', 'Guru::nilaiSantri', ['filter' => 'role:guru,admin']);
$routes->post('/guru/transkrip_nilai', 'Guru::nilaiSantri', ['filter' => 'role:guru,admin'] );
$routes->post('/guru/simpanNilaiSantri', 'Guru::simpanNilaiSantri');
$routes->delete('/guru/hapusTranskripNilai/(:num)', 'Guru::hapusTranskripNilai/$1');
$routes->get('/guru/editTranskripNilai/(:num)', 'Guru::editTranskripNilai/$1');
$routes->post('/guru/updateTranskripNilai/(:num)', 'Guru::updateTranskripNilai/$1');
$routes->get('/guru/isiNilai/(:num)', 'Guru::isiNilai/$1', ['filter' => 'role:guru,admin']);
$routes->get('/guru/raport/(:num)', 'Guru::raport/$1');
$routes->post('/guru/simpanNilai/(:num)', 'Guru::simpanNilai/$1');
$routes->get('/guru/cetakRaport/(:num)', 'Guru::cetakRaport/$1');
$routes->get('/guru/ketAbsen/(:num)', 'Guru::ketAbsen/$1');
$routes->post('/guru/updateKetAbsen/(:num)', 'Guru::updateKetAbsen/$1');
$routes->get('/guru/profile', 'Guru::profile', ['filter' => 'role:guru']);
$routes->get('/guru/detailProfile', 'Guru::detailProfile', ['filter' => 'role:guru']);
$routes->post('/guru/updateDetailProfile/(:num)', 'Guru::updateDetailProfile/$1', ['filter' => 'role:guru']);
$routes->post('/guru/generateQR', 'AbsensiGuru::generateQR', ['filter' => 'role:admin']);
$routes->get('/guru/generateQR', 'AbsensiGuru::generateQR', ['filter' => 'role:admin']);

$routes->get('/santri', 'Santri::index');
$routes->get('/santri/absensi', 'AbsensiSantri::index', ['filter' => 'role:admin']);
$routes->get('/guru/santri/absensi', 'AbsensiSantri::index', ['filter' => 'role:guru']);
$routes->get('/santri/tambahAbsen', 'AbsensiSantri::tambahAbsen', ['filter' => 'role:admin']);
$routes->get('/santri/editAbsen/(:num)', 'AbsensiSantri::editAbsen/$1', ['filter' => 'role:admin']);
$routes->post('/santri/updateAbsen/(:num)', 'AbsensiSantri::updateAbsen/$1', ['filter' => 'role:admin']);
$routes->post('/santri/simpanAbsen', 'AbsensiSantri::simpanAbsen', ['filter' => 'role:admin']);
$routes->delete('/santri/hapusAbsen/(:num)', 'AbsensiSantri::hapusAbsen/$1', ['filter' => 'role:admin']);
$routes->get('/santri/hasilScanSantri/(:segment)', 'AbsensiSantri::hasilScanSantri/$1', ['filter' => 'role:santri']);
$routes->get('/santri/scanqr', 'AbsensiSantri::scanqr', ['filter' => 'role:santri']);
$routes->get('/santri/printpdf/(:num)', 'AbsensiSantri::printpdf/$1', ['filter' => 'role:admin']);
$routes->get('/santri/printpdfAll', 'AbsensiSantri::printpdfAll', ['filter' => 'role:admin']);
$routes->get('/santri/profile', 'Santri::profile', ['filter' => 'role:santri']);
$routes->get('/santri/detailProfile', 'Santri::detailProfile', ['filter' => 'role:santri']);
$routes->post('/santri/updateDetailProfile/(:num)', 'Santri::updateDetailProfile/$1', ['filter' => 'role:santri']);
$routes->get('/santri/jadwalPelajaran', 'Santri::jadwalPelajaran', ['filter' => 'role:santri']);
$routes->post('/santri/jadwalPelajaran', 'Santri::jadwalPelajaran', ['filter' => 'role:santri']);
// $routes->get('/santri/daftarJadwalPelajaran', 'Admin::jadwalPelajaran');
// $routes->post('/santri/daftarJadwalPelajaran', 'Admin::jadwalPelajaran');
$routes->get('/santri/cetakJp', 'Santri::cetakJp', ['filter' => 'role:santri']);
$routes->get('/santri/transkripNilai', 'Santri::transkripNilai', ['filter' => 'role:santri']);
$routes->get('/santri/cetakNilai/(:num)', 'Santri::cetakNilai/$1', ['filter' => 'role:santri']);
$routes->get('/santri/downloadInformasi/(:num)', 'Santri::downloadInformasi/$1', ['filter' => 'role:santri']);
$routes->post('/santri/generateQR', 'AbsensiSantri::generateQR', ['filter' => 'role:admin']);
$routes->get('/santri/generateQR', 'AbsensiSantri::generateQR', ['filter' => 'role:admin']);

$routes->get('/dokumen', 'Dokumen::index');
$routes->post('/dokumen', 'Dokumen::index');
$routes->post('/dokumen/simpanDokumen', 'Dokumen::simpanDokumen', ['filter' => 'role:admin']);
$routes->post('/dokumen/ubahDokumen/(:num)', 'Dokumen::ubahDokumen/$1', ['filter' => 'role:admin']);
$routes->delete('/dokumen/hapusDokumen/(:num)', 'Dokumen::hapusDokumen/$1', ['filter' => 'role:admin']);
$routes->get('/dokumen/downloadDokumen/(:num)', 'Dokumen::downloadDokumen/$1');



$routes->get('/event/dataEvent', 'Event::index', ['filter' => 'role:admin']);
$routes->post('/event/simpanEvent', 'Event::simpanEvent', ['filter' => 'role:admin']);
$routes->post('/event/ubahEvent/(:num)', 'Event::ubahEvent/$1', ['filter' => 'role:admin']);
$routes->delete('/event/hapusEvent/(:num)', 'Event::hapusEvent/$1', ['filter' => 'role:admin']);
$routes->post('/event/updateStatus/(:num)', 'Event::updateStatus/$1', ['filter' => 'role:admin']);

$routes->get('/home/event', 'Home::event');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
