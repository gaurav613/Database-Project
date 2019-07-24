<html>
<link rel="stylesheet" type="text/css" href="style.css">
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.1/build/pure-min.css" integrity="sha384-oAOxQR6DkCoMliIh8yFnu25d7Eq/PHS21PClpwjOTeU2jRSq11vu66rf90/cZr47" crossorigin="anonymous">
<body>
<div class="header">
  <h1>All About Cars</h1>
  <p>MSCI 346 Term Project</p>
</div>

<form action ="page2.php" method="get">
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

echo '<label for="company_id">Pick Company:</label>';
echo '<select name="company_ids[]" multiple size = 10 class="pure-menu pure-menu-scrollable">';
while($stmt->fetch())
{
  printf('<option value="%s">%s</option>',$company_id,$company_name);
}
echo '</select>';

$stmt->close();
$mysqli->close();
?>
</form>

<form class = "pure-form pure-form-stacked">
  <fieldset>
    <input type="text" name="minprice" placeholder ="Minimum Price" />
    <input type="text" name="subjet" placeholder ="Maximum Price" />
  </fieldset>
</form>

<br>
<input class="pure-button" type="submit" value="Continue"/>
</br>

</body>
</html>

