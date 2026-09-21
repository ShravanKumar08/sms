<?php

function app_config(string $key, $default = null)
{
    static $config = null;

    if ($config === null) {
        $config = require BASE_PATH . '/config/config.php';
    }

    return $config[$key] ?? $default;
}

function e(string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}

function csrf_token(): string
{
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['_csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '">';
}

function verify_csrf(): bool
{
    $submitted = $_POST['_csrf'] ?? '';
    return is_string($submitted) && !empty($_SESSION['_csrf']) && hash_equals($_SESSION['_csrf'], $submitted);
}

function set_flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function get_flash(): ?array
{
    if (empty($_SESSION['flash'])) {
        return null;
    }

    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);

    return $flash;
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function is_logged_in(): bool
{
    return !empty($_SESSION['user']);
}

function current_user_role(): ?string
{
    return $_SESSION['user']['role'] ?? null;
}

function require_login(): void
{
    if (!is_logged_in()) {
        redirect('/login');
    }
}

function route_matches(string $route): bool
{
    $requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $requestPath = rtrim($requestPath, '/');
    $requestPath = $requestPath === '' ? '/' : $requestPath;
    $route = rtrim($route, '/');

    return $requestPath === $route;
}

function url(string $path = '/'): string
{
    return $path === '/' ? '/' : '/' . ltrim($path, '/');
}

function active_nav(string $current, string $expected): string
{
    return $current === $expected ? 'active' : '';
}

function money(float $value): string
{
    return '₹' . number_format($value, 2, '.', ',');
}

function format_date(?string $date): string
{
    if (!$date) {
        return 'N/A';
    }

    return date('d M, Y', strtotime($date));
}
