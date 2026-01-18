<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}
?>

<?php

$backPage = "../user_page.php";
if (isset($_SESSION['role']) and $_SESSION['role'] === "admin") {
    $backPage = "../admin_page.php";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Ticket</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body style="background: #fff;">


    <div class="create_tickets">

        <h1>Create New Ticket</h1>

        <form action="store.php" method="POST">
            <label>Title:</label><br>
            <input type="text" name="title" required><br><br>

            <label>Description:</label><br>
            <input name="description" required><br><br>

            <label>Status:</label><br>
            <select name="status">
                <option value="open">Open</option>
                <option value="in progress">In Progress</option>
                <option value="closed">Closed</option>
            </select><br><br>

            <button type="submit" name="save">Save Ticket</button>
            <a href="<?php echo $backPage; ?>" class="btn_home_page">Back</a>
        </form>
    </div>
</body>

</html>