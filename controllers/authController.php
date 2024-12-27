<?php
require '../config.php';

function register($name, $email, $password) {
    global $pdo;

    // Validate input fields
    if (empty($name) || empty($email) || empty($password)) {
        return 'All fields are required.';
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Invalid email format.';
    }

    // Check if email already exists in the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        return 'This email is already taken.';
    }

    // Hash the password before storing
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user into the database
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
    if ($stmt->execute([$name, $email, $passwordHash])) {
        return 'Registration successful!';
    } else {
        return 'An error occurred during registration. Please try again.';
    }
}

function login($email, $password) {
    global $pdo;

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Invalid email format.';
    }

    // Check if the user exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        // Start the session and set the user session data
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];  // Optionally store the user's name
        return true;
    }

    return 'Invalid email or password.';
}
?>
