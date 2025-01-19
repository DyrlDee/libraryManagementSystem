<?php
session_start();
include("config.php");
include("reusable.php");

if (isset($_SESSION["user_id"])) {
    $userId = $_SESSION["user_id"];
} else {
}

if (isset($_GET["book_id"])) {
    $bookId = $_GET["book_id"];

    $query = "SELECT * FROM book WHERE book_id = $bookId";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $bookDetails = mysqli_fetch_assoc($result);
} else {
}

customhead("Book Loan History");
usertype("type");
?>
<body>


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

        //check if date borrow is in between borrow date
        $sql = "SELECT *FROM bookloan WHERE date_end >= '$dateBorrow' AND book_id = '$bookId';";

        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result)>0){
            //book is unavailable at that time
            header("Location: book_module_loan.php?book_id=$bookId&fail=true");
            exit();
        }

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
                        <td data-title="Status">' . getStatusLabel($row["hasReturn"]) . '</td>';

                echo '</tr>';
                $counter++;
            }
            ?>
        </tbody>
    </table>
</div>

<?php
mysqli_close($conn);

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
</body>
</html>
