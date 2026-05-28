<?php require __DIR__ . '/../partials/header.php'; ?>

<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <a href="/tickets/create" class="btn_small">+ New Ticket</a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">My Open Tickets</div>
        <div class="stat-value" style="color:#e65100"><?= $stats['open'] ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">In Progress</div>
        <div class="stat-value" style="color:#1565c0"><?= $stats['in progress'] ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Closed</div>
        <div class="stat-value" style="color:#555"><?= $stats['closed'] ?></div>
    </div>
</div>

<div class="card" style="overflow:hidden">
    <div style="padding:16px 20px;border-bottom:1px solid #f0f0f0;display:flex;justify-content:space-between;align-items:center">
        <h3 style="font-size:15px;font-weight:600;color:#333">My Recent Tickets</h3>
        <a href="/tickets" style="font-size:13px;color:#ff891c;text-decoration:none">View all →</a>
    </div>
    <?php if (empty($recentTickets)): ?>
        <p style="padding:20px;color:#bbb;font-size:14px">No tickets yet. <a href="/tickets/create" style="color:#ff891c">Create one →</a></p>
    <?php else: ?>
    <div class="table_section">
        <table>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Date</th>
            </tr>
            <?php foreach ($recentTickets as $ticket): ?>
            <tr>
                <td style="color:#aaa;font-size:13px"><?= $ticket['id'] ?></td>
                <td><a href="/tickets/<?= $ticket['id'] ?>" style="color:#333;text-decoration:none;font-weight:500"><?= htmlspecialchars($ticket['title']) ?></a></td>
                <td><span class="badge badge-<?= str_replace(' ', '-', $ticket['status']) ?>"><?= $ticket['status'] ?></span></td>
                <td><span class="priority-badge priority-<?= $ticket['priority'] ?>"><?= ucfirst($ticket['priority']) ?></span></td>
                <td style="font-size:13px;color:#aaa"><?= date('d M Y', strtotime($ticket['created_at'])) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
