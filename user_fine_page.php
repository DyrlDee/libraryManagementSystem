<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,  initial-scale=1.0">
    <title>My Study KPI</title>
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
        if(isset($_SESSION["type"])){

            if($_SESSION["type"] == 1){
                // For Staff
                include 'staff_menu.php';
            }
            elseif($_SESSION["type"] == 2){
                //For User
                include 'user_menu.php';
            }
            
        }
        else {
            include 'user_menu.php';
            // include 'staff_menu.php';
            // include 'menu.php';
        }
        ?>
        <h2 class="title">Fine</h2>

        <!-- Fine table -->
        <div>
            <table border="1" width="80%" style="border-collapse: collapse;" class="Atable">
                <thead>
                
                <tr>
                <th width="5%">No</th>
                <th width="20%">Fine Category</th>
                <th width="30%">Description</th>
                <th width="20%">Fine Fee</th>
                <th width="15%">Status</th>
                </tr>

                </thead>

                <tbody>
                
                <!-- <tr><td colspan="5">0 results</td></tr> -->

                <tr>
                    <td data-title='No' class="rowNumber">1</td>
                    <td data-title='Fine Category'>damaged book</td>
                    <td data-title='Description'>you damage my book</td>
                    <td data-title='Fine Fee'>9999</td>
                    <td data-title='Status'>pending</td>
                </tr>

                <tr>
                    <td data-title='No' class="rowNumber">2</td>
                    <td data-title='Fine Category'>damaged key</td>
                    <td data-title='Description'>you damage my key</td>
                    <td data-title='Fine Fee'>1000</td>
                    <td data-title='Status'>pending</td>
                </tr>

                <tr>
                    <td data-title='No' class="rowNumber">3</td>
                    <td data-title='Fine Category'>damaged key</td>
                    <td data-title='Description'>you damage my key</td>
                    <td data-title='Fine Fee'>1000</td>
                    <td data-title='Status'>pending</td>
                </tr>

                </tbody>

                
            </table>
        </div>
       

    </body>
</html>
