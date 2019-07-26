<!--This form acts as an interface for the user to insert data into the database. The user can enter their rating and review of the car.
The date of the review is recorded by an inbuilt function that produces the current date, which is added along with the user inputs.-->
<!DOCTYPE html>
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
<br><br><br>

<?php
$model =$_GET['car_model'];
echo '<h2>Add Review for '.$model.'</h2>';
?>

<form action="add_review.php" method ="get">
  <input type='hidden' value="<?php echo $model; ?>" name="model"><!--Hidden input that takes the value of the car model, as received from the manipulation of the URL in car_info.php-->
  <?php
    echo '<div class="header">';
    echo '<label "for=rating">Enter rating</label><br>';
    echo '<input name = "rating" type="text" /><br><br>';
    echo '<label "for=review" >Enter review</label><br>';
    echo '<input name = "review" type="textarea"/><br>';
    echo '</div>';
  ?>
  <input type="submit">
</form>
</div>

</body>
</html>