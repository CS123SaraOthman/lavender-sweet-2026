<?php
session_start();
include 'db.php'; // Database connection

// OPTIONAL: Check if user is admin
// if(!isset($_SESSION['type']) || $_SESSION['type'] !== 'admin'){
//     header("Location: login.php");
//     exit();
// }

// Check if product ID is provided
if(!isset($_GET['id'])){
    header("Location: Control Panel.php");
    exit();
}

$id = intval($_GET['id']); // Simple security: convert ID to integer

// OPTIONAL: Get product image path before deleting (to remove file from server)
$get = $conn->prepare("SELECT img FROM product WHERE id = ?");
$get->bind_param("i", $id);
$get->execute();
$result = $get->get_result();

// If product does not exist, redirect back
if($result->num_rows === 0){
    header("Location: Control Panel.php");
    exit();
}

$product = $result->fetch_assoc();
$get->close();

// Delete product from database
$stmt = $conn->prepare("DELETE FROM product WHERE id = ?");
$stmt->bind_param("i", $id);

if($stmt->execute()){

    // OPTIONAL: Delete product image from folder if it exists
    if(!empty($product['img']) && file_exists($product['img'])){
        unlink($product['img']);
    }

    // Redirect back to control panel with success message
    header("Location: Control Panel.php?msg=deleted");
    exit();

} else {
    // If delete fails
    echo "Error deleting product";
}

$stmt->close();
$conn->close();
?>
