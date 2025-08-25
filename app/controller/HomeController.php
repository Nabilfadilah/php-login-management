<?php

namespace Nabil\MVC\controller;

use Nabil\MVC\app\View;

class HomeController
{
    function index()
    {
        View::render('Home/index', [
            "title" => "PHP Login Management"
        ]);
    }
}
