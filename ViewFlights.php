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
	if($_POST['date1'] != '' && $_POST['date2'] != '' && $_POST['dCoA'] !='' && $_POST['aCoA']) {
		$date1 = $_POST['date1'];
		$date2 = $_POST['date2'];
		$dCoA = $_POST['dCoA'];
		$aCoA = $_POST['aCoA'];
		$sql1 = "select f.flight_num, f.departure_airport, f.arrival_airport, f.departure_time, f.arrival_time from flight as f,airport as a1, airport as a2 where a1.airport_name = f.departure_airport and a2.airport_name = f.arrival_airport and status = 'Upcoming' and (departure_airport = '$dCoA' or a1.airport_city = '$dCoA') and (arrival_airport = '$aCoA' or a2.airport_city = '$aCoA') and airline_name = '$theAirline' and departure_time between '$date1' and '$date2' ";

	}
	else {
		$sql1 = "select f.flight_num, f.departure_airport, f.arrival_airport, f.departure_time, f.arrival_time from flight as f where status = 'Upcoming' and departure_time between date(now()) and date(now() + interval 30 day) and airline_name = '$theAirline'";
	}

}
else {
	$sql1 = "select f.flight_num, f.departure_airport, f.arrival_airport, f.departure_time, f.arrival_time from flight as f where status = 'Upcoming' and departure_time between date(now()) and date(now() + interval 30 day) and airline_name = '$theAirline'";
}

$result1 = mysqli_query($conn,$sql1);
echo "<br><br>";

if(mysqli_num_rows($result1) == 0) {
	echo "There are no flights this time!<br>";
}
else {
	echo "<table border=1>";
	echo "<tr><th>Flight Number</th><th>Dep. Airport</th><th>Arr. Airport</th><th> Departure Time </th><th> Arrival Time </th></tr>";
	while($row1 = mysqli_fetch_assoc($result1)) {
		$fnum = $row1['flight_num'];
		$dAir = $row1['departure_airport'];
		$aAir = $row1['arrival_airport'];
		$dTime = $row1['departure_time'];
		$aTime = $row1['arrival_time'];
		echo "<tr><td><center>$fnum</center></td><td><center>$dAir</center></td><td><center>$aAir</center></td><td>$dTime</td><td>$aTime</td></tr>";
	}
	echo "</table>";
}
$conn->close();
?>

<br>
<br>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
Date1: <input type="date" name="date1">
Date2: <input type="date" name="date2">
Departure Airport/City: <input type="search" name="dCoA">
Arrival Airport/City: <input type="searcg" name="aCoA">
<input type="submit" value="Search">
</form>
