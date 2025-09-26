<?php
session_start();
require_once '../config.php';


if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
 
    $email = $_SESSION['email'];
    $stmt = $conn->prepare("SELECT id, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user) {
        die("User not found for email: " . $email);
    }

    $user_id = $user['id'];
    $role = $user['role'];

  
    $title = $_POST['title'];
    $description = $_POST['description'];
    $status = $_POST['status'];

 
    $stmt = $conn->prepare("INSERT INTO tickets (user_id, title, description, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $title, $description, $status);

    if ($stmt->execute()) {
      
        if ($role === 'admin') {
            header("Location: ../admin_page.php");
        } else {
            header("Location: ../user_page.php");
        }
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

