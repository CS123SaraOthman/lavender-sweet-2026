<?php
session_start();
include 'db.php'; // Database connection

$id = $_GET['id'] ?? 0;
$id = intval($id);

// Fetch product data
$stmt = $conn->prepare("SELECT * FROM product WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    die("Product not found!");
}

$errors = [];
$success = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $flavor = trim($_POST['flavor'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $img = $product['img']; // Keep old image by default

    // Handle image upload
    if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $img = $targetDir . basename($_FILES['img']['name']);
        move_uploaded_file($_FILES['img']['tmp_name'], $img);
    }

    // Validation
    if ($name === '' || $price === '' || $description === '' || $flavor === '' || $type === '') {
        $errors[] = "All fields are required.";
    }

    // Update product in database
    if (!$errors) {
        $stmt = $conn->prepare("UPDATE product SET name=?, price=?, img=?, description=?, flavor=?, type=? WHERE id=?");
        $stmt->bind_param("sdssssi", $name, $price, $img, $description, $flavor, $type, $id);
        if ($stmt->execute()) {
            $success = "Product updated successfully!";
            // Refresh product data
            $product['name'] = $name;
            $product['price'] = $price;
            $product['img'] = $img;
            $product['description'] = $description;
            $product['flavor'] = $flavor;
            $product['type'] = $type;
        } else {
            $errors[] = "Database error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product - Chocolate Shop</title>
    <link rel="stylesheet" href="Control Panel.css"> <!-- Reuse CSS -->
</head>
<body>
    <h1>Edit Product 💜</h1>

    <?php if ($errors): ?>
        <div style="color:red; text-align:center;">
            <?php foreach ($errors as $error) echo "<p>$error</p>"; ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div style="color:green; text-align:center;">
            <p><?= $success ?></p>
        </div>
    <?php endif; ?>



<!--enctype="multipart/form-data" → Important if the form contains uploaded files (images).-->
    <form action="" method="post" enctype="multipart/form-data" style="max-width:500px; margin:auto;">
        <label>Name:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required><br><br>

        <label>Price ($):</label><br>
        <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required><br><br>

        <label>Image:</label><br>
        <input type="file" name="img" accept="image/*"><br>
        <?php if ($product['img']): ?>
            <img src="<?= $product['img'] ?>" width="100" style="margin-top:10px;"><br><br>
        <?php endif; ?>

        <label>Description:</label><br>
        <textarea name="description" rows="4" required><?= htmlspecialchars($product['description']) ?></textarea><br><br>

        <label>Flavor:</label><br>
        <input type="text" name="flavor" value="<?= htmlspecialchars($product['flavor']) ?>" required><br><br>

        <label>Type:</label><br>
        <input type="text" name="type" value="<?= htmlspecialchars($product['type']) ?>" required><br><br>

        <button type="submit" class="button">Update Product</button>
        <a href="Control Panel.php" class="button">Back</a>
    </form>
</body>
</html>
