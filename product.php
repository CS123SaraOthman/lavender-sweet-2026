<?php
//session_start();
include 'db.php';
include 'header.php'; 

$type = $_GET['type'] ?? 'all';
$flavor = $_GET['flavor'] ?? 'all';

$sql = "SELECT * FROM product WHERE 1=1";
if($type !== 'all') $sql .= " AND type='$type'";
if($flavor !== 'all') $sql .= " AND flavor='$flavor'";
$result = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <link rel="stylesheet" href="style-to-product.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&family=Pacifico&display=swap" rel="stylesheet">
</head>
<body>
<h1>Products</h1>

<div class="filters">
    <form method="GET">
        <label>type:</label>
        <select name="type" onchange="this.form.submit()">
            <option value="all" <?= $type=='all'?'selected':'' ?>>ALL</option>

            <!--إIf the current $type = gift

               Add the word "selected"

                So that the option remains selected after the refresh-->
            <option value="gift" <?= $type=='gift'?'selected':'' ?>>Gift</option>
            <option value="family" <?= $type=='family'?'selected':'' ?>>Family</option>
            <option value="single" <?= $type=='single'?'selected':'' ?>>Single</option>
        </select>

        <label>flavor:</label>
        <select name="flavor" onchange="this.form.submit()">
            <option value="all" <?= $flavor=='all'?'selected':'' ?>>ALL</option>
            <option value="dark" <?= $flavor=='dark'?'selected':'' ?>>Dark</option>
            <option value="milk" <?= $flavor=='milk'?'selected':'' ?>>Milk</option>
            <option value="white" <?= $flavor=='white'?'selected':'' ?>>White</option>
        </select>
    </form>
</div>

<div class="products-grid"><!--In order for the products to appear next to each other in an organized manner.-->
<?php
if(count($products) == 0){
    echo "<p>لا يوجد منتجات مطابقة للفلتر.</p>";
} else {
    foreach($products as $p){
        echo "<div class='product-card' onclick=\"location.href='product-details.php?id={$p['id']}'\">
                <img src='{$p['img']}'>
                <h3>{$p['name']}</h3>
                <p> price: $ {$p['price']}</p>
              </div>";
    }
}
?>
</div>

<?php include 'footer.php'; ?>
</body>
