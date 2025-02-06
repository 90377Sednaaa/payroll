<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: ../login-form/login-form.php");
    exit();
}

$email = trim($_POST['email']);
$password = trim($_POST['password']);

if (empty($email) || empty($password)) {
    $_SESSION['error'] = "Please fill in all fields.";
    header("Location: ../login-form/login-form.php");
    exit();
}

require 'dbhc.inc.php';

try {
    // Check Admin Credentials
    $stmt = $pdo->prepare("SELECT admin_id, admin_password FROM Admin WHERE admin_email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['admin_password'])) {
        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['admin_email'] = $email;
        header("Location: ../Admin-Panel/dashboard.php");
        exit();
    }

    // Check Employee Credentials if Admin Check Fails
    $stmt = $pdo->prepare("SELECT employee_id, employee_password FROM Employees WHERE employee_email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($employee && password_verify($password, $employee['employee_password'])) {
        $_SESSION['employee_id'] = $employee['employee_id'];
        $_SESSION['employee_email'] = $email;
        header("Location: ../Employee-Panel/employee-dashboard.php");
        exit();
    }

    $_SESSION['error'] = "Invalid email or password.";
} catch (PDOException $e) {
    $_SESSION['error'] = "Database error. Please try again later.";
    error_log("Login Error: " . $e->getMessage());
}

header("Location: ../login-form/login-form.php");
exit();