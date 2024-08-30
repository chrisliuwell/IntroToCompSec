<?php
$connection = require __DIR__ . "/connectionDB.php";

// values come from user, through webform
$username = $_POST['inputUsername'];

$forename = $_POST['inputForename'];
$surname = $_POST['inputSurname'];

$email1 = $_POST['inputEmail1'];
$email2 = $_POST['inputEmail2'];

$PhoneNo = $_POST['inputNumber'];

$password1 = $_POST['inputPassword1'];
$password2 = $_POST['inputPassword2'];

$password_hash = password_hash($password1, PASSWORD_DEFAULT);

// Used for account activation
$activation_token = bin2hex(random_bytes(16));
$activation_token_hash = hash("sha256", $activation_token);

// Error Variable
$errorOccured = 0;

// Make Sure none of the boxes are blank 
if (empty($forename)) {
    $errorOccured = 1;
    die("Forename is required");
}
if (empty($surname)) {
    $errorOccured = 1;
    die("Surname is required");
}
if (empty($username)) {
    $errorOccured = 1;
    die("Username is required");
}
if ($PhoneNo == "") {
    $errorOccured = 1;
}
if (!filter_var($email1, FILTER_VALIDATE_EMAIL)) {
    $errorOccured = 1;
    die("Valid email is required");
}
if ($email1 != $email2) {
    $errorOccured = 1;
    die("Email must be matched");
}
if (!preg_match("/[0-9]/i", $PhoneNo)) {
    $errorOccured = 1;
    die("Valid phone number is required");
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

// Check if Username already exists in the database
$userResult = $connection->query("SELECT * FROM `System`");

//Loop Through from the first to the last record
while ($userRow = mysqli_fetch_array($userResult)) {
    // Check to see if the current username mathced the one from the user 
    if ($userRow['Username'] == $username) {
        die("The username has already been used !");
        $errorOccured = 1;
    }
}

// Check if Email already exists in the database
$userResult = $connection->query("SELECT * FROM `System`");

//Loop Through from the first to the last record
while ($userRow = mysqli_fetch_array($userResult)) {
    // Check to see if the current username mathced the one from the user 
    if ($userRow['Email'] == $email1) {
        die("The email has already been used !");
        $errorOccured = 1;
    }
}

$url = 'https://www.google.com/recaptcha/api/siteverify';
$secret = '6Lfavx4pAAAAAPa7vxtqp4LO4_d28djAKHYOMGjW';
$response = $_POST['token_generate'];
$remoteip = $_SERVER['REMOTE_ADDR'];

$request = file_get_contents($url . '?secret=' . $secret . '&response=' . $response);

$result = json_decode($request);

if ($errorOccured == 0) {
    // Add all of the contents of the variables to the SystemUser table
    if ($result->success == true){
        $sql = "INSERT INTO `System` (Username, Password, Forename, Surname, Email, PhoneNo, activationtoken)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $connection->stmt_init();

        if (!$stmt->prepare($sql)) {
            die("SQL error: " . $connection->error);
        }

        // SQL Injection Prevention
        $stmt->bind_param(
            "sssssss",
            $username,
            $password_hash,
            $forename,
            $surname,
            $email1,
            $PhoneNo,
            $activation_token_hash
        );
    

        if ($stmt->execute()) {
            
            $mail = require __DIR__ . "/mailer.php";
            
            $mail->setFrom("noreply@example.com");
            $mail->addAddress($email1);
            $mail->Subject = "Account Activation";
            // The content of a href must be change later on when hosting in public server
            $mail->Body = <<<END
            
            Click <a href="http://localhost/CompSecAssignment/accountactivated.php?token=$activation_token">here</a> to activate account.
            
            END;
            
            // Try and Catch Exception incase there is an error while sending email.
                try {
                    $mail->send();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
                    exit;
                }

                header("Location: ../CompSecAssignment/signup-success.html");
        }
    }
}
