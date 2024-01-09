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
            include 'user_menu.php';
            // include 'staff_menu.php';
            // include 'menu.php';
        }
        ?>
		
		<h2 class="title">Manage Notification</h2>
		
		<div class="container">

		<!-- Form search user -->
		<div class="search">
			<form action="#.php" method="GET">
				<label for="email">User Email : </label>
				<input type="email" name="email" id="email">
				<input type="submit" name="" id="" value="Search">
			</form>
		</div>

		<?php
		if (isset($_GET["email"]) && $_GET["email"] != "") {
			$email = $_GET["email"];

			$sql = "SELECT * FROM notification JOIN user ON notification.user_id = user.user_id WHERE user.user_email = '$email'";
			$result = mysqli_query($conn, $sql);

			echo "<div>";

			// Check if the email exists in the database
			if ($row = mysqli_fetch_assoc($result)) {
				echo "<h3 style='font-weight:600' class='displayInfo'> User Info </h3>";
				echo "<h3 class='displayInfo'> Username: " . $row["user_name"] . "</h3>";
				echo "<h3 class='displayInfo'> Email: " . $row["user_email"] . "</h3>";

				echo "<br>";
				echo "<table border='1' width='80%' style='border-collapse: collapse;' class='Atable'>";
				echo "<thead>";
				echo "<tr>";

				echo " 
					<th width='5%'>No</th>
					<th width='50%'>Notification</th>
					<th width='10%'></th>
				";

				echo "</tr>" . "\n\t\t";
				echo "</thead>";

				echo "<tbody>";

				$numrow = 1;

				do {
					echo "<tr>";
					echo "<td data-title='No' class='rowNumber'>" . $numrow . "</td><td data-title='Notification'>". $row["noti_description"]. "</td>";
					echo '<td> <a class="link-btn" href="edit_notification.php?id=' . $row["noti_id"] . '">Edit</a>&nbsp;&nbsp;';
					echo '<a class="link-btn" href="delete_notification.php?id=' . $row["noti_id"] . '" onClick="return confirm(\'Delete?\');">Delete</a> </td>';
					echo "</tr>" . "\n\t\t";
					$numrow++;
				} while($row = mysqli_fetch_assoc($result));

				echo "</tbody>";
				echo "</table>";
				
				echo "<a class='addlink' href='add_notification.php?email=" . urlencode($email) . "'>Add Notification <i class='fa fa-plus-circle' aria-hidden='true'></i></a>";


			} else {
				// Check if there are no notifications
				$sqlCheckUser = "SELECT * FROM user WHERE user_email = '$email'";
				$resultCheckUser = mysqli_query($conn, $sqlCheckUser);

				if (mysqli_num_rows($resultCheckUser) > 0) {
					echo "<p class='not_exist'> The email you searched, $email, has no notifications.</p>";
				} else {
					echo "<p class='not_exist'> The email you searched, $email, does not exist in the database.</p>";
				}
			}

			echo "</div>";
		} else {
			// Display search prompt when the page is loaded
			echo "<p style='color: #505050; font-size: 18px; font-family: Raleway; font-weight: 200;'>Search user by email address</p>";
		}
		mysqli_close($conn);
		?>


		</div>

		<footer>
			<br>Copyright 2023.</br>
		</footer>

    </body>
</html>