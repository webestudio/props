<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Middleware\AuthMiddleware;

class DashboardController extends BaseController
{
    public function index(): void
    {
        AuthMiddleware::handle();

        // Stats
        $stats = [
            'clients' => \App\Models\Client::count(),
            'projects' => \App\Models\Project::count(),
            'budgets' => \App\Models\Budget::count(),
            'pending_tasks' => \App\Models\Task::count('status != ?', ['completed'])
        ];

        // Latest activity
        $latestProjects = \App\Models\Project::latest(3);
        $latestTasks = \App\Models\Task::latest(3);
        $latestBudgets = \App\Models\Budget::latest(3);

        $this->render('dashboard/index', [
            'stats' => $stats,
            'latestProjects' => $latestProjects,
            'latestTasks' => $latestTasks,
            'latestBudgets' => $latestBudgets
        ]);
    }
}
