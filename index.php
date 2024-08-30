<!-- If the user is not logged in, it will redirect to the login page -->
<?php
session_start();

if (isset($_SESSION["user_id"])) {

    $connection = require __DIR__ . "/connectionDB.php";

    // Fetch the information of the user based on their ID
    $sql = "SELECT * FROM `System` WHERE ID = {$_SESSION["user_id"]}";

    $result = $connection->query($sql);

    $user = $result->fetch_assoc();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <script src="https://www.google.com/recaptcha/api.js?render=6Lfavx4pAAAAAEYRRuRcbg6Mdusz2DbtiJ6TEgrs"></script>
    <link rel="stylesheet" href="../CompSecAssignment/style.css">
</head>

<body>
    <div>
        <form action="requestCheck.php" method="post">
            <?php if (isset($user)) : ?>
                <h1><br>Hello <?= htmlspecialchars($user["Username"]) ?></h1>

                <div>
                    <h2>Order Details</h2>
                    <i>Please Type In Order and Request Details Below</i>
                    <textarea name="detail" id="detail" cols="35" rows="25" placeholder="..." required></textarea>
                </div>

                <div>
                    <h2>Contact Method</h2>
                    <i>Please Select Your Prefferred Contact method <br><br></i>
                    <select id="contactMethod" name="contactMethod" required>
                        <option value="1">Text</option>
                        <option value="2">Email</option>
                    </select>
                </div>

                <div class="fileupload">
                    <h2>Upload File</h2>
                    <i>If you wish to upload a photo of the order <a href="../CompSecAssignment/fileUpload.php">Click Here</a> <br><br></i>
                </div>

                <br>

                <input type="hidden" name="token_generate" id="token_generate">

                <button type="submit">Submit</button>

                <a href="../CompSecAssignment/logout.php">Logout</a>

            <?php else : ?>

                <h1>Hello</h1>
                <p><a href="login.php"> Log in</a> or <a href=registration.php>sign up</a>

                <?php endif; ?>

        </form>
    </div>
</body>

</html>
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute('6Lfavx4pAAAAAEYRRuRcbg6Mdusz2DbtiJ6TEgrs', {
            action: 'submit'
        }).then(function(token) {

            var response = document.getElementById('token_generate');
            response.value = token;

        })
    })
</script>