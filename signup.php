<?php
session_start();
include 'db.php'; 

$errors = [];
$success_message = "";

if($_SERVER["REQUEST_METHOD"] === "POST"){

    // Get inputs and delete the spaces 
     
    $name = trim($_POST["name"] ?? "");
    $location = trim($_POST["location"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm = $_POST["confirm_password"] ?? "";

    // Validation
    if($name === "") $errors[] = "Name is required.";
    if($location === "") $errors[] = "Location is required.";
    if(strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";
    if($password !== $confirm) $errors[] = "Passwords do not match.";

    if(empty($errors)){
        // Check if name exists
        $check = $conn->prepare("SELECT id FROM users WHERE name = ?");
        $check->bind_param("s", $name);
        $check->execute();
        $check_result = $check->get_result();
        if($check_result->num_rows > 0){
            $errors[] = "This username already exists. Please choose another one.";
        }
        $check->close();
    }

    // Insert if no errors
    if(empty($errors)){
        $type = "client";
        $stmt = $conn->prepare("INSERT INTO users (name, type, location, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $type, $location, $password);

        if($stmt->execute()){
            $inserted_id = $stmt->insert_id;

            $_SESSION['user'] = [
                "id" => $inserted_id,
                "name" => $name,
                "type" => "client",
                "location" => $location
            ];

            $success_message = "Account created successfully. Your ID is: " . $inserted_id;
        } else {
            $errors[] = "Database error, try again.";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="signup.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div class="signup-container">
    <div class="signup-box">
        <h1>Create Account</h1>

        <?php if(!empty($errors)): ?>
            <div class="error-box">
                <?php foreach($errors as $e): ?>
                    <p><?= $e ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if($success_message): ?>
            <div class="success-box"><?= $success_message ?></div>
            <meta http-equiv="refresh" content="5 ;url=index.php">
        <?php endif; ?>

        <form method="POST">
            <label>Name</label>
            <input type="text" name="name" required>

            <label>Location</label>
            <input type="text" name="location" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <label>Confirm Password</label>
            <input type="password" name="confirm_password" required>

            <button type="submit">Sign Up</button>
        </form>

        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</div>

</body>
</html>
