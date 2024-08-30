<?php
    $connection = require __DIR__ . "/connectionDB.php";

    session_start();

    $id = $_SESSION["user_id"];

    print_r($id);

    $order_detail = $_POST['detail'];
    // Contact Method will be input with integer value instead of string to enhance security
    $contactM = filter_input(INPUT_POST, "contactMethod", FILTER_VALIDATE_INT);

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $secret = '6Lfavx4pAAAAAPa7vxtqp4LO4_d28djAKHYOMGjW';
    $response = $_POST['token_generate'];
    $remoteip = $_SERVER['REMOTE_ADDR'];

    $request = file_get_contents($url . '?secret=' . $secret . '&response=' . $response);

    $result = json_decode($request);

    if ($result->success == true) {

        $sql = "UPDATE `System` SET orderdetail = ?, contactmethod = ? WHERE ID = ?";

        $stmt = $connection->stmt_init();

        if (!$stmt->prepare($sql)){
            die("SQL error: " . $connection->error);
        }
        
        $stmt->bind_param("sis", $order_detail, $contactM ,$id);

    }

    if(mysqli_stmt_execute($stmt)){
        header("Location: ../CompSecAssignment/uploadsuccess.html");
    };

 
?>