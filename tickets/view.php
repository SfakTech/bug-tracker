<?php
require_once '../config.php';
$result = $conn->query("SELECT * FROM tickets ORDER BY created_at DESC");
?>


<?php
session_start();
$backPage = "../user_page.php";
if (isset($_SESSION['role']) and $_SESSION['role'] === "admin") {
  $backPage = "../admin_page.php";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="../style.css">

</head>

<body style="background: #ffffffff;">
  <link rel="stylesheet" href="../style.css">

  <div class="container py-4">
    <div class="box1">
      <h2>Tickets</h2>
      <div class="buttons_container">
        <button type="button" class="btn_small" data-bs-toggle="modal" data-bs-target="#exampleModal">Add New Ticket</button>
        <a href="<?php echo $backPage; ?>" class="btn_secondary">Back</a>
      </div>

    </div>

    <table class="table_section">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Status</th>
          <th>Created</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td><?= $row['created_at'] ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>

    </table>

  </div>

  <form action="insert.php" method="post">
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Ticket</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">


            <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" name="title" class="form-control" id="title">
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <input type="text" name="description" class="form-control" id="description">
            </div>
            <div class="mb-3">
              <label for="status" name="status" class="form-label">Status</label>
              <select class="form-select" id="status" name="status">
                <option value="open">Open</option>
                <option value="in progress">In Progress</option>
                <option value="closed">Closed</option>
              </select>
            </div>

          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-primary" style="background-color: #ff891c; border: none;" name="save" value="Add new ticket">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: #ff891c; border: none;">Close</button>
          </div>
        </div>
      </div>
    </div>
  </form>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</html>