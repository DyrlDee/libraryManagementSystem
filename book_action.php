<?php
session_start();
include("config.php");
include("reusable.php");

if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
}

$report_description = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $report_description = isset($_POST["report_description"]) ? $_POST["report_description"] : "";
    $book_id = $_POST["book_id"];
    $sql = "INSERT INTO report (user_id,book_id,report_category, report_description)
        VALUES ($user_id,$book_id,'Book', '$report_description')";

    $status = runquery($conn, $sql);

    if ($status) {
        echo "Form data saved successfully!<br>";
        header("Location: book_module_page.php");
        exit();
    } else {
        echo '<a href="book_report.php">Back</a>';
    }
}

mysqli_close($conn);
?>
