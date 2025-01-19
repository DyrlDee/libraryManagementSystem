<?php
include("config.php");
include("reusable.php");

// Fetch loan history for the current user from the database
session_start();
if (isset($_SESSION["user_id"])) {
    $userId = $_SESSION["user_id"];
    $query = "SELECT * FROM bookLoan WHERE user_id = $userId";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
} else {
    // Redirect to login page or handle the case when the user is not logged in
    //header("Location: login.php");
    //exit();
}

customhead("Book Loan History");
loggedin_usertype("type");
?>
<body>
<div class="category-buttons">
    <button onclick="location.href='book_module_page.php'">All</button>
    <button onclick="location.href='book_module_page_fiction.php'">Fiction</button>
    <button onclick="location.href='book_module_page_nonfiction.php'">Non-Fiction</button>
</div>

<div class="book-module-history">
    <h2 class="title">Book Loan History</h2>

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
