<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Core/helpers.php';

use App\Config\Database;
use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\UserController;
use App\Controllers\ClientController;
use App\Controllers\ProjectController;
use App\Controllers\BudgetController;

// Initialize database and run migrations
Database::runMigrations();

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Create router
$router = new Router();

// Public routes
$router->get('/', [AuthController::class, 'showLogin']);
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

// Protected routes
$router->get('/dashboard', [DashboardController::class, 'index']);

// Users (admin only)
$router->get('/users', [UserController::class, 'index']);
$router->get('/users/create', [UserController::class, 'create']);
$router->post('/users/create', [UserController::class, 'create']);
$router->get('/users/edit', [UserController::class, 'edit']);
$router->post('/users/edit', [UserController::class, 'edit']);
$router->get('/users/delete', [UserController::class, 'delete']);

// Clients
$router->get('/clients', [ClientController::class, 'index']);
$router->get('/clients/create', [ClientController::class, 'create']);
$router->post('/clients/create', [ClientController::class, 'create']);
$router->get('/clients/edit', [ClientController::class, 'edit']);
$router->post('/clients/edit', [ClientController::class, 'edit']);
$router->get('/clients/delete', [ClientController::class, 'delete']);

// Projects
$router->get('/projects', [ProjectController::class, 'index']);
$router->get('/projects/create', [ProjectController::class, 'create']);
$router->post('/projects/create', [ProjectController::class, 'create']);
$router->get('/projects/edit', [ProjectController::class, 'edit']);
$router->post('/projects/edit', [ProjectController::class, 'edit']);
$router->get('/projects/delete', [ProjectController::class, 'delete']);

// Budgets
$router->get('/budgets', [BudgetController::class, 'index']);
$router->get('/budgets/create', [BudgetController::class, 'create']);
$router->post('/budgets/create', [BudgetController::class, 'create']);
$router->get('/budgets/edit', [BudgetController::class, 'edit']);
$router->post('/budgets/edit', [BudgetController::class, 'edit']);
$router->get('/budgets/delete', [BudgetController::class, 'delete']);
$router->post('/budgets/add-item', [BudgetController::class, 'addItem']);
$router->get('/budgets/delete-item', [BudgetController::class, 'deleteItem']);
$router->get('/budgets/export/pdf', [BudgetController::class, 'export']);

// Dispatch
// Settings routes
$router->get('/settings', [App\Controllers\SettingsController::class, 'index']);
$router->post('/settings', [App\Controllers\SettingsController::class, 'update']);

// Tasks (AJAX)
$router->post('/tasks/create', [App\Controllers\TaskController::class, 'store']);
$router->post('/tasks/update', [App\Controllers\TaskController::class, 'update']);
$router->post('/tasks/delete', [App\Controllers\TaskController::class, 'delete']);

$router->dispatch();
