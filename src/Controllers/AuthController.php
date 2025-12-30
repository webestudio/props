<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\User;
use App\Middleware\AuthMiddleware;

class AuthController extends BaseController
{
    public function showLogin(): void
    {
        AuthMiddleware::guest();
        $this->render('auth/login', [], false);
    }

    public function login(): void
    {
        AuthMiddleware::guest();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = User::authenticate($email, $password);

            if ($user) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_name'] = $user->name;
                $_SESSION['user_email'] = $user->email;
                $_SESSION['user_role'] = $user->role;

                $this->redirect('/dashboard');
            }

            $this->render('auth/login', ['error' => 'Credenciales incorrectas'], false);
        }
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_destroy();
        $this->redirect('/login');
    }
}
