<?php
session_start();
require '../controllers/userController.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user = getUserDetails($_SESSION['user_id']);
$orders = getOrderHistory($_SESSION['user_id']); // Fetch orders
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ecommerce Dashboard</title>
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
    />
    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Chilanka&family=Montserrat&display=swap" rel="stylesheet">

  </head>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Chilanka&family=Montserrat&display=swap');
    :root {
  --body-font: 'Chilanka', cursive;
  --heading-font: 'Chilanka', cursive;
  --secondary-font: 'Montserrat', sans-serif;
}

* {
  margin: 0;
  padding: 0;
  transition: 0.5s all;
  box-sizing: border-box;
  text-decoration: none;
  border: none;
  outline: none;
  list-style: none;
}

html,
body {
  width: 100%;
  height: 100%;
}

body {
  font-family: var(--body-font);
  display: flex;
  overflow: hidden;
}

h1, h2, h3, h4, h5, h6 {
  font-family: var(--heading-font); /* Applying heading font */
}

button {
  cursor: pointer;
}

.sidebar {
  width: 250px;
  background: #F2E1C1;
  border-radius: 0 30px 30px 0;
  padding: 30px;
}

#mobile-menu {
  visibility: hidden;
  opacity: 0;
  position: absolute;
  z-index: -8888;
}

#mobile-menu:checked + .sidebar {
  transform: translate(280px);
  z-index: 1;
}

#mobile-menu:checked + .sidebar + #mmenu {
  transform: translate(50px);
  color: #000;
}

#mobile-menu:checked + .sidebar + #mmenu i:first-child {
  visibility: hidden;
  position: absolute;
  opacity: 0;
  top: -50%;
}

#mobile-menu:checked + .sidebar + #mmenu i:last-child {
  position: absolute;
  visibility: visible;
  opacity: 1;
  top: unset;
}

#mmenu i:last-child {
  visibility: hidden;
  opacity: 0;
  position: absolute;
  top: -50%;
}

#mmenu {
  padding: 15px;
  opacity: 0;
  position: absolute;
  font-size: 22px;
}

.sidebar .logo {
  display: flex;
  justify-content: center;
  align-items: center;
  color: #000;
}

.main-logo img {
  max-width: 100%; /* Makes sure the image does not overflow its container */
  height: auto; /* Maintains the aspect ratio */
}


.sidebar .logo i,
.sidebar .logo h2 {
  font-size: 24px;
  padding: 4px;
}

.sidebar .menu {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 70px 0;
}

.sidebar .menu ul li {
  font-family: var(--secondary-font); /* Applying secondary font */
  padding: 13px 15px;
  padding-right: 30px;
  letter-spacing: 0.05px;
  margin: 15px 0;
  color: #000;
  font-size: 15px;
  cursor: pointer;
}

.sidebar .menu ul li:first-child,
.sidebar .menu ul li:hover:not(:last-child) {
  background: rgba(255, 255, 255, 0.2);
  border-radius: 10px;
}

.sidebar .menu ul li:last-child {
  position: absolute;
  bottom: 0;
}

.sidebar .menu ul li i {
  margin-right: 25px;
}

.content {
  flex: 1;
  padding: 35px 45px;
  overflow-x: overlay;
}

.content .top {
  display: flex;
  justify-content: space-between;
}

.content .top .search {
  position: relative;
}

.content .top .search input {
  background: #ddd9f2;
  padding: 10px 150px;
  border-radius: 6px;
  font-weight: 600;
  padding-left: 15px;
}

.content .top .search i {
  position: absolute;
  right: 10px;
  top: 25%;
  color: #000;
  cursor: pointer;
}

.content .top .user i {
  padding: 0 10px;
  color: #DEAD6F;
  font-size: 20px;
  cursor: pointer;
}

.content .categories {
  width: 100%;
  display: flex;
}

.content #heading {
  padding-top: 30px;
  color: #DEAD6F;
}

.content .categories .category {
  width: 33.3%;
  color: #fff;
  background: #DEAD6F;
  margin-right: 15px;
  border-radius: 10px;
  padding: 14px;
}

.content .categories .category img {
  padding: 5px 15px;
  float: right;
  padding-bottom: 0;
  opacity: 0.6;
}

.content .all-products {
  width: 100%;
}

.content .all-products .title {
  padding: 15px 0;
  color: #DEAD6F;
}

.content .products {
  width: 100%;
  display: flex;
}

