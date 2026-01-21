<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    echo "login_required";
    exit;
}

$user_id = $_SESSION['user_id']; 
/*return int ===id*/
$product_id = intval($_POST['id']);

$check = $conn->query("SELECT * FROM cart WHERE user_id=$user_id AND product_id=$product_id");

if($check->num_rows > 0){
    $conn->query("UPDATE cart SET quantity = quantity + 1 
                  WHERE user_id=$user_id AND product_id=$product_id");
} else {
    $conn->query("INSERT INTO cart(user_id, product_id, quantity)
                  VALUES ($user_id, $product_id, 1)");
}

echo "done";
