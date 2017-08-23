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

$sql1 = "select booking_agent_id, count(ticket_id) as numSold from purchases where booking_agent_id !='NULL' group by booking_agent_id order by numSold desc";
$res = mysqli_query($conn,$sql1);
echo "<br>";

echo "<h1>Top 5 Booking Agents based on Tickets Sold: <br></h2>";

if(mysqli_num_rows($res) == 0) {
	echo "There are no booking agents!<br>";
}
else {
	$count = 0;
	echo "<table border=1>";
	echo "<tr><th>Booking Agent ID <th> Number Tickets Sold </th></tr>";
	while($row1 = mysqli_fetch_assoc($res)) {
		$bA = $row1['booking_agent_id'];
		$nS = $row1['numSold'];
		echo "<tr><td><center>$bA</td><td><center>$nS</center></td></tr>";
		$count++;
		if($count == 5) break;
	}
	echo "</table>";
}

$sql2 = "select booking_agent_id, sum(0.1*price) as tot from purchases as p, flight as f, ticket as t where booking_agent_id != 'NULL' and t.ticket_id = p.ticket_id and t.flight_num = f.flight_num and purchase_date >= date(now()-interval 365 day) group by booking_agent_id order by tot desc";
$res2 = mysqli_query($conn,$sql2);
echo "<br>";

echo "<h1>Top 5 Booking Agents based on Commission for the Last Year: <br></h2>";

if(mysqli_num_rows($res2) == 0) {
	echo "There are no booking agents!<br>";
}
else {
	$count1 = 0;
	echo "<table border=1>";
	echo "<tr><th>Booking Agent ID <th> Total Commission </th></tr>";
	while($row2 = mysqli_fetch_assoc($res2)) {
		$bA1 = $row2['booking_agent_id'];
		$nC = $row2['tot'];
		echo "<tr><td><center>$bA1</td><td><center>$nC</center></td></tr>";
		$count1++;
		if($count1 == 5) break;
	}
	echo "</table>";
}
?>