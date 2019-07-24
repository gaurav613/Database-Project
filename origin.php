<html>
<link rel="stylesheet" type="text/css" href="style.css">
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
<body>
<div class="header">
  <h1>All About Cars</h1>
  <p>MSCI 346 Term Project</p>
</div>
<body>
<?php
// Enable error logging: 
error_reporting(E_ALL ^ E_NOTICE);
// mysqli connection via user-defined function

include('./my_connect.php');
$mysqli = get_mysqli_conn();

// SQL statement
$sql = "SELECT m.year FROM cars s NATURAL JOIN makes m NATURAL JOIN company c WHERE c.company_cid = ?, s.cid = ?";

// Prepared statement, stage 1: prepare
$stmt = $mysqli->prepare($sql);

// Prepared statement, stage 2: bind and execute 
$company_id = $_GET['company_id']; 
$company_name = $_GET['company_name'];

// "i" for integer, "d" for double, "s" for string, "b" for blob 
$stmt->bind_param('i', $company_id); 
$stmt->execute();

// Bind result variables 
$stmt->bind_result($company_origin,$company_name); 

/* fetch values */ 
if ($stmt->fetch()) 
{ 
 echo '<label>The cars from '. $company_name .' are made in '. $company_origin.'</label>';
} 

/* close statement and connection*/ 
$stmt->close(); 
$mysqli->close();
?>
<br>
<a class="stdbtn" href="index.php">Back to the main page</a>
</br>
</body>
</html>
