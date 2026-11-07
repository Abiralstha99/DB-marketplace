<?php
// Author: Raiyat Haque
// logs the user out and goes back to the home page

include_once("util/auth.php");

logoutUser();

header("refresh:2;url=index.php");

include("views/partials/header.php");
print "<DIV class='container pt-4'><P><B>You are logged out</B></P></DIV>\n";
include("views/partials/footer.php");
?>
