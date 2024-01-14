<?php
include("config.php");

if (isset($_GET["query"])) {
    $searchQuery = mysqli_real_escape_string($conn, $_GET["query"]);

    $query = "SELECT * FROM book WHERE 
              book_name LIKE '%$searchQuery%' OR
              book_author LIKE '%$searchQuery%' OR
              book_publisher LIKE '%$searchQuery%' OR
              book_genre LIKE '%$searchQuery%'";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
} else {
    header("Location: book_module_page.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Books</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
session_start();
if (isset($_SESSION["type"])) {
    if ($_SESSION["type"] == 1) {
        include 'staff_menu.php';
    } elseif ($_SESSION["type"] == 2) {
        include 'user_menu.php';
    }
} else {
    include 'staff_menu.php';
}
?>

<div class="category-buttons">
    <button onclick="location.href='book_module_page_fiction.php'">Fiction</button>
    <button onclick="location.href='book_module_page_nonfiction.php'">Non-Fiction</button>
    <button onclick="location.href='book_module_page.php'">All</button>
</div>

<div class="search-results">
   <h2 class="title">Search Result</h2>

    <div class="book-container">
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="book">
                <img src="' . urldecode($row["book_img"]) . '" alt="' . $row["book_name"] . '">
                <div class="action-buttons">
                    <button class="borrow" onclick="redirectToBorrowPage(' . $row["book_id"] . ')">Borrow</button>
                    <button class="report" onclick="redirectToReportPage(\'' . $row["book_name"] . '\')">Report</button>
                </div>
              </div>';
        }
        ?>
    </div>
</div>

<script>
    function redirectToBorrowPage(bookId) {
        window.location.href = 'book_module_loan.php?book_id=' + bookId;
    }

    function redirectToReportPage(bookName) {
        // Implement the logic to redirect to the report page
    }
</script>

	<footer>
		<br>Copyright 2023.</br>
	</footer>

</body>
</html>

<?php
mysqli_close($conn);
?>
