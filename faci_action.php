<?php
session_start();
include("config.php");
include("reusability.php");


if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
}

//variables
$report_description = "";

//this block is called when the Submit button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //values for add or edit
    $report_description = isset($_POST["report_description"]) ? $_POST["report_description"] : "";
    $faci_id = $_POST["faci_id"];
    $sql = "INSERT INTO report (user_id,faci_id,report_category, report_description)
        VALUES ($user_id,$faci_id,'Facility', '$report_description')";

    $status = runquery($conn, $sql);

    if ($status) {
        echo "Form data saved successfully!<br>";
        header("Location: facility_module.php");
        exit();
    } else {
        echo '<a href="facility_report.php">Back</a>';
    }
}

mysqli_close($conn);

?>