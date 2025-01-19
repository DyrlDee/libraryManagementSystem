<?php
session_start();

include("config.php");
include("reusable.php");


if (isset($_GET['email'])) {
    $user_email = urldecode($_GET['email']);

    $sqlUserDetails = "SELECT * FROM user WHERE user_email = '$user_email'";
    $resultUserDetails = mysqli_query($conn, $sqlUserDetails);

    if ($rowUserDetails = mysqli_fetch_assoc($resultUserDetails)) {
        $username = $rowUserDetails["user_name"];
        $id = $rowUserDetails["user_id"];
        $email = $rowUserDetails["user_email"];
        $phone = $rowUserDetails["phone_number"];
        // You can fetch other user details if needed
    } else {
        // Handle the case where user details are not found
        // You may want to redirect or display an error message
        // header("Location: error.php");
        // exit();
    }
} else {
    // Handle the case where email is not provided in the URL
    // You may want to redirect or display an error message
    // header("Location: error.php");
    // exit();
}
customhead('Send Notification');
usertype($type);
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


    <h2 class="title">Send Notification</h2>

    <div class="container">
		
		<div class="user-display">Username: <?php echo $username; ?></div>
		<div class="user-display">Email: <?php echo $email; ?></div>
		<div class="user-display">Phone Number: <?php echo $phone; ?></div>
		
		<div class="notification-form">
			<form action="" method="POST">
				<label for="notification">New Notification:</label>
				<textarea id="notification" name="notification" rows="3" required></textarea>
				<input type="submit" value="Send Notification">
			</form>
		</div>

		<?php

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (isset($_POST['notification'])) {
				$notification = htmlspecialchars($_POST['notification']);

				// Retrieve user_id based on email
				$sqlGetUserId = "SELECT user_id FROM user WHERE user_email = ?";
				$stmtGetUserId = mysqli_prepare($conn, $sqlGetUserId);
				mysqli_stmt_bind_param($stmtGetUserId, "s", $user_email);
				mysqli_stmt_execute($stmtGetUserId);
				$resultUserId = mysqli_stmt_get_result($stmtGetUserId);

				if ($rowUserId = mysqli_fetch_assoc($resultUserId)) {
					$user_id = $rowUserId["user_id"];

					// Insert the notification into the database
					$sqlInsertNotification = "INSERT INTO notification (user_id, noti_description) VALUES (?, ?)";
					$stmtInsertNotification = mysqli_prepare($conn, $sqlInsertNotification);
					mysqli_stmt_bind_param($stmtInsertNotification, "is", $user_id, $notification);
					
					if (mysqli_stmt_execute($stmtInsertNotification)) {
						// Notification successfully added to the database
						echo '<p class="noti-sent">Notification sent successfully to user with email: ' . htmlspecialchars($user_email) . '.</p>';

					} else {
						// Handle the case where insertion fails
						echo "Error: " . mysqli_error($conn);
					}
				} else {
					// Handle the case where user_id is not found
					echo "Error: User not found for email $user_email.";
				}
			} else {
				// Handle the case where email or notification is not provided
				echo "Invalid form submission.";
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
