<!--This page updates the requested user review data in the reviews table-->
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
//getting the older values; to be added as parameters for the query
$old_rating = $_GET['old_rating'];
$old_review = $_GET['old_review'];
$old_date = $_GET['old_date'];
$rating = $_GET['rating'];
$review = $_GET['review'];
$current = date('Y-m-d');
$model = $_GET['model'];

//again, since the reviews table has a FK of cid, the cmodel's corresponding cid needs to be found
$sql = "SELECT cid from cars where cmodel = ? ";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s",$model);
$stmt->execute();
$stmt->bind_result($cid);
$stmt->fetch();
$stmt->close();

//update statement
$sql1 = "UPDATE reviews r SET rating=?, review=?, date=? WHERE (rating=? AND review=? AND date=? AND cid=?)";
$stmt1 = $mysqli->prepare($sql1);
echo $mysqli->error;
//here the parameters need to be the old and new values, because the reviews table is a weak entity, and hence has no primary key to hold together the rows
$stmt1->bind_param("ssssssi",$rating,$review,$current,$old_rating,$old_review,$old_date,$cid);

if ($stmt1->execute()) {
    echo "Review updated successfully!";
    ?>
    <br>
    <?php
     echo '<a class="stdbtn" href="car_info.php?car_model='.$model.'">Check it out!</a>'//allow the user to go see that the update has been made to the database, as will be shown on the info page
     ?>
    </br>
    <?php
} else {
    echo "FAILURE";
}
$stmt1->close();

?>
