<?php
session_start();
include 'db.php'; // Database connection

$errors = [];
$success = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $flavor = trim($_POST['flavor'] ?? '');
    $type = trim($_POST['type'] ?? '');

    // Handle image upload
    $img = '';
    if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $img = $targetDir . basename($_FILES['img']['name']);
        move_uploaded_file($_FILES['img']['tmp_name'], $img);
    }

    // Simple validation
    if ($name === '' || $price === '' || $description === '' || $flavor === '' || $type === '') {
        $errors[] = "All fields are required.";
    }

    // Insert into database
    if (!$errors) {
        $stmt = $conn->prepare("INSERT INTO product (name, price, img, description, flavor, type) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdssss", $name, $price, $img, $description, $flavor, $type);
        if ($stmt->execute()) {
            $success = "Product added successfully!";
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
    <title>Add Product - Chocolate Shop</title>
    <link rel="stylesheet" href="Control Panel.css"> <!-- Reuse your CSS -->
</head>
<body>
    <h1>Add New Product 💜</h1>

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

    <form action="" method="post" enctype="multipart/form-data" style="max-width:500px; margin:auto;">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Price ($):</label><br>
        <input type="number" step="0.01" name="price" required><br><br>

        <label>Image:</label><br>
        <input type="file" name="img" accept="image/*" required><br><br>

        <label>Description:</label><br>
        <textarea name="description" rows="4" required></textarea><br><br>

        <label>Flavor:</label><br>
        <input type="text" name="flavor" required><br><br>

        <label>Type:</label><br>
        <input type="text" name="type" required><br><br>

        <button type="submit" class="button">Add Product</button>
        <a href="Control Panel.php" class="button">Back</a>
    </form>
</body>
</html>
