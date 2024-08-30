<?php
    // Server and DB Connection
    $servername = "localhost";
    $rootUser = "root";
    $db = "Lovejoy";
    $rootPassword = "toor";

    // Create Connection 
    $connection = new mysqli($servername, $rootUser, $rootPassword, $db) or die("Could not connect to the server");

    return $connection;
?>