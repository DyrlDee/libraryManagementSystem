<?php
session_start();
include("config.php");

if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
}

$query = "SELECT * FROM report";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Fetch the data from the result set
$row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Report</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,400&family=Raleway:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<script>
    function myFunction() {
        var x = document.getElementById("myTopHeader");
        if (x.className === "myTopHeader") {
            x.className += " responsive";
        } else {
            x.className = "myTopHeader";
        }
    }
</script>

<body>
        
        <?php
            include 'user_menu.php';
            // include 'staff_menu.php';
            // include 'menu.php';
        ?>
    
    <!-- report bar -->

    <div class="container">
        <h1 class = "title">User report</h1>
        <div class="section_table_1">
            <table border="1" width="80%" style="border-collapse: collapse;" class="Atable">

            <thead>
               <tr class = "report_columns">
                   <th class = "No">No</th>
                   <th class = "Report Category">Report Category</th>
                   <th class = "Description">Description</th>
                   <th class = "Status">Status</th>
               </tr>                    
            </thead>
            
            <tbody>
            <?php
            $sql = "SELECT * FROM report WHERE user_id = $user_id"; 
            //SELECT * FROM fine WHERE user_id = $user_id actual code
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
            // output data of each row 
            $numrow=1;
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td data-title='No' class='rowNumber'>" . $numrow . "</td><td data-title='Report Category'>". $row["report_category"]. "</td><td data-title='Description'>" . $row["report_description"] .
                "</td><td data-title='Status'>" . $row["status"] . "</td>";
                echo "</tr>" . "\n\t\t";
                $numrow++;
            }
            } else {
            echo '<tr><td colspan="4">0 results</td></tr>';
            } 
            mysqli_close($conn); 
            ?>

        </tbody>

            </table> 
        </div>
    </div>

</body>

</html>
