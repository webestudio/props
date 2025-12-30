<?php

namespace App\Models;

use App\Core\BaseModel;

class Task extends BaseModel
{
    protected static string $table = 'tasks';

    public function project(): ?Project
    {
        if (!$this->project_id) {
            return null;
        }

        return Project::find($this->project_id);
    }
}
