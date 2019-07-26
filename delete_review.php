<!--
  This file deletes the review that the user may have chosen to delete. 
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
</div>

<?php
    // Enable error logging: 
    error_reporting(E_ALL ^ E_NOTICE);
    // mysqli connection via user-defined function
    include ('./my_connect.php');
    $mysqli = get_mysqli_conn();
?>

<?php
//getting the information about the review. Since reviews is a weak entity, there isn't any primary key, 
//and hence we need all the values of a row to uniquely identify it
$rating = $_GET['rating'];
$review = $_GET['review'];
$current =  $_GET['date'];
$model = $_GET['car_model'];

//finding cid corresponding to the cmodel received, because cid is a foreign key of reviews table
$sql = "SELECT cid from cars where cmodel = ? ";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s",$model);

$stmt->execute();

$stmt->bind_result($cid);

$stmt->fetch();

$stmt->close();

//delete query
$sql1="DELETE FROM reviews WHERE (rating = ? AND review = ? AND `date` = ? AND cid = ?)";

$stmt1 = $mysqli->prepare($sql1);

$stmt1->bind_param("sssi",$rating,$review,$current,$cid);

if ($stmt1->execute()) {
    echo "Review has been deleted successfully!";
    ?>
    <br>
    <?php
     echo '<a class="stdbtn" href="page3.php?car_model='.$model.'">Take a look.</a>'//assuring the user that the review has been removed from the database, by showing that it's not there anymore on the info page
     ?>
    </br>
    <?php
} else {
    echo "FAILURE";
}
?>