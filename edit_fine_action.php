<?PHP
session_start();
include("config.php");

//check if logged-in
if(!isset($_SESSION["UID"])){
    header("location:index.php"); 
}

$user_id = $_SESSION["user_id"];
//variables
$fine_id = "";
$fine_category = "";
$fine_description = "";
$fine_fee =" ";
$status = "";
//for upload


//this block is called when button Submit is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //values for add or edit
    $fine_id = $_POST["fine_id"];
    $fine_category = $_POST["fine_category"];
    $fine_description = trim($_POST["fine_description"]);
    $fine_fee = $_POST["fine_fee"];
    $status = $_POST["status"];
    $email = $_POST["email"];

   
    $sql = "UPDATE fine SET fine_category= '$fine_category', fine_description ='$fine_description', fine_fee =
    $fine_fee,status = '$status' WHERE fine_id = ". $fine_id;
    
    $status = update_DBTable($conn, $sql);

    if ($status) {
        header("Location: staff_fine_page.php?email=$email");
    } else {
        header("Location: staff_fine_page.php?email=$email");
    } 
  
}
//close db connection
mysqli_close($conn);
//Function to insert data to database table
function update_DBTable($conn, $sql){
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        echo "Error: " . $sql . " : " . mysqli_error($conn) . "<br>";
        return false;
    }
}
?>