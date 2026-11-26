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
if ($action === 'editListing' || $action === 'deleteListing') {
    $input = $action === 'editListing' ? $_GET : $_POST;
    $listingId = filter_var($input['listing_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($listingId === false) {
        http_response_code(404);
        exit('Listing not found.');
    }
}

switch ($action) {
    case 'dashboard':
        require_once __DIR__ . '/util/dashboard.php';
        $search = is_string($_GET['search_bar'] ?? null) ? trim($_GET['search_bar']) : '';
        $category = is_string($_GET['category'] ?? null) ? trim($_GET['category']) : '';
        $categories = getListingCategories($db);
        $listings = getDashboardListings($db, $search, $category);
        $listingSuccess = $_SESSION['listing_success'] ?? null;
        unset($_SESSION['listing_success']);
        break;

    case 'addListing':
        $data = [];
        $errors = [];
        if ($isPost) {
            $data = $_POST;
            $photo = $_FILES['image'] ?? null;
            $errors = validateListing($db, $data, $photo);
            if ($errors === []) {
                $errors = createListing($db, $data, $sellerId, $photo);
            }
            if ($errors === []) {
                $_SESSION['listing_success'] = 'Your item has been posted.';
                header('Location: index.php');
                exit;
            }
        }
        $categories = getListingCategories($db);
        $formOptions = [];
        break;

    case 'myListings':
        $listings = getSellerListings($db, $sellerId);
        $listingManagementSuccess = $_SESSION['listing_management_success'] ?? null;
        unset($_SESSION['listing_management_success']);
        break;

    case 'editListing':
        $data = getOwnedListing($db, $listingId, $sellerId);
        if ($data === false) {
            http_response_code(404);
            exit('Listing not found.');
        }

        $errors = [];
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
        $formOptions = ["index.php?action=editListing&listing_id=$listingId", 'Edit Listing', 'Save changes'];
        break;

    case 'deleteListing':
        if (!softDeleteOwnedListing($db, $listingId, $sellerId)) {
            http_response_code(404);
            exit('Listing not found.');
        }
        $_SESSION['listing_management_success'] = 'Your listing has been deleted.';
        header('Location: index.php?action=myListings', true, 303);
        exit;
}

require __DIR__ . '/views/partials/header.php';
require $routes[$action];
if (isset($formOptions)) {
    createListingForm($categories, $data, $errors, ...$formOptions);
}
require __DIR__ . '/views/partials/footer.php';
