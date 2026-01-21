<?php
include 'db.php';
include 'header.php';

// Get product ID from URL safely
$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    echo "Product not found";
    exit;
}

// Fetch product from database
$sql = "SELECT * FROM product WHERE id = $id";
$result = mysqli_query($conn, $sql);
$p = mysqli_fetch_assoc($result);

if (!$p) {
    echo "Product not found";
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title><?= $p['name'] ?></title>
    <link rel="stylesheet" href="product-details.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<div class="product-details">

    <!-- Product Image -->
    <img src="<?= $p['img'] ?>" alt="Product Image">

    <div class="info">

        <!-- Product Name -->
        <h1><?= $p['name'] ?></h1>

        <!-- Product Description -->
        <p><?= $p['description'] ?></p>

        <!-- Product Price -->
        <p>Price: $<?= $p['price'] ?></p>

        <!-- Add to Cart BUTTON -->
        <!-- This submits the form to add_to_cart.php -->
        <form action="add_to_cart.php" method="POST">
            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
            
               
<button type="button" onclick="addToCart(<?= $p['id'] ?>)">ADD TO CART</button>

<p id="msg" style="color: green; margin-top:10px;">
    
</p>

        </form>

        <!-- Back to products -->
        <a href="product.php?type=all&flavor=all" class="back-btn">Back to Products</a>

    </div>
</div>

<?php include 'footer.php'; ?>
<script>
function addToCart(id){
    fetch("add_to_cart.php", {
        method: "POST",


/*Additional information we send to the server with the request.
data type &*/

        headers: {"Content-Type": "application/x-www-form-urlencoded"},/*this link for the normal form fram*/


        /*The content of the request that we send to the server.*/
        body: "id=" + id
    })




    .then(res => res.text())
    /*Converts the response to text.*/

    .then(res => {
        if(res === "login_required"){
            alert("الرجاء تسجيل الدخول لإضافة منتجات للسلة");
        } else {
            document.getElementById("msg").innerHTML = "ADDED✔️";
        }
    });
}
</script>


</body>
</html>