.content .product {
  width: 33.3%;
  position: relative;
  margin: 5px 5px;
  padding: 15px;
  background: #f6f5fb;
  text-align: center;
}

.content .product:hover::before {
  content: "";
  position: absolute;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
  background: rgba(255, 255, 255, 0.6);
}

.content .product:hover .addbutton {
  visibility: visible;
  opacity: 1;
  bottom: 50%;
  transform: translate(-50%, -50%);
  transition: all 0.5s;
  left: 50%;
}

.addbutton {
  visibility: hidden;
  opacity: 0;
  position: absolute;
  transition: all 0.5s;
}

.addbutton button {
  padding: 5px 25px;
  color: #000;
  border-radius: 5px;
  background: #DEAD6F;
}

.content .product img {
  padding: 10px;
  width: 125px;
  height: 130px;
}

.content .product i {
  float: right;
  color: #b5b4ba;
}

.content .product .subtitle {
  display: flex;
  justify-content: space-between;
}

.content .product .price h1 {
  font-size: 20px;
}

/* Responsive */

@media (max-width: 768px) {
  .sidebar {
    margin-left: -295px;
  }

  .content {
    width: 100%;
    margin: 5px;
  }

  .sidebar + #mmenu {
    transform: translate(50px);
  }

  .content .top {
    flex-direction: column;
  }

  .content .search {
    padding-bottom: 25px;
  }

  #mmenu {
    opacity: 1;
    visibility: visible;
    z-index: 2;
    color: #000;
    position: relative;
  }

  .content .products {
    display: block;
  }

  .content .product {
    width: 100%;
  }

  .content .top .search input {
    padding: 10px 45px;
  }

  .content .top .search i {
    top: 16%;
  }

  .content .categories {
    display: block;
  }

  .content .categories .category {
    width: 100%;
    margin-top: 5px;
  }

  .content .categories .category img {
    display: none;
  }

  .user {
    display: flex;
  }
}

.order-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    font-family: var(--secondary-font);
}

.order-table th, .order-table td {
    border: 1px solid #ddd;
    padding: 12px 15px;
    text-align: center;
    font-size: 14px;
}

.order-table th {
    background-color: #DEAD6F; /* Matches the theme */
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 0.1em;
}

.order-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.order-table tr:nth-child(odd) {
    background-color: #fff;
}

.order-table tr:hover {
    background-color: #f2e1c1; /* Highlight on hover */
    cursor: pointer;
}

.order-table td {
    color: #333;
}

.order-table a {
    color: #DEAD6F;
    text-decoration: none;
    font-weight: bold;
}

.order-table a:hover {
    text-decoration: underline;
}


  </style>
  <body>
    <input type="checkbox" id="mobile-menu" />

    <div class="sidebar">
    <div class="col-sm-4 col-lg-3 text-center text-sm-start">
  <div class="main-logo">
    <a href="dashboard.php">
      <img src="../images/logo.png" alt="logo" class="img-fluid">
    </a>
  </div>
</div>

<div class="menu">
        <ul>
          <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="orderHistory.php"><i class="fa fa-box"></i> Order History</a></li> <!-- Changed from Categories to Order History -->
          <li><a href="wishlist.php"><i class="fa fa-heart"></i> Wishlist</a></li> <!-- Changed from Wallet to Wishlist -->
          <li><a href="#"><i class="fa fa-shopping-cart"></i> Cart</a></li>
          <li><a href="account.php"><i class="fa fa-user"></i> Account</a></li>
          <!--<li><i class="fa fa-cog"></i> Settings</li>-->
          <li><a href="logout.php"><i class="fa fa-sign-out-alt"></i> Sign Out</a></li>
        </ul>
      </div>

    </div>

    <label for="mobile-menu" id="mmenu">
      <i class="fa fa-bars"></i>
      <i class="fa fa-times"></i>
    </label>

    <div class="content">
        <!-- order history table go in here -->
        <h1 id="heading">Order History</h1>
      
      <?php if (count($orders) > 0): ?>
        <table class="order-table">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Date</th>
              <th>Status</th>
              <th>Total Amount</th>
              <th>Details</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orders as $order): ?>
              <tr>
                <td><?php echo $order['order_id']; ?></td>
                <td><?php echo date('Y-m-d H:i', strtotime($order['order_date'])); ?></td>
                <td><?php echo $order['status']; ?></td>
                <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                <td><a href="orderDetails.php?order_id=<?php echo $order['order_id']; ?>">View</a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p>No orders found.</p>
      <?php endif; ?>
    </div>
  </body>
</html>

