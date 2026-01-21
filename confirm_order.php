<?php
session_start();
include 'db.php';

// Check if user is logged in

  if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

    $user_id = $_SESSION['user_id'];

// Get all items from user's cart
$sql_cart = "
    SELECT c.product_id, c.quantity, p.price FROM cart c
    JOIN product p ON c.product_id = p.id
    WHERE c.user_id = $user_id
";
$cart_result = mysqli_query($conn, $sql_cart);

$total_price = 0;
$cart_items = [];

// Loop through cart items and calculate total price
while ($item = mysqli_fetch_assoc($cart_result)) {
    $cart_items[] = $item;
    $total_price += $item['quantity'] * $item['price']; // Add item total
}

// Create a new order
$sql_order = "INSERT INTO orders (user_id, total_price) VALUES ($user_id, $total_price)";
mysqli_query($conn, $sql_order);

$order_id = mysqli_insert_id($conn); 
// Get the last inserted order ID

// Insert each cart item into order_items table
foreach ($cart_items as $item) {
    $product_id = $item['product_id'];
    $quantity = $item['quantity'];
    $price = $item['price'];
    $total = $quantity * $price;

    mysqli_query($conn,
        "INSERT INTO order_items (order_id, product_id, quantity, price, total)
         VALUES ($order_id, $product_id, $quantity, $price, $total)"
    );
}

// Clear the cart after order is placed
mysqli_query($conn, "DELETE FROM cart WHERE user_id = $user_id");

// Redirect to order success page
header("Location: order_success.php");
exit();
?>
