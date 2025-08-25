<?php

namespace Nabil\MVC\App {

    function header(string $value)
    {
        echo $value;
    }
}

namespace Nabil\MVC\Service {

    function setcookie(string $name, string $value)
    {
        echo "$name: $value";
    }
}
