<?php
if (!defined('MARKETPLACE_ROUTED')) {
    http_response_code(403);
    exit;
}

function createListingForm(
    $categories,
    $data,
    $errors,
    $formAction = 'index.php?action=addListing',
    $heading = 'Post an Item',
    $submitLabel = 'Post item',
    $token = ''
) {
    $price = $data['price'] ?? null;
    $categoryId = $data['category_id'] ?? null;
?>
<main class="listing-page">
    <h1><?= htmlspecialchars($heading, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></h1>
    <?php if ($formAction === 'index.php?action=addListing'): ?>
        <p>Share an item with the campus community.</p>
    <?php endif; ?>
    <div class="listing-form-card">
    <?php foreach ($errors as $error): ?>
        <p role="alert"><?= htmlspecialchars($error, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
    <?php endforeach; ?>
    <form method="post" action="<?= htmlspecialchars($formAction, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
        <input type="hidden" name="listing_token" value="<?= htmlspecialchars($token, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
        <div class="mb-3">
            <label class="form-label" for="listing-title">Title</label>
            <input class="form-control" id="listing-title" name="title" type="text" maxlength="150" value="<?= htmlspecialchars(is_string($data['title'] ?? null) ? $data['title'] : '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="listing-description">Description</label>
            <textarea class="form-control" id="listing-description" name="description" maxlength="1000" required><?= htmlspecialchars(is_string($data['description'] ?? null) ? $data['description'] : '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label" for="listing-price">Price ($)</label>
            <input class="form-control" id="listing-price" name="price" type="number" min="0" max="999999.99" step="0.01" value="<?= htmlspecialchars(is_scalar($price) ? (string) $price : '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="listing-category">Category</label>
            <select class="form-select" id="listing-category" name="category_id" required>
                <option value="">Select a category</option>
                <?php foreach ($categories as $row): ?>
                    <option value="<?= (int) $row['category_id'] ?>" <?= (is_string($categoryId) || is_int($categoryId)) && (string) $categoryId === (string) $row['category_id'] ? 'selected' : '' ?>><?= htmlspecialchars((string) $row['name'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="listing-condition">Condition</label>
            <select class="form-select" id="listing-condition" name="item_condition" required>
                <option value="">Select a condition</option>
                <?php foreach (['new' => 'New', 'like_new' => 'Like new', 'good' => 'Good', 'fair' => 'Fair', 'poor' => 'Poor'] as $value => $label): ?>
                    <option value="<?= $value ?>" <?= ($data['item_condition'] ?? '') === $value ? 'selected' : '' ?>><?= $label ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="listing-pickup">Pickup location (optional)</label>
            <input class="form-control" id="listing-pickup" name="pickup_location" type="text" maxlength="100" value="<?= htmlspecialchars(is_string($data['pickup_location'] ?? null) ? $data['pickup_location'] : '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
        </div>
        <button class="btn btn-primary" type="submit"><?= htmlspecialchars($submitLabel, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></button>
    </form>
    </div>
</main>
<?php
}
