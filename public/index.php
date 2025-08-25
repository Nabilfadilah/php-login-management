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

Router::add('GET', '/', HomeController::class, 'index', []);

Router::run(); // jalankan routernya
