<?php

$backPage = "../user_page.php";
if (isset($_SESSION['role']) and $_SESSION['role'] === "admin") {
    $backPage = "../admin_page.php";
}

?>

<?php
require "../config.php";

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $status = $_POST['status'];

    $sql = "UPDATE tickets SET  title = '$title', status = '$status' WHERE id = $id";
    $run = mysqli_query($conn, $sql);

    if ($run) {
        header('Location: edit.php');
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$sql = "SELECT * FROM tickets";
$run = mysqli_query($conn, $sql);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Ticket List</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($run)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td><?php echo $row['modified_at']; ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm text-white" style="background-color:#ff891c; border-color:#ff891c;">Edit</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm text-white" style="background-color:#ff891c; border-color:#ff891c;" onclick="return confirm('Are you sure you want to delete this ticket?');"> Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="<?php echo $backPage; ?>" class="btn btn-success" style="background-color:#ff891c; border-color:#ff891c;">Back</a>
    </div>

</body>

</html>