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
    <title>Manage Notification</title>
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
            //include 'user_menu.php';
            include 'staff_menu.php';
            // include 'menu.php';
        }
        ?>
		
		<h2 class="title">List of Library Users</h2>
		
		<div class="container">

        <?php
        // Fetch user details from the database
        $sql = "SELECT * FROM user";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<table border='1' width='80%' style='border-collapse: collapse;' class='Atable'>";
            echo "<thead>";
            echo "<tr>";

            echo " 
                <th width='5%'>No</th>
                <th width='5%'>User ID</th>
                <th width='30%'>Username</th>
                <th width='30%'>Email</th>
                <th width='20%'>Phone Number</th>
				<th width='10%'></th>
            ";

            echo "</tr>" . "\n\t\t";
            echo "</thead>";

            echo "<tbody>";

			$count = 1; // Initialize the count variable

            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td data-title='No'>" . $count . "</td>";
                echo "<td data-title='User ID'>" . $row["user_id"] . "</td>";
                echo "<td data-title='Username'>" . $row["user_name"] . "</td>";
                echo "<td data-title='Email'>" . $row["user_email"] . "</td>";
                echo "<td data-title='Phone Number'>" . $row["phone_number"] . "</td>";
				echo '<td> <a class="link-btn" href="">View</a>&nbsp;&nbsp;';
                echo "</tr>";
				$count++; // Increment the count for each row
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p class='not_exist'> No users found.</p>";
        }

        mysqli_close($conn);
        ?>

		</div>

		<footer>
			<br>Copyright 2023.</br>
		</footer>

    </body>
</html>