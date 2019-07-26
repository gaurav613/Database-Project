<html>
<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.1/build/pure-min.css" integrity="sha384-oAOxQR6DkCoMliIh8yFnu25d7Eq/PHS21PClpwjOTeU2jRSq11vu66rf90/cZr47" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="style.css">
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
<body>
<div class="header">
  <h1>All About Cars</h1>
  <p>MSCI 346 Term Project</p>
  <br>
    <a class="stdbtn" href="index.php">Main Page</a>
  </br>
</div>
<body>
    

<form action = "page2.php" method ="get">
    <select for="sorting" name="sort">
        <option value="" selected="selected">Any Order</option>
        <option value="ASC">Ascending</option>
        <option value="DESC">Descending</option>
    </select>
    <br>
        <input  class = "pure-button pure-button-primary" type="submit" value="Continue"/>
    </br>
</form>
    <?php
    // Enable error logging: 
    error_reporting(E_ALL ^ E_NOTICE);
    // mysqli connection via user-defined function
    include ('./my_connect.php');
    $mysqli = get_mysqli_conn();

    ?>
    <?php
        
        $sqlOld = "SELECT s.cmodel, s.price, t.type, c.company_name, m.year FROM types t NATURAL JOIN oftype NATURAL JOIN cars s NATURAL JOIN makes m NATURAL JOIN company c ";
        $add = "";
    //Company Filter
        if(!empty($_GET['company_ids']))
        {
            $add .= " WHERE (";
            foreach($_GET['company_ids'] as $id)
            {
                $add .= "c.company_id = " . $id . " OR ";
            }
            $add = substr($add, 0, -3);
            $add .= ") AND ";
        }

        else
        {
            $add .= " WHERE ";
        }

    //Price Filter
        $min_price = (empty($_GET['minprice']) ? '0' : $_GET['minprice']);
        $max_price = (empty($_GET['maxprice']) ? '4300000' : $_GET['maxprice']);
        $add .=" (s.price BETWEEN $min_price AND $max_price)";
    
    //Type Filter
        if(!empty($_GET['car_types']))
        {
            $add .= " AND (";
            foreach($_GET['car_types'] as $type)
            {
                $add .= "t.type = '" . $type . "' OR ";
            }
            $add = substr($add, 0, -3);
            $add .= ")";
        }
    //sorting of price 
        if(!empty($_POST["sorting"]))
        {
            $add .= "ORDER BY s.price " .$_GET["sorting"];
        }
    
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
        <th>Add a review</th> 
    </tr>
        <?php
        while($stmt->fetch())
        {
            echo '<tr>';
            echo '<td><a class="stdbtn" href ="page3.php?car_model='.$cars_cmodel.'">'.$cars_cmodel.'</a></td>';
            echo '<td>'.$price.'</td>';
            echo '<td>'.$type.'</td>';
            echo '<td>'.$company_name.'</td>';
            echo '<td>'.$year.'</td>';
            echo '<td><a class="stdbtn" href ="page4.php?car_model='.$cars_cmodel.'">Add Review</a></td>';
            echo '</tr>';
        }
        $stmt->close();
        ?>
    </table>
</body>
</html>
