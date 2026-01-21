<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LAVENDER SWEET💜</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include 'header.php'; 
 ?>

</head>
<body>
<section class="banner">
 
    <div class="banner-content">
        <h1>LAVENDER SWEET</h1>
        <p>"Indulge in the elegance of Lavender Sweet <br> where chocolate becomes an art of luxury."</p>
    </div>
</section>


<section>
    <div id="main_content">
        <h1>Step Into Our Chocolate Museum</h1>
 <div class="boxes">
            <!-- prodect 1 -->

<div class="box" onclick="location.href='product-details.php?id=7'">
                <img src="fw1.jpg" alt="">
                <div class="info">"Within each piece, a tale of love and joy gently whispers. Indulge in bliss."</div>
            </div>

            <!-- prodect 2 -->
<div class="box" onclick="location.href='product-details.php?id=19'">
                <img src="random box.png" alt="">
                <div class="info">"Where artistry meets indulgence. Each fragment is a unique expression, a burst of flavour waiting to unfold. Open this treasure, and embark on a vibrant journey of taste. It's an invitation to savour pure moments of delight."</div>
            </div>
 <!-- prodect 3 -->

<div class="box" onclick="location.href='product.php?type=single'">
                <img src="bar 2.jpg" alt="">
                <div class="info">"Within each square, artistry and harmony. A curated collection of luxurious chocolates, adorned with exquisite flavors. A design that captivates, a taste that delights. Let this sweet beginning take you on a unique journey, where every bite is pure bliss."</div>
            </div>

            <!-- prodect 4 -->
<div class="box" onclick="location.href='product.php?type=gift'">
                <img src="box one piece.jpg" alt="">
                <div class="info">“Where sensation meets art. Each heart carries a touch of wonder and soft passion. Open the box and   begin a memorable journey of taste<br/>an invitation to share pure affection.”</div>
     </div>
    </div>




</section>

<!-- ABOUT US SECTION (with optional left image) -->
<section id="about-us" >
  <div class="about-wrapper">

    <div class="about-img" >
     
      <img src="about-photo.jpg" alt="Lavender Sweet founder" />
    </div>

    <!-- RIGHT: text -->
    <div class="about-text">
      <h2 id="about-title">About Lavender Sweet</h2>
      <p class="tagline">Where quiet strength meets gentle elegance.</p>

      <p>
        I started Lavender Sweet because I believe power doesn't always shout — sometimes it
        arrives softly, patient and steady. We craft chocolate that remembers you of that hidden strength:
        small, sincere moments that remind you who you really are.
      </p>

      <p>
        Our chocolates are made with intention — quality ingredients, calm design, and a touch of
        tenderness. Each box is an invitation to pause, to celebrate the quiet courage inside you,
        even when you don't feel it.
      </p>

      <p>
        Lavender Sweet is more than a brand — it's a little refuge. A reminder that beauty begins
        from within, and strength can be tasted one gentle bite at a time.
      </p>

      <!-- optional CTA (remove if you don't want a button) -->
      <a class="about-cta" href="about.php">Learn more</a>
    </div>
  </div>
</section>


<section id="packages">
    <h1>For You or for Loved Ones</h1>

    <div class="package-boxes" >
        <div class="p-box" onclick="window.location='product.php?type=gift'">Gift</div>
   <div class="p-box" onclick="window.location='product.php?type=family'">Family</div>
<div class="p-box" onclick="window.location='product.php?type=single'">Single</div>

    </div>
<h2 >"Life is sweeter with a touch of chocolate 💜"</h2>
   
</section>
 

<?php include("footer.php"); ?>

</body>
</html>
