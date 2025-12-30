<?php

function h(string $string): string
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function auth(): ?object
{
    if (!isset($_SESSION['user_id'])) {
        return null;
    }

    return (object) [
        'id' => $_SESSION['user_id'],
        'name' => $_SESSION['user_name'],
        'email' => $_SESSION['user_email'],
        'role' => $_SESSION['user_role']
    ];
}

function isAdmin(): bool
{
    return auth() && auth()->role === 'admin';
}

function formatCurrency(float $amount): string
{
    return number_format($amount, 2, ',', '.') . ' €';
}

function formatDate(?string $date): string
{
    if (!$date) {
        return '-';
    }

    return date('d/m/Y', strtotime($date));
}
