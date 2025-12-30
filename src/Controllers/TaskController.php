<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Task;
use App\Middleware\AuthMiddleware;

class TaskController extends BaseController
{
    public function store(): void
    {
        AuthMiddleware::handle();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);

            if ($input) {
                $task = new Task();
                $task->project_id = $input['project_id'];
                $task->title = $input['title'];
                $task->description = $input['description'] ?? '';
                $task->priority = $input['priority'] ?? 'medium';
                $task->status = 'pending';
                $task->due_date = $input['due_date'] ?? null;
                $task->save();

                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'id' => $task->id]);
                exit;
            }
        }
    }

    public function update(): void
    {
        AuthMiddleware::handle();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $_GET['id'] ?? 0;
            $task = Task::find($id);

            if ($task && $input) {
                if (isset($input['status']))
                    $task->status = $input['status'];
                if (isset($input['title']))
                    $task->title = $input['title'];
                if (isset($input['description']))
                    $task->description = $input['description'];
                if (isset($input['priority']))
                    $task->priority = $input['priority'];
                if (isset($input['due_date']))
                    $task->due_date = $input['due_date'];

                $task->save();

                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
                exit;
            }
        }
    }

    public function delete(): void
    {
        AuthMiddleware::handle();

        $id = $_GET['id'] ?? 0;
        $task = Task::find($id);

        if ($task) {
            $task->delete();
        }

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
    }
}
