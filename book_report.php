<?php
session_start();
include("config.php");

$book_id;

if(isset($_GET["book_id"]) && $_GET["book_id"] != ""){

    $book_id = $_GET["book_id"];

}

$query = "SELECT * FROM book WHERE book_id = $book_id";
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
