<style>
mark { 
    background-color: yellow;
    color: black;
}
</style>

<?php
include "BAgentLinks.php";
include "db.php";
session_start();
echo "<br><br>";
$username = $_SESSION["BAusername"];

$sql1 = "select booking_agent_id from booking_agent where email = '$username'";
$result1 = mysqli_query($conn,$sql1);
$row1 = mysqli_fetch_assoc($result1);
$bID = $row1['booking_agent_id'];



$sql = "select p.customer_email, t.ticket_id, f.airline_name, f.flight_num, f.departure_airport, f.arrival_airport, f.departure_time, f.arrival_time from ticket as t, flight as f, purchases as p where f.flight_num = t.flight_num and t.ticket_id = p.ticket_id and p.booking_agent_id = '$bID'";
$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result) == 0) {
	echo "You haven't purchased flights for customers!<br>";
	echo '<a href="BASearchFlights.php">Purchase Flights Here!</a>';
}
else {
	echo "<table border=1>";
	echo "<tr><th>Customer Email</th><th>Ticket ID</th><th>Airline</th><th>Flight Number</th><th>Dep. Airport</th><th>Arr. Airport</th><th>Dep. Time</th><th>Arr. Time</th></tr>";
	while($row = mysqli_fetch_assoc($result)) {
		$cN = $row['customer_email'];
		$tid = $row['ticket_id'];
		$airline = $row['airline_name'];
		$fnum = $row['flight_num'];
		$dAir = $row['departure_airport'];
		$aAir = $row['arrival_airport'];
		$dTime = $row['departure_time'];
		$aTime = $row['arrival_time'];
		echo "<tr><td><center>$cN</center></td><td><center>$tid</center></td><td>$airline</td><td><center>$fnum</center></td><td><center>$dAir</center></td><td><center>$aAir</center></td><td>$dTime</td><td>$aTime</td></tr>";
	}
	echo "</table>";
}

?>