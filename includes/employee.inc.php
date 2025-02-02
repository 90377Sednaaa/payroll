<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login-form/login-form.php");
    exit();
}

// Database connection
require 'dbhc.inc.php';

// Add Employee
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['edit-employee-id']) && isset($_POST['ename'], $_POST['email'], $_POST['epassword'], $_POST['hire_date'], $_POST['eposition'], $_POST['eschedule'])) {
    $employeeName = trim($_POST['ename']);
    $employeeEmail = trim($_POST['email']);
    $employeePassword = password_hash($_POST['epassword'], PASSWORD_DEFAULT);
    $hireDate = $_POST['hire_date'];
    $positionId = (int)$_POST['eposition'];
    $scheduleId = (int)$_POST['eschedule'];

    try {
        $stmt = $pdo->prepare("INSERT INTO Employees (employee_name, employee_email, employee_password, hire_date, position_id, schedule_id) VALUES (:name, :email, :password, :hire_date, :position_id, :schedule_id)");
        $stmt->bindParam(':name', $employeeName);
        $stmt->bindParam(':email', $employeeEmail);
        $stmt->bindParam(':password', $employeePassword);
        $stmt->bindParam(':hire_date', $hireDate);
        $stmt->bindParam(':position_id', $positionId);
        $stmt->bindParam(':schedule_id', $scheduleId);
        $stmt->execute();
        $_SESSION['success'] = "Employee added successfully!";
        header("Location: ../Admin-Panel/employee.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error adding employee: " . $e->getMessage();
        header("Location: ../Admin-Panel/employee.php");
        exit();
    }
}

// Edit Employee
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit-employee-id'], $_POST['ename'], $_POST['email'], $_POST['epassword'], $_POST['hire_date'], $_POST['eposition'], $_POST['eschedule'])) {
    $employeeId = (int)$_POST['edit-employee-id'];
    $employeeName = trim($_POST['ename']);
    $employeeEmail = trim($_POST['email']);
    $employeePassword = password_hash($_POST['epassword'], PASSWORD_DEFAULT);
    $hireDate = $_POST['hire_date'];
    $positionId = (int)$_POST['eposition'];
    $scheduleId = (int)$_POST['eschedule'];

    try {
        $stmt = $pdo->prepare("UPDATE Employees SET employee_name = :name, employee_email = :email, employee_password = :password, hire_date = :hire_date, position_id = :position_id, schedule_id = :schedule_id WHERE employee_id = :id");
        $stmt->bindParam(':id', $employeeId);
        $stmt->bindParam(':name', $employeeName);
        $stmt->bindParam(':email', $employeeEmail);
        $stmt->bindParam(':password', $employeePassword);
        $stmt->bindParam(':hire_date', $hireDate);
        $stmt->bindParam(':position_id', $positionId);
        $stmt->bindParam(':schedule_id', $scheduleId);
        $stmt->execute();
        $_SESSION['success'] = "Employee updated successfully!";
        header("Location: ../Admin-Panel/employee.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error updating employee: " . $e->getMessage();
        header("Location: ../Admin-Panel/employee.php");
        exit();
    }
}

// Delete Employee
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete-id'])) {
    $employeeId = (int)$_GET['delete-id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM Employees WHERE employee_id = :id");
        $stmt->bindParam(':id', $employeeId);
        $stmt->execute();
        $_SESSION['success'] = "Employee deleted successfully!";
        header("Location: ../Admin-Panel/employee.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error deleting employee: " . $e->getMessage();
        header("Location: ../Admin-Panel/employee.php");
        exit();
    }
}