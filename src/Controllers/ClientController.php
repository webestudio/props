<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Client;
use App\Middleware\AuthMiddleware;

class ClientController extends BaseController
{
    public function index(): void
    {
        AuthMiddleware::handle();

        $search = $_GET['search'] ?? '';
        $page = (int) ($_GET['page'] ?? 1);
        $perPage = (int) ($_GET['per_page'] ?? 10);

        $results = Client::paginate($page, $perPage, $search, ['name', 'company', 'email']);

        $this->render('clients/index', [
            'clients' => $results['data'],
            'pagination' => $results,
            'search' => $search
        ]);
    }

    public function create(): void
    {
        AuthMiddleware::handle();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $client = new Client();
            $client->name = $_POST['name'] ?? '';
            $client->email = $_POST['email'] ?? '';
            $client->phone = $_POST['phone'] ?? '';
            $client->company = $_POST['company'] ?? '';
            $client->notes = $_POST['notes'] ?? '';
            $client->save();

            $this->redirect('/clients');
        }

        $this->render('clients/create');
    }

    public function edit(): void
    {
        AuthMiddleware::handle();

        $id = $_GET['id'] ?? 0;
        $client = Client::find($id);

        if (!$client) {
            $this->redirect('/clients');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $client->name = $_POST['name'] ?? '';
            $client->email = $_POST['email'] ?? '';
            $client->phone = $_POST['phone'] ?? '';
            $client->company = $_POST['company'] ?? '';
            $client->notes = $_POST['notes'] ?? '';
            $client->save();

            $this->redirect('/clients');
        }


        $this->render('clients/edit', ['client' => $client]);
    }

    public function delete(): void
    {
        AuthMiddleware::handle();

        $id = $_GET['id'] ?? 0;
        $client = Client::find($id);

        if ($client) {
            $client->delete();
        }

        $this->redirect('/clients');
    }
}
