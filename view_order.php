<?php
include 'db.php';

$order_id = $_GET['id'];

$order = $conn->query("SELECT o.*, u.name as user_name, u.email 
                       FROM orders o 
                       JOIN users u ON o.user_id = u.id 
                       WHERE o.id = $order_id")->fetch_assoc();

//  (order_items)
$items = $conn->query("SELECT oi.*, p.name as name, p.price 
                       FROM order_items oi 
                       JOIN product p ON oi.id = p.id 
                       WHERE oi.order_id = $order_id");
?>
    <link rel="stylesheet" href="view_order.css">

<h1>Order #<?= $order['id'] ?> Details</h1>
<p>User: <?= $order['user_name'] ?> (<?= $order['email'] ?>)</p>
<p>Total Price: <?= $order['total_price'] ?> $</p>
<p>Status: <?= $order['order_status'] ?></p>

<h2>Items</h2>
<table>
    <tr>
        <th>Product Name</th>
        <th>Price</th>
        <th>Quantity</th>
    </tr>
    <?php while($item = $items->fetch_assoc()): ?>
    <tr>
        <td><?= $item['name'] ?></td>
        <td><?= $item['price'] ?> $</td>
        <td><?= $item['quantity'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>
