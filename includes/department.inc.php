<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login-form/login-form.php");
    exit();
}

require 'dbhc.inc.php';

// Add Department
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['edit-department-id']) && isset($_POST['dep_name'])) {
    $depName = trim($_POST['dep_name']);

    try {
        $stmt = $pdo->prepare("INSERT INTO Departments (department_name) VALUES (:name)");
        $stmt->bindParam(':name', $depName);
        $stmt->execute();
        $_SESSION['success'] = "Department added successfully!";
        header("Location: ../Admin-Panel/department.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error adding department: " . $e->getMessage();
        header("Location: ../Admin-Panel/department.php");
        exit();
    }
}

// Edit Department
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit-department-id'], $_POST['dep_name'])) {
    $depId = (int)$_POST['edit-department-id'];
    $depName = trim($_POST['dep_name']);

    try {
        $stmt = $pdo->prepare("UPDATE Departments SET department_name = :name WHERE department_id = :id");
        $stmt->bindParam(':id', $depId);
        $stmt->bindParam(':name', $depName);
        $stmt->execute();
        $_SESSION['success'] = "Department updated successfully!";
        header("Location: ../Admin-Panel/department.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error updating department: " . $e->getMessage();
        header("Location: ../Admin-Panel/department.php");
        exit();
    }
}

// Delete Department
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete-id'])) {
    $depId = (int)$_GET['delete-id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM Departments WHERE department_id = :id");
        $stmt->bindParam(':id', $depId);
        $stmt->execute();
        $_SESSION['success'] = "Department deleted successfully!";
        header("Location: ../Admin-Panel/department.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error deleting department: " . $e->getMessage();
        header("Location: ../Admin-Panel/department.php");
        exit();
    }
}