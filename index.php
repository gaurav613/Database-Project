<html>
<link rel="stylesheet" type="text/css" href="style.css">
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.1/build/pure-min.css" integrity="sha384-oAOxQR6DkCoMliIh8yFnu25d7Eq/PHS21PClpwjOTeU2jRSq11vu66rf90/cZr47" crossorigin="anonymous">
<body>
<div class="header">
  <h1>All About Cars</h1>
  <p>MSCI 346 Term Project</p>
</div>


<form action ="page2.php" method="get" >
<?php
// Enable error logging: 
error_reporting(E_ALL ^ E_NOTICE);
// mysqli connection via user-defined function
include ('./my_connect.php');
$mysqli = get_mysqli_conn();
?>
<?php
//statement for company name filter
$sql = "SELECT c.company_id, c.company_name FROM company c";
//prepare statement
$stmt = $mysqli->prepare($sql);
//execute statement
$stmt->execute();
//bind result of executed statement
$stmt->bind_result($company_id,$company_name);

echo '<label "for=company_id">Pick Company:</label><br>';
echo '<select name="company_ids[]" multiple size = 10 class="pure-menu pure-menu-scrollable">';
while($stmt->fetch())
{
  printf('<option value="%s">%s</option>',$company_id,$company_name);
}
echo '</select><br>';

echo '<div class="header">';
echo '<label "for=min_price">Enter minimum price</label><br>';
echo '<input name = "minprice" type="text" /><br><br>';
echo '<label "for=max_price" >Enter maximum price</label><br>';
echo '<input name = "maxprice" type="text"/><br>';
echo '</div>';

$sql1 = "SELECT t.type FROM types t";
//prepare statement
$stmt1 = $mysqli->prepare($sql1);
//execute statement
$stmt1->execute();
//bind result of executed statement
$stmt1->bind_result($type);

echo '<label "for=type">Pick Type:</label><br>';
echo '<select name="car_types[]" multiple>';
while($stmt1->fetch())
{
  printf('<option value="%s">%s</option>',$type,$type);
}
echo '</select><br>';

$stmt->close();
$stmt1->close();
$mysqli->close();


?>
  <br>
    <input  class = "pure-button pure-button-primary" type="submit" value="Continue"/>
  </br>
</form>

</body>
</html>

