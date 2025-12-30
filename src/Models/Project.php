<?php

namespace App\Models;

use App\Core\BaseModel;

class Project extends BaseModel
{
    protected static string $table = 'projects';

    public function client(): ?Client
    {
        if (!$this->client_id) {
            return null;
        }

        return Client::find($this->client_id);
    }

    public function budgets(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM budgets WHERE project_id = ? ORDER BY id DESC");
        $stmt->execute([$this->id]);
        $rows = $stmt->fetchAll();

        return array_map(fn($row) => new Budget($row), $rows);
    }

    public function tasks(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM tasks WHERE project_id = ? ORDER BY status DESC, priority DESC");
        $stmt->execute([$this->id]);
        $rows = $stmt->fetchAll();

        return array_map(fn($row) => new Task($row), $rows);
    }

    public static function findOrCreateGeneral(int $clientId, string $title = 'General'): self
    {

        $db = \App\Config\Database::connect();

        // Try to find an open generic project
        $stmt = $db->prepare("SELECT * FROM projects WHERE client_id = ? AND name LIKE 'General%' LIMIT 1");
        $stmt->execute([$clientId]);
        $row = $stmt->fetch();

        if ($row) {
            return new self($row);
        }

        // Create new
        $project = new self();
        $project->client_id = $clientId;
        $project->name = 'General (' . date('Y') . ')';
        $project->description = 'Proyecto general para presupuestos';
        $project->status = 'active';
        $project->save();

        return $project;
    }
}
