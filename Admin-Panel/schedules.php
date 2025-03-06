<?php
require '../includes/schedules.inc.php';

// Fetch Schedules from Database
try {
  $stmt = $pdo->query("SELECT * FROM schedules");
  $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  $_SESSION['error'] = "Error fetching schedules: " . $e->getMessage();
  header("Location: ../Admin-Panel/schedules.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="Styles/general.css" />
  <link rel="stylesheet" href="Styles/info.css" />
  <title>Schedules</title>
</head>

<body>
  <div
    class="d-flex flex-column position-fixed bot bg-dark vh-100 top-0 start-0"
    style="width: 250px">
    <div class="container-fluid text-center">
      <img src="../images/Payroll.png" class="img-fluid mt-3" style="width: 120px" />
      <h1 class="text-white">Admin</h1>
    </div>
    <div class="container">
      <hr class="text-white" />
    </div>
    <ul class="nav nav-pills flex-column mb-auto text-white">
      <li class="nav-item items">
        <a class="nav-link d-flex align-items-center text-white" href="../Admin-Panel/dashboard.php"> <img src="../images/dashboard.png" class="me-2" style="width: 20px;"> Dashboard</a>
      </li>
      <li class="nav-item items">
        <a class="nav-link d-flex align-items-center text-white" href="../Admin-Panel/employee.php"> <img src="../images/person_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png" class="me-2" style="width: 20px;"> Employee</a>
      </li>
      <li class="nav-item items">
        <a class="nav-link d-flex align-items-center text-white active" href="../Admin-Panel/schedules.php"> <img src="../images/schedule_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png" class="me-2" style="width: 20px;"> Schedules</a>
      </li>
      <li class="nav-item items">
        <a class="nav-link d-flex align-items-center text-white" href="../Admin-Panel/department.php"> <img src="../images/badge_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png" class="me-2" style="width: 20px;"> Department</a>
      </li>
      <li class="nav-item items">
        <a class="nav-link d-flex align-items-center text-white" href="../Admin-Panel/position.php"> <img src="../images/sentiment_satisfied_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png" class="me-2" style="width: 20px;"> Position</a>
      </li>
      <li class="nav-item items">
        <a class="nav-link d-flex align-items-center text-white" href="../Admin-Panel/deductions.php"> <img src="../images/price_change_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png" class="me-2" style="width: 20px;"> Deductions</a>
      </li>
      <li class="nav-item items">
        <a class="nav-link d-flex align-items-center text-white" href="../Admin-Panel/payroll.php"> <img src="../images/payments_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png" class="me-2" style="width: 20px;"> Payroll</a>
      </li>
    </ul>
    <div class="container">
      <hr class="text-white" />
    </div>
    <div class="container mb-2">
      <a class="btn btn-outline-danger" href="../includes/logout.inc.php">Logout</a>
    </div>
  </div>

  <div class="container d-flex align-items-center mb-5">
    <img src="../images/dark icons/schedule_24dp_000000_FILL0_wght400_GRAD0_opsz24.svg" class="me-2" style="width: 50px;" />
    <h1 class=""><strong>Schedules</strong></h1>
  </div>
  <div class="container">
    <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#add-schedules"><img class="me-2" style="width: 20px;" src="../images/add_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png"> Schedule</button>

    <!-- Add Modal -->
    <div class="modal fade" id="add-schedules" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Enter New Schedule Details</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="../includes/schedules.inc.php" method="post">
              <div class="mb-3">
                <label for="schedule_name" class="form-label">Schedule Name</label>
                <input type="text" class="form-control" id="schedule_name" name="sched_name" required>
              </div>
              <div class="mb-3">
                <label for="timeIn" class="form-label">Time In</label>
                <input type="time" class="form-control" id="timeIn" name="time_in" required>
              </div>
              <div class="mb-3">
                <label for="timeOut" class="form-label">Time Out</label> 
                <input type="time" class="form-control" id="timeOut" name="time_out" required>
              </div>
              <button type="submit" class="btn btn-primary mt-4">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <table class="table mt-5">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Schedule Name</th>
          <th scope="col">Time In</th>
          <th scope="col">Time Out</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody class="table-group-divider">
        <?php foreach ($schedules as $schedule): ?>
          <tr>
            <th scope="row"><?php echo $schedule['schedule_id']; ?></th>
            <td><?php echo htmlspecialchars($schedule['schedule_name']); ?></td>
            <td><?php echo $schedule['start_time']; ?></td>
            <td><?php echo $schedule['end_time']; ?></td>
            <td>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit-schedule-<?php echo $schedule['schedule_id']; ?>">Edit</button>
              <a href="../includes/schedules.inc.php?delete-id=<?php echo $schedule['schedule_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this schedule?')">Delete</a>

              <!-- Edit Modal -->
              <div class="modal fade" id="edit-schedule-<?php echo $schedule['schedule_id']; ?>" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5">Edit Schedule Details</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="../includes/schedules.inc.php" method="post">
                        <input type="hidden" name="edit-schedule-id" value="<?php echo $schedule['schedule_id']; ?>">
                        <div class="mb-3">
                          <label class="form-label">Schedule Name</label>
                          <input type="text" class="form-control" name="sched_name"
                            value="<?php echo htmlspecialchars($schedule['schedule_name']); ?>" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Time In</label>
                          <input type="time" class="form-control" name="time_in"
                            value="<?php echo $schedule['start_time']; ?>" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Time Out</label>
                          <input type="time" class="form-control" name="time_out"
                            value="<?php echo $schedule['end_time']; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4">Update</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-info mt-3" role="alert">
        <?php echo $_SESSION['success']; ?>
      </div>
      <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger mt-3" role="alert">
        <?php echo $_SESSION['error']; ?>
      </div>
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
  </div>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>