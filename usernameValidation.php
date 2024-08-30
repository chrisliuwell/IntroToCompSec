<?php
$connection = require __DIR__ . "/connectionDB.php";

$sql = sprintf("SELECT * FROM `System` WHERE username = '%s'", $connection->real_escape_string($_GET["inputUsername"]));

$result = $connection->query($sql);

$is_available = $result->num_rows === 0;

header("Content-Type: application/json");

echo json_encode(["available" => $is_available]);
