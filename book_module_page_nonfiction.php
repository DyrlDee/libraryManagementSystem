<?php
include("config.php");

// Fetch non-fiction books from the database
$query = "SELECT * FROM book WHERE book_genre = 'non-fiction'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,400&family=Raleway:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Non-Fiction Books</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
// Include the appropriate menu based on the user type
session_start();
if (isset($_SESSION["type"])) {
    if ($_SESSION["type"] == 1) {
        // For Staff
        include 'staff_menu.php';
    } elseif ($_SESSION["type"] == 2) {
        // For User
        include 'user_menu.php';
    }
} else {
    // Default to staff menu if user type is not set
    include 'staff_menu.php';
}
?>

<!-- Content specific to non-fiction book module page -->

<div class="book-module">

    <!-- Book category buttons -->
    <div class="category-buttons">
		<button onclick="location.href='book_module_page.php'">All</button>
        <button onclick="location.href='book_module_page_fiction.php'">Fiction</button>
        <button onclick="location.href='book_module_history.php'">History</button>
    </div>
	
	 <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search...">
        <button onclick="searchBooks()">Search</button>
    </div>
	
   <h2 style="text-align: left; color: black; font-size: 24px; margin-top: 10px; margin-left: 100px;">Non-Fiction</h2>

    <!-- Center-aligned book images with Borrow and Report buttons -->
    <div class="book-container">
       <?php
    while ($row = mysqli_fetch_assoc($result)) {
       echo '<div class="book">
        <img src="img/' . $row['book_img'] . '" alt="' . $row['book_name'] . '">
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
    function searchBooks() {
        var searchInput = document.getElementById('searchInput').value;
        window.location.href = 'search_books.php?query=' + searchInput;
    }
	
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
// Close the database connection
mysqli_close($conn);
?>
