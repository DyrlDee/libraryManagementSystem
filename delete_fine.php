<?PHP
session_start();
include("config.php");
include("reusable.php");

sessionvalidation("UID");

$email;

if(isset($_GET["email"]) && $_GET["email"] != ""){
    $email = $_GET["email"];
}

$user_id = $_SESSION["user_id"];
//this action is called when the Delete link is clicked
if(isset($_GET["id"]) && $_GET["id"] != ""){
    $id = $_GET["id"];
    $sql = "DELETE FROM fine WHERE fine_id=" . $id;
    // echo $sql . "<br>";

    if (mysqli_query($conn, $sql)) {
        header("Location: staff_fine_page.php?email=$email");
    } else {
        echo "Error deleting record: " . mysqli_error($conn) . "<br>";
        echo '<a href="staff_fine_page.php?email=' . $email . '">Back</a>';
    }
}
mysqli_close($conn);
?>