<?php
session_start();
include("config.php");
include("reusable.php");

if (isset($_SESSION["user_id"])) {
    $userId = $_SESSION["user_id"];
} else {
    // Redirect to login page or handle the case when the user is not logged in
    //header("Location: login.php");
    //exit();
}


// Fetch book details based on the book ID from the URL
if (isset($_GET["book_id"])) {
    $bookId = $_GET["book_id"];

    // Check if the book is already borrowed
    // $queryCheckLoan = "SELECT * FROM bookloan WHERE book_id = $bookId AND hasReturn = 'no'";
    // $resultCheckLoan = mysqli_query($conn, $queryCheckLoan);

    // if (!$resultCheckLoan) {
    //     die("Query failed: " . mysqli_error($conn));
    // }

    // Proceed to fetch book details if the book is available for loan
    $query = "SELECT * FROM book WHERE book_id = $bookId";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $bookDetails = mysqli_fetch_assoc($result);
} else {
    // Redirect to the book module page if no book ID is provided
    header("Location: book_module_page.php");
    exit();
}

customhead("Loan Book");
usertype("type");

?>
<body>
<div class="book-module-loan">
    <h2>Loan Book</h2>
    
	<div class="form-container">
    <?php
    if (isset($bookDetails)) {
        ?>
  
		<div class="book-image">
			<img src="img/<?php echo $bookDetails['book_img']; ?>" alt="<?php echo $bookDetails['book_name']; ?>">
		</div>

        <?php
        if (false) {
            echo "<p>Book is not available for loan.\n</p>";
        } else {
        ?>
		<form class="form" method="post" action="book_module_loan_action.php">
			<input type="hidden" name="bookId" value="<?php echo $bookId; ?>">

			<table>
				<tr>
					<td><label for="bookName">Book Name:</label></td>
					<td><input type="text" id="bookName" name="bookName" value="<?php echo $bookDetails['book_name']; ?>" readonly></td>
				</tr>

				<tr>
					<td><label for="bookAuthor">Author:</label></td>
					<td><input type="text" id="bookAuthor" name="bookAuthor" value="<?php echo $bookDetails['book_author']; ?>" readonly></td>
				</tr>

				<tr>
					<td><label for="bookPublisher">Publisher:</label></td>
					<td><input type="text" id="bookPublisher" name="bookPublisher" value="<?php echo $bookDetails['book_publisher']; ?>" readonly></td>
				</tr>

				<tr>
					<td><label for="bookGenre">Genre:</label></td>
					<td><input type="text" id="bookGenre" name="bookGenre" value="<?php echo $bookDetails['book_genre']; ?>" readonly></td>
				</tr>

				<tr>
					<td><label for="dateBorrow">Date Borrow:</label></td>
					<td><input type="date" id="dateBorrow" name="dateBorrow" required></td>
				</tr>

				<tr>
					<td><label for="dateReturn">Date Return:</label></td>
					<td><input type="date" id="dateReturn" name="dateReturn" required></td>
				</tr>

				<tr>
					<td colspan="2"><input type="submit" value="Submit"></td>
				</tr>
			</table>

            <?php
                if (isset($_GET["fail"])) {
                    echo "Book is not available at that time";
                }
                    
            ?>
		</form>

        <?php
        }
    } else {
        // Display a message if the book details are not available
        echo "<p>Book details not available.</p>";
    }
    ?>
	</div>
</div>
	<footer>
		<br>Copyright 2023.</br>
	</footer>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
