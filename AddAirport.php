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
	$AN = $_POST['AN'];
	$AC = $_POST['AC'];
	$sql1 = "insert into `airport` (`airport_name`, `airport_city`) VALUES ('$AN', '$AC')";
	mysqli_query($conn,$sql1);
	header("Location: AirStaffHome.php");
}

?>

<br><br>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
Airport Name: <input type="text" name="AN">
Airport City: <input type="text" name="AC">
<input type="submit" value="Add Airport">