<?php
function validateListing($db, $data) {
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

    $pickup = $data['pickup_location'] ?? '';
    if (!is_string($pickup) || mb_strlen(trim($pickup)) > 100) {
        $errors[] = 'Pickup location must be at most 100 characters.';
    }

    return $errors;
}

function createListing($db, $data, $sellerId) {
    $sql = $db->prepare("INSERT INTO listings
        (seller_id, category_id, title, description, price, item_condition, pickup_location, status, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");
    $pickup = trim($data['pickup_location'] ?? '');
    $sql->execute([
        $sellerId, $data['category_id'], trim($data['title']), trim($data['description']),
        $data['price'], $data['item_condition'], $pickup === '' ? null : $pickup,
    ]);
}

function getListingCategories($db) {
    $sql = $db->prepare("SELECT category_id, name FROM categories ORDER BY name");
    $sql->execute();
    return $sql->fetchAll();
}
