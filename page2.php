<html>
<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.1/build/pure-min.css" integrity="sha384-oAOxQR6DkCoMliIh8yFnu25d7Eq/PHS21PClpwjOTeU2jRSq11vu66rf90/cZr47" crossorigin="anonymous">
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
    include ('./my_connect.php');
    $mysqli = get_mysqli_conn();

    ?>
    <?php
        
        $sqlOld = "SELECT s.cmodel, s.price, t.type, c.company_name, m.year FROM types t NATURAL JOIN oftype NATURAL JOIN cars s NATURAL JOIN makes m NATURAL JOIN company c  WHERE ";
        $add = "";
    //Company Filter
        foreach($_GET['company_ids'] as $id)
        {
            $add .= "c.company_id = " . $id . " OR ";
        }
        $add = substr($add, 0, -3);

    //Price Filter
        $min_price = (empty($_GET['minprice']) ? '0' : $_GET['minprice']);
        $max_price = (empty($_GET['maxprice']) ? '4300000' : $_GET['maxprice']);
        $add .="AND (s.price BETWEEN $min_price AND $max_price)";
    
    //Type Filter
        $add .= " AND ";
        foreach($_GET['car_types'] as $type)
        {
            $add .= "t.type = '" . $type . "' OR ";
        }
        $add = substr($add, 0, -3);
    
        
        //Type Filter
        $add .= " AND ";
        foreach($_GET['car_types'] as $type)
        {
            $add .= "t.type = '" . $type . "' OR ";
        }
        $add = substr($add, 0, -3);
    
        $sql = $sqlOld . $add ;
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($cars_cmodel, $price, $type, $company_name,$year);

    ?>
    <table class="pure-table" align="center">
    <tr>
        <th>Car</th>
        <th>Price</th>
        <th>Type</th> 
        <th>Company</th> 
        <th>Year</th> 
    </tr>
        <?php
        while($stmt->fetch())
        {
            echo '<tr>';
            echo '<td>'.$cars_cmodel.'</td>';
            echo '<td>'.$price.'</td>';
            echo '<td>'.$type.'</td>';
            echo '<td>'.$company_name.'</td>';
            echo '<td>'.$year.'</td>';
            echo '</tr>';
        }
        $stmt->close();
        ?>
    </table>
    <br>
    <a class="stdbtn" href="index.php">Back to the main page</a>
    </br>
</body>
</html>
