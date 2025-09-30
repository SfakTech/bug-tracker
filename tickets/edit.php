<?php
require "../config.php";

$backPage = "lists.php";

$id = $_GET['id'] ?? 0;
$id = intval($id);

$sql = "SELECT * FROM tickets WHERE id = $id";
$run = mysqli_query($conn, $sql);

if ($stm = mysqli_fetch_assoc($run)) {
    $id = $stm['id'];
    $title = $stm['title'];
    $status = $stm['status'];
} else {
    header("Location: lists.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <form action="lists.php" method="POST">
        <div class="container w-50">
            <h1>Edit Form</h1>

            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input class="form-control mb-3 border-secondary" type="text" name="id" value="<?php echo $id; ?>" readonly="ID">
            <input class="form-control mb-3 border-secondary" type="text" name="title" value="<?php echo $title; ?>" placeholder="Title">
            <label>Status:</label><br>
            <select name="status">
                <option value="open">Open</option>
                <option value="in progress">In Progress</option>
                <option value="closed">Closed</option>
            </select><br><br>   

            <button class="btn btn-success" style="background-color:#ff891c; border-color:#ff891c;" name="edit">Confirm</button>
            <a href="<?php echo $backPage; ?>" class="btn btn-success" style="background-color:#ff891c; border-color:#ff891c;" >Back</a>
        </div>
    </form>
</body>

</html>