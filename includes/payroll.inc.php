<?php
require 'dbhc.inc.php';
session_start();

// Function to calculate gross pay
function calculateGrossPay($pdo, $employee_id, $start_date, $end_date)
{
    // Get the employee's hourly rate
    $stmt = $pdo->prepare("
        SELECT p.hourly_rate 
        FROM Employees e 
        JOIN Positions p ON e.position_id = p.position_id 
        WHERE e.employee_id = ?
    ");
    $stmt->execute([$employee_id]);
    $hourlyRate = $stmt->fetchColumn();

    // Calculate total hours worked during the pay period
    $stmt = $pdo->prepare("
        SELECT COALESCE(SUM(total_hours), 0) 
        FROM Attendance 
        WHERE employee_id = ? 
        AND attendance_date BETWEEN ? AND ?
    ");
    $stmt->execute([$employee_id, $start_date, $end_date]);
    $totalHours = $stmt->fetchColumn();

    return $hourlyRate * $totalHours;
}

// Handle payroll creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_payroll'])) {
    try {
        $employee_id = $_POST['employee_id'];
        $start_date = $_POST['pay_start'];
        $end_date = $_POST['pay_end'];
        $deduction_ids = isset($_POST['deduction_ids']) ? $_POST['deduction_ids'] : [];

        // Validate dates
        if (strtotime($start_date) >= strtotime($end_date)) {
            throw new Exception("Start date must be before end date.");
        }

        // Calculate gross pay
        $grossPay = calculateGrossPay($pdo, $employee_id, $start_date, $end_date);

        // Insert payroll entry
        $stmt = $pdo->prepare("INSERT INTO Payroll (employee_id, pay_period_start, pay_period_end, gross_pay) 
                              VALUES (?, ?, ?, ?)");
        $stmt->execute([$employee_id, $start_date, $end_date, $grossPay]);
        $pay_id = $pdo->lastInsertId();

        // Link selected deductions
        foreach ($deduction_ids as $deduction_id) {
            $stmt = $pdo->prepare("INSERT INTO PayrollDeductions (pay_id, deduction_id) VALUES (?, ?)");
            $stmt->execute([$pay_id, $deduction_id]);
        }

        $_SESSION['success'] = "Payroll created successfully!";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }

    header("Location: ../Admin-Panel/payroll.php");
    exit;
}

// Handle payroll update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_payroll'])) {
    try {
        $pay_id = $_POST['pay_id'];
        $employee_id = $_POST['employee_id'];
        $start_date = $_POST['pay_start'];
        $end_date = $_POST['pay_end'];
        $deduction_ids = isset($_POST['deduction_ids']) ? $_POST['deduction_ids'] : [];

        // Validate dates
        if (strtotime($start_date) >= strtotime($end_date)) {
            throw new Exception("Start date must be before end date.");
        }

        // Calculate new gross pay
        $grossPay = calculateGrossPay($pdo, $employee_id, $start_date, $end_date);

        // Update payroll entry
        $stmt = $pdo->prepare("UPDATE Payroll 
                              SET employee_id = ?, pay_period_start = ?, pay_period_end = ?, gross_pay = ?
                              WHERE pay_id = ?");
        $stmt->execute([$employee_id, $start_date, $end_date, $grossPay, $pay_id]);

        // Remove old deductions
        $stmt = $pdo->prepare("DELETE FROM PayrollDeductions WHERE pay_id = ?");
        $stmt->execute([$pay_id]);

        // Link new deductions
        foreach ($deduction_ids as $deduction_id) {
            $stmt = $pdo->prepare("INSERT INTO PayrollDeductions (pay_id, deduction_id) VALUES (?, ?)");
            $stmt->execute([$pay_id, $deduction_id]);
        }

        $_SESSION['success'] = "Payroll updated successfully!";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }

    header("Location: ../Admin-Panel/payroll.php");
    exit;
}

// Handle payroll deletion
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
    try {
        $pay_id = $_GET['delete'];

        // Remove associated deductions
        $stmt = $pdo->prepare("DELETE FROM PayrollDeductions WHERE pay_id = ?");
        $stmt->execute([$pay_id]);

        // Delete payroll entry
        $stmt = $pdo->prepare("DELETE FROM Payroll WHERE pay_id = ?");
        $stmt->execute([$pay_id]);

        $_SESSION['success'] = "Payroll deleted successfully!";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
    }

    header("Location: ../Admin-Panel/payroll.php");
    exit;
}
