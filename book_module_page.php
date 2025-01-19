<?php
include("config.php");
include("reusable.php");


$query = "SELECT * FROM book";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

customhead("Book Module Page");
usertype("type");
?>
<body>

<?php
session_start();

?>

<div class="book-module">
    <div class="category-buttons">
        <button onclick="location.href='book_module_page_fiction.php'">Fiction</button>
        <button onclick="location.href='book_module_page_nonfiction.php'">Non-Fiction</button>
        <button onclick="location.href='book_module_history.php'">History</button>
    </div>
    
    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search...">
        <button onclick="searchBooks()">Search</button>
    </div>

   <h2 style="text-align: left; color: black; font-size: 24px; margin-top: 10px; margin-left: 100px;">All</h2>

   <div class="book-container">
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
		echo '<div class="book">
			<img src="img/' . $row['book_img'] . '" alt="' . $row['book_name'] . '">
			<div class="action-buttons">
				<button class="borrow" onclick="redirectToBorrowPage(' . $row['book_id'] . ')">Borrow</button>
				<button class="report" onclick="redirectToReportPage(\'' . $row['book_id'] . '\')">Report</button>
			</div>
		</div>';
    }
    ?>
</div>

<script>
    function searchBooks() {
        var searchInput = document.getElementById('searchInput').value;
        window.location.href = 'search_books.php?query=' + searchInput;
    }

    function redirectToBorrowPage(bookId) {
        window.location.href = 'book_module_loan.php?book_id=' + bookId;
    }

    function redirectToReportPage(bookId) {
        // Implement the logic to redirect to the report page
        window.location.href = 'book_report.php?book_id=' + bookId;
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
