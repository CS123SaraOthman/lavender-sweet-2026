<?php include 'header.php'; 
include 'db.php';

?>
<link rel="stylesheet" href="contact.css">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';

    $to = "info@lavendersweet.com";
    $subject = "New Contact Message";
    $body = "Name: $name\nEmail: $email\nMessage:\n$message";
    $headers = "From: noreply@lavendersweet.com";

    if(mail($to, $subject, $body, $headers)){
        echo "donee";
    } else {
        echo "again";
    }
}
?>


<!-- Contact Page -->
<section id="contact-page">
    <h1>Contact Us</h1>
    <p>Phone Number: <strong>+970 59 123 4567</strong></p>
    <p>Email: <strong>info@lavendersweet.com</strong></p>


    <!-- Contact Form -->
    <form action="mailto:sarashehadi17@gmail.com" method="post" enctype="text/plain">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <textarea name="message" placeholder="Your Message" required></textarea>
        <button type="submit">Send</button>
        <button type="reset">Reset</button>
    </form>

</section>
<?php include 'footer.php'; ?>
