<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';
?>


<link rel="stylesheet" href="header_style.css">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">


<section class="b">
    <nav class="mn">
        <a href="index.php">HOME</a>
        <a href="product.php?type=all&flavor=all">PRODUCTS</a>
        <a href="about.php">ABOUT US</a>
        <a href="contact.php">CONTACT</a>
        <a href="cart.php">CART</a>

        <?php 
      if(isset($_SESSION['user_id'])): ?>
            <a href="logout.php">Log Out</a>

        <?php else: ?>
            <a href="login.php">Log In</a>
        <?php endif; ?>
    </nav>
</section>
