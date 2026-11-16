<?php
require_once __DIR__ . '/util/auth.php';
requireLogin();

$action = $_GET['action'] ?? 'dashboard';
$routes = [
    'dashboard' => __DIR__ . '/views/users/dashboard.php',
    'addListing' => __DIR__ . '/views/users/listings.php',
];

if (!is_string($action) || !isset($routes[$action])) {
    http_response_code(404);
    exit('Page not found.');
}

require_once __DIR__ . '/database/db_connect.php';
define('MARKETPLACE_ROUTED', true);

require __DIR__ . '/views/partials/header.php';
require $routes[$action];
require __DIR__ . '/views/partials/footer.php';
