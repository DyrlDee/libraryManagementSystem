<?php
include("config.php");
include("reusable.php");


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
customhead("My Notification");
loggedin_usertype("type");
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
		function searchUser() {
			var searchInput = document.getElementById('searchInput').value;
			window.location.href = 'search_user.php?query=' + searchInput;
		}
    </script>

	<body>

		<div class="container">
			
			<div class="notification-bar">
				<div class="notification-title">
					Notification
				</div>
			</div>
		
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
