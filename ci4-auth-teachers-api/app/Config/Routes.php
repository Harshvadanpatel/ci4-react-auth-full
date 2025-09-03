<?php
namespace Config;

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes = Services::routes();

$routes->setDefaultNamespace('App\\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setAutoRoute(false);

// Public routes
$routes->post('api/auth/register', 'AuthController::register');
$routes->post('api/auth/login', 'AuthController::login');

// Protected routes
$routes->group('api', ['filter' => 'jwt-auth'], static function($routes) {
    $routes->post('teacher', 'TeacherController::create'); // single POST: user + teacher
    $routes->get('users', 'TeacherController::listUsers');
    $routes->get('teachers', 'TeacherController::listTeachers');
    $routes->get('teachers/join', 'TeacherController::listTeachersWithUser');
});
