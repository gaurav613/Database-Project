<body>
<h1>Find Origin of Company</h1>

<?php
// Enable error logging: 
error_reporting(E_ALL ^ E_NOTICE);
// mysqli connection via user-defined function

include('./my_connect.php');
$mysqli = get_mysqli_conn();

// SQL statement
$sql = "SELECT c.origin, c.company_name FROM company c WHERE c.company_id=?";

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
</body>
