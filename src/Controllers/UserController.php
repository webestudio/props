<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\User;
use App\Middleware\AuthMiddleware;

class UserController extends BaseController
{
    public function index(): void
    {
        AuthMiddleware::requireAdmin();

        $users = User::all();
        $this->render('users/index', ['users' => $users]);
    }

    public function create(): void
    {
        AuthMiddleware::requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? '',
                'role' => $_POST['role'] ?? 'user'
            ];

            User::create($data);
            $this->redirect('/users');
        }

        $this->render('users/create');
    }

    public function edit(): void
    {
        AuthMiddleware::requireAdmin();

        $id = $_GET['id'] ?? 0;
        $user = User::find($id);

        if (!$user) {
            $this->redirect('/users');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->name = $_POST['name'] ?? '';
            $user->email = $_POST['email'] ?? '';
            $user->role = $_POST['role'] ?? 'user';

            if (!empty($_POST['password'])) {
                $user->password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }

            $user->save();
            $this->redirect('/users');
        }

        $this->render('users/edit', ['user' => $user]);
    }

    public function delete(): void
    {
        AuthMiddleware::requireAdmin();

        $id = $_GET['id'] ?? 0;
        $user = User::find($id);

        if ($user) {
            $user->delete();
        }

        $this->redirect('/users');
    }
}
