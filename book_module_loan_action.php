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

    // Proceed to fetch book details if the book is available for loan
    $query = "SELECT * FROM book WHERE book_id = $bookId";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $bookDetails = mysqli_fetch_assoc($result);
} else {
    // Redirect to the book module page if no book ID is provided
    //header("Location: book_module_page.php");
    //exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,400&family=Raleway:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Book Loan History</title>
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

<div class="category-buttons">
    <button onclick="location.href='book_module_page.php'">All</button>
    <button onclick="location.href='book_module_page_fiction.php'">Fiction</button>
    <button onclick="location.href='book_module_page_nonfiction.php'">Non-Fiction</button>
</div>

<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Check if the form is submitted

		// Retrieve form data
		$bookId = $_POST["bookId"];
		$dateBorrow = $_POST["dateBorrow"];
		$dateReturn = $_POST["dateReturn"];

		$insertQuery = "INSERT INTO bookloan (user_id, book_id, date_start, date_end, hasReturn) VALUES ($userId, $bookId, '$dateBorrow', '$dateReturn', 'no')";
		$insertResult = mysqli_query($conn, $insertQuery);

		if (!$insertResult) {
			die("Query failed: " . mysqli_error($conn));
		}

		// Display success message
		echo '<div class="message-container success"><p>Book loan submitted successfully.</p></div>';
	} else {
		// Handle the case when user_id is not found in the session
		echo '<div class="message-container error"><p>Error: User ID not found in session.</p></div>';
	}

?>

<!-- Content specific to book module history page -->
<div class="book-module-history">
    <h2 class="title">Book Loan History</h2>

    <!-- History Table -->
    <table border="1" width="80%" style="border-collapse: collapse;" class="Atable">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Book Name</th>
                <th width="30%">Date Borrowed</th>
                <th width="20%">Return Due</th>
                <th width="15%">Status</th>
                <th width="15%">&nbsp;</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $counter = 1;
            // Modify the query to fetch books borrowed by the user in the session
            $query = "SELECT * FROM bookLoan WHERE user_id = $userId";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                die("Query failed: " . mysqli_error($conn));
            }

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>
                        <td data-title="No" class="rowNumber">' . $counter . '</td>
                        <td data-title="Book Name">' . getBookName($row["book_id"]) . '</td>
                        <td data-title="Date Borrowed">' . $row["date_start"] . '</td>
                        <td data-title="Return Due">' . $row["date_end"] . '</td>
                        <td data-title="Status">' . getStatusLabel($row["hasReturn"]) . '</td>
                        <td>';

                // Check if the book has already been returned
                if ($row["hasReturn"] == 'no') {
                    echo '<a class="link-btn" href="">Return</a>';
                    // Staff should update this book status
                }

                echo '</td></tr>';
                $counter++;
            }
            ?>
        </tbody>
    </table>
</div>

<?php
// Close the database connection
mysqli_close($conn);

// Helper function to get book name based on book ID
function getBookName($bookId) {
    global $conn;
    $query = "SELECT book_name FROM book WHERE book_id = $bookId";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $book = mysqli_fetch_assoc($result);
    return $book["book_name"];
}

function getStatusLabel($status) {
    if ($status == 'no') {
        return 'Not Returned';
    } elseif ($status == 'yes') {
        return 'Returned';
    } else {
        return 'Unknown';
    }
}
?>
	<footer>
		<br>Copyright 2023.</br>
	</footer>
</body>
</html>
