<!--This page displays the information about a certain model, which is chosen form page2.php.
Advnaced details such as the features and performance specifications of the model are displayed here.
An additional feature that was added was the reviews section, which allowed the user to not only add a review, but also delete/update their reviews.
There's also an option to add a review on the previous page.-->
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
$main = "SELECT c.price, s.company_name, m.year FROM cars c NATURAL JOIN makes m NATURAL JOIN company s WHERE c.cmodel = ?";//gets main details of car(as shown in page2.php)
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
    echo  '<h2>'.$company.' '.$cmodel.' '.$year.'<br><br>$'.$price.'<br></h2>';
    echo '</div>';
    echo '<p></p>';
}
$stmtm->close();
?>

<?php
 echo '<div class="header2">';
 echo  '<h3>FEATURES</h3>';
 echo '</div>';
//query to get features of the car. Since sunroof, and trunk are 0/1 values, they were converted to yes/no using IF
$sql = "SELECT f.n_doors, f.n_seats, IF(f.sunroof, 'Yes', 'No') , IF(f.trunk, 'Yes', 'No') FROM features f NATURAL JOIN includes NATURAL JOIN cars c WHERE c.cmodel = ? ";
//prepare statement
$stmt = $mysqli->prepare($sql);
//execute statement
$stmt->bind_param('s',$cmodel);
$stmt->execute();
//bind result of executed statement
$stmt->bind_result($doors,$seats,$sunroof,$trunk);
?>
<!--Information is displayed in tabular form-->
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
//query to get performance specs of the car
$sql1 = "SELECT p.fuel_efficiency, p.safety_rating, p.acceleration, p.horsepower FROM performance p NATURAL JOIN records NATURAL JOIN cars c WHERE c.cmodel = ? ";
//prepare statement
$stmt1 = $mysqli->prepare($sql1);
//bind parameters
$stmt1->bind_param('s',$cmodel);
//execute statement
$stmt1->execute();
//bind result of executed statement
$stmt1->bind_result($fe,$sr,$acc,$hp);
?>

<!--Performance Information is displayed in tabular form-->
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
//query to get the review details for the model
$review = "SELECT r.rating, r.review, r.date FROM reviews r NATURAL JOIN cars c WHERE c.cmodel = ?";

$stmtr = $mysqli->prepare($review);
$stmtr->bind_param('s',$cmodel);
$stmtr->execute();
$stmtr->bind_result($rating,$review,$date);
?>
<!--Also displayed in tabular form-->
<table class="pure-table" align="center">
    <tr>
        <th>Rating</th>
        <th>Review</th>
        <th>Date</th>
        <th>Update</th>
        <th>Delete</th>
    </tr>
        <?php
        while($stmtr->fetch())
        {
            echo '<tr>';
            echo '<td>'.$rating.'</td>';
            echo '<td>'.$review.'</td>';
            echo '<td>'.$date.'</td>';
            //giving the user an option to update their query: by clicking this, the user will be directed to a page where they can make the changes and resubmit their review
            echo '<td><a class="stdbtn" href ="update_review.php?car_model='.$cmodel.'&rating='.$rating.'&review='.$review.'&date='.$date.'">Update Review</a></td>';
            //clicking this button would delete the entire review!!
            echo '<td><a class="stdbtn" href ="delete_review.php?car_model='.$cmodel.'&rating='.$rating.'&review='.$review.'&date='.$date.'">Delete Review</a></td>';
            echo '</tr>';
        }
        $stmtr->close();
        ?>
</table>

<br>

   <?php 
   echo '<div class="header">';
   echo '<a class="stdbtn" href="get_review.php?car_model='.$cmodel.'">Add a review</a>';//this button acts directs the user to the php page where they can enter their review of the car
   echo '</div>';
   ?>
</br>


</body>
</html>
