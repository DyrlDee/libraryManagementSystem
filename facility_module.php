<?php
session_start();
include("config.php");
include("reusable.php");

// Fetch Meeting Room facilities
$queryMeetingRoom = "SELECT * FROM facility WHERE faci_type = 'Meeting Room'";
$resultMeetingRoom = mysqli_query($conn, $queryMeetingRoom);

// Fetch Cubicle facilities
$queryCubicle = "SELECT * FROM facility WHERE faci_type = 'Cubicle Room'";
$resultCubicle = mysqli_query($conn, $queryCubicle);

if (!$resultMeetingRoom || !$resultCubicle) {
    die("Query failed: " . mysqli_error($conn));
}

customhead("Facility Module");
loggedin_usertype("type");
?>

<body>

<div class="facility-module">
    <button onclick="location.href='reservation_history.php'" class="category-button">History</button>

    <h2 style="text-align: center; color: black; font-size: 24px; margin-top: 20px;">Meeting Room</h2>

    <div class="facility-container">
	<?php
	while ($row = mysqli_fetch_assoc($resultMeetingRoom)) {
		echo '<div class="facility">
			<h3><a href="reservation_room.php?faci_id=' . $row["faci_id"] . '">' . $row["faci_name"] . '</a></h3>
			<a href="facility_report.php?faci_id=' . $row["faci_id"] . '" class="report-button red">Report</a>
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
				<a href="facility_report.php?faci_id=' . $row["faci_id"] . '" class="report-button red">Report</a>
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
