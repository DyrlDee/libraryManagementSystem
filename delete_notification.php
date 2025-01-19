<?php
include("config.php");

// Check if notification ID is provided
if (isset($_GET['id'])) {
    $notificationId = $_GET['id'];

    // Perform the delete operation
    $query = "DELETE FROM notification WHERE noti_id = $notificationId";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Notification deleted successfully.";
    } else {
        echo "Error deleting notification: " . mysqli_error($conn);
    }
} else {
    echo "Notification ID not provided.";
}

// Redirect back to the previous page
$previousPage = $_SERVER['HTTP_REFERER'];
header("Location: $previousPage");
exit();

?>