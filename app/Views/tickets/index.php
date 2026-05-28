<?php require __DIR__ . '/../partials/header.php'; ?>

<h1>Tickets</h1>
<br>
<a href="/tickets/create" class="btn_small">+ New Ticket</a>
<br><br>

<?php if (empty($tickets)): ?>
    <p>No tickets found.</p>
<?php else: ?>
<div class="table_section">
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Status</th>
            <th>Created</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($tickets as $ticket): ?>
        <tr>
            <td><?= $ticket['id'] ?></td>
            <td><?= htmlspecialchars($ticket['title']) ?></td>
            <td><?= htmlspecialchars($ticket['status']) ?></td>
            <td><?= $ticket['created_at'] ?></td>
            <td>
                <a href="/tickets/<?= $ticket['id'] ?>/edit" class="btn_small">Edit</a>
                <?php if ($isAdmin): ?>
                <form method="POST" action="/tickets/<?= $ticket['id'] ?>/delete" style="display:inline" onsubmit="return confirm('Delete this ticket?')">
                    <button type="submit" class="btn_small">Delete</button>
                </form>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php endif; ?>

<br>
<a href="/" class="btn_small">Back</a>

<?php require __DIR__ . '/../partials/footer.php'; ?>
