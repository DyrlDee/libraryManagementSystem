<?php
session_start();
include("config.php");

if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
}

if(isset($_GET["faci_id"]) && $_GET["faci_id"] != ""){

    $faci_id = $_GET["faci_id"];
}


$query = "SELECT * FROM facility WHERE faci_id = $faci_id ";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Fetch the data from the result set
$row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Report</title>
    <link rel="stylesheet" href="css/style.css">
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
    ?>
        <h1 class = "title">Report Facility</h1>
        <form action="faci_action.php" method="POST">

            <div class="section_table_2">
                <table class = "facility_report">
                    <tr>
                        <td class = "faci_title"> Room Name: </td>
                        <td><?php echo isset($row["faci_name"]) ? $row["faci_name"] : ""; ?></td>
                    </tr>
                    <tr>
                        <td class = "faci_title"> Faci Type: </td>
                        <td><?php echo isset($row["faci_type"]) ? $row["faci_type"] : ""; ?></td>
                    </tr>
                    <tr>
                        <td class = "faci_title"> Report Category: </td>
                        <td>Facility</td>
                    </tr>
                    
                    <tr>
                        <td class = "faci_title_d" style="text-align:center; "> Report Description: </td>
                        <td><textarea rows="4" name="report_description" cols="20"></textarea></td>
                    </tr>

                    <input type="hidden" name="faci_id" value="<?php echo $faci_id;?>">
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
