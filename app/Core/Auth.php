<?php
namespace App\Core;

/**
 * MyMind original es de un solo usuario sin login, así que aquí solo
 * manejamos la sesión y la protección CSRF de los formularios.
 */
class Auth
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(random_bytes(16));
        }
    }

    public static function token(): string
    {
        return $_SESSION['csrf'] ?? '';
    }

    public static function field(): string
    {
        return '<input type="hidden" name="_csrf" value="' . self::token() . '">';
    }

    public static function verify(?string $token): bool
    {
        return is_string($token) && hash_equals(self::token(), $token);
    }

    public static function flash(?string $msg = null): ?string
    {
        if ($msg !== null) {
            $_SESSION['flash'] = $msg;
            return null;
        }
        $m = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $m;
    }
}
