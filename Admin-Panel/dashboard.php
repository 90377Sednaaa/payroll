<?php
require '../includes/dashboard.inc.php';
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
  <title>Dashboard</title>
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
        <a class="nav-link d-flex align-items-center active" href="../Admin-Panel/dashboard.php"> <img src="../images/dashboard.png" class="me-2" style="width: 20px;"> Dashboard</a>
      </li>
      <li class="nav-item items">
        <a class="nav-link d-flex align-items-center text-white" href="../Admin-Panel/employee.php"> <img src="../images/person_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png" class="me-2" style="width: 20px;"> Employee</a>
      </li>
      <li class="nav-item items">
        <a class="nav-link d-flex align-items-center text-white" href="../Admin-Panel/schedules.php"> <img src="../images/schedule_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png" class="me-2" style="width: 20px;"> Schedules</a>
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
    <img src="../images/dark icons/dataset_24dp_000000_FILL0_wght400_GRAD0_opsz24.svg" class="me-2" style="width: 50px;" />
    <h1><strong>Dashboard</strong></h1>
  </div>
  <div class="container center py-4">
    <div class="row gap-0 column-gap-3 gx-3">
      <div class="col-md-5 card-container mb-3 bg-info shadow">
        <div class="ps-4 pt-3">
          <h1 class="mb-0">Welcome Back!</h1>
        </div>
        <div class="ps-4 pt-2">
        <h2><?php echo htmlspecialchars($adminName); ?></h2>
        </div>
      </div>
      <div class="col-md-5 card-container bg-success shadow">
        <div class="ps-4 pt-3 d-flex align-items-center">
          <img src="../images/dark icons/person_24dp_000000_FILL0_wght400_GRAD0_opsz24.svg" class="me-2" style="width: 50px;" />
          <h1 class="mb-0">Number of Employees</h1>
        </div>
        <div class="ps-4 pt-2 ms-3 d-flex align-items-center">

          <h2><?php echo $numEmployees; ?></h2>
        </div>
      </div>
      <div class="col-md-5 card-container shadow" style="background-color: rgb(188, 166, 209);">
        <div class="ps-4 pt-3 d-flex align-items-center">
          <img src="../images/dark icons/badge_24dp_000000_FILL0_wght400_GRAD0_opsz24.svg" class="me-2" style="width: 50px;" />
          <h1 class="mb-0">Number of Departments</h1>
        </div>
        <div class="ps-4 pt-2 ms-3">
          <h2><?php echo $numDepartments; ?></h2>
        </div>
      </div>
      <div class="col-md-5 card-container shadow" style="background-color: rgb(209, 101, 151);">
        <div class="ps-4 pt-3 d-flex align-items-center">
          <img src="../images/dark icons/sentiment_satisfied_24dp_000000_FILL0_wght400_GRAD0_opsz24.svg" class="me-2" style="width: 50px;" />
          <h1 class="mb-0">Number of Positions</h1>
        </div>
        <div class="ps-4 pt-2 ms-3">
          <h2><?php echo $numPositions; ?></h2>
        </div>
      </div>
    </div>
  </div>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>