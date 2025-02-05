<?php
session_start();

// Redirect if not logged in as an employee
if (!isset($_SESSION['employee_id'])) {
    header("Location: ../login-form/login-form.php");
    exit();
}

require 'dbhc.inc.php';

// Get employee ID
$employeeId = $_SESSION['employee_id'];

// Fetch employee details
try {
    $stmt = $pdo->prepare("SELECT e.employee_name, e.hire_date, e.employee_email, p.position_name, d.department_name 
                           FROM Employees e 
                           JOIN Positions p ON e.position_id = p.position_id 
                           JOIN Departments d ON p.department_id = d.department_id 
                           WHERE e.employee_id = :employee_id");
    $stmt->bindParam(':employee_id', $employeeId);
    $stmt->execute();
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error'] = "Error fetching employee data: " . $e->getMessage();
    header("Location: ../Employee-Panel/payslip.php");
    exit();
}

// Check if a payroll period is selected
$payroll = null;
$deductions = [];
$totalDeductions = 0;
$netPay = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payroll_id'])) {
    $payrollId = (int)$_POST['payroll_id'];

    // Fetch payroll data
    try {
        $stmt = $pdo->prepare("SELECT * FROM Payroll WHERE pay_id = :payroll_id AND employee_id = :employee_id");
        $stmt->bindParam(':payroll_id', $payrollId);
        $stmt->bindParam(':employee_id', $employeeId);
        $stmt->execute();
        $payroll = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error fetching payroll data: " . $e->getMessage();
        header("Location: ../Employee-Panel/payslip.php");
        exit();
    }

    // Fetch deductions applied to this payroll
    try {
        $stmt = $pdo->prepare("SELECT D.deduction_name, D.deduction_value 
                               FROM Deductions D 
                               JOIN PayrollDeductions PD ON D.deduction_id = PD.deduction_id 
                               WHERE PD.pay_id = :payroll_id");
        $stmt->bindParam(':payroll_id', $payrollId);
        $stmt->execute();
        $deductions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error fetching deductions: " . $e->getMessage();
        header("Location: ../Employee-Panel/payslip.php");
        exit();
    }

    // Calculate total deductions and net pay
    $totalDeductions = array_sum(array_column($deductions, 'deduction_value'));
    $netPay = $payroll['gross_pay'] - $totalDeductions;
}