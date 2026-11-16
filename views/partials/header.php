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
    <header class="border-bottom">
        <nav class="container-fluid d-flex justify-content-between align-items-center px-5 py-2">
            <div class="logo d-flex align-items-center gap-4">
                <img src="/public/assets/images/gettysburg-logo.png" alt="Gettysburg Logo">
                <span class="border-start border-secondary ps-4 fs-3 fw-bold text-primary-emphasis">Campus Marketplace</span>
            </div>

            <div class="nav-links d-flex align-items-center gap-5">
                <a href="index.php">Home</a>
                <a href="browse.php">Browse Listings</a>
                <a href="listings.php">Sell an Item</a>
                <?php
                    if (isset($_SESSION['uid'])) {
                        print "<span>Hi, " . $_SESSION['name'] . "</span>\n";
                        print "<a href='logout.php'>Log Out</a>\n";
                    }
                    else {
                        print "<a href='login.php'>Log In</a>\n";
                    }
                ?>
            </div>
        </nav>    
    </header>
