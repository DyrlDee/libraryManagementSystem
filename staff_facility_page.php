<?php
session_start();

include("config.php");

// $user_id = $_SESSION["user_id"];

$id = "";
if(!empty($_GET['id'])) {
	$id = $_GET['id'];
}
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,  initial-scale=1.0">
    <title>Library Management System</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,400&family=Raleway:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <script>
        function myFunction() {
            var x = document.getElementById("myTopHeader");
            if (x.className === "myTopHeader") {
                x.className += " responsive";
            } else {
                x.className = "myTopHeader";
            }
        }
		
		function show_addRoom() {
			var x = document.getElementById("facilityList");
			x.style.display = 'none';
			
			var x = document.getElementById("addRoom");
			x.style.display = 'inline';
		}
		
		function confirmDelete(delid) {
			var ok = window.confirm("Delete?");
			var link = "staff_facility_action.php";
			if(ok == false){
				window.location.href = link;
			} else {
				link = link.concat(delid);
				window.location.href = link;
			}
		}
    </script>

    <body>
        <?php 
        if(isset($_SESSION["type"])){

            if($_SESSION["type"] == 1){
                // For Staff
                include 'staff_menu.php';
            }
            elseif($_SESSION["type"] == 2){
                //For User
                //include 'user_menu.php';
				header(Location:index.php);
            }
            
        }
        else {
            //include 'user_menu.php';
            include 'staff_menu.php';
            //include 'menu.php';
        }
        ?>
		<div id="facilityList">
		<div class="row" style="justify-content:center;margin-left:auto;margin-right:auto;">
			<a href="javascript:show_addRoom();" class="link-btn" style="margin-top:30px;padding:8px 30px;">Add Room</a>
		</div>
		
        <h2 class="title">Meeting Room</h2>
        <!-- Facility -->
        <div class="gridiv">
			<?php
			$sql = "SELECT * FROM facility WHERE faci_type='Meeting Room'";
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
				$numrow=1;
				while($row = mysqli_fetch_assoc($result)) {
					echo "<div class='griditem'>";
					echo "<div class='gridimg' 
					style='width:auto;height:100px;";
					echo $row['status']=='notavailable' ? "background-color:#D9D9D9;": "";
					echo "'><p class='gridtext'>".$row['faci_name']."</p></div><a href='staff_facility_page.php?id=".$row['faci_id']."' class='link-btn' style='margin-top:30px;text-align:center;'>Update</a>";
					echo "</div>";
					$numrow++;
				}
			} else {
				echo '<p style="text-align:center">0 Results</p>';
			}
			?>
        </div>
		
        <h2 class="title">Cubicle</h2>
        <!-- Kubikle -->
        <div class="gridiv">
			<?php
			$sql = "SELECT * FROM facility WHERE faci_type='Cubicle Room'";
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
				$numrow=1;
				while($row = mysqli_fetch_assoc($result)) {
					echo "<div class='griditem'>";
					echo "<div class='gridimg' 
					style='width:auto;height:100px;";
					echo $row['status']=='notavailable' ? "background-color:#dfdfdf;": "";
					echo "'><p class='gridtext'>".$row['faci_name']."</p></div><a href='staff_facility_page.php?id=".$row['faci_id']."' class='link-btn' style='margin-top:30px;text-align:center;'>Update</a>";
					echo "</div>";
					$numrow++;
				}
			} else {
				echo '<p style="text-align:center">0 Results</p>';
			}
			?>
        </div>
		</div>
		
		<div id="addRoom" style="display:none;">
			<h2 class="title">Add Facility</h2>
			<form action="staff_facility_action.php" method="POST">
			<table class="Atable">
				<input type="hidden" name="action" value="ADD">
				<tr>
					<th><label for="roomname">Room Name: </label></th>
					<td><input type="text" name="roomname" required></td>
				</tr>
				<tr>
					<th><label for="facitype">Faci Type: </label></th>
					<td><select size="1" name="facitype" required>      
						<option value="" selected disabled>&nbsp;</option>
						<option value="Meeting Room">Meeting Room</option>
						<option value="Cubicle Room">Cubicle Room</option>
					</select></td>
				</tr>
				<tr>
					<th><label for="status">Status: </label></th>
					<td><select size="1" name="status" required>      
						<option value="" selected disabled>&nbsp;</option>
						<option value="available">Available</option>
						<option value="notavailable">Not Available</option>
					</select></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="" id="" value="Add"></td>
				</tr>
			</table>
			</form>
		</div>
		
		<div id="updateRoom" style="display:none;">
			<h2 class="title">Update Facility</h2>
			<form action="staff_facility_action.php" method="POST">
			<?php
			$sql = "SELECT * FROM facility WHERE faci_id='$id'";
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
				$row = mysqli_fetch_assoc($result);
			}
			
			?>
			<table class="Atable">
				<input type="hidden" name="action" value="UPDATE">
				<input type="hidden" name="id" value="<?=$row['faci_id']?>">
				<tr>
					<th><label for="roomname">Room Name: </label></th>
					<td><input type="text" name="roomname" value="<?=$row['faci_name']?>" required></td>
				</tr>
				<tr>
					<th><label for="facitype">Faci Type: </label></th>
					<td><select size="1" name="facitype" required>
					<?php
						echo '<option value="Meeting Room" '; 
						if($row['faci_type']=="Meeting Room") echo 'selected';
						echo '>Meeting Room</option>';
						
						echo '<option value="Cubicle Room" '; 
						if($row['faci_type']=="Cubicle Room") echo 'selected';
						echo '>Cubicle Room</option>';
					?>
					</select></td>
				</tr>
				<tr>
					<th><label for="status">Status: </label></th>
					<td><select size="1" name="status" required>
					<?php
						echo '<option value="available" '; 
						if($row['status']=="available") echo 'selected';
						echo '>Available</option>';
						
						echo '<option value="notavailable" '; 
						if($row['status']=="notavailable") echo 'selected';
						echo '>Not Available</option>';
					?>
					</select></td>
				</tr>
				<tr>
					<td colspan="2">
					<input type="submit" name="" id="" value="Update">  
					<input type="button" name="delete" id="delete" value="Delete" onclick="confirmDelete('?delid=<?=$row['faci_id']?>')">
					</td>
				</tr>
			</table>
			</form>
		</div>
		
		<?php //show update room form
		if(!empty($_GET['id'])) {
			$id = $_GET['id'];
			echo '<script>
			(function () {
				var x = document.getElementById("facilityList");
				x.style.display = "none";
				
				var x = document.getElementById("updateRoom");
				x.style.display = "inline";
				})();
			</script>';
		}
		?>
	</body>
</html>
