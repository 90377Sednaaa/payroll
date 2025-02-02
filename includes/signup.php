<?php
// Include the database connection
require 'dbhc.inc.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input (basic validation)
    if (empty($name) || empty($email) || empty($password)) {
        die("All fields are required.");
    }

    // Check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Check for duplicate email in the Admin table
    try {
        $stmt = $pdo->prepare("SELECT * FROM Admin WHERE admin_email = :email");
        $stmt->execute(['email' => $email]);
        if ($stmt->rowCount() > 0) {
            // Redirect back to the signup page with an error message
            header("Location: ../index.php?error=duplicate_email");
            exit();
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new admin into the Admin table
    try {
        $stmt = $pdo->prepare("INSERT INTO Admin (admin_name, admin_email, admin_password) VALUES (:name, :email, :password)");
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ]);

        // Redirect to a success page or login page
        header("Location: /payroll/login-form/login-form.php?signup=success");
        exit();
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    // Redirect back to the signup page if the form is not submitted
    header("Location: ../index.php");
    exit();
}
