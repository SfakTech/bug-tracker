<?php
require_once '../config.php';
$result = $conn->query("SELECT * FROM tickets ORDER BY created_at DESC");
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

<body style="background: #fff;">
    <link rel="stylesheet" href="../style.css">

    <div class="container py-4">
    <div class="box1">
        <h2>Tickets</h2>
        <button class="btn add" data-bs-toggle="modal" data-bs-target="#exampleModal">Add New Ticket</button>
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

</body>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Ticket</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
        
            <form id="ticketForm">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="Open">Open</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Closed">Closed</option>
                    </select>
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" form="ticketForm">Save Ticket</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</html>