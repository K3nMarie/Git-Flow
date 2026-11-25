<?php
namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, string $handler): void  { $this->add('GET', $path, $handler); }
    public function post(string $path, string $handler): void { $this->add('POST', $path, $handler); }

    private function add(string $method, string $path, string $handler): void
    {
        $regex = '#^' . preg_replace('#\{(\w+)\}#', '(?P<$1>[^/]+)', $path) . '$#';
        $this->routes[] = [$method, $regex, $handler];
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = rtrim(parse_url($uri, PHP_URL_PATH) ?: '/', '/') ?: '/';

        foreach ($this->routes as [$m, $regex, $handler]) {
            if ($m !== $method || !preg_match($regex, $path, $matches)) {
                continue;
            }
            if ($method === 'POST' && !Auth::verify($_POST['_csrf'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? null))) {
                http_response_code(419);
                echo 'Token CSRF inválido.';
                return;
            }
            [$class, $action] = explode('@', $handler);
            $class = "App\\Controllers\\$class";
            $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
            (new $class())->$action(...array_values($params));
            return;
        }

        http_response_code(404);
        echo '404 - Página no encontrada';
    }
}
