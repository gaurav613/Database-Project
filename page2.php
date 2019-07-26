<!--This page displays the final table, which is the data that gets filtered through index.php.
<This table displays information about the car such as the model name, its price, its type, the company that makes it, and the year it was made in.
<In this page, the model names act as links to a page that displays additional details about that model
On this page, the user also has an option to add their review to a car that they might have experience with.-->
<html>
<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.1/build/pure-min.css" integrity="sha384-oAOxQR6DkCoMliIh8yFnu25d7Eq/PHS21PClpwjOTeU2jRSq11vu66rf90/cZr47" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="style.css">
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
<body>
<div class="header">
  <h1>All About Cars</h1>
  <p>MSCI 346 Term Project</p>
  
    <a class="stdbtn" href="index.php">Main Page</a>
  
  <p>Click name of the car to get more information about it!</p>
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
        //the base query, filters keep getting added, depending on how the inputs are made
        $sqlBase = "SELECT s.cmodel, s.price, t.type, c.company_name, m.year FROM types t NATURAL JOIN oftype NATURAL JOIN cars s NATURAL JOIN makes m NATURAL JOIN company c ";
        $add = "";//additional string, that keeps changing as filters get added
    
    //Company Name Filter
        if(!empty($_GET['company_ids']))//if the user has selected companies
        {
            $add .= " WHERE (";
            foreach($_GET['company_ids'] as $id)//loop through the list of names
            {
                $add .= "c.company_id = " . $id . " OR ";//keep adding the names as filters
            }
            $add = substr($add, 0, -3);//getting rid of final 'OR' from the query
            $add .= ") AND ";
        }

        else
        {
            $add .= " WHERE ";
        }

    //Price Filter
        $min_price = (empty($_GET['minprice']) ? '0' : $_GET['minprice']);//if the minimum price input is empty, it is set to 0
        $max_price = (empty($_GET['maxprice']) ? '4300000' : $_GET['maxprice']);//if the maximum price input is empty, it is set to the maximum price in the database(found form phpmyadmin)
        $add .=" (s.price BETWEEN $min_price AND $max_price)";//adding the price filter query
    
    //Type Filter
        if(!empty($_GET['car_types']))//if the user has selected type(s) of car
        {
            $add .= " AND (";
            foreach($_GET['car_types'] as $type)//loop through the list of types
            {
                $add .= "t.type = '" . $type . "' OR ";//keep adding the types as filters
            }
            $add = substr($add, 0, -3);//getting rid of final 'OR' from the query
            $add .= ")";
        }
        
        
    //Group by Filter
        if(!empty($_GET['group_by']))//if an option is chosen
        {
            $val =$_GET['group_by'];
            if($val=='company_name')//if chosen to group by company
            {
                $add .= " ORDER BY c.company_name";//upon implementing this, it was seen that GROUP BY used to get rid of duplicates, so ORDER BY was another option, without getting rid of duplicates
            }

            if($val=='type')//if chosen to group by company
            {
                $add .= " ORDER BY t.type";//same as above
            }
          
        }
        
        $sql = $sqlBase . $add ;//add the clauses to the base query
        //prepare statement
        $stmt = $mysqli->prepare($sql);
        //execute statement
        $stmt->execute();
        //bind results 
        $stmt->bind_result($cars_cmodel, $price, $type, $company_name,$year);

    ?>
    <!--The data gets output in tabular form-->
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
            echo '<td><a class="stdbtn" href ="car_info.php?car_model='.$cars_cmodel.'">'.$cars_cmodel.'</a></td>';//manipulating the URL of the PHP page that it is directed to, in order to go to a specific model's info page
            echo '<td>'.$price.'</td>';
            echo '<td>'.$type.'</td>';
            echo '<td>'.$company_name.'</td>';
            echo '<td>'.$year.'</td>';
            echo '<td><a class="stdbtn" href ="get_review.php?car_model='.$cars_cmodel.'">Add Review</a></td>';//manipulating the URL of the PHP page that it is directed to, in order to add review for the specific model
            echo '</tr>';
        }
        $stmt->close();
        ?>
    </table>
    
</body>
</html>
