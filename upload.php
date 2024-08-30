<?php
$connection = require __DIR__ . "/connectionDB.php";

session_start();

$id = $_SESSION["user_id"];

if(isset($_POST["submit"])){
    $name = $_POST["name"];
    if ($_FILES["image"]["error"] === 4) {
            echo "Image Does Not Exist";
        } else {
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $secret = '6Lfavx4pAAAAAPa7vxtqp4LO4_d28djAKHYOMGjW';
            $response = $_POST['token_generate'];
            $remoteip = $_SERVER['REMOTE_ADDR'];

            $request = file_get_contents($url . '?secret=' . $secret . '&response=' . $response);

            $result = json_decode($request);


            $fileName = $_FILES["image"]["name"];
            $tmpName = $_FILES["image"]["tmp_name"];
            $fileSize = $_FILES["image"]["size"];

            $validImageExtension = ['jpg', 'jpeg', 'png'];
            $imageExtension = explode('.', $fileName);
            $imageExtension = strtolower(end($imageExtension));

            if ($result->success == true) {

                if (!in_array($imageExtension, $validImageExtension)) {
                    echo "Invalid Image Extension";
                } else if ($fileSize > 1000000) {
                    echo "Image too large";
                } else {
                    $newImageName = uniqid() . '.' . $imageExtension;

                    move_uploaded_file($tmpName ,'img/' . $newImageName);
                    $sql = "UPDATE `System` SET name = ?, image = ? WHERE ID = ?";

                    $stmt = $connection->stmt_init();

                    if (!$stmt->prepare($sql)) {
                        die("SQL error: " . $connection->error);
                    }

                    $stmt->bind_param("sss", $name, $newImageName, $id);

                    if(mysqli_stmt_execute($stmt)){
                        header("Location: ../CompSecAssignment/uploadsuccess.html");
                    };                 
                    
                }
            }
        }
}

// if($_SERVER["REQUEST_METHOD"] !== "POST"){
//     exit("POST request method required");
// }

