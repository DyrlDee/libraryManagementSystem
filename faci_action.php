<!-- 

    DISCLAIMER

    This is not the complete version of the report; configurations will be made after login, 
    and the book loan module is available. Linking between different PHP files is required 
    for it to be automatically displayed in the report. A dummy database is set up solely 
    for testing the functionality of the code.

    Configuration will be done during the compilation of codes.

 -->

<?php
session_start();
include("config.php");

//variables
$room_name = "";
$faci_type = "";
$status = "";
$cat = "";
$des = "";

//this block is called when the Submit button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //values for add or edit
    $room_name = isset($_POST["room_name"]) ? $_POST["room_name"] : "";
    $faci_type = isset($_POST["faci_type"]) ? $_POST["faci_type"] : "";
    $status = isset($_POST["status"]) ? $_POST["status"] : "";
    $cat = isset($_POST["cat"]) ? $_POST["cat"] : "";
    $des = isset($_POST["des"]) ? $_POST["des"] : "";

    $sql = "INSERT INTO facility_reports (room_name, faci_type, status, report_category, report_description)
        VALUES ('$room_name', '$faci_type', '$status', '$cat', '$des')";

    $status = insertTo_DBTable($conn, $sql);

    if ($status) {
        echo "Form data saved successfully!<br>";
        header("Location: facility_report.php");
        exit();
    } else {
        echo '<a href="facility_report.php">Back</a>';
    }
}

//close db connection
mysqli_close($conn);

//Function to insert data to the database table
function insertTo_DBTable($conn, $sql) {
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        echo "Error: " . $sql . " : " . mysqli_error($conn) . "<br>";
        return false;
    }
}
?>
