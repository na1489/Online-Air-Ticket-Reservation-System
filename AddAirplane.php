<?php
include "ASLinks.php";
include "db.php";

session_start();
$username = $_SESSION["ASusername"];
$sql = "select * from airline_staff where username = '$username'";
$result = mysqli_query($conn,$sql);
$tuple = mysqli_fetch_assoc($result);
$theName = $tuple["first_name"];
$theAirline = $tuple["airline_name"];

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$AirID = $_POST['AirID'];
	$seats = $_POST['seats'];
	$sql1 = "insert into `airplane` (`airline_name`, `airplane_id`, `seats`) VALUES ('$theAirline', '$AirID', '$seats')";
	mysqli_query($conn,$sql1);
	header("Location: ViewAirplanes.php");
}

?>

<br><br>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
Airplane ID: <input type="number" name="AirID">
Total Number of Seats: <input type="number" name="seats">
<input type="submit" value="Add Airplane">