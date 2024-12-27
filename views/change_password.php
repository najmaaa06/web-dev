<?php
session_start();
require '../controllers/userController.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        if (changePassword($user_id, $current_password, $new_password)) {
            echo "Password changed successfully!";
        } else {
            echo "Failed to change password.";
        }
    } else {
        echo "Passwords do not match.";
    }
}

// Function to change the password
function changePassword($user_id, $current_password, $new_password) {
    global $pdo;
    $sql = "SELECT password_hash FROM users WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    if ($user && password_verify($current_password, $user['password_hash'])) {
        $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        $update_sql = "UPDATE users SET password_hash = ? WHERE id = ?";
        $update_stmt = $pdo->prepare($update_sql);
        return $update_stmt->execute([$new_password_hash, $user_id]);
    }

    return false;
}
?>
