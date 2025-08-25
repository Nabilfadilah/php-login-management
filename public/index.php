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
use Nabil\MVC\controller\ProductController;
use Nabil\MVC\middleware\AuthMiddleware;

// use ProgrammerZamanNow\Belajar\PHP\MVC\Controller\HomeController;
// use ProgrammerZamanNow\Belajar\PHP\MVC\Controller\ProductController;
// use ProgrammerZamanNow\Belajar\PHP\MVC\Middleware\AuthMiddleware;

// awal dan akhir tidak menggunakan '/' karena '/' banyak digunakan di URL, 'categories' = nama function harus sama seperti di controller
Router::add('GET', '/products/([0-9a-zA-Z]*)/categories/([0-9a-zA-Z]*)', ProductController::class, 'categories');

Router::add('GET', '/', HomeController::class, 'index');

// kalau mau akses hello dan world, harus login dulu ngab
Router::add('GET', '/hello', HomeController::class, 'hello', [AuthMiddleware::class]);
Router::add('GET', '/world', HomeController::class, 'world', [AuthMiddleware::class]);

Router::add('GET', '/about', HomeController::class, 'about');

Router::run(); // jalankan routernya
