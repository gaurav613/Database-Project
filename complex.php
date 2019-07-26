<!--
    Since we didn't have any queries using EXISTS and nesting, we decided to make a button that would process some input and query it using EXISTS.
    This query, essentially, displays a list of cars that are above a specific price, in the descending order of price
    -->
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
    <?php
        // Enable error logging: 
        error_reporting(E_ALL ^ E_NOTICE);
        // mysqli connection via user-defined function
        include ('./my_connect.php');
        $mysqli = get_mysqli_conn();
        //the query, done using nesting and EXISTS
        $sql = "SELECT cars.cmodel, cars.price, types.type, company.company_name, makes.year FROM types NATURAL JOIN oftype NATURAL JOIN cars NATURAL JOIN makes NATURAL JOIN company WHERE EXISTS(SELECT cars2.price FROM cars cars2 WHERE cars.price>?) ORDER BY cars.price DESC";
        //prepare statement
        $stmt = $mysqli->prepare($sql);
        //bind parameters to statement
        $stmt->bind_param("d",$_GET['minprice']);
        //execute the statement
        $stmt->execute();
        //bind results to executed statement
        $stmt->bind_result($model,$price,$type,$company,$year);
    ?>
    <!--
        The table displayed here is the same as the one in page2.php
        -->
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
            echo '<td><a class="stdbtn" href ="car_info.php?car_model='.$model.'">'.$model.'</a></td>';
            echo '<td>'.$price.'</td>';
            echo '<td>'.$type.'</td>';
            echo '<td>'.$company.'</td>';
            echo '<td>'.$year.'</td>';
            echo '<td><a class="stdbtn" href ="get_review.php?car_model='.$model.'">Add Review</a></td>';
            echo '</tr>';
        }
        $stmt->close();
        ?>
    </table>

</body>
</html>