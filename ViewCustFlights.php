<style>
mark { 
    background-color: yellow;
    color: black;
}
</style>

<?php
include "CustLinks.php";
include "db.php";
session_start();
echo "<br><br>";
$username = $_SESSION["Cusername"];



$sql = "select t.ticket_id, f.airline_name, f.flight_num, f.departure_airport, f.arrival_airport, f.departure_time, f.arrival_time from ticket as t, flight as f, purchases as p where f.flight_num = t.flight_num and t.ticket_id = p.ticket_id and p.customer_email = '$username'";
$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result) == 0) {
	echo "You haven't purchased flights!<br>";
	echo '<a href="CustBuy.php">Purchase Flights Here!</a>';
}
else {
	echo "<table border=1>";
	echo "<tr><th>Ticket ID</th><th>Airline</th><th>Flight Number</th><th>Dep. Airport</th><th>Arr. Airport</th><th>Dep. Time</th><th>Arr. Time</th></tr>";
	while($row = mysqli_fetch_assoc($result)) {
		$tid = $row['ticket_id'];
		$airline = $row['airline_name'];
		$fnum = $row['flight_num'];
		$dAir = $row['departure_airport'];
		$aAir = $row['arrival_airport'];
		$dTime = $row['departure_time'];
		$aTime = $row['arrival_time'];
		echo "<tr><td><center>$tid</center></td><td>$airline</td><td><center>$fnum</center></td><td><center>$dAir</center></td><td><center>$aAir</center></td><td>$dTime</td><td>$aTime</td></tr>";
	}
	echo "</table>";
}

?>