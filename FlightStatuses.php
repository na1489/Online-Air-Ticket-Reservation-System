<?php
include "NormLinks.php";
include "db.php";


$fNum = '';
$DepD = '';
$ArrD = '';
$fEr = '';
$dEr = '';
$aEr = '';

if($_SERVER["REQUEST_METHOD"] == "POST") {

	if(empty($_POST['fNum'])) {
		$fEr = "<br><h2>Flight number required.</h2>";
		echo $fEr;
		echo '<a href="GenFlights.php">Go Back To Search</a>';
	}
	else $fNum = $_POST['fNum'];

	if(empty($_POST['Depdate'])) {
		$dEr = "<br><h2>Departure date required.</h2>";
		echo $dEr;
		echo '<a href="GenFlights.php">Go Back To Search</a>';
	}
	else $DepD = $_POST['Depdate'];

	if(empty($_POST['Arrdate'])) {
		$aEr = "<br><h2>Arrival date required.</h2>";
		echo $aEr;
		echo '<a href="GenFlights.php">Go Back To Search</a>';
	}
	else $ArrD = $_POST['Arrdate'];

	$sql = "select f.flight_num, f.departure_airport, f.departure_time, f.arrival_airport, f.arrival_time, f.status from flight as f where f.flight_num = '$fNum' and f.departure_time = '$DepD' and f.arrival_time = '$ArrD'";
	$result = mysqli_query($conn,$sql);
	if(mysqli_num_rows($result) < 1) {
		echo "<h2>There are no such flights!</h2>";
	}
	else {
		echo "<br><br>";
		echo "<table border=1>";
		echo "<tr><th>Flight Number</th><th>Departure Airport</th><th>Departure Time</th><th>Arrival Airport</th><th> Arrival Time</th><th><b>Flight Status</th></tr>";
		$row = mysqli_fetch_assoc($result);
		$depA = $row['departure_airport'];
		$arrA = $row['arrival_airport'];
		$status = $row['status'];
		echo "<tr><td>$fNum</td><td><center>$depA</center></td><td><center>$DepD</center></td><td><center>$arrA</center></td><td><center>$ArrD</center></td><td><b>$status</td></tr>";
	}
	echo "</table>";
}
?>