<?php
function showCategories($db){
    $query = "SELECT name FROM categories ORDER BY name";
    $sql = $db->prepare($query);
    $sql->execute();

    $rows = $sql->fetchAll();
    ?>
    <nav class="marketplace-categories" aria-label="Browse categories">
        <ul class="category-row">
            <li><a class="category-pill is-active" href="index.php">All Topics</a></li>
            <?php foreach ($rows as $row): ?>
                <li><a class="category-pill" href="index.php?category=<?= urlencode($row['name']) ?>"><?= htmlspecialchars((string) $row['name'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <?php
}

function showListings($db){
    $query = "SELECT l.listing_id, l.title, l.price, l.item_condition, l.pickup_location, l.created_at, CONCAT(u.first_name, ' ', u.last_name) AS seller_name, u.class_year
            FROM listings l
            JOIN users u
                ON l.seller_id = u.user_id
            WHERE l.status = 'active'
            ORDER BY l.created_at DESC
            LIMIT 12 OFFSET 0";
    $sql = $db->prepare($query);
    $sql->execute();

    $rows = $sql->fetchAll();
    ?>
    <?php if (empty($rows)) { ?>
        <p class="listings-empty">No listings available yet.</p>
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
