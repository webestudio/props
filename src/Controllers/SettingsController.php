<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Middleware\AuthMiddleware;
use App\Models\CompanySettings;

class SettingsController extends BaseController
{
    public function index(): void
    {
        AuthMiddleware::requireAdmin(); // Only admins can change settings
        $settings = CompanySettings::get();
        $this->render('settings/index', ['settings' => $settings]);
    }

    public function update(): void
    {
        AuthMiddleware::requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $settings = CompanySettings::get();

            $settings->name = $_POST['name'] ?? $settings->name;
            $settings->tax_id = $_POST['tax_id'] ?? $settings->tax_id;
            $settings->address = $_POST['address'] ?? $settings->address;
            $settings->city = $_POST['city'] ?? $settings->city;
            $settings->zip = $_POST['zip'] ?? $settings->zip;
            $settings->email = $_POST['email'] ?? $settings->email;
            $settings->phone = $_POST['phone'] ?? $settings->phone;
            $settings->website = $_POST['website'] ?? $settings->website;
            $settings->default_iva_rate = $_POST['default_iva_rate'] ?? $settings->default_iva_rate;
            $settings->default_irpf_rate = $_POST['default_irpf_rate'] ?? $settings->default_irpf_rate;
            $settings->budget_series = $_POST['budget_series'] ?? $settings->budget_series;

            // Handle Logo Upload
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $filename = uniqid('logo_') . '_' . basename($_FILES['logo']['name']);
                $targetPath = $uploadDir . $filename;

                if (move_uploaded_file($_FILES['logo']['tmp_name'], $targetPath)) {
                    // Remove old logo if exists
                    if ($settings->logo_path && file_exists($_SERVER['DOCUMENT_ROOT'] . $settings->logo_path)) {
                        @unlink($_SERVER['DOCUMENT_ROOT'] . $settings->logo_path);
                    }
                    $settings->logo_path = '/uploads/' . $filename;
                }
            }

            if ($settings->save()) {
                // Redirect back with success message (using session or query param if toast needed)
                // For now, simple redirect
                $this->redirect('/settings');
            }
        }
    }
}
