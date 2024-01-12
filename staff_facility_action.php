<?php //code for adding or updating room
session_start();
include("config.php");
	
function sanitize($input) {
	$input = htmlspecialchars($input);
	$input = trim($input);
	$input = addslashes($input);
	return $input;
}

$action = "";
$faci_name = "";
$faci_type = "";
$status = "";
$id = "";
if(!empty($_GET['id'])) {
	$id = $_GET['id'];
}
if(!empty($_GET['delid'])) {
	$id = $_GET['delid'];
	$action = "DELETE";
}
//ADD
if ($_SERVER["REQUEST_METHOD"]=="POST" && $_POST["action"]=="ADD") {
	$faci_name = strtoupper(sanitize($_POST["roomname"]));
	$faci_type = $_POST["facitype"];
	$status = $_POST["status"];
	echo $faci_name." ".$faci_type." ".$status;
	
	$sql = "INSERT INTO facility (faci_name, faci_type, status) VALUES ('$faci_name', '$faci_type', '$status')";
	if (mysqli_query($conn, $sql)) {
		header("Location: staff_facility_page.php");
	} else {
		die("Error: " . $sql . " : " . mysqli_error($conn) . "<br>");
	}
}

//UPDATE
if ($_SERVER["REQUEST_METHOD"]=="POST" && $_POST["action"]=="UPDATE") {
	$id = $_POST['id'];
	$faci_name = strtoupper(sanitize($_POST["roomname"]));
	$faci_type = $_POST["facitype"];
	$status = $_POST["status"];
	echo $id." ".$faci_name." ".$faci_type." ".$status;
	
	$sql = "UPDATE facility SET faci_name='$faci_name', faci_type='$faci_type', status='$status' WHERE faci_id=$id";
	if (mysqli_query($conn, $sql)) {
		header("Location: staff_facility_page.php");
	} else {
		die("Error: " . $sql . " : " . mysqli_error($conn) . "<br>");
	}
}

//DELETE
if ($action=="DELETE") {
	$sql = "DELETE FROM facility WHERE faci_id=$id";
	if (mysqli_query($conn, $sql)) {
		header("Location: staff_facility_page.php");
	} else {
		die("Error: " . $sql . " : " . mysqli_error($conn) . "<br>");
	}
} 
?>