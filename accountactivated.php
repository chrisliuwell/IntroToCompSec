<?php
// TOKEN ATTACHED IN THE EMAIL WILL BE VERIFIED WITH THE ONES WRITTEN IN THE DATABASE IF ITS VALID THIS PROCEED
    $token = $_GET["token"];

    $token_hash = hash("sha256", $token);

    $connection = require __DIR__ . "/connectionDB.php";

    $sql = "SELECT * FROM `System`
                        WHERE activationtoken = ?";

    $stmt = $connection->prepare($sql);

    $stmt->bind_param("s", $token_hash);

    $stmt->execute();

    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    if ($user === null) {
        die("token not found");
    }

    $sql = "UPDATE `System`
            SET activationtoken = NULL
            WHERE ID = ?";

    $stmt = $connection->prepare($sql);

    $stmt->bind_param("s", $user["ID"]);

    $stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

<body>
    <h1>Account Activated</h1>

    <p>Account activated successfull. You can now <a href="../CompSecAssignment/login.php">Log in</a></p>

</body>

</html>