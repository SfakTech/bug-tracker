<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>New Ticket</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div class="create_tickets">
        <h1>Create New Ticket</h1>
        <form action="../admin_page.php" method="POST">
            <label>Title:</label><br>
            <input type="text" name="title" required><br><br>

            <label>Description:</label><br>
            <textarea name="description"></textarea><br><br>

            <label>Status:</label><br>
            <select name="status">
                <option value="open">Open</option>
                <option value="in progress">In Progress</option>
                <option value="closed">Closed</option>
            </select><br><br>

            <button type="submit" name="save">Save Ticket</button>

        </form>
    </div>
</body>

</html>