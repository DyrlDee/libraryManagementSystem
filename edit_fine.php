<?php
session_start();

include("config.php");

if(!isset($_SESSION["user_id"])){
    header("location:index.php"); 
}

$user_id = $_SESSION["user_id"];
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
        
        <div>
            <?php
                
                if(isset($_GET["fine_id"]) && $_GET["fine_id"] != ""){
                    
                    $fine_id = $_GET["fine_id"];
                    $sql = "SELECT * FROM fine JOIN user ON fine.user_id = user.user_id WHERE fine.fine_id = $fine_id";
                    //echo $sql . "<br>";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $fine_category = $row["fine_category"];
                        $fine_description = trim($row["fine_description"]);
                        $fine_fee = $row["fine_fee"];
                        $status = $row["status"];
                        $user_name = $row["user_name"];
                        $user_email = $row["user_email"];
                        $loan_id = $row["loan_id"];
                        $reserve_id =$row["reserve_id"];

                    }
                }
                mysqli_close($conn);
            
            ?>
        </div>

        <?php

            if($loan_id){
                echo "<h2 class='title'>Edit Book fine</h2>";
                
            }
            elseif($reserve_id){
                echo "<h2 class='title'>Edit Facility fine</h2>";
            }
            
        ?>

        <div class="EditFineInfo">
            <p> <b>Username:</b>  <?php echo "$user_name";?></p>
            <p> <b>Username:</b>  <?php echo "$user_email";?></p>
            <p> <b>Fine Category:</b>  <?php echo "$fine_category";?></p>
            <p><b>Description:</b></p>
            <div style="text-align: justify;">
                <?php echo "$fine_description";?>
            </div>
            <p><b>Fine fee:</b>  RM<?php echo "$fine_fee";?></p>
            <p><b>Status:</b> <?php echo "$status";?></p>
            
        </div>

        <div class="fineEditForm">
            <form action="edit_fine_action.php" method="POST">

                <input type="hidden" name="fine_id" value = "<?php echo"$fine_id"; ?>">
                <input type="hidden" name="email" value = "<?php echo"$user_email"; ?>">
                <div class="sepInput">
                    <label for="">Fine Category</label>
                    <select name='fine_category' id=''>
                        <?php
                            if($loan_id){

                                if($fine_category=="Damaged Book"){
                                    echo "<option value='Damage Book' selected>Damaged Book</option>";
                                }
                                else{
                                    echo "<option value='Damage Book'>Damaged Book</option>";
                                }

                                if($fine_category=="Book Lost"){
                                    echo "<option value='Book Lost' selected>Book Lost</option>";
                                }
                                else{
                                    echo "<option value='Book Lost'>Book Lost</option>";
                                }

                                if($fine_category=="Late Book Return"){
                                    echo "<option value='Late Book Return' selected>Late Book Return</option>";
                                }
                                else{
                                    echo "<option value='Late Book Return'>Late Book Return</option>";
                                }
                                
                            }
                            elseif($reserve_id){
                                
                                if($fine_category=="Damaged Facility"){
                                    echo "<option value='Damaged Facility' selected>Damaged Facility</option>";
                                }
                                else{
                                    echo "<option value='Damaged Facility'>Damaged Facility</option>";
                                }

                                if($fine_category=="Key Lost"){
                                    echo "<option value='Key Lost' selected>Key Lost</option>";
                                }
                                else{
                                    echo "<option value='Key Lost'>Key Lost</option>";
                                }

                                if($fine_category=="Late Key Return"){
                                    echo "<option value='Late Key Return' selected>Late Key Return</option>";
                                }
                                else{
                                    echo "<option value='Late Key Return'>Late Key Return</option>";
                                }
                            }
                        
                        ?>
                    </select>
                   
                </div>
                
                <div>
                    <label for="">Description</label>    
                </div>
            
                <div>
                    <textarea name="fine_description" id="" cols="30" rows="5"><?php echo "$fine_description";?></textarea>
                </div>

               
                <div class="sepInput">
                    <label for=''>Fine Fee</label>
                    <input type="text" name="fine_fee" value="<?php echo $fine_fee; ?>">
                </div>

                
                
                
                <div class="sepInput">
                    <Label>Status</Label>
                    <select name="status" id="">

                        <?php
                        
                            if($status=="pending"){
                                echo "<option value='pending' selected>pending</option>";
                            }
                            else{
                                echo "<option value='pending'>pending</option>";
                            }

                            if($status=="settled"){
                                echo "<option value='settled' selected>settled</option>";
                            }
                            else{
                                echo "<option value='settled'>settled</option>";
                            }
                        
                        ?>

                    </select>
                </div>
                <br>
                
                <div>
                    <input type="submit" name="" id="" value="Update">
                </div>
                

            </form>
        </div>

    </body>
</html>
