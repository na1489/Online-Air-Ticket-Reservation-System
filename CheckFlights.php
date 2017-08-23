<?php
include "NormLinks.php";
include "db.php";

$dCoA = "";
$aCoA = "";
$ddate = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$dCoA = $_POST['DepCoAName'];
	$aCoA = $_POST['ArrCoAName'];
	$ddate = $_POST['date'];
	if($ddate == '' && $dCoA != '' && $aCoA != '') {
		$sql = "select f.airline_name, f.flight_num, f.departure_airport, f.arrival_airport, f.departure_time, f.arrival_time, f.price from flight as f,airport as a1, airport as a2 where a1.airport_name = f.departure_airport and a2.airport_name = f.arrival_airport and status = 'Upcoming' and (departure_airport = '$dCoA' or a1.airport_city = '$dCoA') and (arrival_airport = '$aCoA' or a2.airport_city = '$aCoA')";
	}
	elseif($ddate !='' && $dCoA != '' && $aCoA != '') {
		$sql = "select f.airline_name, f.flight_num, f.departure_airport, f.arrival_airport, f.departure_time, f.arrival_time, f.price from flight as f,airport as a1, airport as a2 where a1.airport_name = f.departure_airport and a2.airport_name = f.arrival_airport and status = 'Upcoming' and (departure_airport = '$dCoA' or a1.airport_city = '$dCoA') and (arrival_airport = '$aCoA' or a2.airport_city = '$aCoA') and departure_time between '$ddate' and '$ddate 23:59:59'";
	}
	elseif($ddate =='' && $dCoA == '' && $aCoA == '') {
		$sql = "select f.airline_name, f.flight_num, f.departure_airport, f.arrival_airport, f.departure_time, f.arrival_time, f.price from flight as f where status = 'Upcoming' ";
	}
}

$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result) == 0) {
	echo "There are no upcoming flights!<br>";
}
else {
	echo "<br><table border=1>";
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
			<form action ='Login.php'><input type='submit' value='purchase'></form></td>'</tr>";
	}
	echo "</table>";
}
?>