<?php
include "ASLinks.php";
include "db.php";

session_start();
$username = $_SESSION['ASusername'];
$sql = "select * from airline_staff where username = '$username'";
$result = mysqli_query($conn,$sql);
$tuple = mysqli_fetch_assoc($result);
$theName = $tuple["first_name"];
$theAirline = $tuple["airline_name"];

$sql1 = "select * from airplane where airline_name = '$theAirline'";
$res = mysqli_query($conn,$sql1);
echo "<br><br>";

if(mysqli_num_rows($res) == 0) {
	echo "There are no airplanes owned by '$theAirline'!<br>";
}
else {
	echo "<table border=1>";
	echo "<tr><th>Airplane ID<th> Seats </th></tr>";
	while($row1 = mysqli_fetch_assoc($res)) {
		$airID = $row1['airplane_id'];
		$seats = $row1['seats'];
		echo "<tr><td><center>$airID</td><td>$seats</td></tr>";
	}
	echo "</table>";
}
?>