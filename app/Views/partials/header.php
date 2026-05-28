<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bug Tracker</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<div class="header">
    <span class="welcome">Welcome, <?= htmlspecialchars($_SESSION['user']['email']) ?></span>
    <span class="admin-text"><span>Bug</span> Tracker</span>
    <form method="POST" action="/logout" style="margin:0">
        <button type="submit">Logout</button>
    </form>
</div>
<div style="margin-top: 80px; padding: 20px;">
