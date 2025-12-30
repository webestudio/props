<?php

namespace App\Models;

use App\Core\BaseModel;
use App\Config\Database;

class User extends BaseModel
{
    protected static string $table = 'users';

    public static function authenticate(string $email, string $password): ?self
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch();

        if ($row && password_verify($password, $row['password_hash'])) {
            return new self($row);
        }

        return null;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public static function create(array $data): self
    {
        $user = new self();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password_hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $user->role = $data['role'] ?? 'user';
        $user->save();

        return $user;
    }
}
