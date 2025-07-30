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
$routes->get('Dashboard/Dosen', 'Dashboard\Dosen::index');
$routes->get('Dashboard/Dosen/ApprovalKRS', 'Dashboard\Dosen::ApprovalKRS');
$routes->get('Dashboard/Dosen/InputNilai', 'Dashboard\Dosen::InputNilai');

// $routes->get('home/getArtikels', 'Home::getArtikels');