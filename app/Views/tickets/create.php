<?php require __DIR__ . '/../partials/header.php'; ?>

<h1>New Ticket</h1>
<br>

<form method="POST" action="/tickets">
    <input type="text" name="title" placeholder="Title" required>
    <textarea name="description" placeholder="Description" style="width:100%;padding:12px;background:#eee;border-radius:6px;border:none;outline:none;font-size:16px;margin-bottom:20px;resize:vertical;min-height:100px;font-family:inherit"></textarea>
    <select name="status">
        <option value="open">Open</option>
        <option value="in progress">In Progress</option>
        <option value="closed">Closed</option>
    </select>
    <br><br>
    <button type="submit">Save Ticket</button>
</form>

<a href="/tickets" class="btn_small">Back</a>

<?php require __DIR__ . '/../partials/footer.php'; ?>
