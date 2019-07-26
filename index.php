<!--MSCI 346 Term Project
    GROUP 17:
    GAURAV MUDBHATKAL 20747018
    HARDIK CHUGH 20747036
    RUHOLLAH NASIM 20715117
  Being the index file, this page is the first page of the web application. It allows the user to apply filters that can be used to query our database
  -->
<html>
<link rel="stylesheet" type="text/css" href="style.css">
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.1/build/pure-min.css" integrity="sha384-oAOxQR6DkCoMliIh8yFnu25d7Eq/PHS21PClpwjOTeU2jRSq11vu66rf90/cZr47" crossorigin="anonymous">
<body>
<div class="header">
  <h1>All About Cars</h1>
  <p>MSCI 346 Term Project</p>
<p class="dotted">MAIN FILTERS</p>
<form action ="page2.php" method="get" >
<?php
// Enable error logging: 
error_reporting(E_ALL ^ E_NOTICE);
// mysqli connection via user-defined function
include ('./my_connect.php');
$mysqli = get_mysqli_conn();
?>

<!--Company Filters-->
<?php
$sql = "SELECT c.company_id, c.company_name FROM company c";
//prepare statement
$stmt = $mysqli->prepare($sql);
//execute statement
$stmt->execute();
//bind result of executed statement
$stmt->bind_result($company_id,$company_name);

echo '<label "for=company_id">Pick Company:</label><br>';
echo '<select name="company_ids[]" multiple size = 10 class="pure-menu pure-menu-scrollable">';//allowing multiple selection of company names as a filter
while($stmt->fetch())
{
  printf('<option value="%s">%s</option>',$company_id,$company_name);
}
echo '</select><br>';
?>

<br>
<!--Price Filters-->
<?php
echo '<div>';
echo '<label "for=min_price">Enter minimum price</label><br>';//minimum price input
echo '<input name = "minprice" type="text" /><br><br>';
echo '<label "for=max_price" >Enter maximum price</label><br>';//maximum price input
echo '<input name = "maxprice" type="text"/><br>';
echo '</div>';
?>

<br>
<!--Type Filters-->
<?php

$sql1 = "SELECT t.type FROM types t";
//prepare statement
$stmt1 = $mysqli->prepare($sql1);
//execute statement
$stmt1->execute();
//bind result of executed statement
$stmt1->bind_result($type);

echo '<label "for=type">Pick Type:</label><br>';
echo '<select name="car_types[]" multiple>';//allowing multiple selection of car types for filtering
while($stmt1->fetch())
{
  printf('<option value="%s">%s</option>',$type,$type);
}
echo '</select><br>';

echo '<br><label for="group_by">Group By:</label><br>';//adding options to group the rows by 
echo '<input type="radio" name="group_by" value="company_name"> Company</input><br>';//they can either be grouped by company name or type of car
echo '<input type="radio" name="group_by" value="type"> Type</input><br>';
$stmt->close();
$stmt1->close();
$mysqli->close();
?>
  <br>
    <input  class = "continue" type="submit" value="Continue"/>
  </br>
</form>
<br><p class="dotted">ADDITIONAL QUERIES</p><br>
<!--Input section for an additional query that uses EXISTS to find out cars above a certain price-->
<form action="complex.php" method="get">
  <?php
  echo '<label "for=min_price">Enter minimum price</label><br>';
  echo '<input name = "minprice" type="text" /><br><br>';
  ?>
  <br>
    <input  class = "pure-button pure-button-primary" type="submit" value="Complex Query"/>
  </br>
</form>
</div>

<div class="footer">
  <p>Made by: Group 17</p>
</div>

</body>
</html>

