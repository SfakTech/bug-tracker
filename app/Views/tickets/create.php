<?php require __DIR__ . '/../partials/header.php'; ?>

<div class="page-header">
    <h1 class="page-title">New Ticket</h1>
</div>

<div class="card" style="max-width:700px;padding:28px">
    <form method="POST" action="/tickets">
        <?= CSRF::field() ?>
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="description" placeholder="Description" style="width:100%;padding:12px;background:#eee;border-radius:6px;border:none;outline:none;font-size:15px;margin-bottom:20px;resize:vertical;min-height:120px;font-family:inherit"></textarea>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px">
            <div>
                <label style="font-size:13px;color:#666;display:block;margin-bottom:6px">Status</label>
                <select name="status" style="width:100%;padding:12px;background:#eee;border-radius:6px;border:none;font-size:15px;outline:none">
                    <option value="open">Open</option>
                    <option value="in progress">In Progress</option>
                    <option value="closed">Closed</option>
                </select>
            </div>
            <div>
                <label style="font-size:13px;color:#666;display:block;margin-bottom:6px">Priority</label>
                <select name="priority" style="width:100%;padding:12px;background:#eee;border-radius:6px;border:none;font-size:15px;outline:none">
                    <option value="low">Low</option>
                    <option value="medium" selected>Medium</option>
                    <option value="high">High</option>
                    <option value="critical">Critical</option>
                </select>
            </div>
        </div>

        <button type="submit" style="width:auto;padding:12px 32px">Save Ticket</button>
    </form>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
