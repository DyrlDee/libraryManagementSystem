<?php
session_start();

include("config.php");
include("reusable.php");

if (isset($_GET['id'])) {
    $noti_id = urldecode($_GET['id']);

    // Fetch notification details using the noti_id
    $sqlNotificationDetails = "SELECT * FROM notification WHERE noti_id = '$noti_id'";
    $resultNotificationDetails = mysqli_query($conn, $sqlNotificationDetails);

    if ($rowNotificationDetails = mysqli_fetch_assoc($resultNotificationDetails)) {
        // Retrieve user details using the user_id associated with the notification
        $user_id = $rowNotificationDetails["user_id"];
        $sqlUserDetails = "SELECT * FROM user WHERE user_id = '$user_id'";
        $resultUserDetails = mysqli_query($conn, $sqlUserDetails);

        if ($rowUserDetails = mysqli_fetch_assoc($resultUserDetails)) {
            $username = $rowUserDetails["user_name"];
            $email = $rowUserDetails["user_email"];
            $phone = $rowUserDetails["phone_number"];
            $notification = $rowNotificationDetails["noti_description"];

            // You can fetch other user details if needed
        } else {
            // Handle the case where user details are not found
            // You may want to redirect or display an error message
            // header("Location: error.php");
            // exit();
        }
    } else {
        // Handle the case where notification details are not found
        // You may want to redirect or display an error message
        // header("Location: error.php");
        // exit();
    }
} else {
    // Handle the case where noti_id is not provided in the URL
    // You may want to redirect or display an error message
    // header("Location: error.php");
    // exit();
}

customhead("Send Notification");
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

    <h2 class="title">Edit Notification</h2>

    <div class="container">
		
		<div class="user-display">Username: <?php echo $username; ?></div>
		<div class="user-display">Email: <?php echo $email; ?></div>
		<div class="user-display">Phone Number: <?php echo $phone; ?></div>
		
		<div class="notification-msg"><?php echo $notification; ?></div>
		
		<div class="notification-form">
			<form action="" method="POST">
				<label for="notification">New Notification:</label>
				<textarea id="notification" name="notification" rows="3" required></textarea>
				<input type="submit" value="Edit Notification">
			</form>
		</div>

		<?php
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (isset($_POST['notification'])) {
				$notification = htmlspecialchars($_POST['notification']);

				// Update the notification in the database
				$sqlUpdateNotification = "UPDATE notification SET noti_description = ? WHERE noti_id = ?";
				$stmt = mysqli_prepare($conn, $sqlUpdateNotification);
				mysqli_stmt_bind_param($stmt, "si", $notification, $noti_id);

				if (mysqli_stmt_execute($stmt)) {
					// Notification successfully updated in the database
					echo '<p class="noti-sent">Notification updated successfully.</p>';
				} else {
					// Handle the case where update fails
					echo "Error: " . mysqli_error($conn);
				}
			} else {
				// Handle the case where notification is not provided
				//echo "Invalid form submission.";
			}
		} else {
			// Handle invalid request method
			//echo "Invalid request method.";
		}

		mysqli_close($conn);
		?>


    </div>

    <footer>
        <br>Copyright 2023.</br>
    </footer>

</body>
</html>
