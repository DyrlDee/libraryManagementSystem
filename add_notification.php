<?php
session_start();

// Include your database configuration
include("config.php");

// Retrieve the user email from the URL
if (isset($_GET['email'])) {
    $user_email = urldecode($_GET['email']);

    // Fetch user details using the email (assuming you have a user table)
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
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Notification</title>
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
