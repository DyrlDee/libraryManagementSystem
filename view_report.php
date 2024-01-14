<?php
include("config.php");

// Fetch notifications for the current user
if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $query = "SELECT * FROM notification WHERE user_id = $user_id";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Fetched notifications array
    $notifications = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Report</title>
    <link rel="stylesheet" href="./style.css">
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
        // if(isset($_SESSION["type"])){

        //     if($_SESSION["type"] == 1){
        //         // For Staff
        //         include 'staff_menu.php';
        //     }
        //     elseif($_SESSION["type"] == 2){
        //         //For User
        //         include 'user_menu.php';
        //     }
            
        // }
        // else {
        //     include 'user_menu.php';
        //     // include 'staff_menu.php';
        //     // include 'menu.php';
        // }
        ?>
        
        <?php
            include 'user_menu.php';
            // include 'staff_menu.php';
            // include 'menu.php';
        ?>
    
    <!-- report bar -->

    <div class="report_container">
        <h1 class = "title_s">User report</h1>
        <div class="section_table_1">
            <table class = "report_table">

               <tr class = "report_columns">
                   <td class = "No"> No </td>
                   <td class = "Report Category"> Report Category </td>
                   <td class = "Description"> Description </td>
                   <td class = "Status"> Status </td>
               </tr>                    

               <?php
              // Assuming $conn is your database connection
              $sql = "SELECT * FROM report WHERE user_id = ?";
              $stmt = mysqli_prepare($conn, $sql);
                    
              if ($stmt) {
                  mysqli_stmt_bind_param($stmt, 's', $userMatric);
                  mysqli_stmt_execute($stmt);
                  $result = mysqli_stmt_get_result($stmt);
              
                  if (!$result) {
                      die('Error: ' . mysqli_error($conn));
                  }
                
                  $total_rows = mysqli_num_rows($result);
                
                  if ($total_rows > 0) {
                      // Output data of each row 
                      while ($row = mysqli_fetch_assoc($result)) {
                        
                      }
                  } else {
                      echo '<tr><td colspan="6">0 results</td></tr>';
                  }
                
                  mysqli_stmt_close($stmt);
                  mysqli_close($conn);
              } else {
                  die('Error in preparing the statement: ' . mysqli_error($conn));
              }
              ?>

            </table> 
        </div>
    </div>

    <footer>
        <br>Copyright 2023.</br>
    </footer>
</body>

</html>
