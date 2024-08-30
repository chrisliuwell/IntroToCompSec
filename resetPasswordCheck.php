<?php
    // STEP 3 - TOKEN WILL BE VERIFIED ONCE AGAIN, AND AFTER THAT NEW PASSWORD WILL BE UPDATED, ALSO TOKEN AND TIME EXPIRATION WILL SET BACK TO NULL
    $token = $_POST["token"];

    $token_hash = hash("sha256", $token);

    $connection = require __DIR__ . "/connectionDB.php";

    $sql = "SELECT * FROM `System`
                WHERE tokenhash = ?";

    $stmt = $connection->prepare($sql);

    $stmt->bind_param("s", $token_hash);

    $stmt->execute();

    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    if ($user === null) {
        die("token not found");
    }

    if (strtotime($user["tokenexpiration"]) <= time()) {
        die("token has expired");
    }

    // Changing Password In the Database

    $password1 = $_POST['inputPassword1'];
    $password2 = $_POST['inputPassword2'];

    $password_hash = password_hash($password1, PASSWORD_DEFAULT);

    $errorOccured = 0;

    if ($user === null) {
        die("token not found");
    }

    if (strtotime($user["tokenexpiration"]) <= time()) {
        die("token has expired");
    }

    if (strlen($password1) < 8) {
        $errorOccured = 1;
        die("Password must be at least 8 characters");
    }
    if (!preg_match("/[a-z]/i", $password1)) {
        $errorOccured = 1;
        die("Password must contain at least one letter");
    }
    if (!preg_match("/[0-9]/i", $password1)) {
        $errorOccured = 1;
        die("Password must contain at least one number");
    }
    if ($password1 != $password2) {
        $errorOccured = 1;
        die("Password must be matched");
    }

    if ($errorOccured == 0){
        $sql = "UPDATE `System`
                SET Password = ?,
                    tokenhash = NULL,
                    tokenexpiration = NULL
                WHERE ID = ?";
    }

    $stmt = $connection->prepare($sql);

    $stmt->bind_param("ss", $password_hash, $user["ID"]);

    $stmt->execute();

    echo "Password Updated. You can now login.";
?>
    
