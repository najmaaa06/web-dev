<?php
require '../config.php';

// Helper function to update user details (in `userController.php`)
function updateUserDetails($user_id, $name, $email, $address, $phone) {
    global $pdo;  // Use PDO connection

    $query = "UPDATE users SET name = ?, email = ?, address = ?, phone = ? WHERE id = ?";
    $stmt = $pdo->prepare($query);  // Prepare query using PDO
    $stmt->execute([$name, $email, $address, $phone, $user_id]);  // Execute with parameters as an array
}


function getUserDetails($userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getOrderHistory($userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getUserLoyaltyPoints($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT loyalty_points FROM users WHERE id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['loyalty_points'] ?? 0; // Default to 0 if no loyalty points found
}


// Function to get order history for a user
 {
    // Create a connection to your database (update credentials as needed)
    $conn = new mysqli('localhost', 'root', '', 'tiny_clothes');
    
    // Check if the connection is successful
    if ($conn->connect_error) {
        die("Connfunction getOrderHistory($user_id)ection failed: " . $conn->connect_error);
    }

    // Prepare the SQL query to get the user's orders
    $sql = "SELECT * FROM orders WHERE id = ? ORDER BY order_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);  // 'i' denotes integer type for user_id
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();
    $orders = [];

    // Fetch all the orders
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    // Close the connection
    $stmt->close();
    $conn->close();

    // Return the order history
    return $orders;
}

?>
