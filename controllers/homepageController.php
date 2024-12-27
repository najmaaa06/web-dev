<?php
require '../config.php';

function getFeaturedProducts() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM products WHERE is_featured = TRUE");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getPromotions() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM promotions WHERE valid_until >= CURDATE()");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
