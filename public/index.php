<?php

/* Este es el script que siempre se ejecuta primero. Su trabajo es arrancar Symfony y ejecutar
 nuestra apliación. Probablemente nunca no haya que abrirlo nunca. */

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};

