<?php
// Author: Raiyat Haque
// login page: shows the login form and checks the email and password

include_once("database/db_connect.php");
include_once("util/auth.php");

$message = "";
$isError = false;   // error messages are shown in red, others in green
$email   = "";

if (isset($_SESSION['uid'])) {
    // already logged in
    header("refresh:2;url=index.php");
    $message = "You are already logged in";
}
else if (isset($_POST['email'])) {
    // the form was submitted
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $error = loginUser($db, $email, $password);

    if ($error == "") {
        // login worked: go to the dashboard in 2 seconds
        header("refresh:2;url=index.php");
        $message = "Welcome " . $_SESSION['name'] . "! Taking you to the dashboard...";
    }
    else {
        $message = $error;
        $isError = true;
    }
}

include("views/partials/header.php");

print "<main class='auth-page'>\n";

if ($message != "") {
    $class = $isError ? "auth-message auth-message-error" : "auth-message auth-message-success";
    $role  = $isError ? "alert" : "status";
    print "<p class='$class' role='$role'>" . htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</p>\n";
}

if (!isset($_SESSION['uid'])) {
    showLoginForm(is_string($email) ? $email : "");
}

print "</main>\n";

include("views/partials/footer.php");
?>
