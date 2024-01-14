<?php
session_start();
include("config.php");

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
    $queryCheckLoan = "SELECT * FROM bookloan WHERE book_id = $bookId AND hasReturn = 'no'";
    $resultCheckLoan = mysqli_query($conn, $queryCheckLoan);

    if (!$resultCheckLoan) {
        die("Query failed: " . mysqli_error($conn));
    }

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,400&family=Raleway:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Book</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
// Include the appropriate menu based on the user type
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

<!-- Content specific to book loan module page -->

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
        if (mysqli_num_rows($resultCheckLoan) > 0) {
            echo "<p>Book is not available for loan.\n</p>";
			//echo "<p>\n\nBook might not be available because :</p>";
			//echo "<p>\n(1) Another user is borrowing the book.</p>";
			//echo "<p>\n(2) You have not return the book.</p>";
        } else {
        ?>
        <!-- Loan Book Form -->
		<form class="form" method="post" action="book_module_loan_action.php">
			<!-- Add a hidden input field to store the book_id -->
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
