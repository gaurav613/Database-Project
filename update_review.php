<!-- 
  This form acts as an interface for the user to update their ratings/reviews of the car. It's similar to get_review.php, 
  but here, the fields already have default values of the previous reviews
-->
<html>
<link rel="stylesheet" type="text/css" href="style.css">
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.1/build/pure-min.css" integrity="sha384-oAOxQR6DkCoMliIh8yFnu25d7Eq/PHS21PClpwjOTeU2jRSq11vu66rf90/cZr47" crossorigin="anonymous">
<body>
<div class="header">
  <h1>All About Cars</h1>
  <p>MSCI 346 Term Project</p>
  <br>
    <a class="stdbtn" href="index.php">Main Page</a>
  </br> 

<?php
    // Enable error logging: 
    error_reporting(E_ALL ^ E_NOTICE);
    // mysqli connection via user-defined function
    include ('./my_connect.php');
    $mysqli = get_mysqli_conn();
?>
<?php
//getting the original review information
$rating = $_GET['rating'];
$review = $_GET['review'];
$current =  $_GET['date'];
$model = $_GET['car_model'];
?>
<form action="handle_update.php" method ="get">
<!-- Hidden inputs that take the previous values as default values -->
  <input type='hidden' value="<?php echo $model; ?>" name="model">
  <input type='hidden' value="<?php echo $rating; ?>" name="old_rating">
  <input type='hidden' value="<?php echo $review; ?>" name="old_review">
  <input type='hidden' value="<?php echo $current; ?>" name="old_date">

  <?php
    echo '<div class="header">';
    echo '<label "for=rating">Change the rating</label><br>';
    echo '<input name = "rating" type="text" value='.$rating.'><br><br>';//default old rating
    echo '<label "for=review">Change the review review</label><br>';
    echo '<input name = "review" type="text" value='.$review.'><br>';//default old review
    echo '</div>';
  ?>

  <input type="submit">

</form>
</div>
</body>
</html>