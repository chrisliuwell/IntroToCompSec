<?php
// STEP 2 - TOKEN ATTACHED IN THE EMAIL WILL BE VERIFIED WITH THE ONES WRITTEN IN THE DATABASE IF ITS VALID THIS PROCEED
    $token = $_GET["token"];

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
    <h1>Reset Password</h1>

    <form method="post" action="resetPasswordCheck.php" id="resetpassword" >

        <!-- This is used to hide the token value -->
        <input type="hidden" name="token" id="token" value="<?= htmlspecialchars($token) ?>">

        <div>
            <input type="password" name="inputPassword1" id="inputPassword1" placeholder="Enter New Password">

            <input type="password" name="inputPassword2" id="inputPassword2" placeholder="Repeat New Password">
        </div>

        <button>Send</button>

    </form>

</body>

</html>