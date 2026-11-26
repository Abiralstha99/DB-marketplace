<?php
if (!defined('MARKETPLACE_ROUTED')) {
    http_response_code(403);
    exit;
}
?>

<main class="listing-page">
    <h1>My Listings</h1>

    <?php if ($listingManagementSuccess !== null): ?>
        <p role="status"><?= htmlspecialchars($listingManagementSuccess) ?></p>
    <?php endif; ?>

    <?php if (empty($listings)): ?>
        <p>You don't have any listings yet.</p>
        <a class="btn btn-primary" href="index.php?action=addListing">
            Post an Item
        </a>
    <?php else: ?>
        <ul class="list-unstyled mt-3" role="list">
            <?php foreach ($listings as $listing): ?>
                <?php
                $id = (int) $listing['listing_id'];
                $title = htmlspecialchars($listing['title']);
                $price = (float) $listing['price'];
                $condition = ucfirst(str_replace('_', ' ', $listing['item_condition']));
                $status = ucfirst($listing['status']);
                $postedAt = new DateTimeImmutable($listing['created_at']);
                ?>

                <li class="listing-card mb-3">
                    <h2 class="h5 text-break"><?= $title ?></h2>

                    <span class="listing-price">
                        <?= $price == 0 ? 'Free' : '$' . number_format($price, 2) ?>
                    </span>

                    <p class="listing-meta mb-0">
                        <?= htmlspecialchars($condition) ?> &middot;
                        <?= htmlspecialchars($status) ?> &middot;
                        Posted <time datetime="<?= $postedAt->format('Y-m-d') ?>">
                            <?= $postedAt->format('M j, Y') ?>
                        </time>
                    </p>

                    <div class="d-flex flex-wrap gap-2 mt-3">
                        <a class="btn btn-outline-primary"
                           href="index.php?action=editListing&amp;listing_id=<?= $id ?>"
                           aria-label="Edit <?= $title ?>">
                            Edit
                        </a>

                        <form method="post" action="index.php?action=deleteListing">
                            <input type="hidden" name="listing_id" value="<?= $id ?>">
                            <button class="btn btn-outline-danger" type="submit"
                                    aria-label="Delete <?= $title ?>">
                                Delete
                            </button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</main>