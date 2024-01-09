<?php
session_start();

include("config.php");

// $user_id = $_SESSION["user_id"];
?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,  initial-scale=1.0">
    <title>My Study KPI</title>
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
        if(isset($_SESSION["type"])){

            if($_SESSION["type"] == 1){
                // For Staff
                include 'staff_menu.php';
            }
            elseif($_SESSION["type"] == 2){
                //For User
                include 'user_menu.php';
            }
            
        }
        else {
            include 'user_menu.php';
            // include 'staff_menu.php';
            // include 'menu.php';
        }
        ?>
        <h2 class="title">Manage Fine</h2>

        <!-- Form search user -->
        <div class="search">
            <form action="staff_fine_page.php" method="GET">
                <label for="email">User Email</label>
                <input type="email" name="email">
                <input type="submit" name="" id="" value="search">
            </form>
        </div>
       
        <?php

                    if(isset($_GET["email"]) && $_GET["email"] != ""){

                        $email =  $_GET["email"];
                        
                        $sql = "SELECT * FROM fine JOIN user ON fine.user_id = user.user_id WHERE user.user_email = '$email'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        
                        
                        
                        echo "<div>";
                        
                        
                        if($row){
                            echo "<h3 style='font-weight:600' class='displayInfo'> User Info </h3>";
                            echo "<h3 class='displayInfo'> Username: " . $row["user_name"] . "</h3>";
                            echo "<h3 class='displayInfo'> Email: " . $row["user_email"] . "</h3>";


                            echo "<br>";
                            echo "<table border='1' width='80%' style='border-collapse: collapse;' class='Atable'>";
                            echo "<thead>";
                            echo "<tr>";
    
                            echo " 
                            <th width='5%'>No</th>
                            <th width='20%'>Fine Category</th>
                            <th width='30%'>Description</th>
                            <th width='20%'>Fine Fee</th>
                            <th width='15%'>Status</th>
                            <th width='10%'></th>
                            ";
    
                            echo "</tr>" . "\n\t\t";
                            echo "</thead>";
    
                            echo "<tbody>";
    
                            
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row 
                                $numrow=1;
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td data-title='No' class='rowNumber'>" . $numrow . "</td><td data-title='Fine Category'>". $row["fine_category"]. "</td><td data-title='Description'>" . $row["fine_description"] .
                                    "</td><td data-title='Fine Fee'>" . $row["fine_fee"] . "</td><td data-title='Status'>" . $row["status"] 
                                    . "</td>";
                                    echo '<td> <a class="link-btn" href="edit_fine.php?id=' . $row["fine_id"] . '">Edit</a>&nbsp;&nbsp;';
                                    echo '<a class="link-btn" href="delete_fine.php?id=' . $row["fine_id"] . 
                                    '" onClick="return confirm(\'Delete?\');">Delete</a> </td>';
                                    echo "</tr>" . "\n\t\t";
                                    $numrow++;
                                }
                                } else {
                                echo '<tr><td colspan="6">0 results</td></tr>';
                            }
                            echo "</tbody>";
                            echo "</table>";
                            echo "<a class='addlink' href=''>Add Fine <i class='fa fa-plus-circle' aria-hidden='true'></i></a>";
                            
                        }
                        else{
                            echo "<p class='not_exist'> The email you search $email , does not exist in the database</p>";
                        }
                        echo "</div>";
                       
                       
                    }
                    mysqli_close($conn);
        ?>

    </body>
</html>
