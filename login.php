<?php
// Author: Raiyat Haque
// login page: shows the login form and checks the email and password

include_once("database/db_connect.php");
include_once("util/auth.php");

$message = "";

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
    }
}

include("views/partials/header.php");

if ($message != "") {
    print "<DIV class='container pt-4'><P><B>$message</B></P></DIV>\n";
}

if (!isset($_SESSION['uid'])) {
    showLoginForm();
}

include("views/partials/footer.php");
?>
