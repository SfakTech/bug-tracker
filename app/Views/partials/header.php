<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bug Tracker</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="dashboard">
<div class="layout">

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-icon">
                <i data-lucide="bug"></i>
            </div>
            <span class="logo-text">Bug Tracker</span>
        </div>

        <?php
            $navPath = $_SERVER['REQUEST_URI'];
            $onTickets = str_contains($navPath, '/tickets');
            $onAdmin   = str_contains($navPath, '/admin');
            $onHome    = !$onTickets && !$onAdmin;

            require_once __DIR__ . '/../../Models/Ticket.php';
            $_isAdminNav = $_SESSION['user']['role'] === 'admin';
            $_openCount  = Ticket::countByStatus('open', $_isAdminNav ? null : (int)$_SESSION['user']['id']);
        ?>

        <nav class="sidebar-nav">
            <a href="/" class="nav-item <?= $onHome ? 'active' : '' ?>">
                <i data-lucide="layout-dashboard"></i>
                <span>Dashboard</span>
            </a>
            <a href="/tickets" class="nav-item <?= $onTickets ? 'active' : '' ?>">
                <i data-lucide="ticket"></i>
                <span>Tickets</span>
                <?php if ($_openCount > 0): ?>
                <span class="nav-badge"><?= $_openCount ?></span>
                <?php endif; ?>
            </a>
            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
            <a href="/admin/users" class="nav-item <?= $onAdmin ? 'active' : '' ?>">
                <i data-lucide="users"></i>
                <span>Users</span>
            </a>
            <?php endif; ?>
        </nav>

        <div class="sidebar-footer">
            <div class="user-avatar">
                <?= strtoupper(substr($_SESSION['user']['email'], 0, 1)) ?>
            </div>
            <div class="user-details">
                <span class="user-email"><?= htmlspecialchars($_SESSION['user']['email']) ?></span>
                <span class="user-role"><?= htmlspecialchars($_SESSION['user']['role']) ?></span>
            </div>
            <form method="POST" action="/logout" style="margin:0">
                <?= CSRF::field() ?>
                <button type="submit" class="logout-btn" title="Logout">
                    <i data-lucide="log-out"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main -->
    <div class="main">
        <?php require __DIR__ . '/flash.php'; ?>
