

<?php

session_start();
// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

include("config.php");

// Fetch notifications for the current user
if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $query = "SELECT * FROM notification WHERE user_id = $user_id";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Fetched notifications array
    $notifications = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Report</title>
    <link rel="stylesheet" href="./style.css">
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
            include 'user_menu.php';
        ?>
    
    <!-- report bar -->

    <div class="report_container">
    <h1 class="title_s">Staff Report</h1>

    <div class="section_table_1">
        <form method="post" action="">
            <input type="submit" name="submit" value="By Faculty" class="report_btn">
            <input type="submit" name="submit" value="By Book" class="report_btn">
        </form>

        <!-- table and PHP logic for displaying data -->
        <table class="report_table">
            <tr class="report_columns">
                <td class="No"> No </td>
                <td class="Report Category"> Report Category </td>
                <td class="Description"> Description </td>
                <td class="Status"> Status </td>
                <td class="Status"> Update </td>
            </tr>
            <!-- The data rows will be displayed here -->
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['submit']) && $_POST['submit'] == 'By Faculty') {
                    $sql = "SELECT * FROM report WHERE user_id = ? AND report_category = 'By Faculty'";
                } elseif (isset($_POST['submit']) && $_POST['submit'] == 'By Book') {
                    $sql = "SELECT * FROM report WHERE user_id = ? AND report_category = 'By Book'";
                } else {
                    $sql = "SELECT * FROM report WHERE user_id = ?";
                }
        
                $stmt = mysqli_prepare($conn, $sql);
        
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, 's', $user_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
        
                    if (!$result) {
                        die('Error: ' . mysqli_error($conn));
                    }
        
                    $total_rows = mysqli_num_rows($result);
        
                    if ($total_rows > 0) {
                        // Output data of each row 
                        while ($row = mysqli_fetch_assoc($result)) {
                            //asd
                        }
                    } else {
                        echo '<tr><td colspan="6">0 results</td></tr>';
                    }
        
                    mysqli_stmt_close($stmt);
                } else {
                    die('Error in preparing the statement: ' . mysqli_error($conn));
                }
                mysqli_close($conn);
            }
            ?>
        </table>
    </div>
</div>


    <footer>
        <br>Copyright 2023.</br>
    </footer>
</body>

</html>
