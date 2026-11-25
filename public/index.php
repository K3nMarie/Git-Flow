<?php
// Front controller. Arrancar con:  php -S localhost:8000 -t public
require dirname(__DIR__) . '/app/Core/Application.php';
require dirname(__DIR__) . '/app/Core/Auth.php';
require dirname(__DIR__) . '/app/Core/Router.php';
require dirname(__DIR__) . '/app/Core/Controller.php';
require dirname(__DIR__) . '/app/Core/Model.php';
require dirname(__DIR__) . '/app/Core/Database.php';
require dirname(__DIR__) . '/app/Core/helpers.php';

(new App\Core\Application())->run();
