<?php require __DIR__ . '/../partials/header.php'; ?>

<h1>Dashboard</h1>
<p>Welcome, <strong><?= htmlspecialchars($_SESSION['user']['email']) ?></strong></p>
<br>
<a href="/tickets" class="btn_small">My Tickets</a>

<?php require __DIR__ . '/../partials/footer.php'; ?>
