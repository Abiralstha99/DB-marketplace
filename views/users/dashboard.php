<?php
if (!defined('MARKETPLACE_ROUTED')) {
    http_response_code(403);
    exit;
}
?>
<main class="marketplace-dashboard">
    <?php if ($listingSuccess !== null): ?>
        <p role="status"><?= htmlspecialchars($listingSuccess) ?></p>
    <?php endif; ?>
    <section class="text-center marketplace-hero">
        <h1 class="display-4 fw-bold">Buy, sell, and trade on campus</h1>
        <p class="lead">Find great deals from fellow Gettysburg students — no shipping, just a quick meetup.</p>
    </section>
    <form class="marketplace-search container pb-3" action="index.php" method="get" role="search">
            <?php if ($category !== ''): ?>
                <input type="hidden" name="category" value="<?= htmlspecialchars($category) ?>">
            <?php endif; ?>
            <label class="visually-hidden" for="marketplace-search-input">Search listings</label>
            <div class="input-group">
                <span class="marketplace-search-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"></circle><path d="m16 16 4 4"></path></svg></span>
                <input
                    class="form-control"
                    id="marketplace-search-input"
                    name="search_bar"
                    type="search"
                    value="<?= htmlspecialchars($search) ?>"
                    placeholder="Search textbooks, furniture, electronics..."
                    aria-label="Search listings"
                >
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
    <nav class="marketplace-categories" aria-label="Browse categories">
        <ul class="category-row">
            <li><a class="category-pill<?= $category === '' ? ' is-active' : '' ?>" href="index.php<?= $search !== '' ? '?search_bar=' . urlencode($search) : '' ?>" <?= $category === '' ? 'aria-current="page"' : '' ?>>All Topics</a></li>
            <?php foreach ($categories as $row): ?>
                <li><a class="category-pill<?= $category === $row['name'] ? ' is-active' : '' ?>" href="index.php?category=<?= urlencode($row['name']) ?><?= $search !== '' ? '&amp;search_bar=' . urlencode($search) : '' ?>" <?= $category === $row['name'] ? 'aria-current="page"' : '' ?>><?= htmlspecialchars((string) $row['name']) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <section class="recent-listings" aria-labelledby="recent-listings-title">
        <div>
            <h2 id="recent-listings-title">Recent Listings</h2>
            <p>Fresh from students this week</p>
        </div>
        <div class="recent-listings-actions">
            <a href="browse.php">View all</a>
            <a class="recent-listings-post" href="index.php?action=addListing">
                <span aria-hidden="true">+</span> 
                Post an Item
            </a>
        </div>
    </section>
    <?php if (empty($listings)): ?>
        <p class="listings-empty"><?= $search !== '' || $category !== '' ? 'No matching listings found.' : 'No listings available yet.' ?></p>
    <?php else: ?>
        <div class="listings-grid">
            <?php foreach ($listings as $row): ?>
                <div class="listing-card">
                    <div class="listing-card-image">
                        <?php if ($row['image_url'] !== null): ?>
                            <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="" loading="lazy">
                        <?php else: ?>
                            No photo
                        <?php endif; ?>
                    </div>
                    <div class="listing-condition"><?= htmlspecialchars(ucwords(str_replace('_', ' ', $row['item_condition']))) ?></div>
                    <div class="listing-card-heading">
                        <h3><?= htmlspecialchars($row['title']) ?></h3>
                        <span class="listing-price"><?= (float) $row['price'] == 0 ? 'Free' : '$' . number_format((float) $row['price'], 2) ?></span>
                    </div>
                    <p class="listing-meta">
                        <?php if (!empty($row['pickup_location'])): ?>
                            <?= htmlspecialchars($row['pickup_location']) ?> ·
                        <?php endif; ?>
                        <?= date('M j, Y', strtotime($row['created_at'])) ?>
                    </p>
                    <div class="listing-seller">
                        <?= htmlspecialchars($row['seller_name']) ?>
                        <?php if ($row['class_year'] !== null): ?>
                            '<?= htmlspecialchars(substr((string) $row['class_year'], -2)) ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

