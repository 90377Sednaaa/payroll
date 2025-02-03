<?php
session_start();

// Check if the user is an employee
if (!isset($_SESSION['employee_id'])) {
    header("Location: ../login-form/login-form.php");
    exit();
}

require 'dbhc.inc.php';
$employeeId = $_SESSION['employee_id'];
$currentDate = date('Y-m-d');

// Fetch existing attendance for today
try {
    $stmt = $pdo->prepare("SELECT * FROM Attendance WHERE employee_id = :employee_id AND attendance_date = :date");
    $stmt->bindParam(':employee_id', $employeeId);
    $stmt->bindParam(':date', $currentDate);
    $stmt->execute();
    $attendance = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error'] = "Error fetching attendance data: " . $e->getMessage();
    header("Location: ../Employee-Panel/attendance.php");
    exit();
}

// Clock-In Functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'time_in') {
    if ($attendance) {
        // Check if already clocked in today
        if ($attendance['time_in'] && $attendance['time_out'] === null) {
            $_SESSION['error'] = "You have already clocked in today!";
        } elseif ($attendance['time_in'] && $attendance['time_out'] !== null) {
            $_SESSION['error'] = "You have already clocked in and out today!";
        } else {
            $currentTime = date('H:i:s');
            try {
                $stmt = $pdo->prepare("INSERT INTO Attendance (employee_id, time_in, attendance_date) VALUES (:employee_id, :time_in, :date)");
                $stmt->bindParam(':employee_id', $employeeId);
                $stmt->bindParam(':time_in', $currentTime);
                $stmt->bindParam(':date', $currentDate);
                $stmt->execute();
                $_SESSION['success'] = "Timed in successfully!";
            } catch (PDOException $e) {
                $_SESSION['error'] = "Error clocking in: " . $e->getMessage();
            }
        }
    } else {
        $currentTime = date('H:i:s');
        try {
            $stmt = $pdo->prepare("INSERT INTO Attendance (employee_id, time_in, attendance_date) VALUES (:employee_id, :time_in, :date)");
            $stmt->bindParam(':employee_id', $employeeId);
            $stmt->bindParam(':time_in', $currentTime);
            $stmt->bindParam(':date', $currentDate);
            $stmt->execute();
            $_SESSION['success'] = "Timed in successfully!";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error clocking in: " . $e->getMessage();
        }
    }
    header("Location: ../Employee-Panel/attendance.php");
    exit();
}

// Clock-Out Functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'time_out') {
    if ($attendance) {
        if ($attendance['time_out'] !== null) {
            $_SESSION['error'] = "You have already clocked out today!";
        } else {
            $currentTime = date('H:i:s');
            try {
                $stmt = $pdo->prepare("UPDATE Attendance SET time_out = :time_out WHERE attendance_id = :id");
                $stmt->bindParam(':id', $attendance['attendance_id']);
                $stmt->bindParam(':time_out', $currentTime);
                $stmt->execute();
                $_SESSION['success'] = "Timed out successfully!";
            } catch (PDOException $e) {
                $_SESSION['error'] = "Error clocking out: " . $e->getMessage();
            }
        }
    } else {
        $_SESSION['error'] = "You need to clock in before clocking out!";
    }
    header("Location: ../Employee-Panel/attendance.php");
    exit();
}