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
$report_description = "";

//this block is called when the Submit button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //values for add or edit
    $report_description = isset($_POST["report_description"]) ? $_POST["report_description"] : "";

    $sql = "INSERT INTO report (report_category, report_description, status)
        VALUES ('Facility', '$report_description', 'Pending')";

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
