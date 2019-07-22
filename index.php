<body>
<h1>Find Origin of Company</h1>

<form action="origin.php" method="get">

<?php
// Enable error logging: 
error_reporting(E_ALL ^ E_NOTICE);
// mysqli connection via user-defined function
include ('./my_connect.php');
$mysqli = get_mysqli_conn();
?>

<?php
// SQL statement
$sql = "SELECT c.company_id,c.company_name "
	. "FROM company c";
	
// Prepared statement, stage 1: prepare
$stmt = $mysqli->prepare($sql);

// Prepared statement, stage 2: execute
$stmt->execute();

// Bind result variables 
$stmt->bind_result($company_id, $company_name); 

/* fetch values */ 
echo '<label for="company_id">Pick Company: </label>'; 
echo '<select name="company_id">'; 
while ($stmt->fetch()) 
{
printf ('<option value="%s">%s</option>', $company_id, $company_name); 
}
echo '</select><br>'; 

/* close statement and connection*/ 
$stmt->close(); 
$mysqli->close();
?>

<br>
<input type="submit" value="Continue"/>
</br>
</form>
</body>