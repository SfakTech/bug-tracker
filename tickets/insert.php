<?php
session_start();
require '../config.php';

if (isset($_POST['save'])) {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $status = strtolower($_POST['status']);
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO tickets (user_id, title, description, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $title, $description, $status);
    $stmt->execute();

    header('Location:view.php?insert_msg=Your data has been added successfully');
    exit;
}
