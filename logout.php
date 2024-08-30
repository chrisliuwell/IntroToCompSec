<?php
    session_start();
    // This will stop the session and will be redirected to login page
    session_destroy();
    header("Location:../CompSecAssignment/login.php");
?>