<?php
require '../includes/deduction.inc.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
  <link rel="stylesheet" href="Styles/general.css" />
  <link rel="stylesheet" href="Styles/info.css" />
  <title>Deductions</title>
</head>

<body>
  <div class="d-flex flex-column position-fixed bot bg-dark vh-100 top-0 start-0" style="width: 220px">
    <div class="container-fluid text-center">
      <h1 class="text-white text-center mt-4">Admin</h1>
    </div>
    <div class="container">
      <hr class="text-white" />
    </div>
    <ul class="nav nav-pills flex-column mb-auto text-white">
      <li class="nav-item">
        <a class="nav-link text-start text-white" href="../Admin-Panel/dashboard.php">Dashboard</a>
      </li>
      <li class="nav-item items">
        <a class="nav-link text-white" href="../Admin-Panel/employee.php">Employee</a>
      </li>
      <li class="nav-item items">
        <a class="nav-link text-white" href="../Admin-Panel/schedules.php">Schedules</a>
      </li>
      <li class="nav-item items">
        <a class="nav-link text-white" href="../Admin-Panel/department.php">Department</a>
      </li>
      <li class="nav-item items">
        <a class="nav-link text-white" href="../Admin-Panel/position.php">Position</a>
      </li>
      <li class="nav-item items">
        <a class="nav-link text-white active" href="../Admin-Panel/deductions.php">Deductions</a>
      </li>
      <li class="nav-item items">
        <a class="nav-link text-white" href="../Admin-Panel/payroll.php">Payroll</a>
      </li>
    </ul>
    <div class="container">
      <hr class="text-white" />
    </div>
    <div class="container mb-2">
      <a class="btn btn-outline-danger" href="../includes/logout.inc.php">Logout</a>
    </div>
  </div>

  <div class="container">
    <h1 class="mb-5"><strong>Deductions</strong></h1>
  </div>

  <!-- Add Deduction Button and Modal -->
  <div class="container">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-deduction">Add Deduction</button>

    <!-- Add Deduction Modal -->
    <div class="modal fade" id="add-deduction" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5">Add New Deduction</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="../includes/deduction.inc.php" method="post">
              <div class="mb-3">
                <label class="form-label">Deduction Name</label>
                <input type="text" class="form-control" name="deduc_name" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Deduction Value</label>
                <input type="number" class="form-control" name="deduc_val" step="0.01" required>
              </div>
              <button type="submit" class="btn btn-primary mt-4">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Deductions Table -->
  <div class="container mt-5">
    <?php
    try {
      $stmt = $pdo->query("SELECT * FROM Deductions");
      $deductions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      $_SESSION['error'] = "Error fetching deductions: " . $e->getMessage();
      header("Location: ../Admin-Panel/deductions.php");
      exit();
    }
    ?>

    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Value</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($deductions as $deduction): ?>
          <tr>
            <td><?php echo htmlspecialchars($deduction['deduction_id']); ?></td>
            <td><?php echo htmlspecialchars($deduction['deduction_name']); ?></td>
            <td><?php echo $deduction['deduction_value']; ?></td>
            <td>
              <!-- Edit Button -->
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit-deduction-<?php echo $deduction['deduction_id']; ?>">Edit</button>

              <!-- Edit Deduction Modal -->
              <div class="modal fade" id="edit-deduction-<?php echo $deduction['deduction_id']; ?>" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5">Edit Deduction</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="../includes/deduction.inc.php" method="post">
                        <input type="hidden" name="edit-deduction-id" value="<?php echo $deduction['deduction_id']; ?>">
                        <div class="mb-3">
                          <label class="form-label">Deduction Name</label>
                          <input type="text" class="form-control" name="deduc_name" value="<?php echo htmlspecialchars($deduction['deduction_name']); ?>" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Deduction Value</label>
                          <input type="number" class="form-control" name="deduc_val" value="<?php echo $deduction['deduction_value']; ?>" step="0.01" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4">Update</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Delete Button -->
              <a href="../includes/deduction.inc.php?delete-id=<?php echo $deduction['deduction_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this deduction?')">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Display Messages -->
  <?php if (isset($_SESSION['success'])): ?>
    <div class="container mt-3">
      <div class="alert alert-success" role="alert">
        <?php echo $_SESSION['success']; ?>
      </div>
    </div>
    <?php unset($_SESSION['success']); ?>
  <?php endif; ?>

  <?php if (isset($_SESSION['error'])): ?>
    <div class="container mt-3">
      <div class="alert alert-danger" role="alert">
        <?php echo $_SESSION['error']; ?>
      </div>
    </div>
    <?php unset($_SESSION['error']); ?>
  <?php endif; ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>