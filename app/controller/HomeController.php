<?php

namespace Nabil\MVC\controller;

use Nabil\MVC\app\View;

class HomeController
{

    function index(): void
    {
        // ini contoh model, yang dikirimkan ke view
        $model = [
            "title" => "Login Management",
            "content" => "Selamat Membuat Project App Login Management"
        ];

        // data yang dikirimkan dari variable model, dari class view
        View::render('home/index', $model);
    }

    function hello(): void
    {
        echo "HomeController.hello()";
    }

    function world(): void
    {
        echo "HomeController.world()";
    }

    function about(): void
    {
        echo "Author : Mohammad Nabil Fadilah";
    }

    // login
    function login(): void
    {
        // data(model) request yang mengambil data usernama dan password
        $request = [
            "username" => $_POST['username'],
            "password" => $_POST['password']
        ];

        $user = [];

        // nah nanti tampilkan response hasil datanya
        $response = [
            "message" => "Login Sukses"
        ];
        // kirimkan response ke view
    }
}
