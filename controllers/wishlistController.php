<?php
require_once '../config.php'; // Adjust path if necessary

function getWishlist($user_id) {
    global $pdo; // Use the $pdo connection from config.php

    $query = "SELECT w.wishlist_id, w.product_id, p.name, p.price, p.image 
              FROM wishlist w 
              INNER JOIN products p ON w.product_id = p.product_id 
              WHERE w.id = :user_id"; // Updated column to 'id'
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function addToWishlist($user_id, $product_id) {
    global $pdo;

    $query = "INSERT INTO wishlist (user_id, product_id) VALUES (:user_id, :product_id)";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':product_id', $product_id, PDO::PARAM_INT);

    $stmt->execute();
    return $pdo->lastInsertId(); // Return the inserted ID if needed
}

function removeFromWishlist($user_id, $product_id) {
    global $pdo; // Use the PDO connection from your config.php

    // Prepare the SQL query to delete the item from the wishlist
    $query = "DELETE FROM wishlist WHERE id = :user_id AND product_id = :product_id";
    $stmt = $pdo->prepare($query);

    // Bind the parameters
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':product_id', $product_id, PDO::PARAM_INT);

    // Execute the query and check if the delete was successful
    return $stmt->execute();
}

?>
