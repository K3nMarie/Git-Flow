<?php
namespace App\Core;

class Application
{
    private static array $config = [];

    public static function config(?string $key = null): mixed
    {
        return $key === null ? self::$config : (self::$config[$key] ?? null);
    }

    public function run(): void
    {
        $root = dirname(__DIR__, 2);

        spl_autoload_register(function (string $class) use ($root) {
            if (str_starts_with($class, 'App\\')) {
                $file = $root . '/app/' . str_replace('\\', '/', substr($class, 4)) . '.php';
                if (is_file($file)) require $file;
            }
        });

        self::$config = require $root . '/config/config.php';
        date_default_timezone_set(self::$config['timezone']);
        Auth::start();

        $router = new Router();
        (require $root . '/routes/web.php')($router);
        $router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', $_SERVER['REQUEST_URI'] ?? '/');
    }
}
