<?php
session_start();
include("config.php");
include("reusable.php");


$book_id;

if(isset($_GET["book_id"]) && $_GET["book_id"] != ""){
    $book_id = $_GET["book_id"];
}

$query = "SELECT * FROM book WHERE book_id = $book_id";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);

customhead("My Report");
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
        
        <?php
            include 'user_menu.php';
        ?>

    <!-- report bar -->

    <div class="container">
        <h1 class = "title">Report Book</h1>
        <div class = "book_grid">

            <form action="book_action.php" method="POST" style="width: 60%;">
                <div class="photo_grid">
                <img src="img/<?php echo $row['book_img']; ?>" alt="Book Image">
                </div>

                <div> <b>Book Name:</b> <?php echo $row["book_name"]; ?> </div>
               
                <div > <b>Author:</b>  <?php echo isset($row["book_author"]) ? $row["book_author"] : ""; ?></div>
                
                <div > <b>Publisher:</b>  <?php echo isset($row["book_publisher"]) ? $row["book_publisher"] : ""; ?></div>
               
                <div > <b>Genre:</b>  <?php echo isset($row["book_genre"]) ? $row["book_genre"] : ""; ?></div>

                <input type="hidden" name="book_id" value="<?php echo $book_id;?>">
                <label for="">Report Description:</label><br>
                <textarea rows="4" name="report_description" cols="40"></textarea>


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
