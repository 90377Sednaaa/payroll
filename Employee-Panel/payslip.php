<?php
require '../includes/payslip.inc.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link rel="stylesheet" href="Styles/general.css" />
    <link rel="stylesheet" href="Styles/payslip.css" />
    <title>Payslip</title>
</head>

<body>
    <!-- Sidebar -->
    <div class="d-flex flex-column position-fixed bot bg-dark vh-100 top-0 start-0" style="width: 220px">
        <div class="container-fluid text-center">
            <h1 class="text-white text-center mt-4">Employee</h1>
        </div>
        <div class="container">
            <hr class="text-white" />
        </div>
        <ul class="nav nav-pills flex-column mb-auto text-white">
            <li class="nav-item items">
                <a class="nav-link text-start text-white" href="../Employee-Panel/employee-dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item items">
                <a class="nav-link text-start text-white" href="../Employee-Panel/attendance.php">Attendance</a>
            </li>
            <li class="nav-item items">
                <a class="nav-link text-start text-white active" href="../Employee-Panel/payslip.php">Payslip</a>
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
        <h1 class="mb-5"><strong>Payslip</strong></h1>
    </div>

    <!-- Payroll Selection -->
    <div class="container">
        <div class="mt-3">
            <label class="mb-2 ps-1 h5" for="payrolls">Available payrolls</label>
            <form action="" method="post">
                <select class="form-select" style="width: 400px" id="payrolls" name="payroll_id">
                    <option value="">Select a payroll</option>
                    <?php
                    try {
                        $stmt = $pdo->prepare("SELECT pay_id, pay_period_start, pay_period_end FROM Payroll WHERE employee_id = :employee_id ORDER BY pay_period_start DESC");
                        $stmt->bindParam(':employee_id', $employeeId);
                        $stmt->execute();
                        $payrolls = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                        $_SESSION['error'] = "Error fetching payrolls: " . $e->getMessage();
                        header("Location: ../Employee-Panel/payslip.php");
                        exit();
                    }

                    foreach ($payrolls as $payroll): ?>
                        <option value="<?= $payroll['pay_id']; ?>">
                            <?= date('Y-m-d', strtotime($payroll['pay_period_start'])) . ' - ' . date('Y-m-d', strtotime($payroll['pay_period_end'])); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary mt-4">Request Payslip</button>
            </form>
        </div>
    </div>

    <hr />

    <!-- Payslip Display -->
    <?php if (isset($payroll)): ?>
        <div class="payslip-container shadow-lg" >
            <h1 class="text-center">Payslip</h1>
            <h6 class="text-center">Company Name Inc.</h6>
            <h6 class="text-center">Matina Aplaya, Davao City.</h6>
            <div class="employee-info">
                <div class="details-container">
                    <div class="details">
                        <h6>Date of Joining</h6>
                        <h6>: <?= $employee['hire_date'] ?? 'N/A'; ?></h6>
                    </div>
                    <div class="details">
                        <h6>Pay Period Start</h6>
                        <h6>: <?= date('Y-m-d', strtotime($payPeriodStart)) ?? 'N/A'; ?></h6>
                    </div>
                    <div class="details">
                        <h6>Pay Period End</h6>
                        <h6>: <?= date('Y-m-d', strtotime($payPeriodEnd)) ?? 'N/A'; ?></h6>
                    </div>
                </div>
                <div class="details-container">
                    <div class="details">
                        <h6>Employee Name</h6>
                        <h6>: <?= $employee['employee_name'] ?? 'N/A'; ?></h6>
                    </div>
                    <div class="details">
                        <h6>Department</h6>
                        <h6>: <?= $employee['department_name'] ?? 'N/A'; ?></h6>
                    </div>
                    <div class="details">
                        <h6>Position</h6>
                        <h6>: <?= $employee['position_name'] ?? 'N/A'; ?></h6>
                    </div>
                </div>
            </div>
            <div class="container d-flex flex column justify-content-center" style="margin-top: 80px; width: 1200px;">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">Earnings</th>
                            <th scope="col">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Basic Salary</td>
                            <td><?= $grossPay ?? 'N/A'; ?></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td style="font-weight: bold;">Total Earnings</td>
                            <td><?= $grossPay ?? 'N/A'; ?></td>
                        </tr>
                    </tfoot>
                </table>
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">Deductions</th>
                            <th scope="col">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($deductions as $deduction): ?>
                            <tr>
                                <td><?= $deduction['deduction_name']; ?></td>
                                <td><?= $deduction['deduction_value']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td style="font-weight: bold;">Total Deductions</td>
                            <td><?= $totalDeductions; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-3 d-flex flex-column justify-content-center">
                <h1><strong>Net Pay: <?= $netPay; ?></strong></h1>
            </div>
        </div>
    <?php endif; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>