<?php
require '../includes/payroll.inc.php';

// Fetch payroll entries with dynamically calculated deductions
try {
  $stmt = $pdo->query("
      SELECT 
          p.pay_id,
          p.employee_id,
          p.pay_period_start,
          p.pay_period_end,
          p.gross_pay,
          (SELECT COALESCE(SUM(d.deduction_value), 0)
           FROM PayrollDeductions pd
           JOIN Deductions d ON pd.deduction_id = d.deduction_id
           WHERE pd.pay_id = p.pay_id) AS total_deductions,
          e.employee_name
      FROM Payroll p
      JOIN Employees e ON p.employee_id = e.employee_id
  ");
  $payrolls = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  $_SESSION['error'] = "Error fetching payroll data: " . $e->getMessage();
}

// Fetch employees for dropdown
try {
  $employees = $pdo->query("SELECT employee_id, employee_name FROM Employees")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  $_SESSION['error'] = "Error fetching employees: " . $e->getMessage();
}

// Fetch deductions for dropdown
try {
  $deductions = $pdo->query("SELECT deduction_id, deduction_name, deduction_value FROM Deductions")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  $_SESSION['error'] = "Error fetching deductions: " . $e->getMessage();
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
  <title>Dashboard</title>
</head>

<body>
  <div
    class="d-flex flex-column position-fixed bot bg-dark vh-100 top-0 start-0"
    style="width: 220px">
    <div class="container-fluid text-center">
      <!-- <img src="/images/payroll-logo.webp" class="img-fluid mt-3" style="width: 130px"/> -->
      <h1 class="text-white text-center mt-4">Admin</h1>
    </div>
    <div class="container">
      <hr class="text-white" />
    </div>
    <ul class="nav nav-pills flex-column mb-auto text-white">
      <li class="nav-item">
        <a class="nav-link text-start text-white" href="../Admin-Panel/dashboard.php"> Dashboard</a>
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
        <a class="nav-link text-white active" href="../Admin-Panel/payroll.php"> Payroll</a>
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
    <h1 class="mb-5"><strong>Payroll</strong></h1>
  </div>
  <div class="container">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-payroll">Create Payroll</button>


    <!-- Create Payroll Modal -->
    <div class="modal fade" id="create-payroll" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="../includes/payroll.inc.php" method="post">
            <input type="hidden" name="create_payroll" value="1">
            <div class="modal-header">
              <h1 class="modal-title fs-5">Create Payroll</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Employee:</label>
                <select class="form-select" name="employee_id" required>
                  <option value="">Select Employee</option>
                  <?php foreach ($employees as $employee): ?>
                    <option value="<?= $employee['employee_id'] ?>"><?= $employee['employee_name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Pay Start:</label>
                <input type="date" class="form-control" name="pay_start" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Pay End:</label>
                <input type="date" class="form-control" name="pay_end" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Select Deduction <small> &lpar; <span style="color: red; font-weight: bold;">ctrl + click</span> for multiple deductions &rpar;</small> :</label>
                <select class="form-select" name="deduction_ids[]" multiple required>
                  <?php foreach ($deductions as $deduction): ?>
                    <option value="<?= $deduction['deduction_id'] ?>">
                      <?= $deduction['deduction_name'] ?> (<?= $deduction['deduction_value'] ?>)
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Create</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <table class="table mt-5">
      <thead>
        <tr>
          <th>ID</th>
          <th>Employee</th>
          <th>Period</th>
          <th>Gross Pay</th>
          <th>Deductions</th>
          <th>Net Pay</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($payrolls as $payroll): ?>
          <tr>
            <td><?= $payroll['pay_id'] ?></td>
            <td><?= $payroll['employee_name'] ?></td>
            <td>
              <?= date('F j, Y', strtotime($payroll['pay_period_start'])) ?> -
              <?= date('F j, Y', strtotime($payroll['pay_period_end'])) ?>
            </td>
            <td>$<?= number_format($payroll['gross_pay'], 2) ?></td>
            <td>
              <?php
              // Calculate total deductions for this payroll
              $stmt = $pdo->prepare("SELECT SUM(d.deduction_value) 
                                          FROM PayrollDeductions pd 
                                          JOIN Deductions d ON pd.deduction_id = d.deduction_id 
                                          WHERE pd.pay_id = ?");
              $stmt->execute([$payroll['pay_id']]);
              $totalDeductions = $stmt->fetchColumn() ?: 0;
              ?>
              $<?= number_format($totalDeductions, 2) ?>
            </td>
            <td>
              $<?= number_format(($payroll['gross_pay'] - $totalDeductions), 2) ?>
            </td>
            <td>
              <!-- Edit Button -->
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit-payroll-<?= $payroll['pay_id'] ?>">Edit</button>

              <!-- Edit Payroll Modal -->
              <div class="modal fade" id="edit-payroll-<?= $payroll['pay_id'] ?>" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <form action="../includes/payroll.inc.php" method="post">
                      <input type="hidden" name="update_payroll" value="1">
                      <input type="hidden" name="pay_id" value="<?= $payroll['pay_id'] ?>">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5">Edit Payroll</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
                        <div class="mb-3">
                          <label class="form-label">Employee:</label>
                          <select class="form-select" name="employee_id" required>
                            <?php foreach ($employees as $employee): ?>
                              <option value="<?= $employee['employee_id'] ?>"
                                <?= ($employee['employee_id'] == $payroll['employee_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($employee['employee_name']) ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Pay Start:</label>
                          <input type="date" class="form-control" name="pay_start"
                            value="<?= $payroll['pay_period_start'] ?>" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Pay End:</label>
                          <input type="date" class="form-control" name="pay_end"
                            value="<?= $payroll['pay_period_end'] ?>" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Select Deduction <small> &lpar;  <span style="color: red; font-weight: bold;"> ctrl + click </span> for multiple deductions &rpar;</small> :</label>
                          <select class="form-select" name="deduction_ids[]" multiple required>
                            <?php
                            // Fetch applied deductions for this payroll
                            $stmt = $pdo->prepare("SELECT deduction_id FROM PayrollDeductions WHERE pay_id = ?");
                            $stmt->execute([$payroll['pay_id']]);
                            $appliedDeductions = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
                            ?>
                            <?php foreach ($deductions as $deduction): ?>
                              <option value="<?= $deduction['deduction_id'] ?>"
                                <?= in_array($deduction['deduction_id'], $appliedDeductions) ? 'selected' : '' ?>>
                                <?= $deduction['deduction_name'] ?> (<?= $deduction['deduction_value'] ?>)
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Gross Pay</label>
                          <p class="form-control-plaintext">$<?= number_format($payroll['gross_pay'], 2) ?></p>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

              <!-- Delete Button -->
              <a href="../includes/payroll.inc.php?delete=<?= $payroll['pay_id'] ?>" class="btn btn-danger" onclick="return confirm('Confirm deletion?')">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <!-- Message Display -->
    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
      <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
  </div>


  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>