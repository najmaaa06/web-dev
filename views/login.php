<?php
require '../controllers/authController.php';

session_start();  // Start the session to access session variables

$errorMessage = '';

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the fields are empty
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $_SESSION['errorMessage'] = "Please fill in both fields.";  // Set error message
        header('Location: ../login.html');  // Redirect back to login page
        exit();  // Stop further script execution
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Call login function and check credentials
        if (login($email, $password)) {
            header('Location: dashboard.php');  // Redirect to user dashboard
            exit();  // Stop further script execution
        } else {
            $_SESSION['errorMessage'] = "Invalid email or password. Please try again.";  // Set error message
            header('Location: ../login.html');  // Redirect back to login page
            exit();  // Stop further script execution
        }
    }
}
?>


