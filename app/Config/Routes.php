<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(true);
$routes->get('/', 'Home::index');
$routes->get('profil-kampus', 'Home::ProfilKampus');

// Routes untuk Dashboard Mahasiswa
$routes->get('Dashboard/Mahasiswa', 'Dashboard\Mahasiswa::index');
$routes->get('Dashboard/Mahasiswa/KRS', 'Dashboard\Mahasiswa::KRS');
$routes->get('Dashboard/Mahasiswa/KHS', 'Dashboard\Mahasiswa::KHS');

// Routes untuk Dashboard Dosen
$routes->group('Dashboard/Dosen', ['filter' => 'filterdosen'], function($routes) {
    $routes->get('', 'Dashboard\Dosen::index');
    $routes->get('JadwalMengajar', 'Dashboard\Dosen::JadwalMengajar');
    $routes->get('MateriKuliah', 'Dashboard\Dosen::MateriKuliah');
    $routes->get('Laporan', 'Dashboard\Dosen::Laporan');
    $routes->get('InputNilai', 'Dashboard\Dosen::InputNilai');
    $routes->get('getMahasiswaByKelas/(:num)', 'Dashboard\Dosen::getMahasiswaByKelas/$1');
    $routes->post('SaveNilai', 'Dashboard\Dosen::SaveNilai');
    $routes->get('Absensi', 'Dashboard\Dosen::Absensi');
    $routes->get('Tugas', 'Dashboard\Dosen::Tugas');
    $routes->get('ApprovalKRS', 'Dashboard\Dosen::ApprovalKRS');
    $routes->post('ApproveKRS/(:num)', 'Dashboard\Dosen::ApproveKRS/$1');
    $routes->post('RejectKRS/(:num)', 'Dashboard\Dosen::RejectKRS/$1');
});

// Routes untuk Admin Mata Kuliah
$routes->group('admin', function($routes) {
    $routes->get('mata-kuliah', 'MataKuliah::index');
    $routes->get('mata-kuliah/create', 'MataKuliah::create');
    $routes->post('mata-kuliah/store', 'MataKuliah::store');
    $routes->get('mata-kuliah/edit/(:num)', 'MataKuliah::edit/$1');
    $routes->post('mata-kuliah/update/(:num)', 'MataKuliah::update/$1');
    $routes->get('mata-kuliah/delete/(:num)', 'MataKuliah::delete/$1');
    $routes->post('mata-kuliah/get-dosen-by-prodi', 'MataKuliah::getDosenByProdi');
});

// Routes untuk Dosen Nilai
$routes->group('dosen', ['filter' => 'filterdosen'], function($routes) {
    $routes->get('mata-kuliah', 'DosenNilai::index');
    $routes->get('mata-kuliah/nilai/(:num)', 'DosenNilai::nilai/$1');
    $routes->post('nilai/update', 'DosenNilai::updateNilai');
    $routes->post('nilai/finalisasi', 'DosenNilai::finalisasiNilai');
});

// Routes untuk Import Mahasiswa
$routes->get('Mahasiswa/Import', 'Mahasiswa::Import');
$routes->post('Mahasiswa/ProcessImport', 'Mahasiswa::ProcessImport');
$routes->get('Mahasiswa/DownloadTemplate', 'Mahasiswa::DownloadTemplate');

// Routes untuk Prodi
$routes->group('Prodi', ['filter' => 'filteradmin'], function($routes) {
    $routes->get('', 'Prodi::index');
    $routes->get('create', 'Prodi::create');
    $routes->post('store', 'Prodi::store');
    $routes->get('edit/(:num)', 'Prodi::edit/$1');
    $routes->post('update/(:num)', 'Prodi::update/$1');
    $routes->get('delete/(:num)', 'Prodi::delete/$1');
});

// $routes->get('home/getArtikels', 'Home::getArtikels');