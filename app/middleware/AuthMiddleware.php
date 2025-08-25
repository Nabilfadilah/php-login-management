<?php

namespace Nabil\MVC\middleware;

// class authmiddleware implement middleware
class AuthMiddleware implements Middleware
{
    function before(): void
    {
        // lakukan start session
        session_start();
        // apakah session user nya ada?
        if (!isset($_SESSION['user'])) {
            // kalau ada arahkan ke /login
            header('Location: /login');
            exit(); // agar middleware lainnya tidak di eksekusi
        }
    }
}
