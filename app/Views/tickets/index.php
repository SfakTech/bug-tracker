<?php require __DIR__ . '/../partials/header.php'; ?>

<div class="page-header">
    <h1 class="page-title">Tickets</h1>
    <a href="/tickets/create" class="btn_small">+ New Ticket</a>
</div>

<div class="ticket-stats">
    <span class="stat-pill open"><?= $stats['open'] ?> Open</span>
    <span class="stat-pill progress"><?= $stats['in progress'] ?> In Progress</span>
    <span class="stat-pill closed"><?= $stats['closed'] ?> Closed</span>
</div>

<!-- Filter bar -->
<div class="filter-bar">
    <input type="text" id="ticketSearch" placeholder="Search tickets..." class="search-input">

    <div class="filter-labeled-group">
        <span class="filter-label">Status</span>
        <div class="filter-group">
            <button class="filter-btn active" data-filter-type="status" data-value="all">All</button>
            <button class="filter-btn" data-filter-type="status" data-value="open">Open</button>
            <button class="filter-btn" data-filter-type="status" data-value="in progress">In Progress</button>
            <button class="filter-btn" data-filter-type="status" data-value="closed">Closed</button>
        </div>
    </div>

    <div class="filter-divider"></div>

    <div class="filter-labeled-group">
        <span class="filter-label">Priority</span>
        <div class="filter-group">
            <button class="filter-btn active" data-filter-type="priority" data-value="all">All</button>
            <button class="filter-btn" data-filter-type="priority" data-value="critical">Critical</button>
            <button class="filter-btn" data-filter-type="priority" data-value="high">High</button>
            <button class="filter-btn" data-filter-type="priority" data-value="medium">Medium</button>
            <button class="filter-btn" data-filter-type="priority" data-value="low">Low</button>
        </div>
    </div>
</div>

<?php if (empty($tickets)): ?>
    <div class="empty-state">
        <i data-lucide="ticket" style="width:48px;height:48px;color:#ddd"></i>
        <p>No tickets found.</p>
        <a href="/tickets/create" class="btn_small">Create your first ticket</a>
    </div>
<?php else: ?>
<div class="card" id="noResults" style="display:none;padding:30px;text-align:center;color:#aaa">
    No tickets match your search.
</div>
<div class="card">
    <div class="table_section">
        <table>
            <thead>
                <tr>
                    <th data-sort="id" class="sortable"># <span class="sort-icon">↕</span></th>
                    <th data-sort="title" class="sortable">Title <span class="sort-icon">↕</span></th>
                    <th data-sort="status" class="sortable">Status <span class="sort-icon">↕</span></th>
                    <th data-sort="priority" class="sortable">Priority <span class="sort-icon">↕</span></th>
                    <th data-sort="date" class="sortable">Created <span class="sort-icon">↕</span></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="ticketsBody">
                <?php foreach ($tickets as $ticket): ?>
                <tr class="ticket-row"
                    data-title="<?= htmlspecialchars(strtolower($ticket['title'])) ?>"
                    data-status="<?= $ticket['status'] ?>"
                    data-priority="<?= $ticket['priority'] ?>">
                    <td style="color:#aaa;font-size:13px"><?= $ticket['id'] ?></td>
                    <td><a href="/tickets/<?= $ticket['id'] ?>" style="color:#333;text-decoration:none;font-weight:500"><?= htmlspecialchars($ticket['title']) ?></a></td>
                    <td>
                        <form method="POST" action="/tickets/<?= $ticket['id'] ?>/status" style="margin:0">
                            <?= CSRF::field() ?>
                            <input type="hidden" name="_redirect" value="/tickets">
                            <select name="status" class="inline-status badge-<?= str_replace(' ', '-', $ticket['status']) ?>" onchange="this.form.submit()">
                                <option value="open"        <?= $ticket['status'] === 'open'        ? 'selected' : '' ?>>Open</option>
                                <option value="in progress" <?= $ticket['status'] === 'in progress' ? 'selected' : '' ?>>In Progress</option>
                                <option value="closed"      <?= $ticket['status'] === 'closed'      ? 'selected' : '' ?>>Closed</option>
                            </select>
                        </form>
                    </td>
                    <td><span class="priority-badge priority-<?= $ticket['priority'] ?>"><?= ucfirst($ticket['priority']) ?></span></td>
                    <td style="font-size:13px;color:#aaa"><?= date('d M Y', strtotime($ticket['created_at'])) ?></td>
                    <td>
                        <a href="/tickets/<?= $ticket['id'] ?>/edit" class="btn_small">Edit</a>
                        <?php if ($isAdmin): ?>
                        <form method="POST" action="/tickets/<?= $ticket['id'] ?>/delete" style="display:inline" onsubmit="return confirm('Delete this ticket?')">
                            <?= CSRF::field() ?>
                            <button type="submit" class="btn_small">Delete</button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?php if ($totalPages > 1): ?>
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="/tickets?page=<?= $page - 1 ?>" class="page-btn">← Prev</a>
    <?php else: ?>
        <span class="page-btn disabled">← Prev</span>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <?php if ($i === $page): ?>
            <span class="page-btn active"><?= $i ?></span>
        <?php elseif ($i === 1 || $i === $totalPages || abs($i - $page) <= 1): ?>
            <a href="/tickets?page=<?= $i ?>" class="page-btn"><?= $i ?></a>
        <?php elseif (abs($i - $page) === 2): ?>
            <span class="page-btn dots">…</span>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
        <a href="/tickets?page=<?= $page + 1 ?>" class="page-btn">Next →</a>
    <?php else: ?>
        <span class="page-btn disabled">Next →</span>
    <?php endif; ?>

    <span class="page-info">Page <?= $page ?> of <?= $totalPages ?> &middot; <?= $total ?> tickets</span>
</div>
<?php endif; ?>

<?php require __DIR__ . '/../partials/footer.php'; ?>
