<?php

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="style.css">
</head>

<body style="background: #fff;">

    <div class="header">
        <div class="welcome">Welcome, <span><?= $_SESSION['name']; ?></span></div>
        <div class="admin-text">This is an <span>admin</span> page</div>
        <button onclick="window.location.href='logout.php'">Logout</button>
    </div>

    <div class="container">
        <?php require 'tickets/tickets.php' ?>
    </div>



</body>

</html>