<?php
require '../includes/employee.inc.php';

// Fetch Positions and Schedules for dropdown
try {
  $stmt = $pdo->query("SELECT * FROM Positions");
  $positions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  $_SESSION['error'] = "Error fetching positions: " . $e->getMessage();
  header("Location: ../Admin-Panel/employee.php");
  exit();
}

try {
  $stmt = $pdo->query("SELECT * FROM Schedules");
  $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  $_SESSION['error'] = "Error fetching schedules: " . $e->getMessage();
  header("Location: ../Admin-Panel/employee.php");
  exit();
}

// Fetch Employees
try {
  $stmt = $pdo->query("SELECT e.*, p.department_id, p.position_name, s.schedule_name FROM Employees e JOIN Positions p ON e.position_id = p.position_id JOIN Schedules s ON e.schedule_id = s.schedule_id");
  $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  $_SESSION['error'] = "Error fetching employees: " . $e->getMessage();
  header("Location: ../Admin-Panel/employee.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
  <link rel="stylesheet" href="Styles/general.css" />
  <link rel="stylesheet" href="Styles/info.css" />
  <title>Employee</title>
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
        <a class="nav-link text-white active" href="../Admin-Panel/employee.php">Employee</a>
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
        <a class="nav-link text-white" href="../Admin-Panel/deductions.php">Deductions</a>
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
    <h1 class="mb-5"><strong>Employees</strong></h1>
  </div>

  <!-- Add Employee Button and Modal -->
  <div class="container">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-employee">Add Employee</button>

    <!-- Add Employee Modal -->
    <div class="modal fade" id="add-employee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5">Add New Employee</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="../includes/employee.inc.php" method="post">
              <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" class="form-control" name="ename" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Select a Position</label>
                <select class="form-control" name="eposition" required>
                  <?php foreach ($positions as $position): ?>
                    <option value="<?php echo $position['position_id']; ?>"><?php echo htmlspecialchars($position['position_name']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Select a Schedule</label>
                <select class="form-control" name="eschedule" required>
                  <?php foreach ($schedules as $schedule): ?>
                    <option value="<?php echo $schedule['schedule_id']; ?>"><?php echo htmlspecialchars($schedule['schedule_name']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Date Hired</label>
                <input type="date" class="form-control" name="hire_date" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control password-input" id="employee_password_add" name="epassword" required>
              </div>
              <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="showpassword-add" onclick="togglePasswordVisibility(this)">
                <label class="form-check-label" for="showpassword-add">Show password</label>
              </div>
              <button type="submit" class="btn btn-primary mt-4">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Employees Table -->
  <div class="container mt-5">
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Hired Date</th>
          <th scope="col">Position</th>
          <th scope="col">Schedule</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($employees as $employee): ?>
          <tr>
            <td><?php echo htmlspecialchars($employee['employee_id']); ?></td>
            <td><?php echo htmlspecialchars($employee['employee_name']); ?></td>
            <td><?php echo htmlspecialchars($employee['employee_email']); ?></td>
            <td><?php echo $employee['hire_date']; ?></td>
            <td><?php echo htmlspecialchars($employee['position_name']); ?></td>
            <td><?php echo htmlspecialchars($employee['schedule_name']); ?></td>
            <td>
              <!-- Edit Button -->
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit-employee-<?php echo $employee['employee_id']; ?>">Edit</button>

              <!-- Edit Employee Modal -->
              <div class="modal fade" id="edit-employee-<?php echo $employee['employee_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5">Edit Employee Details</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="../includes/employee.inc.php" method="post">
                        <input type="hidden" name="edit-employee-id" value="<?php echo $employee['employee_id']; ?>">
                        <div class="mb-3">
                          <label class="form-label">Full Name</label>
                          <input type="text" class="form-control" name="ename" value="<?php echo htmlspecialchars($employee['employee_name']); ?>" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Email</label>
                          <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($employee['employee_email']); ?>" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Select a Position</label>
                          <select class="form-control" name="eposition" required>
                            <?php foreach ($positions as $position): ?>
                              <option value="<?php echo $position['position_id']; ?>"
                                <?php if ($position['position_id'] == $employee['position_id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($position['position_name']); ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Select a Schedule</label>
                          <select class="form-control" name="eschedule" required>
                            <?php foreach ($schedules as $schedule): ?>
                              <option value="<?php echo $schedule['schedule_id']; ?>"
                                <?php if ($schedule['schedule_id'] == $employee['schedule_id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($schedule['schedule_name']); ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Date Hired</label>
                          <input type="date" class="form-control" name="hire_date" value="<?php echo $employee['hire_date']; ?>" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Password</label>
                          <input type="password" class="form-control password-input" name="epassword" required>
                        </div>
                        <div class="mb-3 form-check">
                          <input type="checkbox" class="form-check-input" id="showpassword-edit" onclick="togglePasswordVisibility(this)">
                          <label class="form-check-label" for="showpassword-edit">Show password</label>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4">Update</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Delete Button -->
              <a href="../includes/employee.inc.php?delete-id=<?php echo $employee['employee_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this employee?')">Delete</a>
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
  <script>
    function togglePasswordVisibility(checkbox) {
      // Find the closest parent form-check element
      const formCheck = checkbox.closest('.form-check');
      // Find the password input within the same form group
      const passwordInput = formCheck.previousElementSibling.querySelector('.password-input');
      passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
    }
  </script>
</body>

</html>