<?php

namespace App\Core;

abstract class BaseController
{
    protected function render(string $view, array $data = [], bool $useLayout = true): void
    {
        extract($data);

        ob_start();
        require __DIR__ . "/../Views/{$view}.php";
        $content = ob_get_clean();

        if ($useLayout) {
            require __DIR__ . '/../Views/layouts/main.php';
        } else {
            echo $content;
        }
    }

    protected function redirect(string $path): void
    {
        header("Location: {$path}");
        exit;
    }

    protected function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
