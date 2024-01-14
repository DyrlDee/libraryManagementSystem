<?php
include("config.php");

// Fetch Meeting Room facilities
$queryMeetingRoom = "SELECT * FROM facility WHERE faci_type = 'Meeting Room'";
$resultMeetingRoom = mysqli_query($conn, $queryMeetingRoom);

// Fetch Cubicle facilities
$queryCubicle = "SELECT * FROM facility WHERE faci_type = 'Cubicle Room'";
$resultCubicle = mysqli_query($conn, $queryCubicle);

if (!$resultMeetingRoom || !$resultCubicle) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facility Module</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
session_start();
if (isset($_SESSION["type"])) {
    if ($_SESSION["type"] == 1) {
        include 'staff_menu.php';
    } elseif ($_SESSION["type"] == 2) {
        include 'user_menu.php';
    }
} else {
    include 'staff_menu.php';
}
?>

<div class="facility-module">
    <button onclick="location.href='reservation_history.php'" class="category-button">History</button>

    <h2 style="text-align: center; color: black; font-size: 24px; margin-top: 20px;">Meeting Room</h2>

    <div class="facility-container">
	<?php
	while ($row = mysqli_fetch_assoc($resultMeetingRoom)) {
		echo '<div class="facility">
			<h3><a href="reservation_room.php?faci_id=' . $row["faci_id"] . '">' . $row["faci_name"] . '</a></h3>
			<a href="report_page.php?faci_id=' . $row["faci_id"] . '" class="report-button red">Report</a>
		</div>';
	}
	?>

	</div>

	<h2 style="text-align: center; color: black; font-size: 24px; margin-top: 20px;">Cubicle</h2>

	<div class="facility-container">
		<?php
		while ($row = mysqli_fetch_assoc($resultCubicle)) {
			echo '<div class="facility">
				<h3><a href="reservation_room.php?faci_id=' . $row["faci_id"] . '">' . $row["faci_name"] . '</a></h3>
				<a href="report_page.php?faci_id=' . $row["faci_id"] . '" class="report-button red">Report</a>
			</div>';
		}
		?>
	</div>

</div>
	<footer>
		<br>Copyright 2023.</br>
	</footer>
</body>
</html>

<?php
mysqli_close($conn);
?>
