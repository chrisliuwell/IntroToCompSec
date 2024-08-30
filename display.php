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
    <title>Assignment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

<body>
    <?php if ($user["usertype"] == "admin") : ?>

        <h1><br>Hello <?= htmlspecialchars($user["Username"]) ?></h1>

        <br>

        <table border=2 cellspacing=0>
            <tr>
                <td>ID</td>
                <td>Forename</td>
                <td>Surname</td>
                <td>Email</td>
                <td>PhoneNo</td>
                <td>Contact Method</td>
                <td>Order Detail</td>
                <td>Image</td>
            </tr>
            <tr>
            <?php

                $query = "SELECT * FROM `System`";

                $result = mysqli_query($connection,$query);

                while($row = mysqli_fetch_assoc($result)){
                    if ($row["usertype"] == "user" && $row["activationtoken"] == null){
                        
            ?>       
                        <td><?php echo $row['ID']?></td>
                        <td><?php echo $row['Forename']?></td>
                        <td><?php echo $row['Surname']?></td>
                        <td><?php echo $row['Email']?></td>
                        <td><?php echo $row['PhoneNo']?></td>
                        <td><?php echo $row['contactmethod']?></td>
                        <td><?php echo $row['orderdetail']?></td>
                        <td><img src="img/<?php echo $row['image']; ?>" width = 200 title="<?php echo $row['image'];?>"</td>
            </tr>
            <?php        
                    }
                } 
            ?>
        
        </table>

        <br>

        <p>Sign in as User ? <a href="../CompSecAssignment/login.php">Click Here</a></p>

        <a href="../CompSecAssignment/logout.php">Logout</a>

    <?php else : ?>

        <?php header("Location: ../CompSecAssignment/index.php");?>

    <?php endif; ?>
</body>

</html>