<?php

namespace App\Middleware;

class AuthMiddleware
{
    public static function handle(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }

    public static function requireAdmin(): void
    {
        self::handle();

        if ($_SESSION['user_role'] !== 'admin') {
            header('Location: /dashboard');
            exit;
        }
    }

    public static function guest(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user_id'])) {
            header('Location: /dashboard');
            exit;
        }
    }
}
