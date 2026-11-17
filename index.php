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

$errors = [];
$data = [];
if ($action === 'addListing') {
    require_once __DIR__ . '/util/listings.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = $_POST;
        $errors = validateListing($db, $data);
        if ($errors === []) {
            createListing($db, $data, $_SESSION['uid']);
            $_SESSION['listing_success'] = 'Your item has been posted.';
            header('Location: index.php');
            exit;
        }
    }
    $categories = getListingCategories($db);
}

require __DIR__ . '/views/partials/header.php';
require $routes[$action];
if ($action === 'addListing') {
    createListingForm($categories, $data, $errors);
}
require __DIR__ . '/views/partials/footer.php';
