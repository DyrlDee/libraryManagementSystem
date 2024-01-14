<!-- 

    DISCLAIMER

    This is not the complete version of the report; configurations will be made after login, 
    and the book loan module is available. Linking between different PHP files is required 
    for it to be automatically displayed in the report. A dummy database is set up solely 
    for testing the functionality of the code.

    Configuration will be done during the compilation of codes.

 -->

<?php
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
    <title>My Report</title>
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

    <div class="container">
    <?php
        $user_id = $_SESSION["user_id"];
        $sql = "SELECT * FROM facility WHERE user_id = '$user_id' AND faci_name = '$faci_name'";
    ?>
        <h1 class = "title">Report Facility</h1>
        <form action="faci_action.php" method="POST">

            <div class="section_table_2">
                <table class = "facility_report">
                    <tr>
                        <td class = "faci_title"> Room Name: </td>
                        <?php
                            if ($result) {
                                $row = mysqli_fetch_assoc($result);
                                if ($row) {
                                    echo "<td>" . (isset($row["faci_name"]) ? $row["faci_name"] : "") . "</td>";
                                } else {
                                    echo "No data found";
                                }
                            }
                        ?>
                    </tr>
                    <tr>
                        <td class = "faci_title"> Faci Type: </td>
                        <?php
                            if ($result) {
                                $row = mysqli_fetch_assoc($result);
                                if ($row) {
                                    echo "<td>" . (isset($row["faci_type"]) ? $row["faci_type"] : "") . "</td>";
                                } else {
                                    echo "No data found";
                                }
                            }
                        ?>
                    </tr>
                    <tr>
                        <td class = "faci_title"> Report Category: </td>
                        <td>Facility</td>
                    </tr>
                    <tr>
                        <td class = "faci_title_d"> Report Description: </td>
                    </tr>
                    <tr>
                        <td><textarea rows="4" name="report_description" cols="20"></textarea></td>
                    </tr>
                </table> 
            </div>
            
            <div class="search">
                <input type="submit" name="" id="" value="submit">
            </div>

        </form>
    </div>

    <footer>
        <br>Copyright 2023.</br>
    </footer>
</body>

</html>
