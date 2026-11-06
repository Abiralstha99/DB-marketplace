<?php
function showCategories($db, $category = '', $search = ''){
    $query = "SELECT name FROM categories ORDER BY name";
    $sql = $db->prepare($query);
    $sql->execute();

    $rows = $sql->fetchAll();
    ?>
    <nav class="marketplace-categories" aria-label="Browse categories">
        <ul class="category-row">
            <li><a class="category-pill<?= $category === '' ? ' is-active' : '' ?>" href="index.php<?= $search !== '' ? '?search_bar=' . urlencode($search) : '' ?>" <?= $category === '' ? 'aria-current="page"' : '' ?>>All Topics</a></li>
            <?php foreach ($rows as $row): ?>
                <li><a class="category-pill<?= $category === $row['name'] ? ' is-active' : '' ?>" href="index.php?category=<?= urlencode($row['name']) ?><?= $search !== '' ? '&amp;search_bar=' . urlencode($search) : '' ?>" <?= $category === $row['name'] ? 'aria-current="page"' : '' ?>><?= htmlspecialchars((string) $row['name'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <?php
}

function showListings($db, $search = '', $category = ''){
    $query = "SELECT l.listing_id, l.title, l.price, l.item_condition, l.pickup_location, l.created_at, CONCAT(u.first_name, ' ', u.last_name) AS seller_name, u.class_year
            FROM listings l
            JOIN users u
                ON l.seller_id = u.user_id
            JOIN categories c
                ON l.category_id = c.category_id
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

    $rows = $sql->fetchAll();
    ?>
    <?php if (empty($rows)) { ?>
        <p class="listings-empty"><?= $search !== '' || $category !== '' ? 'No matching listings found.' : 'No listings available yet.' ?></p>
    <?php } else { ?>
        <div class="listings-grid">
            <?php foreach ($rows as $row) { ?>
                <div class="listing-card">
                    <div class="listing-condition"><?= htmlspecialchars(ucwords(str_replace('_', ' ', $row['item_condition'])), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></div>
                    <div class="listing-card-heading">
                        <h3><?= htmlspecialchars($row['title'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></h3>
                        <span class="listing-price"><?= (float) $row['price'] == 0 ? 'Free' : '$' . number_format((float) $row['price'], 2) ?></span>
                    </div>
                    <p class="listing-meta">
                        <?php if (!empty($row['pickup_location'])) { ?>
                            <?= htmlspecialchars($row['pickup_location'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?> ·
                        <?php } ?>
                        <?= date('M j, Y', strtotime($row['created_at'])) ?>
                    </p>
                    <div class="listing-seller">
                        <?= htmlspecialchars($row['seller_name'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>
                        <?php if ($row['class_year'] !== null) { ?>
                            '<?= htmlspecialchars(substr((string) $row['class_year'], -2), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
    <?php
}
