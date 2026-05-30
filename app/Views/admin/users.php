<?php require __DIR__ . '/../partials/header.php'; ?>

<h1>Manage Users</h1>
<br>

<div class="table_section">
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= htmlspecialchars($user['name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['role']) ?></td>
            <td>
                <?php if ($user['id'] !== $_SESSION['user']['id']): ?>
                <form method="POST" action="/admin/users/<?= $user['id'] ?>/delete" style="display:inline" onsubmit="return confirm('Delete this user?')">
                    <?= CSRF::field() ?>
                    <button type="submit" class="btn_small">Delete</button>
                </form>
                <?php else: ?>
                <span style="color:#aaa;font-size:13px;">You</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<br>
<a href="/" class="btn_small">Back</a>

<?php require __DIR__ . '/../partials/footer.php'; ?>
