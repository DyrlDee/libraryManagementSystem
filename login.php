<!--Written by: Donna Moncigil Losantas(BI21110374)-->

<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
   $password = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select = mysqli_query($conn, "SELECT * FROM `user` WHERE user_email = '$user_email' AND password = '$password'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $row = mysqli_fetch_assoc($select);
      $_SESSION['user_id'] = $row['user_id'];
      header('location:home.php');
   }else{
      $message[] = 'incorrect email or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width,  initial-scale=1.0">
   <title>login</title>
   <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,400&family=Raleway:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" href="css/style.css">

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

</head>
<body>

<?php include 'menu.php'; ?>

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

</body>
</html>