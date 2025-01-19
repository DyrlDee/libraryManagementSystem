<?php //code for adding or updating room
session_start();
include("config.php");
include("reusable.php");


function sanitize($input) {
	$input = htmlspecialchars($input);
	$input = trim($input);
	$input = addslashes($input);
	return $input;
}

$action = "";
$book_name = "";
$book_author = "";
$book_publisher = "";
$book_genre = "";
$book_img = "";
$target_dir = "img/";
$target_file = "";
$uploadOk = 0;
$imageFileType = "";
$id = "";
if(!empty($_GET['id'])) {
	$id = $_GET['id'];
}
if(isset($_POST['action'])) {
	$action = $_POST['action'];
}
if(!empty($_GET['delid'])) {
	$id = $_GET['delid'];
	$action = "DELETE";
}
//ADD or UPDATE
if ($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['action'])){
	$id = $_POST['id'];
	$book_name = sanitize($_POST["bookname"]);
	$book_author = sanitize($_POST["author"]);
	$book_publisher = sanitize($_POST["publisher"]);
	$book_genre = $_POST["genre"];
	
	
	//if there is image
	if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == UPLOAD_ERR_OK) {
		$uploadOk = 1;
		$filetmp = $_FILES["fileToUpload"];
		
		$errmsg = ""; //errormsg
		
		//file
		$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$book_img = basename($_FILES["fileToUpload"]["name"]);
		
		// Check if file already exists
		if (file_exists($target_file)) {
			$errmsg = "Sorry, file already exists.";
			$uploadOk = 0;
		}
		
		// Check file size <= 488.28KB or 500000 bytes
		if ($_FILES["fileToUpload"]["size"] > 500000) {
			$errmsg = "ERROR: Sorry, your file is too large. Try resizing your image.";
			$uploadOk = 0;
		}
		
		// Allow only these file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			$errmsg = "ERROR: Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		} 
		
		if($uploadOk == 0){
			//echo $errmsg;
			echo "<script>
			window.alert('$errmsg');
			window.location.replace('staff_book_page.php')
			</script>";
			//header("Location:staff_book_page.php");
		}
	} else if($_FILES["fileToUpload"]["error"] != UPLOAD_ERR_OK && $book_img != ""){
		//header("Location:staff_book_page.php");
		echo "<script>
		window.alert('Sorry, there was an error uploading your image.');
		window.location.replace('staff_book_page.php')
		</script>";
	}
	
	if($_POST["action"]=="ADD"){
		$sql = "INSERT INTO book (book_name, book_author, book_publisher, book_genre, book_img) VALUES ('$book_name', '$book_author', '$book_publisher', '$book_genre', '$book_img')";
	} else if($_POST["action"]=="UPDATE") {
		$sql = "UPDATE book SET book_name='$book_name', book_author='$book_author', book_publisher='$book_publisher', book_genre='$book_genre', book_img='$book_img' WHERE book_id=$id";
	}
	
	if($book_img == ""){//no image
		if (mysqli_query($conn, $sql)) {
			header("Location: staff_book_page.php");
		} else {
			die("Error: " . $sql . " : " . mysqli_error($conn) . "<br>");
		}
	} else if($book_img != "" && $uploadOk == 1){//has image
		//if adding new book
		if($_POST["action"]=="ADD"){
			if (mysqli_query($conn, $sql)) {
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					//Image file successfully uploaded 
					header("Location: staff_book_page");
				} 
				else{
					//There is an error while uploading image 
					die("Error: " . $sql . " : " . mysqli_error($conn) . "<br>");         
				}
			} else {
				die("Error: " . $sql . " : " . mysqli_error($conn) . "<br>");
			}
		}
		//if updating book
		if($_POST["action"]=="UPDATE"){
			//get old image
			$tmpsql = "SELECT book_img FROM book WHERE book_id=$id";
			$tmpres = mysqli_query($conn, $tmpsql);
			if (mysqli_num_rows($tmpres) > 0) {
				$tmprow = mysqli_fetch_assoc($tmpres);
				$oldimg = $tmprow["book_img"];
				unlink($target_dir.$oldimg); //delete old image
			} else {
				die("Error: " . $sql . " : " . mysqli_error($conn) . "<br>");
			}
			
			if (mysqli_query($conn, $sql)) {
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					//Image file successfully uploaded 
					header("Location: staff_book_page");
				} 
				else{
					//There is an error while uploading image 
					die("Error: " . $sql . " : " . mysqli_error($conn) . "<br>");         
				}
			} else {
				die("Error: " . $sql . " : " . mysqli_error($conn) . "<br>");
			}
		}
	} 
} 

//DELETE
if ($action=="DELETE") {
	echo $action.":".$id;
	//get old image
	$tmpsql = "SELECT book_img FROM book WHERE book_id=$id";
	$tmpres = mysqli_query($conn, $tmpsql);
	if (mysqli_num_rows($tmpres) > 0) {
		$tmprow = mysqli_fetch_assoc($tmpres);
		$oldimg = $tmprow["book_img"];
		unlink($target_dir.$oldimg); //delete old image
	} else {
		die("Error: " . $sql . " : " . mysqli_error($conn) . "<br>");
	}
	
	$sql = "DELETE FROM book WHERE book_id=$id";
	if (mysqli_query($conn, $sql)) {
		header("Location: staff_book_page.php");
	} else {
		die("Error: " . $sql . " : " . mysqli_error($conn) . "<br>");
	}
} 

?>