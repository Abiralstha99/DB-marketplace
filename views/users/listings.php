<?php
require_once __DIR__ . '/../../database/db_connect.php';
require_once __DIR__ . '/../../util/listings.php';

$errors = [];
$data = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors[] = 'Posting items is not available yet.';
    $data = $_POST;
}

require __DIR__ . '/../partials/header.php';
?>
<main class="listing-page">
    <h1>Post an Item</h1>
    <p>Share an item with the campus community.</p>
    <div class="listing-form-card">
    <?php addListings($db, $errors, $data); ?>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
