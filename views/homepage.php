<?php
require 'controllers/homepageController.php';

$featuredProducts = getFeaturedProducts();
$promotions = getPromotions();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Homepage</title>
</head>
<body>
    <h1>Featured Products</h1>
    <ul>
        <?php foreach ($featuredProducts as $product): ?>
            <li><?= $product['name'] ?> - RM<?= $product['price'] ?></li>
        <?php endforeach; ?>
    </ul>

    <h1>Current Promotions</h1>
    <ul>
        <?php foreach ($promotions as $promo): ?>
            <li><?= $promo['title'] ?> - <?= $promo['description'] ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
