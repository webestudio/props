<?php

namespace App\Models;

use App\Core\BaseModel;

class Client extends BaseModel
{
    protected static string $table = 'clients';

    public function projects(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM projects WHERE client_id = ? ORDER BY id DESC");
        $stmt->execute([$this->id]);
        $rows = $stmt->fetchAll();

        return array_map(fn($row) => new Project($row), $rows);
    }
}
