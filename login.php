<?php
session_start();
include 'db.php';

$error = "";

// ===  normal Login ===
if (isset($_POST["login"])) {

    $login_input = $_POST["login_input"];
    $password = $_POST["password"];




    // Search the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ? OR name = ? LIMIT 1");

    /*Prepared Statement → Protects against SQL Injection*/
    $stmt->bind_param("ss", $login_input, $login_input);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();

        if($password === $row['password']){ 
// Text comparison 
            $_SESSION["user_id"] = $row['id'];
            $_SESSION["name"] = $row['name'];
            $_SESSION["type"] = $row['type'];
            $_SESSION["location"] = $row['location'];

            if($row['type'] === "admin"){
                header("Location:Control Panel.php");
                exit();
            } else {
                if(empty($row['location'])){
                    header("Location: complete_profile.php");
                    exit();
                } else {
                    header("Location:product.php");
                    exit();
                }
            }

        } else {
            $error = "Incorrect password";
        }

    } else {
        $error = "User not found";
    }
}

// === Google Login ===
require_once 'vendor/autoload.php';



/*Imports all the necessary libraries that we downloaded using Composer.*/



$client = new Google\Client();


/*Here we are creating a new Google customer.*/

$client->setClientId("676894993162-ks57mgarg5adoukcjdfk7k5gk35mv3ek.apps.googleusercontent.com");

/*Your application is defined at Google.*/


$client->setClientSecret("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");
/*password from your website in google */

$client->setRedirectUri("http://localhost/mywebsite/google-callback.php");
/*return to your website*/

/*scope===User agree to give us permission to know their email and  name.*/

$client->addScope("email");
$client->addScope("profile");


/*createAuthUrl===generate a login link.
*/
$google_login_url = $client->createAuthUrl();
?>

<link rel="stylesheet" href="login.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<h1>LOG IN</h1>

<form action="" method="POST" class="login-form">
    <input type="text" name="login_input" placeholder="Enter ID or Username" required>
    <input type="password" name="password" placeholder="Enter Password" required>
    <label class="error"><?php echo $error; ?></label>
    <button type="submit" name="login">GO</button>

    <a href="<?= $google_login_url ?>" class="google-btn">
        <img src="google.png" alt="google">
        Login with Google
    </a>
</form>

<p class="signup-text">
    Don't have an account? 
    <a href="signup.php" class="signup-btn">Sign Up</a>
</p>

<?php include 'footer.php'; ?>
