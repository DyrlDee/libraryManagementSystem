<!--Written by: Donna Moncigil Losantas(BI21110374)-->

<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
   $password;
    //
   $select = mysqli_query($conn, "SELECT * FROM user WHERE user_email = '$user_email'") or die('query failed');
   //check if staff or not
   if(mysqli_num_rows($select) > 0){
        $row = mysqli_fetch_assoc($select);

        if($row['role'] == 1){
            $password = mysqli_real_escape_string($conn, ($_POST['password']));
            //staff doesn't need md5
        }
        elseif($row['role'] == 2){
            $password = mysqli_real_escape_string($conn, md5($_POST['password']));
            //user will need md5
        }
    }else{
        $message[] = 'incorrect email';
    }
   
    $select = mysqli_query($conn, "SELECT * FROM user WHERE user_email = '$user_email' AND password = '$password'") or die('query failed');
    if(mysqli_num_rows($select) > 0){
    $row = mysqli_fetch_assoc($select);
    $_SESSION['user_id'] = $row['user_id'];
    $_SESSION['type'] = $row['role'];
    header('location:index.php');
    }else{
        $message[] = 'incorrect email or password!';
    }
   

}

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
            // include 'user_menu.php';
            // include 'staff_menu.php';
            include 'menu.php';
        }
        ?>

            <?php 
            if(isset($_SESSION["user_id"])){
            
                $user_id = $_SESSION["user_id"];
            ?>

            <!-- USER ALREADY LOGIN -->

            <div class="home_layout">
            <?php
                    $select = mysqli_query($conn, "SELECT * FROM `user` WHERE user_id = '$user_id'") or die('query failed');
                    if(mysqli_num_rows($select) > 0){
                        $fetch = mysqli_fetch_assoc($select);
                    } 
            ?>
                <p>Welcome  <?php echo $fetch['user_name'];?>!</p>

                
                <a href="#" class="feature-button">Reserve Facility and Loan book anytime, anywhere </a>
                
                <a href="#" class="feature-button">Track your fine</a>
            
                <a href="#" class="feature-button">Get real time notification from library</a>
            
                

                
                </table>
            </div>
            

            <?php
            }
            else {
            ?>
                <!-- LOGIN FORM -->
                <div class="form-container">

                <form action="" method="post" enctype="multipart/form-data">
                <h3>login</h3>
                <?php
                if(isset($message)){
                    foreach($message as $message){
                        echo '<div class="message">'.$message.'</div>';
                    }
                }
                ?>
                <input type="user_email" name="user_email" placeholder="enter email" class="box" required>
                <input type="password" name="password" placeholder="enter password" class="box" required>
                <input type="submit" name="submit" value="login now" class="btn">
                <p>No account? <a href="register.php">Create new account</a></p>
                </form>

                </div>


            <?php
            }
            ?>

        

    </body>
</html>
