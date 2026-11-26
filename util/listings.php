<?php
// Check the listing form and return any errors.
function validateListing($db, $data, $photo = null) {
    $errors = [];
    foreach (['title' => 150, 'description' => 1000] as $field => $limit) {
        $value = $data[$field] ?? null;
        if (!is_string($value) || trim($value) === '' || mb_strlen(trim($value)) > $limit) {
            $errors[] = ucfirst($field) . " is required and must be at most $limit characters.";
        }
    }

    $price = $data['price'] ?? null;
    if (!is_string($price) || !preg_match('/^\d{1,6}(?:\.\d{1,2})?$/D', $price)) {
        $errors[] = 'Enter a price from 0 to 999999.99 with at most two decimal places.';
    }

    $category = $data['category_id'] ?? null;
    if (is_string($category) && preg_match('/^[1-9]\d*$/D', $category)) {
        $sql = $db->prepare('SELECT category_id FROM categories WHERE category_id = ?');
        $sql->execute([$category]);
        $categoryExists = $sql->fetchColumn() !== false;
    } else {
        $categoryExists = false;
    }
    if (!$categoryExists) {
        $errors[] = 'Select an existing category.';
    }

    $condition = $data['item_condition'] ?? null;
    if (!is_string($condition) || !in_array($condition, ['new', 'like_new', 'good', 'fair', 'poor'], true)) {
        $errors[] = 'Select a valid condition.';
    }

    $pickup = $data['pickup_location'] ?? null;
    if (!is_string($pickup) || mb_strlen(trim($pickup)) > 100) {
        $errors[] = 'Pickup location must be at most 100 characters.';
    }

    if ($photo === null || $photo['error'] === UPLOAD_ERR_NO_FILE) {
        return $errors;
    }

    if ($photo['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Image upload failed.';
    } elseif ($photo['size'] > 5 * 1024 * 1024) {
        $errors[] = 'Image must be smaller than 5 MB.';
    } elseif (!in_array(mime_content_type($photo['tmp_name']), ['image/jpeg', 'image/png', 'image/webp'], true)) {
        $errors[] = 'Invalid image type.';
    }

    return $errors;
}

// Save a validated listing and its optional photo. Return any upload error to the form.
function createListing($db, $data, $sellerId, $photo = null): array {
    $image = null;
    if ($photo !== null && $photo['error'] !== UPLOAD_ERR_NO_FILE) {
        try {
            require_once __DIR__ . '/storage.php';
            $image = uploadImage($photo['tmp_name']);
        } catch (Exception $uploadError) {
            error_log('Listing image upload failed: ' . get_class($uploadError));
            return ['Image upload failed. Please try again.'];
        }
    }

    $categoryId = $data['category_id'];
    $title = trim($data['title']);
    $description = trim($data['description']);
    $price = $data['price'];
    $condition = $data['item_condition'];
    $pickup = $data['pickup_location'] ?? null;

    $commitStarted = false;
    try {
        $db->beginTransaction();
        $sql = $db->prepare("
            INSERT INTO listings
            (seller_id, category_id, title, description, price, item_condition, pickup_location, status, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
        ");
        $sql->execute([
            $sellerId,
            $categoryId,
            $title,
            $description,
            $price,
            $condition,
            $pickup
        ]);

        if ($image !== null) {
            $listingId = $db->lastInsertId();
            $sql = $db->prepare("
                INSERT INTO listing_images (listing_id, file_path, cloudinary_public_id, uploaded_at)
                VALUES (?, ?, ?, CURRENT_TIMESTAMP)
            ");
            $sql->execute([$listingId, $image['image_url'], $image['public_id']]);
        }

        $commitStarted = true;
        $db->commit();
    } catch (Throwable $databaseError) {
        try {
            $rolledBack = $db->inTransaction() ? $db->rollBack(): !$commitStarted;

            if ($image !== null && $rolledBack) {
                if (!deletePhoto($image['public_id'])) {
                    error_log('Image cleanup failed.');
                }
            }
        } catch (Throwable $e) {
            error_log('Rollback or cleanup failed.');
        }
        throw $databaseError;
    }
    return [];
}

// Get the categories in alphabetical order.
function getListingCategories($db) {
    $sql = $db->prepare("SELECT category_id, name FROM categories ORDER BY name");
    $sql->execute();
    return $sql->fetchAll();
}

// Get the seller's active and sold listings, newest first.
function getSellerListings($db, $sellerId): array {
    $sql = $db->prepare("SELECT listing_id, title, price, item_condition, created_at, status
        FROM listings
        WHERE seller_id = ? AND status IN ('active', 'sold')
        ORDER BY created_at DESC, listing_id DESC");
    $sql->execute([$sellerId]);
    return $sql->fetchAll();
}

// Load an active or sold listing that belongs to the seller.
function getOwnedListing($db, $listingId, $sellerId): array|false {
    $sql = $db->prepare("SELECT listing_id, category_id, title, description, price, item_condition, pickup_location
        FROM listings
        WHERE listing_id = ? AND seller_id = ? AND status IN ('active', 'sold')");
    $sql->execute([$listingId, $sellerId]);
    return $sql->fetch();
}

// Updates changes to the seller's listing.
function updateOwnedListing($db, $listingId, $sellerId, $data): int {
    $categoryId = $data['category_id'];
    $title = trim($data['title']);
    $description = trim($data['description']);
    $price = $data['price'];
    $condition = $data['item_condition'];
    $pickup = $data['pickup_location'] ?? null;

    $sql = $db->prepare("
        UPDATE listings
        SET category_id = ?, 
            title = ?, 
            description = ?, 
            price = ?, 
            item_condition = ?, 
            pickup_location = ?,
            updated_at = CURRENT_TIMESTAMP
        WHERE listing_id = ? 
          AND seller_id = ? 
          AND status IN ('active', 'sold')
    ");

    $sql->execute([
        $categoryId,
        $title,
        $description,
        $price,
        $condition,
        $pickup,
        $listingId,
        $sellerId
    ]);

    return $sql->rowCount();
}

// Mark the seller's listing as deleted
function softDeleteOwnedListing($db, $listingId, $sellerId): bool {
    $sql = $db->prepare("UPDATE listings
        SET status = 'deleted', updated_at = CURRENT_TIMESTAMP
        WHERE listing_id = ? AND seller_id = ? AND status IN ('active', 'sold')");
    $sql->execute([$listingId, $sellerId]);
    return $sql->rowCount() === 1;
}
