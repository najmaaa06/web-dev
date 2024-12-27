<?php
session_start();
require '../controllers/authController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form inputs
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validation: Check if any field is empty
    if (empty($name) || empty($email) || empty($password)) {
        $_SESSION['errorMessage'] = "Please fill in all fields.";
        header("Location: ../login.html"); // Redirect to login.html
        exit();
    }

    // Attempt registration
    if (register($name, $email, $password)) {
        $_SESSION['successMessage'] = "Registration successful! Please log in.";
        header("Location: ../login.html"); // Redirect to login.html
        exit();
    } else {
        $_SESSION['errorMessage'] = "Registration failed. Email may already be in use.";
        header("Location: ../login.html"); // Redirect to login.html
        exit();
    }
}
?>
