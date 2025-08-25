<?php

namespace Nabil\MVC\Middleware;

use Nabil\MVC\app\View;
use Nabil\MVC\config\Database;
use Nabil\MVC\Service\SessionService;
use Nabil\MVC\Repository\SessionRepository;
use Nabil\MVC\Repository\UserRepository;

class MustNotLoginMiddleware implements Middleware
{
    private SessionService $sessionService;

    public function __construct()
    {
        $sessionRepository = new SessionRepository(Database::getConnection());
        $userRepository = new UserRepository(Database::getConnection());
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    function before(): void
    {
        $user = $this->sessionService->current();
        // usernya harus belom login
        if ($user != null) {
            // arahkan ke /home
            View::redirect('/');
        }
    }
}
