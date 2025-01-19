<?php
session_start();

include("config.php");
include("reusable.php");

customhead("Manage Notification");
usertype("type");
?>
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
		<h2 class="title">Manage Notification</h2>
		
		<div class="container">

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

			$sql0 = "SELECT * FROM user WHERE user_email = '$email'";
			$sql = "SELECT * FROM notification JOIN user ON notification.user_id = user.user_id WHERE user.user_email = '$email'";
			$result = mysqli_query($conn, $sql0);
			$row = mysqli_fetch_assoc($result);

			echo "<div>";
			if($row){
			echo "<h3 style='font-weight:600' class='displayInfo'> User Info </h3>";
			echo "<h3 class='displayInfo'> <b>Username</b>: " . $row["user_name"] . "</h3>";
			echo "<h3 class='displayInfo'> <b>Email:</b> " . $row["user_email"] . "</h3>";
			$result = mysqli_query($conn, $sql);
			if ($row = mysqli_fetch_assoc($result)) {
				

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

			} 

			echo "<a class='addlink' href='add_notification.php?email=" . urlencode($email) . "'>Add Notification <i class='fa fa-plus-circle' aria-hidden='true'></i></a>";

			}
			else {
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
			echo "<p style='color: #505050; font-size: 18px; font-family: Raleway; font-weight: 200;'>Search user by email address</p>";
		}
		mysqli_close($conn);
		?>


		</div>

    </body>
</html>