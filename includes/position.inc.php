<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login-form/login-form.php");
    exit();
}

// Database connection
require 'dbhc.inc.php';

// Fetch Departments for dropdown
try {
    $stmt = $pdo->query("SELECT * FROM Departments");
    $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error'] = "Error fetching departments: " . $e->getMessage();
    header("Location: ../Admin-Panel/position.php");
    exit();
}

// Fetch Positions with Department Names
try {
    $stmt = $pdo->query("SELECT p.*, d.department_name FROM Positions p JOIN Departments d ON p.department_id = d.department_id");
    $positions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error'] = "Error fetching positions: " . $e->getMessage();
    header("Location: ../Admin-Panel/position.php");
    exit();
}

// Add Position
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['edit-position-id']) && isset($_POST['pos_name'], $_POST['hourly_rate'], $_POST['department_id'])) {
    $posName = trim($_POST['pos_name']);
    $hourlyRate = $_POST['hourly_rate'];
    $departmentId = (int)$_POST['department_id'];

    try {
        $stmt = $pdo->prepare("INSERT INTO Positions (position_name, hourly_rate, department_id) VALUES (:name, :rate, :dep_id)");
        $stmt->bindParam(':name', $posName);
        $stmt->bindParam(':rate', $hourlyRate);
        $stmt->bindParam(':dep_id', $departmentId);
        $stmt->execute();
        $_SESSION['success'] = "Position added successfully!";
        header("Location: ../Admin-Panel/position.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error adding position: " . $e->getMessage();
        header("Location: ../Admin-Panel/position.php");
        exit();
    }
}

// Edit Position
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit-position-id'], $_POST['pos_name'], $_POST['hourly_rate'], $_POST['department_id'])) {
    $posId = (int)$_POST['edit-position-id'];
    $posName = trim($_POST['pos_name']);
    $hourlyRate = $_POST['hourly_rate'];
    $departmentId = (int)$_POST['department_id'];

    try {
        $stmt = $pdo->prepare("UPDATE Positions SET position_name = :name, hourly_rate = :rate, department_id = :dep_id WHERE position_id = :id");
        $stmt->bindParam(':id', $posId);
        $stmt->bindParam(':name', $posName);
        $stmt->bindParam(':rate', $hourlyRate);
        $stmt->bindParam(':dep_id', $departmentId);
        $stmt->execute();
        $_SESSION['success'] = "Position updated successfully!";
        header("Location: ../Admin-Panel/position.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error updating position: " . $e->getMessage();
        header("Location: ../Admin-Panel/position.php");
        exit();
    }
}

// Delete Position
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete-id'])) {
    $posId = (int)$_GET['delete-id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM Positions WHERE position_id = :id");
        $stmt->bindParam(':id', $posId);
        $stmt->execute();
        $_SESSION['success'] = "Position deleted successfully!";
        header("Location: ../Admin-Panel/position.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error deleting position: " . $e->getMessage();
        header("Location: ../Admin-Panel/position.php");
        exit();
    }
}