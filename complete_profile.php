<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$error = "";

if(isset($_POST['save_location'])){
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $user_id = $_SESSION['user_id'];

    if(!empty($location)){
        $sql = "UPDATE users SET location='$location' WHERE id=$user_id";
        mysqli_query($conn, $sql);

        $_SESSION['location'] = $location;

        header("Location: product.php");
        exit();
    } else {
        $error = "Please enter your address.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Complete Profile</title>
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background-color: #f7f2fb;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 350px;
            text-align: center;
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            padding: 12px 20px;
            background-color: #6a0572;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        button:hover {
            background-color: #4b034f;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
        /* Responsive adjustments */
@media (max-width: 480px) {
    form {
        width: 90%;
        padding: 20px;
    }

    input, button {
        padding: 10px;
        font-size: 14px;
    }
}
    </style>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<form method="POST" action="">
    <h2>Complete Your Profile</h2>
    <input type="text" name="location" placeholder="Enter your address" required>
    <button type="submit" name="save_location">Save</button>
    <div class="error"><?= $error ?></div>
</form>

</body>
</html>
