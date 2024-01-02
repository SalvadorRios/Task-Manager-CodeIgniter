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
$routes->setAutoRoute(true);

// $outes->get('/', 'Home::index');


$routes->group('api', ['namespace' => 'App\Controllers'], function($routes){
    $routes->get('get-tasks', 'TaskController::getTask');
    $routes->post('create-tasks', 'TaskController::create');
    $routes->get('show-tasks/(:num)', 'TaskController::show/$1');
    $routes->put('edit-tasks/(:num)', 'TaskController::edit/$1');
    $routes->delete('delete-tasks/(:num)', 'TaskController::delete/$1');
    $routes->post('create-users', 'UserApiController::create');
    $routes->post('login-users', 'UserApiController::login');
    $routes->get('read-users', 'UserApiController::readUser');
    $routes->delete('delete-users/(:num)', 'UserApiController::delete/$1');
});



// $routes->resource('tasks', ['controller' => 'TaskController']);
