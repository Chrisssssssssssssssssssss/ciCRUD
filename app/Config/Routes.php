<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Student Routes
$routes->get('/students', 'StudentsController::index');
$routes->get('/students/create', 'StudentsController::createStudent');
$routes->post('/students/store', 'StudentsController::storeStudent');
$routes->get('/students/edit/(:num)', 'StudentsController::editStudent/$1');
$routes->post('/students/update/(:num)', 'StudentsController::updateStudent/$1');
$routes->get('/students/delete/(:num)', 'StudentsController::deleteStudent/$1');