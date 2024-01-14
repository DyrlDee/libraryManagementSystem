<!--Written by: Donna Moncigil Losantas(BI21110374)-->

<?php

include 'config.php';

if(isset($_POST['submit'])){

   $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
   $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
   $password = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $profile_img = $_FILES['profile_img']['name'];
   $image_size = $_FILES['profile_img']['size'];
   $image_tmp_name = $_FILES['profile_img']['tmp_name'];
   $image_folder = 'uploaded_img/'.$profile_img;

   $select = mysqli_query($conn, "SELECT * FROM `user` WHERE user_email = '$user_email' AND password = '$password'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $message[] = 'user already exist'; 
   }else{
      if($password != $cpass){
         $message[] = 'confirm password not matched!';
      }elseif($image_size > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $insert = mysqli_query($conn, "INSERT INTO `user`(user_name, user_email, password, profile_img) VALUES('$user_name', '$user_email', '$password', '$profile_img')") or die('query failed');

         if($insert){
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'registered successfully!';
            header('location:login.php');
         }else{
            $message[] = 'registeration failed!';
         }
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'menu.php'; ?>

<div class="form-container">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>register now</h3>
      <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
      <input type="text" name="user_name" placeholder="enter username" class="box" required>
      <input type="email" name="user_email" placeholder="enter email" class="box" required>
      <input type="password" name="password" placeholder="enter password" class="box" required>
      <input type="password" name="cpassword" placeholder="confirm password" class="box" required>
      <input type="file" name="profile_img" class="box" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" name="submit" value="submit" class="btn">
      <p>already have an account? <a href="index.php">login now</a></p>
   </form>

</div>

</body>
</html>