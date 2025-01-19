<?php
session_start();
include("config.php");
include("reusable.php");

sessionvalidation("user_id");

// Fetch book details based on the book ID from the URL
if (isset($_GET["faci_id"])) {
    $faci_id = $_GET["faci_id"];

    // Proceed to fetch book details if the book is available for loan
    $query = "SELECT * FROM facility WHERE faci_id = $faci_id";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $roomDetails = mysqli_fetch_assoc($result);
} else {
    // Redirect to the book module page if no book ID is provided
    header("Location: facility_module.php");
    exit();
}
customhead("Reserve Room");
loggedin_usertype("type");
?>

<body>
	<div class="book-module-loan">
        <h2 class="title">Reserve Room</h2>

			<form class="form" method="post" action="">
				<input type="hidden" name="roomId" value="<?php echo $faci_id; ?>">

				<table>
					<tr>
						<td><label for="roomName">Room Name:</label></td>
						<td><input type="text" id="roomName" name="roomName" value="<?php echo $roomDetails['faci_name']; ?>" readonly></td>
					</tr>

					<tr>
						<td><label for="FaciType">Facility Type:</label></td>
						<td><input type="text" id="FaciType" name="FaciType" value="<?php echo $roomDetails['faci_type']; ?>" readonly></td>
					</tr>

					<tr>
						<td><label for="status">Current Status:</label></td>
						<td><input type="text" id="status" name="status" value="<?php echo $roomDetails['status']; ?>" readonly></td>
					</tr>

					<tr>
						<td><label for="dateReserve">Reservation Date:</label></td>
						<td><input type="date" id="dateReserve" name="dateReserve" required></td>
					</tr>

					<tr>
						<td><label for="timeStart">Start Time:</label></td>
						<td><input type="time" id="timeStart" name="timeStart" required></td>
					</tr>

					<tr>
						<td><label for="timeEnd">End Time:</label></td>
						<td><input type="time" id="timeEnd" name="timeEnd" required></td>
					</tr>

					<tr>
						<td colspan="2"><input type="submit" value="Submit"></td>
					</tr>
				</table>
			</form>

<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Check if the form is submitted

		// Retrieve form data
		$roomId = $_POST["roomId"];
		$dateReserve = $_POST["dateReserve"];
		$timeStart = $_POST["timeStart"];
		$timeEnd = $_POST["timeEnd"];

		$insertQuery = "INSERT INTO reservation (user_id, faci_id, date, time_start, time_end) VALUES ($userId, $roomId , '$dateReserve', '$timeStart', '$timeEnd')";
		$insertResult = mysqli_query($conn, $insertQuery);

		if (!$insertResult) {
			die("Query failed: " . mysqli_error($conn));
		}

		// Display success message
		echo '<div class="message-container success"><p>Room reservation submitted successfully.</p></div>';
	} else {
		// Handle the case when user_id is not found in the session
		//echo '<div class="message-container error"><p>Error: User ID not found in session.</p></div>';
	}
?>


    </div>
	
	<footer>
		<br>Copyright 2023.</br>
	</footer>
</body>

</html>
