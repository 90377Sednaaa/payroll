<?php
session_start();

// If the admin is not logged in, redirect to login
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login-form/login-form.php");
    exit();
}

require 'dbhc.inc.php';

// Add Schedule
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['edit-schedule-id']) && isset($_POST['sched_name'], $_POST['time_in'], $_POST['time_out'])) {
    $scheduleName = trim($_POST['sched_name']);
    $timeIn = $_POST['time_in'];
    $timeOut = $_POST['time_out'];

    try {
        $stmt = $pdo->prepare("INSERT INTO Schedules (schedule_name, start_time, end_time) VALUES (:name, :in_time, :out_time)");
        $stmt->bindParam(':name', $scheduleName);
        $stmt->bindParam(':in_time', $timeIn);
        $stmt->bindParam(':out_time', $timeOut);
        $stmt->execute();
        $_SESSION['success'] = "Schedule added successfully!";
        header("Location: ../Admin-Panel/schedules.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error adding schedule: " . $e->getMessage();
        header("Location: ../Admin-Panel/schedules.php");
        exit();
    }
}

// Edit Schedule
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit-schedule-id'], $_POST['sched_name'], $_POST['time_in'], $_POST['time_out'])) {
    $scheduleId = (int)$_POST['edit-schedule-id'];
    $scheduleName = trim($_POST['sched_name']);
    $timeIn = $_POST['time_in'];
    $timeOut = $_POST['time_out'];

    try {
        $stmt = $pdo->prepare("UPDATE Schedules SET schedule_name = :name, start_time = :in_time, end_time = :out_time WHERE schedule_id = :id");
        $stmt->bindParam(':id', $scheduleId);
        $stmt->bindParam(':name', $scheduleName);
        $stmt->bindParam(':in_time', $timeIn);
        $stmt->bindParam(':out_time', $timeOut);
        $stmt->execute();
        $_SESSION['success'] = "Schedule updated successfully!";
        header("Location: ../Admin-Panel/schedules.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error updating schedule: " . $e->getMessage();
        header("Location: ../Admin-Panel/schedules.php");
        exit();
    }
}

// Delete Schedule
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete-id'])) {
    $scheduleId = (int)$_GET['delete-id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM Schedules WHERE schedule_id = :id");
        $stmt->bindParam(':id', $scheduleId);
        $stmt->execute();
        $_SESSION['success'] = "Schedule deleted successfully!";
        header("Location: ../Admin-Panel/schedules.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error deleting schedule: " . $e->getMessage();
        header("Location: ../Admin-Panel/schedules.php");
        exit();
    }
}