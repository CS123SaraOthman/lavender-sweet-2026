<?php
session_start();
include 'db.php';
include 'header.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$user_id = $_SESSION['user_id'];

$sql = "SELECT cart.id AS cart_id, product.name, product.price, cart.quantity 
        FROM cart 
        JOIN product ON cart.product_id = product.id
        WHERE cart.user_id = $user_id";

$result = mysqli_query($conn, $sql);

$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
        <link rel="stylesheet" href="checkout_style.css">
        
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>

<h2>Your Order Summary</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Total</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) {
        $line_total = $row['price'] * $row['quantity'];
        $total += $line_total;
    ?>
    <tr>
        <td><?= $row['name'] ?></td>
        <td><?= $row['price'] ?></td>
        <td><?= $row['quantity'] ?></td>
        <td><?= $line_total ?></td>
    </tr>
    <?php } ?>
</table>

<h3>Total Price: <?= $total ?>$</h3>

<form method="POST" action="confirm_order.php">
    <button type="submit" name="confirm">Confirm Order</button>
</form>


</body>
</html>
