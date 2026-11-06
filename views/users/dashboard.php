<?php
require_once __DIR__ . '/../../util/dashboard.php';
?>
<main class="marketplace-dashboard">
    <section class="text-center marketplace-hero">
        <h1 class="display-4 fw-bold">Buy, sell, and trade on campus</h1>
        <p class="lead">Find great deals from fellow Gettysburg students — no shipping, just a quick meetup.</p>
    </section>
    <form class="marketplace-search container pb-3" action="index.php" method="get" role="search">
            <label class="visually-hidden" for="marketplace-search-input">Search listings</label>
            <div class="input-group">
                <span class="marketplace-search-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"></circle><path d="m16 16 4 4"></path></svg></span>
                <input
                    class="form-control"
                    id="marketplace-search-input"
                    name="q"
                    type="search"
                    placeholder="Search textbooks, furniture, electronics..."
                    aria-label="Search listings"
                >
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
    <?php showCategories($db); ?>
    <section class="recent-listings" aria-labelledby="recent-listings-title">
        <div>
            <h2 id="recent-listings-title">Recent Listings</h2>
            <p>Fresh from students this week</p>
        </div>
        <div class="recent-listings-actions">
            <a href="browse.php">View all</a>
            <a class="recent-listings-post" href="#"><span aria-hidden="true">+</span> Post an Item</a>
        </div>
    </section>
    <?php showListings($db); ?>
</main>

