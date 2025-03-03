<?php
require '../includes/employee-dashboard.inc.php';

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
    <title>Employee Dashboard</title>
</head>

<body>
    <div class="d-flex flex-column position-fixed bot bg-dark vh-100 top-0 start-0" style="width: 220px">
        <div class="container-fluid text-center">
            <img src="../images/Payroll.png" class="img-fluid mt-3" style="width: 120px" />
            <h1 class="text-white text-center mt-2">Employee</h1>
        </div>
        <div class="container">
            <hr class="text-white" />
        </div>
        <ul class="nav nav-pills flex-column mb-auto text-white">
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center active" href="../Employee-Panel/employee-dashboard.php"> <img src="../images/dashboard.png" class="me-2" style="width: 20px;"> Dashboard</a>
            </li>
            <li class="nav-item items">
                <a class="nav-link d-flex align-items-center text-white" href="../Employee-Panel/attendance.php"> <img src="../images/event_available_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png" class="me-2" style="width: 20px;"> Attendance</a>
            </li>
            <li class="nav-item items">
                <a class="nav-link d-flex align-items-center text-white" href="../Employee-Panel/payslip.php"> <img src="../images/receipt_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png" class="me-2" style="width: 20px;"> Payslip</a>
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
        <h1 class=""><strong>Dashboard</strong></h1>
    </div>

    <!-- Employee Information -->
    <div class="container d-flex">
        <div class="info-card" style="background-color: rgb(165, 144, 241);">
            <div class="">
                <h1 class="Labels">Welcome Back!</h1>
                <div>
                    <h3 class="ms-4 mt-4"><?php echo htmlspecialchars($employee['employee_name']); ?></h3>
                </div>
            </div>
        </div>
        <div class="info-card" style="background-color: rgb(182, 238, 145);">
            <div>
                <h1 class="Labels">Employee ID</h1>
                <div>
                    <h3 class="ms-4 mt-4"><?php echo $employee['employee_id']; ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="container d-flex mt-3">
        <div class="info-card" style="background-color: antiquewhite;">
            <div>
                <h1 class="Labels">Employee Position</h1>
                <div>
                    <h3 class="ms-4 mt-4"><?php echo htmlspecialchars($employee['position_name']); ?></h3>
                </div>
            </div>
        </div>
        <div class="info-card" style="background-color: rgb(164, 225, 233);">
            <div>
                <h1 class="Labels">Employee Department</h1>
                <div>
                    <h3 class="ms-4 mt-4"><?php echo htmlspecialchars($employee['department_name']); ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>