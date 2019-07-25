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
$cmodel = $_GET['car_model'];
$main = "SELECT c.price, s.company_name, m.year FROM cars c NATURAL JOIN makes m NATURAL JOIN company s WHERE c.cmodel = ?";
//prepare statement
$stmtm = $mysqli->prepare($main);
//execute statement
$stmtm->bind_param('s',$cmodel);
$stmtm->execute();
//bind result of executed statement
$stmtm->bind_result($price,$company,$year);

while($stmtm->fetch())
{
    echo '<div class="header">';
    echo  '<h2>'.$company.' '.$cmodel.' '.$year.'<br><br>$'.$price.'</h2>';
    echo '</div>';
    echo '<p></p>';
}
$stmtm->close();
?>
<?php
 echo '<div class="header2">';
 echo  '<h3>FEATURES</h3>';
 echo '</div>';
$sql = "SELECT f.n_doors, f.n_seats, if(f.sunroof, 'Yes', 'No') , if(f.trunk, 'Yes', 'No') FROM features f NATURAL JOIN includes NATURAL JOIN cars c WHERE c.cmodel = ? ";
//prepare statement
$stmt = $mysqli->prepare($sql);
//execute statement
$stmt->bind_param('s',$cmodel);
$stmt->execute();
//bind result of executed statement
$stmt->bind_result($doors,$seats,$sunroof,$trunk);
?>

<table class="pure-table" align="center">
    <tr>
        <th>Doors</th>
        <th>Seats</th>
        <th>Sunroof</th>
        <th>Trunk</th>
    </tr>
        <?php
        while($stmt->fetch())
        {
            echo '<tr>';
            echo '<td>'.$doors.'</a></td>';
            echo '<td>'.$seats.'</td>';
            echo '<td>'.$sunroof.'</td>';
            echo '<td>'.$trunk.'</td>';
            echo '</tr>';
        }
        $stmt->close();
        ?>
    </table>
<br>
<?php
 echo '<div class="header2">';
 echo  '<h4>PERFORMANCE SPECS</h4>';
 echo '</div>';
$sql1 = "SELECT p.fuel_efficiency, p.safety_rating, p.acceleration, p.horsepower FROM performance p NATURAL JOIN records NATURAL JOIN cars c WHERE c.cmodel = ? ";
//prepare statement
$stmt1 = $mysqli->prepare($sql1);
//execute statement
$stmt1->bind_param('s',$cmodel);
$stmt1->execute();
//bind result of executed statement
$stmt1->bind_result($fe,$sr,$acc,$hp);
?>

<!--Performance-->
<table class="pure-table" align="center">
    <tr>
        <th>Fuel Efficiency</th>
        <th>Safety Rating</th>
        <th>Acceleration</th>
        <th>Horsepower</th>
    </tr>
        <?php
        while($stmt1->fetch())
        {
            echo '<tr>';
            echo '<td>'.$fe.'</td>';
            echo '<td>'.$sr.'</td>';
            echo '<td>'.$acc.'</td>';
            echo '<td>'.$hp.'</td>';
            echo '</tr>';
        }
        $stmt1->close();
        ?>
</table>

<?php
 echo '<div class="header2">';
 echo  '<h4>REVIEWS</h4>';
 echo '</div>';
$review = "SELECT r.rating, r.review, r.date FROM reviews r WHERE cid = ?";
$getID = "SELECT cid from cars WHERE cmodel = ?";
$stmtr = $mysqli->prepare($review);
$stmtid = $mysqli->prepare($getID);
$stmtid->bind_param('s',$cmodel);
$stmtid->execute();
$stmtid->bind_result($id);

$stmtr->bind_param('i',$id);
$stmtr->execute();
$stmtr->bind_result($rating,$review,$date);

?>
<table class="pure-table" align="center">
    <tr>
        <th>Rating</th>
        <th>Review</th>
        <th>Date</th>
    </tr>
        <?php
        while($stmtr->fetch())
        {
            echo '<tr>';
            echo '<td>'.$rating.'</td>';
            echo '<td>'.$review.'</td>';
            echo '<td>'.$date.'</td>';
            echo '</tr>';
        }
        $stmtr->close();
        $stmtid->close();
        ?>
</table>
<br>
    <a class="stdbtn" href="page4.php">Add a review</a>
  </br>
<?php

?>

<form >
</form>
</body>
</html>
