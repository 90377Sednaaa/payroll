<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login-form/login-form.php");
    exit();
}

require 'dbhc.inc.php';

try {
    // Fetch the admin's name
    $adminId = $_SESSION['admin_id'];
    $stmt = $pdo->prepare("SELECT admin_name FROM Admin WHERE admin_id = :admin_id");
    $stmt->bindParam(':admin_id', $adminId);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    $adminName = $admin ? $admin['admin_name'] : 'Admin';

    // Fetch the number of employees
    $stmt = $pdo->query("SELECT COUNT(*) FROM Employees");
    $numEmployees = $stmt->fetchColumn();

    // Fetch the number of departments
    $stmt = $pdo->query("SELECT COUNT(*) FROM Departments");
    $numDepartments = $stmt->fetchColumn();

    // Fetch the number of positions
    $stmt = $pdo->query("SELECT COUNT(*) FROM Positions");
    $numPositions = $stmt->fetchColumn();
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}