<?php
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $secret = '6Lfavx4pAAAAAPa7vxtqp4LO4_d28djAKHYOMGjW';
    $response = $_POST['token_generate'];
    $remoteip = $_SERVER['REMOTE_ADDR'];

    $request = file_get_contents($url . '?secret=' . $secret . '&response=' . $response);

    $result = json_decode($request);
    // STEP 1 - RANDOM BYTES WILL BE GENERATED INTO TOKEN (WITH EXPIRATION TIME) AND UPDATED INTO THE DATABASE
    $email = $_POST["inputEmail"];
    // convert generated random token byte into hexadecimal
    $token = bin2hex(random_bytes(16));
    // Extra Security to store the token in hash instead of plain text; 
    $token_hash = hash("sha256", $token);
    // Time Expiry feature to prevent brute force attack to guess the valid value (last only 30 mins)
    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    $connection = require __DIR__ . "/connectionDB.php";

    $sql = "UPDATE `System`
            SET tokenhash = ?,
                tokenexpiration = ?
            WHERE Email = ?";
    
    $stmt = $connection ->prepare($sql);
    // Bind Param 
    $stmt->bind_param("sss", $token_hash, $expiry, $email);

    $stmt->execute();

// STEP 1A - IF THE EMAIL IS VALID THIS WILL PROCEED AND EMAIL WILL BE SEND WITH TOKEN VALUE ATTACHED
    if ($result->success == true) {
        if ($connection->affected_rows){
            $mail = require __DIR__ . "/mailer.php";

            $mail->setFrom("noreply@example.com");
            $mail->addAddress($email);
            $mail->Subject = "Password Reset";
            // The content of a href must be change later on
            $mail->Body = <<<END

            Click <a href="http://localhost/CompSecAssignment/resetPassword.php?token=$token">here</a> to reset your password.

            END;

            // Try and Catch Exception incase there is an error while sending email.
            try{
                $mail->send();
            } catch (Exception $e){
                echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
            }
        }

        // This will be sent eventho an email does not exist in the system to enhance security feature 
        echo "Message sent, please check your inbox.";
    }
?>