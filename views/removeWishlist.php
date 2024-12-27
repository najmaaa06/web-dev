<?php
session_start();
require '../controllers/wishlistController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'], $_POST['product_id'])) {
        $user_id = $_SESSION['user_id'];
        $product_id = $_POST['product_id'];

        if (removeFromWishlist($user_id, $product_id)) {
            header('Location: dashboard2.php?wishlist=success');
            exit;
        }
    }
}

header('Location: dashboard2.php?wishlist=error');
exit;
