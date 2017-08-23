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
	$newS = $_POST['newS'];
	$fNum = $_POST['fNum'];
	$sql1 = "update flight set status = '$newS' where flight.airline_name = '$theAirline' and flight.flight_num = '$fNum'";
	mysqli_query($conn,$sql1);
	header("Location: ViewFlights.php");
}
?>

<br><br>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
Change Flight Number: <input type="number" name="fNum">
Change Status To: <input type="text" name="newS">
<input type="submit" value="Change Flight Status">