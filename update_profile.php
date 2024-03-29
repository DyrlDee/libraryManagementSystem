<!--Written by: Donna Moncigil Losantas(BI21110374)-->

<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];
$type = $_SESSION['type'];

if(isset($_POST['update_profile'])){

   $old_pass = $_POST['old_pass'];
   $update_pass;
   $new_pass;
   $confirm_pass;

   if($type == 1){
      //staff doesn't need md5
      $update_pass = mysqli_real_escape_string($conn, ($_POST['update_pass']));
      $new_pass = mysqli_real_escape_string($conn, ($_POST['new_pass']));
      $confirm_pass = mysqli_real_escape_string($conn, ($_POST['confirm_pass']));
   }
   elseif($type == 2){
      //user need md5
      $update_pass = mysqli_real_escape_string($conn, md5($_POST['update_pass']));
      $new_pass = mysqli_real_escape_string($conn, md5($_POST['new_pass']));
      $confirm_pass = mysqli_real_escape_string($conn, md5($_POST['confirm_pass']));
   }
   
   $phone_number = $_POST["phone_number"];
   $ic_number = $_POST["ic_number"];

   if($phone_number != ""){
      mysqli_query($conn, "UPDATE `user` SET phone_number = '$phone_number' WHERE user_id = '$user_id'") or die('query failed');
   }
   
   if($ic_number != ""){
      mysqli_query($conn, "UPDATE `user` SET ic_number = '$ic_number' WHERE user_id = '$user_id'") or die('query failed');
   }


   if($update_pass !="" || $new_pass !="" || $confirm_pass !=""){
      if($update_pass != $old_pass){
         $message[] = 'old password not matched!';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'confirm password not matched!';
      }else{
         mysqli_query($conn, "UPDATE `user` SET password = '$confirm_pass' WHERE user_id = '$user_id'") or die('query failed');
         $message[] = 'password updated successfully!';
      }
   }

   $update_image = $_FILES['update_image']['name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_folder = 'uploaded_img/'.$update_image;

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image is too large';
      }else{
         $image_update_query = mysqli_query($conn, "UPDATE `user` SET profile_img = '$update_image' WHERE user_id = '$user_id'") or die('query failed');
         if($image_update_query){
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
         }
         $message[] = 'image updated succssfully!';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width,  initial-scale=1.0">
   <title>Update Profile</title>
   <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,400&family=Raleway:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>
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

<div class="update-profile">

   <?php
      $select = mysqli_query($conn, "SELECT * FROM `user` WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select) > 0){
         $fetch = mysqli_fetch_assoc($select);
      }
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      <?php
         if($fetch['profile_img'] == ''){
            echo '<img src="images/default-avatar.png">';
         }else{
            echo '<img src="uploaded_img/'.$fetch['profile_img'].'">';
         }
         if(isset($message)){
            foreach($message as $message){
               echo '<div class="message">'.$message.'</div>';
            }
         }
      ?>
      <div class="flex">
         <div class="inputBox">
            <span>username :</span>
            <div class="box" style ="border:1px;"><?php echo $fetch['user_name']; ?></div>
            <!-- <input type="text" name="update_name" value="<?php echo $fetch['user_name']; ?>" class="box"> -->
            <span>your email :</span>
            <div class="box" style ="border:1px;"><?php echo $fetch['user_email']; ?></div>
            <span>Ic number :</span>
            <input type="text" name="ic_number" placeholder="enter ic number" value="<?php echo $fetch['ic_number']; ?>" class="box">
            <span>update your pic :</span>
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
         </div>
         <div class="inputBox">
            <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">
            <span>old password :</span>
            <input type="password" name="update_pass" placeholder="enter previous password" value="" class="box">
            <span>new password :</span>
            <input type="password" name="new_pass" placeholder="enter new password"  value="" class="box">
            <span>confirm password :</span>
            <input type="password" name="confirm_pass" placeholder="confirm new password" value="" class="box">
            <span>Phone Number :</span>
            <input type="text" name="phone_number" placeholder="Phone Number" value="<?php echo $fetch['phone_number']; ?>" class="box">
         </div>
      </div>
      <input type="submit" value="update profile" name="update_profile" class="btn">
      <a href="profile.php" class="delete-btn">go back</a>
   </form>

</div>

</body>
</html>