<!--Written by: Donna Moncigil Losantas(BI21110374)-->

<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
   <meta name="viewport" content="width=device-width,  initial-scale=1.0">
   <title>Your Profile</title>
   <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,400&family=Raleway:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'user_menu.php'; ?>


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
</div>

</body>
</html>