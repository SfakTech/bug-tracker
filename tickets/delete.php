<?php
require "../config.php";

$id = $_GET['id'] ?? 0;
$id = intval($id);

if ($id > 0) {
    $sql = "DELETE FROM tickets WHERE id = $id";
    $run = mysqli_query($conn, $sql);

    if ($run) {
        header("Location: lists.php?msg=deleted");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: lists.php");
    exit;
}
