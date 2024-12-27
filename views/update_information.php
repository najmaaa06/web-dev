<?php
session_start();
require '../controllers/userController.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_user_info'])) {    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    // Update user details
    if (updateUserDetails($user_id, $name, $email, $address, $phone)) {
        echo "Information updated successfully!";
    } else {
        echo "Failed to update information.";
    }
}


?>
