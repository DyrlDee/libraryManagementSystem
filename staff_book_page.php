<?php
session_start();

include("config.php");
include("reusable.php");

// $user_id = $_SESSION["user_id"];

$id = "";
if(!empty($_GET['id'])) {
	$id = $_GET['id'];
}

customhead("Library Management System");
loggedin_usertype("type");
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
		
		function show_addBook() {
			var x = document.getElementById("bookList");
			x.style.display = 'none';
			
			var x = document.getElementById("addBook");
			x.style.display = 'inline';
		}
		
		function confirmDelete(delid) {
			var ok = window.confirm("Delete?");
			var link = "staff_book_action.php";
			if(ok == false){
				window.location.href = link;
			} else {
				link = link.concat(delid);
				window.location.href = link;
			}
		}
		
		Filevalidation = () => { //check file size
            const fi = document.getElementById('fileToUpload');
            // Check if any file is selected.
            if (fi.files.length > 0) {
                for (const i = 0; i <= fi.files.length - 1; i++) {
 
                    const fsize = fi.files.item(i).size;
                    const file = Math.round((fsize / 1024));
                    // The size of the file.
                    if (file >= 500) {
                        window.alert("File too big, please select a file less than 500kb");
						fi.value = "";
                    } 
                }
            }
        }
    </script>

    <body>

        <?php 
		
		$genre = $search = '';
		if(!empty($_GET['genre'])){
			$genre = $_GET['genre'];
		}
		if(!empty($_GET['src'])){
			$search = $_GET['src'];
		}
        ?>
		<div id="bookList">
		<div id="btns" class="row" style="justify-content:center;margin-left:auto;margin-right:auto;">
			<a href="staff_book_page.php?genre=fiction" class="link-btn" style="margin:30px;text-align:center;padding:8px 30px;">Fiction</a>
			<a href="staff_book_page.php?genre=non-fiction" class="link-btn" style="margin:30px;text-align:center;padding:8px 30px;">Non-Fiction</a>
			<a href="javascript:show_addBook();" class="link-btn" style="margin:30px;text-align:center;padding:8px 30px;">Add Book</a>
		</div>
		
		<!-- Form search book -->
        <div id="searchbook" class="search">
            <form action="staff_book_page.php" method="GET">
                <label for="search">Search</label>
                <input type="text" name="src" placeholder="Book name">
                <input type="submit" name="" id="" value="Submit">
            </form>
        </div>
		
        <h2 style="text-align:center;">
		<?php
		if(!empty($genre)){
			echo $genre;
		} else if(!empty($search)){
			echo "Searching '".$search."'";
		} else {
			echo "All";
		}
		?>
		</h2>
        <!-- Books -->
        <div id="bookgrid" class="gridivbook">
			<?php
			$sql = "SELECT * FROM book";
			if(!empty($genre) || !empty($search)){
				$sql .= " WHERE ";
			}
			if(!empty($genre)){
				$sql .= "book_genre = '$genre'";
			}
			if(!empty($search)){
				$sql .= "book_name LIKE '%$search%'";
			}
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
			$numrow=1;
			while($row = mysqli_fetch_assoc($result)) {
				echo "<div class='griditem'>";
				if($row['book_img']!=""){
					echo "<img class='bookimg' src='img/".$row['book_img']."'>";
				} else {
					echo "<div class='nobookimg'><div class='gridtext'><i class='fa fa-picture-o fa-2x'></i><br>".$row['book_name']."<br>(".$row['book_author'].")</div></div>";
				}
				echo "
				<a href='staff_book_page.php?id=".$row['book_id']."' class='link-btn' style='text-align:center;'>Update</a>
				<a href='javascript:confirmDelete(\"?delid=".$row['book_id']."\");' class='link-btn-red' style='text-align:center;'>Delete</a>";
				echo "</div>";
				$numrow++;
			}
			} else {
			echo '<p style="text-align:center">0 Results</p>';
			}
			?>
        </div>
		</div>
		
		<div id="addBook" style="display:none;">
			<h2 class="title">Add Book</h2>
			<form id="addform" action="staff_book_action.php" method="post" enctype="multipart/form-data">
			<table class="Atable">
				<input type="hidden" name="action" value="ADD">
				<tr>
					<th><label for="bookname">Book Name: </label></th>
					<td><input type="text" name="bookname" maxlength="255" required></td>
				</tr>
				<tr>
					<th><label for="author">Author: </label></th>
					<td><input type="text" name="author" maxlength="255" required></td>
				</tr>
				<tr>
					<th><label for="publisher">Publisher: </label></th>
					<td><input type="text" name="publisher" maxlength="30" required></td>
				</tr>
				<tr>
					<th><label for="genre">Genre: </label></th>
					<td><select size="1" name="genre" required>      
						<option value="" selected disabled>&nbsp;</option>
						<option value="fiction">Fiction</option>
						<option value="non-fiction">Non-Fiction</option>
					</select></td>
				</tr>
				<tr>
					<th><label>Image: </label></th>
					<td><input onchange="Filevalidation()" type="file" name="fileToUpload" id="fileToUpload" accept=".jpg, .jpeg, .png" required></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="" id="" value="Add"></td>
				</tr>
			</table>
			</form>
		</div>
		
		<div id="updatebook" style="display:none;">
			<h2 class="title">Update Book</h2>
			<form action="staff_book_action.php" method="POST" enctype="multipart/form-data">
			<?php
			$sql = "SELECT * FROM book WHERE book_id='$id'";
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
				$row = mysqli_fetch_assoc($result);
			}
			
			?>
			<table class="Atable">
				<input type="hidden" name="action" value="UPDATE">
				<input type="hidden" name="id" value="<?=$row['book_id']?>">
				<tr>
					<td rowspan="7">
					<?php
					if($row['book_img']!=""){
						echo "<img class='bookimg' src='img/".$row['book_img']."'>";
					} else {
						echo "<div class='nobookimg'><div class='gridtext'><i class='fa fa-picture-o fa-2x'></i><br>".$row['book_name']."</div></div>";
					}
					?>
					</td>
				</tr>
				<tr>
					<th><label for="bookname">Book Name: </label></th>
					<td><input type="text" name="bookname" maxlength="255" value="<?=$row['book_name']?>" required></td>
				</tr>
				<tr>
					<th><label for="author">Author: </label></th>
					<td><input type="text" name="author" maxlength="255" value="<?=$row['book_author']?>" required></td>
				</tr>
				<tr>
					<th><label for="publisher">Publisher: </label></th>
					<td><input type="text" name="publisher" maxlength="30" value="<?=$row['book_publisher']?>" required></td>
				</tr>
				<tr>
					<th><label for="genre">Genre: </label></th>
					<td><select size="1" name="genre" required>
					<?php
						echo '<option value="fiction"';
						if($row['book_publisher']=="fiction") echo ' selected';
						echo '>Fiction</option>';
						
						echo '<option value="non-fiction"';
						if($row['book_publisher']=="non-fiction") echo ' selected';
						echo '>Non-Fiction</option>';
					?>
					</select></td>
				</tr>
				<tr>
					<th><label>Image: </label></th>
					<td><input type="file" name="fileToUpload" id="fileToUpload" accept=".jpg, .jpeg, .png" required></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="" id="" value="Update"></td>
				</tr>
			</table>
			</form>
		</div>
		
		<?php //show update book form
		if(!empty($_GET['id'])) {
			$id = $_GET['id'];
			echo '<script>
			(function () {
				var x = document.getElementById("bookList");
				x.style.display = "none";
				
				var x = document.getElementById("updatebook");
				x.style.display = "inline";
				})();
			</script>';
		}
		?>
    </body>
</html>
