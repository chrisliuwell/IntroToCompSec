<?php

$invalid = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $connection = require __DIR__ . "/connectionDB.php";

  // Used to prevent SQL injetion (real_escape_string)
  $sql = sprintf("SELECT * FROM `System` WHERE username = '%s'", $connection->real_escape_string($_POST['inputUsername']));

  $result = $connection->query($sql);

  $user = $result->fetch_assoc();

  $url = 'https://www.google.com/recaptcha/api/siteverify';
  $secret = '6Lfavx4pAAAAAPa7vxtqp4LO4_d28djAKHYOMGjW';
  $response = $_POST['token_generate'];
  $remoteip = $_SERVER['REMOTE_ADDR'];

  $request = file_get_contents($url . '?secret=' . $secret . '&response=' . $response);

  $result = json_decode($request);

  if ($user && $user["activationtoken"] === null) {

    if ($result->success == true) {
      if (password_verify($_POST["inputPassword"], $user["Password"])) {
        if ($user["usertype"] == "user") {
          session_start();

          // unique ID in the database will be stored globally as session user_id
          $_SESSION["user_id"] = $user["ID"];

          header("Location: ../CompSecAssignment/index.php");
          exit;
        }

        if ($user["usertype"] == "admin") {
          session_start();

          // unique ID in the database will be stored globally as session user_id
          $_SESSION["user_id"] = $user["ID"];

          header("Location: ../CompSecAssignment/display.php");
          exit;
        }
      }
    }
  }
  $invalid = true;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Assignment</title>
  <script src="../CompSecAssignment/js/script.js"></script>
  <script src="https://www.google.com/recaptcha/api.js?render=6Lfavx4pAAAAAEYRRuRcbg6Mdusz2DbtiJ6TEgrs"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <form method="post">
    <h1>Login</h1>

    <!-- Keep little information to the attacker instead of showing username or password is wrong -->
    <?php if ($invalid) : ?>
      <em>Invalid Login</em>
    <?php endif; ?>

    <div>
      <input type="text" name="inputUsername" id="inputUsername" placeholder="Username">
    </div>

    <div>
      <input type="password" name="inputPassword" id="inputPassword" placeholder="Password">
    </div>

    <input type="hidden" name="token_generate" id="token_generate">

    <button type="submit">Login</button>

  </form>
  
  <p>Don't have an account <a href="registration.php">Register Now</a></p>

  <a href="passwordReset.php">Forgot Password</a>

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