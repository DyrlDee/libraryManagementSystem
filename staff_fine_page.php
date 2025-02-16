<?php
session_start();

include("config.php");
include("reusable.php");

sessionvalidation("user_id");

$user_id = $_SESSION["user_id"];
customhead("Fine");
loggedin_usertype("type");
?>
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

                    if(isset($_GET["email"]) && $_GET["email"] !=""){

                        $email =  $_GET["email"];
                        $sql0 = "SELECT * FROM user WHERE user_email = '$email'";
                        $sql = "SELECT * FROM fine JOIN user ON fine.user_id = user.user_id WHERE user.user_email = '$email'";
                        $sql2 = "SELECT * FROM bookloan JOIN user ON bookloan.user_id = user.user_id JOIN book ON bookloan.book_id = book.book_id WHERE user.user_email = '$email'"; //list all user book loan history
                        $sql3 = "SELECT * FROM reservation JOIN user ON reservation.user_id = user.user_id JOIN facility ON reservation.faci_id = facility.faci_id WHERE user.user_email = '$email'"; //list all user reservatio history
                        $result = mysqli_query($conn, $sql0);
                        $row = mysqli_fetch_assoc($result);
                        
                        
                        
                        echo "<div>";
                        
                        
                        if($row){
                            echo "<h3 style='font-weight:600' class='displayInfo'> User Info </h3>";
                            echo "<h3 class='displayInfo'> Username: " . $row["user_name"] . "</h3>";
                            echo "<h3 class='displayInfo'> Email: " . $row["user_email"] . "</h3>";

                            //assign user id
                            $user_id = $row["user_id"];

                            //User fine list table
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
                                $numrow=1;
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td data-title='No' class='rowNumber'>" . $numrow . "</td><td data-title='Fine Category'>". $row["fine_category"]. "</td><td data-title='Description'>" . $row["fine_description"] .
                                    "</td><td data-title='Fine Fee'>" . $row["fine_fee"] . "</td><td data-title='Status'>" . $row["status"] 
                                    . "</td>";
                                    echo '<td> <a class="link-btn" href="edit_fine.php?fine_id=' . $row["fine_id"] . '&email='. $email.'">Edit</a>&nbsp;&nbsp;';
                                    echo '<a class="link-btn" href="delete_fine.php?id=' . $row["fine_id"] . 
                                    '&email='. $email.'" onClick="return confirm(\'Delete?\');">Delete</a> </td>';
                                    echo "</tr>" . "\n\t\t";
                                    $numrow++;
                                }
                                } else {
                                echo '<tr><td colspan="6">User has no fine history</td></tr>';
                            }
                            echo "</tbody>";
                            echo "</table>";

                            //BOOK LOAN TABLE
                            echo "<br>";
                            echo "<h3 style='font-weight:600' class='displayInfo'> Book loan history </h3>";

                            echo "<br>";
                            echo "<table border='1' width='80%' style='border-collapse: collapse;' class='Atable'>";
                            echo "<thead>";
                            echo "<tr>";

                            echo " 
                            <th width='5%'>No</th>
                            <th width='45%'>Book Name</th>
                            <th width='15%'>Date borrowed</th>
                            <th width='15%'>Return Due</th>
                            <th width='10%'>Return Status</th>
                            <th width='10%'></th>
                            ";

                            echo "</tr>" . "\n\t\t";
                            echo "</thead>";

                            echo "<tbody>";
                            
                            $result2 = mysqli_query($conn, $sql2);
                            if (mysqli_num_rows($result2) > 0) {
                                // output data of each row 
                                $numrow=1;
                                while($row = mysqli_fetch_assoc($result2)) {
                                    echo "<tr>";
                                    echo "<td data-title='No' class='rowNumber'>" . $numrow . "</td><td data-title='Book Name'>". $row["book_name"]. "</td><td data-title='Date borrowed'>" . $row["date_start"] .
                                    "</td><td data-title='Return Due'>" . $row["date_end"] . "</td><td data-title='Return Status'>" . $row["hasReturn"] 
                                    . "</td>";
                                    echo '<td> <a class="link-btn-red" href="add_fine.php?loan_id=' . $row["loan_id"] . '&email='. $email.'&user_id='. $user_id.'">Fine</a></td>';
                                    echo "</tr>" . "\n\t\t";
                                    $numrow++;
                                }
                            } else {
                                echo '<tr><td colspan=""6>0 results</td></tr>';
                            }
                            echo "</tbody>";
                            echo "</table>";

                          


                            //RESERVATION TABLE
                            echo "<br>";
                            echo "<h3 style='font-weight:600' class='displayInfo'> Reservation history </h3>";

                            echo "<br>";
                            echo "<table border='1' width='80%' style='border-collapse: collapse;' class='Atable'>";
                            echo "<thead>";
                            echo "<tr>";

                            echo " 
                            <th width='5%'>No</th>
                            <th width='45%'>Facility Name</th>
                            <th width='15%'>Date</th>
                            <th width='15%'>time_start</th>
                            <th width='10%'>time_end</th>
                            <th width='10%'></th>
                            ";

                            echo "</tr>" . "\n\t\t";
                            echo "</thead>";

                            echo "<tbody>";
                            
                            $result3 = mysqli_query($conn, $sql3);
                            if (mysqli_num_rows($result3) > 0) {
                                $numrow=1;
                                while($row = mysqli_fetch_assoc($result3)) {
                                    echo "<tr>";
                                    echo "<td data-title='No' class='rowNumber'>" . $numrow . "</td><td data-title='Facility Name'>". $row["faci_name"]. "</td><td data-title='Date'>" . $row["date"] .
                                    "</td><td data-title='time_start'>" . $row["time_start"] . "</td><td data-title='time_end'>" . $row["time_end"] 
                                    . "</td>";
                                    echo '<td> <a class="link-btn-red" href="add_fine.php?reserve_id=' . $row["reserve_id"] . '&email='. $email.'&user_id='. $user_id.'">Fine</a></td>';
                                    echo "</tr>" . "\n\t\t";
                                    $numrow++;
                                }
                            } else {
                                echo '<tr><td colspan=""6>0 results</td></tr>';
                            }
                            echo "</tbody>";
                            echo "</table>";

                            
                        }
                        else{
                            echo "<p class='not_exist'> The email you search $email , does not exist in the database</p>";
                        }
                        echo "</div>";
                       
                       
                    }
                    mysqli_close($conn);
        ?>

        <br>
        <br>
    
    </body>
</html>
