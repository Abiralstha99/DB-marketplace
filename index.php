<?php
require_once __DIR__ . '/util/auth.php';
requireLogin();

$action = $_GET['action'] ?? 'dashboard';
$routes = [
    'dashboard' => __DIR__ . '/views/users/dashboard.php',
    'addListing' => __DIR__ . '/views/users/listings.php',
    'myListings' => __DIR__ . '/views/users/myListings.php',
    'editListing' => __DIR__ . '/views/users/listings.php',
    'deleteListing' => null,
];

if (!is_string($action) || !array_key_exists($action, $routes)) {
    http_response_code(404);
    exit('Page not found.');
}

$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';
if ($action === 'deleteListing' && !$isPost) {
    header('Allow: POST');
    http_response_code(405);
    exit('Method not allowed.');
}

require_once __DIR__ . '/database/db_connect.php';
require_once __DIR__ . '/util/listings.php';
define('MARKETPLACE_ROUTED', true);

$sellerId = $_SESSION['uid'];
$errors = [];
$data = [];
if ($action === 'addListing') {
    if ($isPost) {
        $data = $_POST;
        $errors = validateListing($db, $data);
        if ($errors === []) {
            createListing($db, $data, $sellerId);
            $_SESSION['listing_success'] = 'Your item has been posted.';
            header('Location: index.php');
            exit;
        }
    }
    $categories = getListingCategories($db);
} elseif ($action === 'myListings') {
    $listings = getSellerListings($db, $sellerId);
    $listingManagementSuccess = $_SESSION['listing_management_success'] ?? null;
    unset($_SESSION['listing_management_success']);
} elseif ($action === 'editListing' || $action === 'deleteListing') {
    $input = $action === 'editListing' ? $_GET : $_POST;
    $listingId = filter_var($input['listing_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($listingId === false) {
        http_response_code(404);
        exit('Listing not found.');
    }

    if ($action === 'deleteListing') {
        if (!softDeleteOwnedListing($db, $listingId, $sellerId)) {
            http_response_code(404);
            exit('Listing not found.');
        }
        $_SESSION['listing_management_success'] = 'Your listing has been deleted.';
        header('Location: index.php?action=myListings', true, 303);
        exit;
    }

    $data = getOwnedListing($db, $listingId, $sellerId);
    if ($data === false) {
        http_response_code(404);
        exit('Listing not found.');
    }

    if ($isPost) {
        $data = $_POST;
        $errors = validateListing($db, $data);
        if ($errors === []) {
            $updated = updateOwnedListing($db, $listingId, $sellerId, $data);
            if ($updated === 0 && getOwnedListing($db, $listingId, $sellerId) === false) {
                http_response_code(404);
                exit('Listing not found.');
            }
            $_SESSION['listing_management_success'] = 'Your listing has been updated.';
            header('Location: index.php?action=myListings', true, 303);
            exit;
        }
    }
    $categories = getListingCategories($db);
}

require __DIR__ . '/views/partials/header.php';
require $routes[$action];
if ($action === 'addListing') {
    createListingForm($categories, $data, $errors);
} elseif ($action === 'editListing') {
    createListingForm($categories, $data, $errors, "index.php?action=editListing&listing_id=$listingId", 'Edit Listing', 'Save changes');
}
require __DIR__ . '/views/partials/footer.php';
