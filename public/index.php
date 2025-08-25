<?php

require_once __DIR__ . '/../vendor/autoload.php';

// $path = "/index";

// mendapat dari path info
// if (isset($_SERVER['PATH_INFO'])) {
//     $path = $_SERVER['PATH_INFO'];
// }

// lalu ambil path nya, misal /login, /register, dll
// require __DIR__ . '/../app/view' . $path . '.php';
use Nabil\MVC\app\Router;
use Nabil\MVC\controller\HomeController;
use Nabil\MVC\Controller\UserController;
use Nabil\MVC\config\Database;

Database::getConnection('prod'); // bikin koneksi setelan prodaction

// Home controller
Router::add('GET', '/', HomeController::class, 'index', []);

// User controller
Router::add('GET', '/users/register', UserController::class, 'register', []);
Router::add('POST', '/users/register', UserController::class, 'postRegister', []);
Router::add('GET', '/users/login', UserController::class, 'login');
Router::add('POST', '/users/login', UserController::class, 'postLogin');
// Router::add('GET', '/users/logout', UserController::class, 'logout', [MustLoginMiddleware::class]);
// Router::add('GET', '/users/profile', UserController::class, 'updateProfile', [MustLoginMiddleware::class]);
// Router::add('POST', '/users/profile', UserController::class, 'postUpdateProfile', [MustLoginMiddleware::class]);
// Router::add('GET', '/users/password', UserController::class, 'updatePassword', [MustLoginMiddleware::class]);
// Router::add('POST', '/users/password', UserController::class, 'postUpdatePassword', [MustLoginMiddleware::class])

Router::run(); // jalankan routernya
