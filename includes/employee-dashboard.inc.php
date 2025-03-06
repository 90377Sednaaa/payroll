<?php
session_start();

if (!isset($_SESSION['employee_id'])) {
    header("Location: ../login-form/login-form.php");
    exit();
}

require 'dbhc.inc.php';

try {
    // Fetch employee details
    $stmt = $pdo->prepare("SELECT * FROM Employees 
                           JOIN Positions ON Employees.position_id = Positions.position_id 
                           JOIN Departments ON Positions.department_id = Departments.department_id 
                           WHERE Employees.employee_id = :employee_id");
    $stmt->bindParam(':employee_id', $_SESSION['employee_id']);
    $stmt->execute();
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error'] = "Error fetching employee data: " . $e->getMessage();
    header("Location: ../Employee-Panel/employee-dashboard.php");
    exit();
}