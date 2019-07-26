<!--This page inserts the given user review data into the reviews table in the database-->
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
//getting all the required information from get_review.php
$rating = $_GET['rating'];
$review = $_GET['review'];
$current = date('Y-m-d');
$model = $_GET['model'];

//since the reviews table has a foreign key of cid, we need to find the corresponding cid of the cmodel that we have
$sql = "SELECT cid from cars where cmodel = ? ";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s",$model);
$stmt->execute();
$stmt->bind_result($cid);
$stmt->fetch();
$stmt->close();

//insert statement
$sql1 = "INSERT INTO reviews VALUES (?,?,?,?)";
$stmt1 = $mysqli->prepare($sql1);
echo $mysqli->error;
$stmt1->bind_param("sssi",$rating,$review,$current,$cid);

if ($stmt1->execute()) {
    echo "Your review has been added successfully!";
    ?>
    <br>
    <?php
     echo '<a class="stdbtn" href="page3.php?car_model='.$model.'">Check it out!</a>'//allow the user to take a look at their review on the info page(again use manipulaation of php URL)
     ?>
    </br>
    <?php
} else {
    echo "FAILURE";
}

$stmt1->close();

?>
</div>
</body>
</html>


