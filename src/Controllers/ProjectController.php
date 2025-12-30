<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Project;
use App\Models\Client;
use App\Middleware\AuthMiddleware;

class ProjectController extends BaseController
{
    public function index(): void
    {
        AuthMiddleware::handle();

        $page = (int) ($_GET['page'] ?? 1);
        $perPageInput = $_GET['per_page'] ?? '10';
        $perPage = ($perPageInput === 'all') ? 0 : (int) $perPageInput;
        $search = $_GET['search'] ?? '';

        $pagination = Project::paginate($page, $perPage, $search, ['name', 'description']);

        $this->render('projects/index', [
            'projects' => $pagination['data'],
            'pagination' => $pagination,
            'search' => $search,
            'per_page' => $perPageInput
        ]);
    }

    public function create(): void
    {
        AuthMiddleware::handle();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $project = new Project();
            $project->client_id = $_POST['client_id'] ?? 0;
            $project->name = $_POST['name'] ?? '';
            $project->description = $_POST['description'] ?? '';
            $project->status = $_POST['status'] ?? 'active';
            $project->save();

            $this->redirect('/projects');
        }

        $clients = Client::all();
        $this->render('projects/create', ['clients' => $clients]);
    }

    public function edit(): void
    {
        AuthMiddleware::handle();

        $id = $_GET['id'] ?? 0;
        $project = Project::find($id);

        if (!$project) {
            $this->redirect('/projects');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $project->client_id = $_POST['client_id'] ?? 0;
            $project->name = $_POST['name'] ?? '';
            $project->description = $_POST['description'] ?? '';
            $project->status = $_POST['status'] ?? 'active';
            $project->save();

            $this->redirect('/projects');
        }

        $clients = Client::all();
        $this->render('projects/edit', ['project' => $project, 'clients' => $clients]);
    }

    public function delete(): void
    {
        AuthMiddleware::handle();

        $id = $_GET['id'] ?? 0;
        $project = Project::find($id);

        if ($project) {
            $project->delete();
        }

        $this->redirect('/projects');
    }
}
