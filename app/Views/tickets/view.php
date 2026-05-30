<?php require __DIR__ . '/../partials/header.php'; ?>

<?php
function timeAgo(string $datetime): string {
    $diff = (new DateTime())->diff(new DateTime($datetime));
    if ($diff->days > 0) return $diff->days . 'd ago';
    if ($diff->h > 0)    return $diff->h . 'h ago';
    if ($diff->i > 0)    return $diff->i . 'm ago';
    return 'just now';
}

function timeDiff(string $from, string $to): string {
    $diff = (new DateTime($from))->diff(new DateTime($to));
    $parts = [];
    if ($diff->days) $parts[] = $diff->days . 'd';
    if ($diff->h)    $parts[] = $diff->h . 'h';
    if ($diff->i)    $parts[] = $diff->i . 'm';
    return implode(' ', $parts) ?: '<1m';
}
?>

<div class="page-header">
    <div style="display:flex;align-items:center;gap:12px">
        <a href="/tickets" style="color:#aaa;text-decoration:none;font-size:14px;">← Tickets</a>
        <h1 class="page-title" style="margin:0">#<?= $ticket['id'] ?> — <?= htmlspecialchars($ticket['title']) ?></h1>
        <span class="badge badge-<?= str_replace(' ', '-', $ticket['status']) ?>"><?= htmlspecialchars($ticket['status']) ?></span>
        <span class="priority-badge priority-<?= $ticket['priority'] ?>"><?= ucfirst($ticket['priority']) ?></span>
    </div>
    <?php if ($isAdmin || $isOwner): ?>
    <a href="/tickets/<?= $ticket['id'] ?>/edit" class="btn_small">Edit</a>
    <?php endif; ?>
</div>

<div class="ticket-layout">

    <!-- Left: Description + Comments -->
    <div class="ticket-main">

        <?php if (!empty($ticket['description'])): ?>
        <div class="card" style="padding:20px;margin-bottom:20px;">
            <p style="color:#555;line-height:1.7"><?= nl2br(htmlspecialchars($ticket['description'])) ?></p>
        </div>
        <?php endif; ?>

        <!-- Comments -->
        <div class="comments-section">
            <h3 style="font-size:15px;color:#555;margin-bottom:16px;font-weight:600;">
                Activity (<?= count($comments) ?>)
            </h3>

            <?php if (empty($comments)): ?>
                <p style="color:#bbb;font-size:14px">No replies yet.</p>
            <?php endif; ?>

            <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <div class="comment-avatar"><?= strtoupper(substr($comment['user_name'], 0, 1)) ?></div>
                <div class="comment-body">
                    <div class="comment-meta">
                        <strong><?= htmlspecialchars($comment['user_name']) ?></strong>
                        <span class="comment-role"><?= $comment['user_role'] ?></span>
                        <span class="comment-time"><?= timeAgo($comment['created_at']) ?></span>
                    </div>
                    <p><?= nl2br(htmlspecialchars($comment['body'])) ?></p>
                </div>
            </div>
            <?php endforeach; ?>

            <!-- Add reply -->
            <form method="POST" action="/tickets/<?= $ticket['id'] ?>/comments" class="reply-form">
                <?= CSRF::field() ?>
                <textarea name="body" placeholder="Write a reply..." required></textarea>
                <button type="submit">Add Reply</button>
            </form>
        </div>
    </div>

    <!-- Right: Info panel -->
    <div class="ticket-info-panel">
        <div class="card" style="padding:0;overflow:hidden">
            <div style="padding:16px 20px;border-bottom:1px solid #f0f0f0">
                <h4 style="font-size:14px;font-weight:600;color:#333">Ticket Information</h4>
            </div>

            <!-- Status -->
            <div class="info-field">
                <label>Status</label>
                <form method="POST" action="/tickets/<?= $ticket['id'] ?>/status">
                    <?= CSRF::field() ?>
                    <select name="status" onchange="this.form.submit()" class="info-select">
                        <option value="open"        <?= $ticket['status'] === 'open'        ? 'selected' : '' ?>>Open</option>
                        <option value="in progress" <?= $ticket['status'] === 'in progress' ? 'selected' : '' ?>>In Progress</option>
                        <option value="closed"      <?= $ticket['status'] === 'closed'      ? 'selected' : '' ?>>Closed</option>
                    </select>
                </form>
            </div>

            <!-- Priority -->
            <div class="info-field">
                <label>Priority</label>
                <span class="priority-badge priority-<?= $ticket['priority'] ?>"><?= ucfirst($ticket['priority']) ?></span>
            </div>

            <!-- Assigned to -->
            <div class="info-field">
                <label>Assigned To</label>
                <?php if ($ticket['assigned_to']): ?>
                    <div style="display:flex;align-items:center;gap:8px">
                        <div class="user-avatar" style="width:26px;height:26px;font-size:11px">
                            <?= strtoupper(substr($ticket['assigned_user_name'], 0, 1)) ?>
                        </div>
                        <span style="font-size:13px"><?= htmlspecialchars($ticket['assigned_user_name']) ?></span>
                    </div>
                    <?php if ($ticket['assigned_at']): ?>
                    <small style="color:#aaa;font-size:11px;display:block;margin-top:4px">
                        Since <?= date('d M Y, H:i', strtotime($ticket['assigned_at'])) ?>
                    </small>
                    <?php endif; ?>
                <?php else: ?>
                    <span style="color:#bbb;font-size:13px">Unassigned</span>
                <?php endif; ?>

                <!-- Assign actions -->
                <?php if ($isAdmin && !empty($users)): ?>
                <form method="POST" action="/tickets/<?= $ticket['id'] ?>/assign" style="margin-top:8px">
                    <?= CSRF::field() ?>
                    <select name="user_id" class="info-select">
                        <option value="">— Assign to —</option>
                        <?php foreach ($users as $u): ?>
                        <option value="<?= $u['id'] ?>" <?= (int)$ticket['assigned_to'] === (int)$u['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($u['name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn_small" style="margin-top:6px;width:100%">Assign</button>
                </form>
                <?php elseif ((int)$ticket['assigned_to'] !== (int)$_SESSION['user']['id']): ?>
                <form method="POST" action="/tickets/<?= $ticket['id'] ?>/assign" style="margin-top:8px">
                    <?= CSRF::field() ?>
                    <input type="hidden" name="user_id" value="<?= $_SESSION['user']['id'] ?>">
                    <button type="submit" class="btn_small" style="width:100%">Assign to me</button>
                </form>
                <?php endif; ?>
            </div>

            <!-- Productivity metrics -->
            <?php if ($ticket['assigned_at']): ?>
            <div class="info-field">
                <label>Time to Assignment</label>
                <span style="font-size:13px;font-weight:600;color:#ff891c">
                    <?= timeDiff($ticket['created_at'], $ticket['assigned_at']) ?>
                </span>
                <small style="color:#aaa;font-size:11px;display:block">from creation to assignment</small>
            </div>
            <?php endif; ?>

            <!-- Created by -->
            <div class="info-field">
                <label>Created By</label>
                <span style="font-size:13px"><?= htmlspecialchars($ticket['user_name']) ?></span>
            </div>

            <!-- Created at -->
            <div class="info-field" style="border:none">
                <label>Created At</label>
                <span style="font-size:13px"><?= date('d M Y, H:i', strtotime($ticket['created_at'])) ?></span>
            </div>
        </div>
    </div>

</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
