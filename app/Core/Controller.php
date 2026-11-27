<?php
namespace App\Core;

abstract class Controller
{
    protected function render(string $view, array $data = [], string $title = 'MyMind'): void
    {
        extract($data, EXTR_SKIP);
        $viewFile = dirname(__DIR__) . "/Views/$view.php";
        ob_start();
        require $viewFile;
        $content = ob_get_clean();
        $flash = Auth::flash();
        $active = explode('/', $view)[0];
        require dirname(__DIR__) . '/Views/layouts/main.php';
    }

    protected function redirect(string $path): never
    {
        header('Location: ' . $path);
        exit;
    }

    protected function json(mixed $data, int $status = 200): never
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    protected function input(string $key, string $default = ''): string
    {
        return trim((string)($_POST[$key] ?? $default));
    }

    protected function validDate(string $d): bool
    {
        $dt = \DateTime::createFromFormat('Y-m-d', $d);
        return $dt && $dt->format('Y-m-d') === $d;
    }
}
