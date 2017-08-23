<?php
include "BAgentLinks.php";
include "db.php";

session_start();
echo "<br><br>";

$username = $_SESSION["BAusername"];
$dCoA = "";
$aCoA = "";
$ddate = "";
$searched = false;

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$searched = true;
	$dCoA = $_POST['DepCoAName'];
	$aCoA = $_POST['ArrCoAName'];
	$ddate = $_POST['date'];
	if($ddate == '') {
		$sql = "select f.airline_name, f.flight_num, f.departure_airport, f.arrival_airport, f.departure_time, f.arrival_time, f.price from flight as f,airport as a1, airport as a2 where a1.airport_name = f.departure_airport and a2.airport_name = f.arrival_airport and status = 'Upcoming' and (departure_airport = '$dCoA' or a1.airport_city = '$dCoA') and (arrival_airport = '$aCoA' or a2.airport_city = '$aCoA')";
	}
	else {
		$sql = "select f.airline_name, f.flight_num, f.departure_airport, f.arrival_airport, f.departure_time, f.arrival_time, f.price from flight as f,airport as a1, airport as a2 where a1.airport_name = f.departure_airport and a2.airport_name = f.arrival_airport and status = 'Upcoming' and (departure_airport = '$dCoA' or a1.airport_city = '$dCoA') and (arrival_airport = '$aCoA' or a2.airport_city = '$aCoA') and departure_time between '$ddate' and '$ddate 23:59:59'";
	}
}
else {
	$sql = "select f.airline_name, f.flight_num, f.departure_airport, f.arrival_airport, f.departure_time, f.arrival_time, f.price from flight as f where status = 'Upcoming' ";
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
Departure City or Airport: <input type="search" name="DepCoAName"> <?php echo $dCoA;?> <br><br>
Arrival City or Airport: <input type="search" name="ArrCoAName"> <?php echo $aCoA;?> <br><br>
Departure Date: <input type="date" name="date"> <?php echo $ddate;?> <br><br>
<input type="submit" value="Search">
</form>

<?php
if($searched == false) {
	echo "<h1><br> All flights below:</h2> <br>";
}
else {
	echo "<h1><br> Searched flights below:</h2> <br>";
}

$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result) == 0) {
	echo "There are no upcoming flights!<br>";
}
else {
	echo "<table border=1>";
	echo "<tr><th>Airline</th><th>Flight Number</th><th>Dep. Airport</th><th>Arr. Airport</th><th> Departure Time </th><th> Arrival Time </th><th>Price</th><th> </th></tr>";
	while($row = mysqli_fetch_assoc($result)) {
		$airline = $row['airline_name'];
		$fnum = $row['flight_num'];
		$dAir = $row['departure_airport'];
		$aAir = $row['arrival_airport'];
		$dTime = $row['departure_time'];
		$aTime = $row['arrival_time'];
		$price = $row['price'];
		echo "<tr><td>$airline</td><td><center>$fnum</center></td><td><center>$dAir</center></td><td><center>$aAir</center></td><td>$dTime</td><td>$aTime</td><td>$$price</td>'<td>
			<form method='post' action ='BAConfirm.php'><input type='submit' value='purchase'><input type='hidden' name='fnum' value='$fnum'></form></td>'</tr>";
	}
	echo "</table>";
}
?>