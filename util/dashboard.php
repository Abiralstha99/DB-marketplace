<?php
function getDashboardListings($db, $search = '', $category = ''): array {
    $query = "SELECT l.listing_id, l.title, l.price, l.item_condition, l.pickup_location, l.created_at,
                CONCAT(u.first_name, ' ', u.last_name) AS seller_name, u.class_year, i.file_path AS image_url
            FROM listings l
            JOIN users u
                ON l.seller_id = u.user_id
            JOIN categories c
                ON l.category_id = c.category_id
            LEFT JOIN listing_images i
                ON l.listing_id = i.listing_id
            WHERE l.status = 'active'";
    $params = [];
    if ($search !== '') {

    // .= Means concatenation 
        $query .= " AND (l.title LIKE ? OR l.description LIKE ?)";
        $params = ["%$search%", "%$search%"];
    }

    if ($category !== '') {
        $query .= " AND c.name = ?";
        $params[] = $category;
    }
    $query .= " ORDER BY l.created_at DESC LIMIT 12";
    $sql = $db->prepare($query);
    $sql->execute($params);

    return $sql->fetchAll();
}
