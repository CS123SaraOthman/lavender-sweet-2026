<?php
session_start();
include 'db.php'; // Database connection

// ========================
// Fetch products
// ========================
$products = $conn->query("SELECT * FROM product ORDER BY id ASC");

// ========================
// Fetch orders
// ========================
$orders = $conn->query("
    SELECT o.id AS order_id, u.name AS user_name, o.total_price, o.payment_status, o.order_status
    FROM orders o
    JOIN users u ON o.user_id = u.id
    ORDER BY o.id DESC
");

// ========================
// Fetch cart data
// ========================
$carts = $conn->query("
    SELECT c.id AS cart_id, u.name AS user_name, p.name AS product_name, c.quantity
    FROM cart c
    JOIN users u ON c.user_id = u.id
    JOIN product p ON c.product_id = p.id
    ORDER BY c.id DESC
");

// ========================
// Update order status via AJAX
// ========================
if(isset($_POST['ajax_update'])){
    header('Content-Type: application/json'); // Tell JS we return JSON

    // Sanitize input
    $id = intval($_POST['id']); 
    $status = $conn->real_escape_string($_POST['status']);

    // Update order
    $sql = "UPDATE orders SET order_status='$status' WHERE id=$id";

    if($conn->query($sql)){
        echo json_encode(['status'=>'success']);
    } else {
        http_response_code(500);
        echo json_encode(['status'=>'error','msg'=>$conn->error]);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Control Panel - Chocolate Shop</title>
    <link rel="stylesheet" href="Control Panel.css">
</head>
<body>

<h1>Control Panel - Chocolate Shop 💜</h1>

<!-- ======================== -->
<!-- Products Section -->
<!-- ======================== -->
<h2>Products</h2>
<a href="add_product.php" class="button">Add New Product</a>
<table>
    <tr>
        <th>ID</th><th>Name</th><th>Price</th><th>Image</th>
        <th>Description</th><th>Flavor</th><th>Type</th><th>Actions</th>
    </tr>
    <?php while($p = $products->fetch_assoc()): ?>
    <tr>
        <td><?= $p['id'] ?></td>
        <td><?= $p['name'] ?></td>
        <td><?= $p['price'] ?> $</td>
        <td><img src="<?= $p['img'] ?>" width="50"></td>
        

        <!-- to string-->

        <td><?= substr($p['description'],0,30).'...' ?></td>
        <td><?= $p['flavor'] ?></td>
        <td><?= $p['type'] ?></td>
        <td>
            <a href="edit_product.php?id=<?= $p['id'] ?>" class="button edit">Edit</a>
            <a href="delete_product.php?id=<?= $p['id'] ?>" class="button delete">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<!-- ======================== -->
<!-- Orders Section -->
<!-- ======================== -->
<h2>Orders</h2>
<table>
    <tr>
        <th>Order ID</th>
        <th>User Name</th>
        <th>Total Price</th>
        <th>Payment Status</th>
        <th>Order Status</th>
        <th>Actions</th>
    </tr>
    <?php while($o = $orders->fetch_assoc()): ?>
    <tr>
        <td><?= $o['order_id'] ?></td>
        <td><?= $o['user_name'] ?></td>
        <td><?= $o['total_price'] ?> $</td>
        <td><?= $o['payment_status'] ?></td>
        <td>


            <!-- Dropdown to change order status -->



            <!--to store the order number within the dropdown list-->
            <select class="status-dropdown" data-order-id="<?= $o['order_id'] ?>">
                <option value="Pending"   <?= $o['order_status']=='Pending'?'selected':'' ?>>Pending</option>
                <option value="Completed" <?= $o['order_status']=='Completed'?'selected':'' ?>>Completed</option>
                <option value="Shipped"   <?= $o['order_status']=='Shipped'?'selected':'' ?>>Shipped</option>
            </select>
            <span class="status-msg"></span>


        </td>
        <td>
            <form action="view_order.php" method="get" style="display:inline;">
                <input type="hidden" name="id" value="<?= $o['order_id'] ?>">
                <button type="submit" class="button view">View</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<!-- ======================== -->
<!-- AJAX Script -->
<!-- ======================== -->
<!-- JavaScript library to AJAX-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    /*this code does not start until all elements on the page are present.*/
$(document).ready(function(){
/*Take the value that is in the Dropdown*/

    $('.status-dropdown').change(function(){
        var orderId = $(this).data('order-id');   // Get order ID
        var status = $(this).val();               // Get selected status
        var msgSpan = $(this).siblings('.status-msg'); // Span for messages

        // Send AJAX request to update order
        $.post('Control Panel.php', {ajax_update:1, id:orderId, status:status}, function(response){
            if(response.status === 'success'){
                msgSpan.text('Updated').css('color','green').show().fadeOut(2000);//2secand 
            } else {
                msgSpan.text('Error').css('color').show().fadeOut(2000);
            }
        }, 'json').fail(function(xhr){
            msgSpan.text('AJAX Error: '+xhr.responseText).css('color','red').show().fadeOut(2000);
        });
    });
});
</script>
      <a href="http://localhost/mywebsite">  <img src="logo1.jpeg" alt="Lavender Sweet Logo" class="footer-logo"><a/>
</body>
</html>
