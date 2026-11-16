<?php
if (!defined('MARKETPLACE_ROUTED')) {
    http_response_code(403);
    exit;
}

require_once __DIR__ . '/../../util/listings.php';

$errors = [];
$data = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors[] = 'Posting items is not available yet.';
    $data = $_POST;
}

?>
<main class="listing-page">
    <h1>Post an Item</h1>
    <p>Share an item with the campus community.</p>
    <div class="listing-form-card">
    <?php foreach ($errors as $error): ?>
        <p role="alert"><?= htmlspecialchars($error, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
    <?php endforeach; ?>
    <?php addListings($db, $data); ?>
    </div>
</main>
