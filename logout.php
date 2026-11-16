<?php
// Author: Raiyat Haque
// logs the user out and goes back to the home page

include_once("util/auth.php");

logoutUser();

header("refresh:2;url=index.php");

include("views/partials/header.php");
?>
<main class="auth-page">
    <div class="auth-card auth-card-center">
        <h1>You are logged out</h1>
        <p class="auth-subtitle">Taking you back to the home page...</p>
        <a class="auth-button" href="index.php">Back to home</a>
    </div>
</main>
<?php
include("views/partials/footer.php");
?>
