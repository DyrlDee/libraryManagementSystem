<?php
session_start();

include("config.php");
include("reusable.php");

if(!isset($_SESSION["user_id"])){
    header("location:index.php"); 
}

$user_id = $_SESSION["user_id"];
customhead("Fine");
usertype("type");
?>
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

        <h2 class="title">Fine</h2>

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
                
                <?php
                $sql = "SELECT * FROM fine WHERE user_id = $user_id"; 
                //SELECT * FROM fine WHERE user_id = $user_id actual code
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                // output data of each row 
                $numrow=1;
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td data-title='No' class='rowNumber'>" . $numrow . "</td><td data-title='Fine Category'>". $row["fine_category"]. "</td><td data-title='Description'>" . $row["fine_description"] .
                    "</td><td data-title='Fine Fee'>" . $row["fine_fee"] . "</td><td data-title='Status'>" . $row["status"] 
                    . "</td>";
                    echo "</tr>" . "\n\t\t";
                    $numrow++;
                }
                } else {
                echo '<tr><td colspan="5">0 results</td></tr>';
                } 
                mysqli_close($conn); 
                ?>
                </tbody>                
            </table>
        </div>
       

    </body>
</html>
