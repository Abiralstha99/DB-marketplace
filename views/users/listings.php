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
    $title = is_string($data['title'] ?? null) ? $data['title'] : '';
    $description = is_string($data['description'] ?? null) ? $data['description'] : '';
    $price = is_scalar($data['price'] ?? null) ? (string) $data['price'] : '';
    $categoryId = $data['category_id'] ?? '';
    $condition = $data['item_condition'] ?? '';
    $pickup = is_string($data['pickup_location'] ?? null) ? $data['pickup_location'] : '';

    $conditions = [
        'new' => 'New',
        'like_new' => 'Like new',
        'good' => 'Good',
        'fair' => 'Fair',
        'poor' => 'Poor'
    ];
?>

<main class="listing-page">
    <h1><?= htmlspecialchars($heading) ?></h1>

    <?php if ($formAction === 'index.php?action=addListing'): ?>
        <p>Share an item with the campus community.</p>
    <?php endif; ?>

    <div class="listing-form-card">

        <?php foreach ($errors as $error): ?>
            <p role="alert"><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>

        <form method="post"
              action="<?= htmlspecialchars($formAction) ?>"
              enctype="multipart/form-data">

            <input type="hidden" name="listing_token"
                   value="<?= htmlspecialchars($token) ?>">

            <!-- Title -->
            <div class="mb-3">
                <label class="form-label" for="listing-title">Title</label>
                <input class="form-control" id="listing-title"
                       name="title" type="text" maxlength="150"
                       value="<?= htmlspecialchars($title) ?>" required>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label class="form-label" for="listing-description">Description</label>
                <textarea class="form-control" id="listing-description"
                          name="description" maxlength="1000"
                          required><?= htmlspecialchars($description) ?></textarea>
            </div>

            <!-- Price -->
            <div class="mb-3">
                <label class="form-label" for="listing-price">Price ($)</label>
                <input class="form-control" id="listing-price"
                       name="price" type="number"
                       min="0" max="999999.99" step="0.01"
                       value="<?= htmlspecialchars($price) ?>" required>
            </div>

            <!-- Category -->
            <div class="mb-3">
                <label class="form-label" for="listing-category">Category</label>
                <select class="form-select" id="listing-category"
                        name="category_id" required>

                    <option value="">Select a category</option>

                    <?php foreach ($categories as $row): ?>
                        <option value="<?= (int) $row['category_id'] ?>"
                            <?= (is_string($categoryId) || is_int($categoryId))
                                && (string) $categoryId === (string) $row['category_id']
                                ? 'selected' : '' ?>>
                            <?= htmlspecialchars((string) $row['name']) ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <!-- Condition -->
            <div class="mb-3">
                <label class="form-label" for="listing-condition">Condition</label>
                <select class="form-select" id="listing-condition"
                        name="item_condition" required>

                    <option value="">Select a condition</option>

                    <?php foreach ($conditions as $value => $label): ?>
                        <option value="<?= $value ?>"
                            <?= $condition === $value ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <!-- Pickup location -->
            <div class="mb-3">
                <label class="form-label" for="listing-pickup">
                    Pickup location (optional)
                </label>
                <input class="form-control" id="listing-pickup"
                       name="pickup_location" type="text" maxlength="100"
                       value="<?= htmlspecialchars($pickup) ?>">
            </div>

            <!-- Image -->
            <div class="mb-3">
                <label class="form-label" for="listing-image">
                    Image (optional)
                </label>
                <input class="form-control" id="listing-image"
                       type="file" name="image"
                       accept="image/jpeg,image/png,image/webp">
            </div>

            <button class="btn btn-primary" type="submit">
                <?= htmlspecialchars($submitLabel) ?>
            </button>

        </form>
    </div>
</main>

<?php
}