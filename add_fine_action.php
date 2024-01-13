<?PHP
session_start();
include("config.php");

//check if logged-in
if(!isset($_SESSION["UID"])){
    header("location:index.php"); 
}

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
    $user_id = $_POST["user_id"];
    $id = $_POST["id"];
    $email = $_POST["email"];
    $type = $_POST["type"];
    $fine_category = $_POST["fine_category"];
    $fine_description = trim($_POST["fine_description"]);
    $fine_fee = $_POST["fine_fee"];
    $status = $_POST["status"];
    $sql;

    if($type == "loan"){
        $sql = "INSERT INTO fine (user_id,loan_id,fine_category, fine_description, fine_fee, status)
        VALUES ($user_id,$id,'$fine_category', '$fine_description', $fine_fee, '$status')";
    }
    else if($type == "reservation"){
        $sql = "INSERT INTO fine (user_id,reserve_id,fine_category, fine_description, fine_fee, status)
        VALUES ($user_id,$id,'$fine_category', '$fine_description', $fine_fee, '$status')";
    }
    
    $status = update_DBTable($conn, $sql);

    if ($status) {
        header("Location: staff_fine_page.php?email=$email");
    } else {
        echo '<a href="my_challenge.php">Back</a>';
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