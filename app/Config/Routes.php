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