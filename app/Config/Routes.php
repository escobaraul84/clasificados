<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/ads', 'AdController::index');
$routes->get('/ads/(:segment)', 'AdController::show/$1');
$routes->get('/publish', 'AdController::create', ['filter' => 'auth']);
$routes->post('/publish', 'AdController::store', ['filter' => 'auth']);
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::attemptRegister');
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::attemptLogin');
$routes->get('/logout', 'AuthController::logout');