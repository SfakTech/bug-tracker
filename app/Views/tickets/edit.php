<?php require __DIR__ . '/../partials/header.php'; ?>

<h1>Edit Ticket</h1>
<br>

<form method="POST" action="/tickets/<?= $ticket['id'] ?>/update">
    <input type="text" name="title" value="<?= htmlspecialchars($ticket['title']) ?>" required>
    <textarea name="description" style="width:100%;padding:12px;background:#eee;border-radius:6px;border:none;outline:none;font-size:16px;margin-bottom:20px;resize:vertical;min-height:100px;font-family:inherit"><?= htmlspecialchars($ticket['description']) ?></textarea>
    <select name="status">
        <option value="open" <?= $ticket['status'] === 'open' ? 'selected' : '' ?>>Open</option>
        <option value="in progress" <?= $ticket['status'] === 'in progress' ? 'selected' : '' ?>>In Progress</option>
        <option value="closed" <?= $ticket['status'] === 'closed' ? 'selected' : '' ?>>Closed</option>
    </select>
    <br><br>
    <button type="submit">Update Ticket</button>
</form>

<br>
<a href="/tickets" class="btn_small">Back</a>

<?php require __DIR__ . '/../partials/footer.php'; ?>
