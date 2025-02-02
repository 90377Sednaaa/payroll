<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login-form/login-form.php");
    exit();
}

// Database connection
require 'dbhc.inc.php';

// Add Deduction
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['edit-deduction-id']) && isset($_POST['deduc_name'], $_POST['deduc_val'])) {
    $deductionName = trim($_POST['deduc_name']);
    $deductionValue = $_POST['deduc_val'];

    try {
        $stmt = $pdo->prepare("INSERT INTO Deductions (deduction_name, deduction_value) VALUES (:name, :value)");
        $stmt->bindParam(':name', $deductionName);
        $stmt->bindParam(':value', $deductionValue);
        $stmt->execute();
        $_SESSION['success'] = "Deduction added successfully!";
        header("Location: ../Admin-Panel/deductions.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error adding deduction: " . $e->getMessage();
        header("Location: ../Admin-Panel/deductions.php");
        exit();
    }
}

// Edit Deduction
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit-deduction-id'], $_POST['deduc_name'], $_POST['deduc_val'])) {
    $deductionId = (int)$_POST['edit-deduction-id'];
    $deductionName = trim($_POST['deduc_name']);
    $deductionValue = $_POST['deduc_val'];

    try {
        $stmt = $pdo->prepare("UPDATE Deductions SET deduction_name = :name, deduction_value = :value WHERE deduction_id = :id");
        $stmt->bindParam(':id', $deductionId);
        $stmt->bindParam(':name', $deductionName);
        $stmt->bindParam(':value', $deductionValue);
        $stmt->execute();
        $_SESSION['success'] = "Deduction updated successfully!";
        header("Location: ../Admin-Panel/deductions.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error updating deduction: " . $e->getMessage();
        header("Location: ../Admin-Panel/deductions.php");
        exit();
    }
}

// Delete Deduction
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete-id'])) {
    $deductionId = (int)$_GET['delete-id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM Deductions WHERE deduction_id = :id");
        $stmt->bindParam(':id', $deductionId);
        $stmt->execute();
        $_SESSION['success'] = "Deduction deleted successfully!";
        header("Location: ../Admin-Panel/deductions.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error deleting deduction: " . $e->getMessage();
        header("Location: ../Admin-Panel/deductions.php");
        exit();
    }
}