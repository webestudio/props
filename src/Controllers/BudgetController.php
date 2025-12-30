<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Budget;
use App\Models\BudgetItem;
use App\Models\Project;
use App\Middleware\AuthMiddleware;

class BudgetController extends BaseController
{
    public function index(): void
    {
        AuthMiddleware::handle();

        $page = (int) ($_GET['page'] ?? 1);
        $perPageInput = $_GET['per_page'] ?? '10';
        $perPage = ($perPageInput === 'all') ? 0 : (int) $perPageInput;
        $search = $_GET['search'] ?? '';

        $pagination = Budget::paginate($page, $perPage, $search, ['title', 'description']);

        $this->render('budgets/index', [
            'budgets' => $pagination['data'],
            'pagination' => $pagination,
            'search' => $search,
            'per_page' => $perPageInput
        ]);
    }

    public function create(): void
    {
        AuthMiddleware::handle();

        // Handle JSON Request (from Alpine.js)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);

            if ($input) {
                try {
                    // Get Settings for Series
                    $settings = \App\Models\CompanySettings::get();
                    $nextNumber = $settings->incrementBudgetNumber();

                    $budget = new Budget();

                    // Validate Client ID
                    if (empty($input['client_id'])) {
                        throw new \Exception('Se requiere un cliente.');
                    }

                    $project = Project::findOrCreateGeneral($input['client_id'], $input['title']);

                    $budget->project_id = $project->id;
                    $budget->title = $input['title'] ?? '';
                    $budget->description = $input['description'] ?? '';
                    $budget->status = $input['status'] ?? 'draft';
                    $budget->tax_rate = $input['tax_rate'] ?? 21.0;
                    $budget->irpf_rate = $input['irpf_rate'] ?? 0;
                    $budget->has_irpf = $input['has_irpf'] ? 1 : 0;
                    $budget->valid_until = $input['valid_until'] ?? null;
                    $budget->series = $settings->budget_series;
                    $budget->number = $nextNumber;

                    $budget->save(); // Save Header

                    // Save Items
                    if (isset($input['items']) && is_array($input['items'])) {
                        foreach ($input['items'] as $itemData) {
                            $item = new BudgetItem();
                            $item->budget_id = $budget->id;
                            $item->concept = $itemData['concept'];
                            $item->quantity = $itemData['quantity'];
                            $item->unit_price = $itemData['unit_price'];
                            if (!$item->save()) {
                                throw new \Exception("Error al guardar el concepto: " . $item->concept);
                            }
                        }
                    }

                    $budget->recalculate();

                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'id' => $budget->id]);
                    exit;

                } catch (\Throwable $e) {
                    http_response_code(500);
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
                    exit;
                }
            }
        }

        $clients = \App\Models\Client::all();
        $settings = \App\Models\CompanySettings::get();
        $this->render('budgets/create', ['clients' => $clients, 'settings' => $settings]);
    }

    public function edit(): void
    {
        AuthMiddleware::handle();

        $id = $_GET['id'] ?? 0;
        $budget = Budget::find($id);

        if (!$budget) {
            $this->redirect('/budgets');
        }

        // Handle JSON Request (from Alpine.js)
        // Handle JSON Request (from Alpine.js)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);

            if ($input) {
                try {
                    // Update Header
                    $budget->title = $input['title'] ?? $budget->title;
                    $budget->description = $input['description'] ?? $budget->description;
                    $budget->status = $input['status'] ?? $budget->status;
                    $budget->tax_rate = $input['tax_rate'] ?? 21.0;
                    $budget->irpf_rate = $input['irpf_rate'] ?? 0;
                    $budget->has_irpf = $input['has_irpf'] ? 1 : 0;
                    $budget->valid_until = $input['valid_until'] ?? null;
                    $budget->save();

                    // Sync Items
                    $incomingItems = $input['items'] ?? [];
                    $currentItems = $budget->items();
                    $currentIds = array_map(fn($i) => $i->id, $currentItems);
                    $incomingIds = array_filter(array_column($incomingItems, 'id')); // Only IDs that exist

                    // Delete removed items
                    $toDelete = array_diff($currentIds, $incomingIds);
                    foreach ($toDelete as $delId) {
                        BudgetItem::find($delId)->delete();
                    }

                    // Update or Insert
                    foreach ($incomingItems as $itemData) {
                        if (isset($itemData['id']) && in_array($itemData['id'], $currentIds)) {
                            $item = BudgetItem::find($itemData['id']);
                        } else {
                            $item = new BudgetItem();
                            $item->budget_id = $budget->id;
                        }

                        $item->concept = $itemData['concept'];
                        $item->quantity = $itemData['quantity'];
                        $item->unit_price = $itemData['unit_price'];
                        if (!$item->save()) {
                            throw new \Exception("Error al guardar el concepto: " . $item->concept);
                        }
                    }

                    $budget->recalculate();

                    header('Content-Type: application/json');
                    echo json_encode(['success' => true]);
                    exit;

                } catch (\Throwable $e) {
                    http_response_code(500);
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
                    exit;
                }
            }
        }

        $projects = Project::all();
        $items = $budget->items();
        $this->render('budgets/edit', [
            'budget' => $budget,
            'projects' => $projects,
            'items' => $items
        ]);
    }

    public function delete(): void
    {
        AuthMiddleware::handle();

        $id = $_GET['id'] ?? 0;
        $budget = Budget::find($id);

        if ($budget) {
            $budget->delete();
        }

        $this->redirect('/budgets');
    }

    public function addItem(): void
    {
        AuthMiddleware::handle();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $item = new BudgetItem();
            $item->budget_id = $_POST['budget_id'] ?? 0;
            $item->concept = $_POST['concept'] ?? '';
            $item->description = $_POST['description'] ?? '';
            $item->quantity = $_POST['quantity'] ?? 1;
            $item->unit_price = $_POST['unit_price'] ?? 0;
            $item->save();

            $this->redirect('/budgets/edit?id=' . $item->budget_id);
        }
    }

    public function deleteItem(): void
    {
        AuthMiddleware::handle();

        $id = $_GET['id'] ?? 0;
        $item = BudgetItem::find($id);

        if ($item) {
            $budgetId = $item->budget_id;
            $item->delete();
            $this->redirect('/budgets/edit?id=' . $budgetId);
        } else {
            $this->redirect('/budgets');
        }
    }

    public function export(): void
    {
        AuthMiddleware::handle();

        try {
            $id = $_GET['id'] ?? 0;
            $budget = Budget::find($id);

            if (!$budget) {
                throw new \Exception("Presupuesto no encontrado (ID: $id)");
            }

            $items = $budget->items();
            $settings = \App\Models\CompanySettings::get();

            // Render View to String
            ob_start();
            include __DIR__ . '/../Views/budgets/pdf.php';
            $html = ob_get_clean();

            // Debug mode: output raw HTML and exit
            if (isset($_GET['debug']) && $_GET['debug'] == '1') {
                echo $html;
                exit;
            }

            // Configure Dompdf
            $options = new \Dompdf\Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);
            $options->set('chroot', $_SERVER['DOCUMENT_ROOT']);

            $dompdf = new \Dompdf\Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Stream PDF
            $filename = 'Presupuesto-' . $budget->series . '-' . $budget->number . '.pdf';
            $dompdf->stream($filename, ["Attachment" => true]);

        } catch (\Throwable $e) {
            if (ob_get_length())
                ob_end_clean();
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'error' => 'Error al generar el PDF: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            exit;
        }
    }
}
