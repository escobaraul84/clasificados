<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// PÁGINA PRINCIPAL
$routes->get('/', 'HomeController::index');

// ANUNCIOS
$routes->get('/ads', 'AdController::index');
$routes->get('/ad/(:segment)', 'AdController::show/$1');
$routes->get('/publish', 'AdController::create', ['filter' => 'auth']);
$routes->post('/publish', 'AdController::store', ['filter' => 'auth']);

// AUTENTICACIÓN
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::attemptRegister');
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::attemptLogin');
$routes->get('/logout', 'AuthController::logout');

// CONTACTO
$routes->get('/ad/contact/(:num)', 'AdController::contact/$1');
$routes->get('/profile/(:num)', 'ProfileController::show/$1');

// NOTIFICACIONES
$routes->post('/notifications/mark-read', 'AdController::markRead');
// auth es el filtro si existe
$routes->get('mis-anuncios', 'AdController::myAds', ['filter' => 'auth']);

$routes->group('mis-anuncios', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'AdController::myAds');
    $routes->get('edit/(:num)', 'AdController::edit/$1');
    $routes->post('update/(:num)', 'AdController::update/$1');
    $routes->post('delete/(:num)', 'AdController::delete/$1');
    $routes->post('toggle/(:num)', 'AdController::toggleStatus/$1'); // pausar / reanudar
});

$routes->post('mis-anuncios/sold/(:num)', 'AdController::markSold/$1');
$routes->get('mis-anuncios/promote/(:num)', 'PromotionController::selectPack/$1');
$routes->get('i/(:num)', 'AdController::pixel/$1');

$routes->get('search', 'SearchController::index');