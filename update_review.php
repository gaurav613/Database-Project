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
</div>
<?php
    // Enable error logging: 
    error_reporting(E_ALL ^ E_NOTICE);
    // mysqli connection via user-defined function
    include ('./my_connect.php');
    $mysqli = get_mysqli_conn();
?>
<?php
$rating = $_GET['rating'];
$review = $_GET['review'];
$current =  $_GET['date'];
$model = $_GET['car_model'];
?>
<form action="handle_update.php" method ="get">
  <input type='hidden' value="<?php echo $model; ?>" name="model">
  <?php
    echo '<div class="header">';
    echo '<label "for=rating">Change the rating</label><br>';
    echo '<input name = "rating" type="text" value='.$rating.'><br><br>';
    echo '<label "for=review">Change the review review</label><br>';
    echo '<input name = "review" type="textarea" value='.$review.'><br>';
    echo '</div>';
  ?>
  <input type="submit">
</form>
