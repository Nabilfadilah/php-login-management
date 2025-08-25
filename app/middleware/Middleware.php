<?php

namespace Nabil\MVC\middleware;

interface Middleware
{
    // function sebelum 
    function before(): void;
}
