<?php
require '../includes/attendance.inc.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
  <link rel="stylesheet" href="Styles/general.css" />
  <link rel="stylesheet" href="Styles/info.css" />
  <link rel="stylesheet" href="Styles/dashboard.css" />
  <link rel="stylesheet" href="Styles/attendance.css" />
  <title>Attendance</title>
</head>

<body>
  <div class="d-flex flex-column position-fixed bot bg-dark vh-100 top-0 start-0" style="width: 220px">
    <div class="container-fluid text-center">
      <h1 class="text-white text-center mt-4">Employee</h1>
    </div>
    <div class="container">
      <hr class="text-white" />
    </div>
    <ul class="nav nav-pills flex-column mb-auto text-white">
      <li class="nav-item">
        <a class="nav-link text-start text-white" href="../Employee-Panel/employee-dashboard.php">Dashboard</a>
      </li>
      <li class="nav-item items">
        <a class="nav-link text-start text-white active" href="../Employee-Panel/attendance.php">Attendance</a>
      </li>
      <li class="nav-item items">
        <a class="nav-link text-start text-white" href="../Employee-Panel/pay-slip.php">Pay Slip</a>
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
    <h1 class="mb-5"><strong>Attendance</strong></h1>
  </div>

  <div class="clock-container">
    <div class="time" id="time"></div>
    <div class="date" id="date"></div>
    <div class="buttons-container">
      <div class="buttons" style="margin-right: 30px;">
        <form action="../includes/attendance.inc.php" method="post" style="display: inline;">
          <input type="hidden" name="action" value="time_in">
          <button type="submit" class="btn btn-success button">Time In</button>
        </form>
      </div>
      <div class="buttons">
        <form action="../includes/attendance.inc.php" method="post" style="display: inline;">
          <input type="hidden" name="action" value="time_out">
          <button type="submit" class="btn btn-danger button">Time Out</button>
        </form>
      </div>
    </div>
    <div class="container mt-3">
      <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success mt-3">
          <?= $_SESSION['success'] ?>
        </div>
        <?php unset($_SESSION['success']); ?>
      <?php endif; ?>
      <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger mt-3">
          <?= $_SESSION['error'] ?>
        </div>
        <?php unset($_SESSION['error']); ?>
      <?php endif; ?>
    </div>
  </div>

  <!-- Current Time Display -->
  <script>
    function updateTime() {
      const now = new Date();
      document.getElementById('time').textContent = now.toLocaleTimeString([], {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
      });
      document.getElementById('date').textContent = now.toLocaleDateString([], {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
    }

    setInterval(updateTime, 1000);
    updateTime(); // Initial call to display immediately
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>