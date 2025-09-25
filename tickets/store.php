<?php
session_start();
require_once '../config.php';

// Έλεγχος αν ο χρήστης είναι συνδεδεμένος
if (!isset($_SESSION['email'])) {
    header("Location: index.php"); // Ανακατεύθυνση αν δεν είναι συνδεδεμένος
    exit();
}

// Έλεγχος αν η φόρμα έχει υποβληθεί
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    // Λήψη του user_id από τη βάση δεδομένων με βάση το email της session
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $_SESSION['email']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $user_id = $user['id'];

    // Λήψη και καθαρισμός δεδομένων
    $title = $_POST['title'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    // Εισαγωγή του ticket στη βάση δεδομένων με prepared statement
    $sql = "INSERT INTO tickets (user_id, title, description, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $user_id, $title, $description, $status);

    if ($stmt->execute()) {
        header("Location: lists.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
