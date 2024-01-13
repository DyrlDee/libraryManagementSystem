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

        <?php

                $loan_id = "";
                $reserve_id = "";
                $id ="";
                $fineExist = false;
                if(isset($_GET["loan_id"]) && $_GET["loan_id"] != ""){
                    //Run if it is a loan fine
                    $loan_id = $_GET["loan_id"];
                
                    //check if loan id is already in fine
                    $sql = "SELECT * FROM fine WHERE loan_id = $loan_id";
                    
                    $result = mysqli_query($conn, $sql);
                
                    if (mysqli_num_rows($result) > 0) {
                        // sorry but loan cannot be fined twice
                        $fineExist = true;
                    }
                    else{
                        $id = $_GET["loan_id"];
                    }
                
                }
                elseif(isset($_GET["reserve_id"]) && $_GET["reserve_id"] != ""){
                    //Run if it is a reserve fine
                
                    $reserve_id = $_GET["reserve_id"];
                
                    //check if reservation id is already in fine
                    $sql = "SELECT * FROM fine WHERE reserve_id = $reserve_id";
                    
                    $result = mysqli_query($conn, $sql);
                
                    if (mysqli_num_rows($result) > 0) {
                        // sorry but reservation cannot be fined twice
                        $fineExist = true;
                    }
                    else{
                        $id = $_GET["reserve_id"];
                    }
                
                }

                if(isset($_GET["email"]) && $_GET["email"] != ""){
                    $email = $_GET["email"];
                }

                if(isset($_GET["user_id"]) && $_GET["user_id"] != ""){
                    $user_id = $_GET["user_id"];
                }
            
        ?>

        <?php 
        if($fineExist == false){
        ?>


        

        <?php
            
            if($loan_id != ""){
                echo "<h2 class='title'>Book Loan Fine</h2>";

                echo "<table border='1' width='80%' style='border-collapse: collapse;' class='Atable'>";
                echo "<thead>";
                echo "<tr>";
    
                echo " 
                <th width='5%'>No</th>
                <th width='45%'>Book Name</th>
                <th width='15%'>Date borrowed</th>
                <th width='15%'>Return Due</th>
                <th width='10%'>Return Status</th>
                ";
    
                echo "</tr>" . "\n\t\t";
                echo "</thead>";
    
                echo "<tbody>";

                $sql2 = "SELECT * FROM bookloan WHERE loan_id = $loan_id";
    
                $result2 = mysqli_query($conn, $sql2);
                if (mysqli_num_rows($result2) > 0) {
                    // output data of each row 
                    $numrow=1;
                    while($row = mysqli_fetch_assoc($result2)) {
                        echo "<tr>";
                        echo "<td data-title='No' class='rowNumber'>" . $numrow . "</td><td data-title='Book Name'>". $row["book_name"]. "</td><td data-title='Date borrowed'>" . $row["date_start"] .
                        "</td><td data-title='Return Due'>" . $row["date_end"] . "</td><td data-title='Return Status'>" . $row["hasReturn"] 
                        . "</td>";
                        echo "</tr>" . "\n\t\t";
                        $numrow++;
                    }
                } else {
                    echo '<tr><td colspan="5">0 results</td></tr>';
                }
                echo "</tbody>";
                echo "</table>";
                
            }
            elseif($reserve_id != ""){

                echo "<h2 class='title'>Reservation Fine</h2>";

                echo "<table border='1' width='80%' style='border-collapse: collapse;' class='Atable'>";
                echo "<thead>";
                echo "<tr>";

                echo " 
                <th width='5%'>No</th>
                <th width='45%'>Facility Name</th>
                <th width='15%'>Date</th>
                <th width='15%'>time_start</th>
                <th width='10%'>time_end</th>
                ";

                echo "</tr>" . "\n\t\t";
                echo "</thead>";

                echo "<tbody>";
                $sql3 = "SELECT * FROM reservation JOIN user ON reservation.user_id = user.user_id JOIN facility ON reservation.faci_id = facility.faci_id WHERE user.user_email = '$email'";
                
                $result3 = mysqli_query($conn, $sql3);
                if (mysqli_num_rows($result3) > 0) {
                    // output data of each row 
                    $numrow=1;
                    while($row = mysqli_fetch_assoc($result3)) {
                        echo "<tr>";
                        echo "<td data-title='No' class='rowNumber'>" . $numrow . "</td><td data-title='Facility Name'>". $row["faci_name"]. "</td><td data-title='Date'>" . $row["date"] .
                        "</td><td data-title='time_start'>" . $row["time_start"] . "</td><td data-title='time_end'>" . $row["time_end"] 
                        . "</td>";
                        echo "</tr>" . "\n\t\t";
                        $numrow++;
                    }
                } else {
                    echo '<tr><td colspan="5">0 results</td></tr>';
                }
                echo "</tbody>";
                echo "</table>";

            }

           
            
        ?>

        <div class="fineEditForm">
            <form action="add_fine_action.php" method="POST">
                <input type="hidden" name="user_id" value = '<?php echo"$user_id"; ?>'>
                <input type="hidden" name="id" value = '<?php echo"$id"; ?>'>
                <input type="hidden" name="email" value = '<?php echo"$email"; ?>'>

                <?php
                    if($loan_id != ""){
                        echo "<input type='hidden' name='type' value ='loan'>";
                    }   
                    elseif($reserve_id != ""){
                        echo "<input type='hidden' name='type' value ='reservation'>";
                    }
                ?>

                <div class="sepInput">
                    <label for="">Fine Category</label>
                    <select name='fine_category' id=''>
                        <?php
                            if($loan_id != ""){

                                echo "<option value='Damage Book'>Damaged Book</option>";
                                echo "<option value='Book Lost'>Book Lost</option>";
                                echo "<option value='Late Book Return'>Late Book Return</option>";
                                
                            }
                            elseif($reserve_id != ""){

                                echo "<option value='Damaged Facility'>Damaged Facility</option>";
                                echo "<option value='Key Lost'>Key Lost</option>";
                                echo "<option value='Late Key Return'>Late Key Return</option>";
            
                            }
                        
                        ?>
                    </select>
                   
                </div>
                
                <div>
                    <label for="">Description</label>    
                </div>
            
                <div>
                    <textarea name="fine_description" id="" cols="30" rows="5"></textarea>
                </div>

               
                <div class="sepInput">
                    <label for=''>Fine Fee</label>
                    <input type="text" name="fine_fee" value="">
                </div>

                
                
                
                <div class="sepInput">
                    <Label>Status</Label>
                    <select name="status" id="">
                    <option value='pending'>pending</option>
                    <option value='settled'>settled</option>
                    </select>
                </div>
                <br>
                
                <div>
                    <input type="submit" name="" id="" value="Fine">
                </div>
                

            </form>
        </div>

        <?php
        }
        else {
        ?>
        <h2 class="title">Fine Failed</h2>
        <p class='not_exist'> Fine already has been issued for this loan/eservation</p>
        
        <?php
            echo '<a class="addlink" style="background-color:#794FCD; color:#fff; border-radius:3px;" href="staff_fine_page.php?email=' . $email . '">Back</a>';
        ?>
        

        <?php
        }
        mysqli_close($conn);
        ?>
        

            


    </body>
</html>
