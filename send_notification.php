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
    <meta name="viewport" content="width=device-width,  initial-scale=1.0">
    <title>My Notification</title>
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
		function searchUser() {
			var searchInput = document.getElementById('searchInput').value;
			window.location.href = 'search_user.php?query=' + searchInput;
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
		
		<!-- notification bar -->

		<div class="container">
			
			<div class="notification-bar">
				<div class="notification-title">
					Notification
				</div>
			</div>

			<!-- notification message -->
			
			<?php
			if (count($notifications) > 0) {
				foreach ($notifications as $notification) {
					echo '<div class="notification-msg">' . $notification['noti_description'] . '</div>';
					echo '<div class="delete-msg"><a href="delete_notification.php?id=' . $notification['noti_id'] . '">Delete</a></div>';
				}
			} else {
				echo '<div class="no-notification-msg">You have no notification</div>';
			}
			?>
		</div>

		
		<footer>
			<br>Copyright 2023.</br>
		</footer>
	</body>

</html>
