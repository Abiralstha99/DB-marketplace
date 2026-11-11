<?php
// Raiyat Haque: added session and the Log In / Log Out link
include_once(__DIR__ . "/../../util/auth.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body>
    <header class="site-header border-bottom">
        <nav class="site-nav container-fluid">
            <div class="logo">
                <img src="/public/assets/images/gettysburg-logo.png" alt="Gettysburg Logo">
                <span>Campus Marketplace</span>
            </div>

            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="browse.php">Browse Listings</a>
                <a href="listings.php">Sell an Item</a>

                <!-- greeting and Log In / Log Out sit together, set apart from the page links -->
                <div class="nav-account">
                <?php
                    if (isset($_SESSION['uid'])) {
                        $name = htmlspecialchars($_SESSION['name'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                        print "<span class='nav-greeting'>Hi, <strong>$name</strong></span>\n";
                        print "<a class='nav-button nav-button-outline' href='logout.php'>Log Out</a>\n";
                    }
                    else {
                        print "<a class='nav-button' href='login.php'>Log In</a>\n";
                    }
                ?>
                </div>
            </div>
        </nav>
    </header>
