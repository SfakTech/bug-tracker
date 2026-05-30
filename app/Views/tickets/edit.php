<?php require __DIR__ . '/../partials/header.php'; ?>

<div class="page-header">
    <h1 class="page-title">Edit Ticket #<?= $ticket['id'] ?></h1>
    <a href="/tickets/<?= $ticket['id'] ?>" style="font-size:13px;color:#aaa;text-decoration:none">← View ticket</a>
</div>

<div class="ticket-layout">

    <!-- Left: Form -->
    <div class="ticket-main">
        <div class="card" style="padding:28px">
            <form method="POST" action="/tickets/<?= $ticket['id'] ?>/update">
                <?= CSRF::field() ?>
                <input type="text" name="title" value="<?= htmlspecialchars($ticket['title']) ?>" required>
                <textarea name="description" style="width:100%;padding:12px;background:#eee;border-radius:6px;border:none;outline:none;font-size:15px;margin-bottom:20px;resize:vertical;min-height:150px;font-family:inherit"><?= htmlspecialchars($ticket['description']) ?></textarea>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px">
                    <div>
                        <label style="font-size:13px;color:#666;display:block;margin-bottom:6px">Status</label>
                        <select name="status" style="width:100%;padding:12px;background:#eee;border-radius:6px;border:none;font-size:15px;outline:none;font-family:inherit">
                            <option value="open"        <?= $ticket['status'] === 'open'        ? 'selected' : '' ?>>Open</option>
                            <option value="in progress" <?= $ticket['status'] === 'in progress' ? 'selected' : '' ?>>In Progress</option>
                            <option value="closed"      <?= $ticket['status'] === 'closed'      ? 'selected' : '' ?>>Closed</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:13px;color:#666;display:block;margin-bottom:6px">Priority</label>
                        <select name="priority" style="width:100%;padding:12px;background:#eee;border-radius:6px;border:none;font-size:15px;outline:none;font-family:inherit">
                            <option value="low"      <?= $ticket['priority'] === 'low'      ? 'selected' : '' ?>>Low</option>
                            <option value="medium"   <?= $ticket['priority'] === 'medium'   ? 'selected' : '' ?>>Medium</option>
                            <option value="high"     <?= $ticket['priority'] === 'high'     ? 'selected' : '' ?>>High</option>
                            <option value="critical" <?= $ticket['priority'] === 'critical' ? 'selected' : '' ?>>Critical</option>
                        </select>
                    </div>
                </div>

                <div style="display:flex;gap:10px;align-items:center">
                    <button type="submit" style="width:auto;padding:12px 32px">Update Ticket</button>
                    <a href="/tickets/<?= $ticket['id'] ?>" style="font-size:14px;color:#aaa;text-decoration:none">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Right: Info panel -->
    <div class="ticket-info-panel">
        <div class="card" style="padding:0;overflow:hidden">
            <div style="padding:16px 20px;border-bottom:1px solid #f0f0f0">
                <h4 style="font-size:14px;font-weight:600;color:#333">Ticket Info</h4>
            </div>

            <div class="info-field">
                <label>Current Status</label>
                <span class="badge badge-<?= str_replace(' ', '-', $ticket['status']) ?>"><?= htmlspecialchars($ticket['status']) ?></span>
            </div>

            <div class="info-field">
                <label>Current Priority</label>
                <span class="priority-badge priority-<?= $ticket['priority'] ?>"><?= ucfirst($ticket['priority']) ?></span>
            </div>

            <div class="info-field">
                <label>Created By</label>
                <span style="font-size:13px"><?= htmlspecialchars($ticket['user_name']) ?></span>
            </div>

            <div class="info-field" style="border:none">
                <label>Created At</label>
                <span style="font-size:13px"><?= date('d M Y, H:i', strtotime($ticket['created_at'])) ?></span>
            </div>
        </div>
    </div>

</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
