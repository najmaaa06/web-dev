<?php
session_start();
require '../controllers/userController.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['order_id'])) {
    header('Location: login.php');
    exit;
}

$order_id = $_GET['order_id'];
$user_id = $_SESSION['user_id'];

// Function to fetch order details
function getOrderDetails($order_id, $user_id) {
    // Create a connection to your database (update credentials as needed)
    $conn = new mysqli('localhost', 'root', '', 'your_database_name');
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to fetch order details
    $sql = "SELECT * FROM orders WHERE order_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $order_id, $user_id); // 'ii' denotes two integer parameters
    $stmt->execute();

    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    $stmt->close();
    $conn->close();

    return $order;
}

$order = getOrderDetails($order_id, $user_id); // Fetch the specific order details

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
</head>
<body>

    <h2>Order Details</h2>

    <?php if ($order): ?>
        <p>Order ID: <?php echo $order['order_id']; ?></p>
        <p>Date: <?php echo date('Y-m-d H:i', strtotime($order['order_date'])); ?></p>
        <p>Status: <?php echo $order['status']; ?></p>
        <p>Total Amount: $<?php echo number_format($order['total_amount'], 2); ?></p>
        <p>Shipping Address: <?php echo $order['shipping_address']; ?></p>
        <p>Payment Method: <?php echo $order['payment_method']; ?></p>
        <!-- Add more order details as necessary -->
    <?php else: ?>
        <p>Order not found or you don't have permission to view it.</p>
    <?php endif; ?>

</body>
</html>
