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
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="Styles/general.css" />
    <link rel="stylesheet" href="Styles/info.css"/>
    <title>Dashboard</title>
  </head>
  <body>
    <div
      class="d-flex flex-column position-fixed bot bg-dark vh-100 top-0 start-0"
      style="width: 220px"
    >
      <div class="container-fluid text-center">
        <!-- <img src="/images/payroll-logo.webp" class="img-fluid mt-3" style="width: 130px"/> -->
        <h1 class="text-white text-center mt-4">Admin</h1>
      </div>
      <div class="container">
        <hr class="text-white" />
      </div>
      <ul class="nav nav-pills flex-column mb-auto text-white">
        <li class="nav-item">
          <a class="nav-link text-start active" href="../Admin-Panel/dashboard.php"> Dashboard</a>
        </li>
        <li class="nav-item items">
          <a class="nav-link text-white" href="../Admin-Panel/employee.php"> Employee</a>
        </li>
        <li class="nav-item items">
          <a class="nav-link text-white" href="../Admin-Panel/schedules.php"> Schedules</a>
        </li>
        <li class="nav-item items">
          <a class="nav-link text-white" href="../Admin-Panel/department.php"> Department</a>
        </li>
        <li class="nav-item items">
          <a class="nav-link text-white" href="../Admin-Panel/position.php"> Position</a>
        </li>
        <li class="nav-item items">
          <a class="nav-link text-white" href="../Admin-Panel/deductions.php"> Deductions</a>
        </li>
        <li class="nav-item items">
          <a class="nav-link text-white" href="../Admin-Panel/payroll.php"> Payroll</a>
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
      <h1 class="mb-5"><strong>Dashboard</strong></h1>
  </div>
    <div class="container py-4">
      <div class="row gap-0 column-gap-3 gx-3">
        <div class="col-md-5 card-container mb-3 bg-info">
          <div class="ps-4 pt-3">
            <h1 class="mb-0">Welcome Back!</h1>
          </div>
          <div class="ps-4 pt-2">
            <h3><?php echo htmlspecialchars($adminName); ?></h3>
          </div>
        </div>
        <div class="col-md-5 card-container bg-success">
          <div class="ps-4 pt-3">
            <h1 class="mb-0">Number of Employees</h1>
          </div>
          <div class="ps-4 pt-2">
            <h3><?php echo $numEmployees; ?></h3>
          </div>
        </div>
        <div class="col-md-5 card-container" style="background-color: rgb(188, 166, 209);">
          <div class="ps-4 pt-3">
            <h1 class="mb-0">Number of Departments</h1>
          </div>
          <div class="ps-4 pt-2">
            <h3><?php echo $numDepartments; ?></h3>
          </div>
        </div>
        <div class="col-md-5 card-container" style="background-color: rgb(209, 101, 151);">
          <div class="ps-4 pt-3">
            <h1 class="mb-0">Number of Positions</h1>
          </div>
          <div class="ps-4 pt-2">
            <h3><?php echo $numPositions; ?></h3>
          </div>
        </div>
      </div>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
