
<div class="cart-container">

<?php
include 'header.php';
include 'db.php';


 ?>
 <body class="<?php echo !isset($_SESSION['user_id']) ? 'not-logged-in' : ''; ?>">

    <link rel="stylesheet" href="cart_style.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php
if(!isset($_SESSION['user_id'])){
    echo "  <div class='login-box'>
        <p>Please log in to view your cart</p>
        <a href='login.php' class='login-btn'>Log In</a>
    </div>
    ";
    exit;
}

$user_id = $_SESSION['user_id'];
if(isset($_POST['remove_id'])){
    /*intval== return int */
    $id = intval($_POST['remove_id']);
    $conn->query("DELETE FROM cart WHERE user_id=$user_id AND product_id=$id");
    echo "done";
    exit;
}
if(isset($_POST['decrease_id'])){
    $pid = intval($_POST['decrease_id']);

    // Get current quantity
    $q = $conn->query("SELECT quantity FROM cart WHERE user_id=$user_id AND product_id=$pid");
    $row = $q->fetch_assoc();
    $qty = $row['quantity'];

    if($qty > 1){
        // reduce quantity
        $conn->query("UPDATE cart SET quantity = quantity - 1 WHERE user_id=$user_id AND product_id=$pid");
    } else {
        // delete item if qty becomes zero
        $conn->query("DELETE FROM cart WHERE user_id=$user_id AND product_id=$pid");
    }

    echo "done";
    exit;
}

if(isset($_POST['increase_id'])){
    $pid = intval($_POST['increase_id']);

    $conn->query("UPDATE cart SET quantity = quantity + 1 WHERE user_id=$user_id AND product_id=$pid");

    echo "done";
    exit;
}


if(isset($_POST['clear_cart'])){
$conn->query("DELETE FROM cart WHERE user_id=$user_id");
    echo "done";
    exit;
}

$query = "SELECT c.product_id, c.quantity, p.name, p.type, p.flavor, p.img, p.description, p.price
          FROM cart c 
          JOIN product p ON c.product_id = p.id
          WHERE c.user_id = $user_id";

$result = $conn->query($query);
?>

<h2 class="title">🛒 Shopping Cart</h2>

<?php if($result->num_rows == 0): ?>
<p class="empty">Your cart is empty</p>
<?php else: ?>
<table class="cart-table">
    <tr>
        <th>Remove</th>
        <th>Product</th>
        <th>Type</th>
        <th>Flavor</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
    </tr>

<?php
$grand_total = 0;
while($row = $result->fetch_assoc()):
    $total = $row['quantity'] * $row['price'];
    $grand_total += $total;


?>
<tr>
    <td><button class="remove-btn" onclick="removeItem(<?= $row['product_id'] ?>)">Remove</button></td>
    <td>
        <img src="<?= $row['img'] ?>" alt="<?= $row['name'] ?>" class="cart-img"><br>
        <?= $row['name'] ?><br>
    </td>
    <td><?= $row['type'] ?></td>
    <td><?= $row['flavor'] ?></td>
    <td>$<?= $row['price'] ?></td>
   <td class="qty-box">
    <button class="plus-btn" onclick="increaseQty(<?= $row['product_id'] ?>)">+</button>
    <span class="qty-number"><?= $row['quantity'] ?></span>
    <button class="minus-btn" onclick="decreaseQty(<?= $row['product_id'] ?>)">-</button>
</td>


    <td>$<?= $total ?></td>
</tr>
<?php endwhile; ?>
</table>

<div class="total-box">Grand Total: <strong>$<?= $grand_total ?></strong></div>

<button class="btn-clear" onclick="clearCart()">Clear Cart</button>
<a href="checkout.php" class="btn-pay">Proceed to Checkout</a>

<script>
function removeItem(id){
    fetch('cart.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'remove_id=' + id
    }).then(() => location.reload());
}

function clearCart(){
    fetch('cart.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'clear_cart=1'
    }).then(() => location.reload());
}
function decreaseQty(id){
    fetch('cart.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'decrease_id=' + id
    }).then(() => location.reload());

}
function increaseQty(id){
    fetch('cart.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'increase_id=' + id
    }).then(() => location.reload());
}

</script>
<?php endif; ?>
</div>