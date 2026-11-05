<?php
// Template. Copy this file to db_connect.php in this folder, then fill in $user and $pass.
// db_connect.php is in .gitignore. Never put a real password in this template.
$server = "cray.cs.gettysburg.edu";
$dbase  = "f26_anrt";
$user   = "YOUR_USERNAME";
$pass   = "YOUR_PASSWORD";
$dsn    = "mysql:host=$server;dbname=$dbase";         // data source name
$options = [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
             PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ];

try {
    $db = new PDO($dsn, $user, $pass, $options);
    // print "Successfully connected to database\n";  // uncomment only to test; it prints on every page
}
catch(PDOException $e) {
    error_log($e->getMessage());
    printf("ERROR connecting to database: %s\n", $e->getMessage());
    exit();
}
