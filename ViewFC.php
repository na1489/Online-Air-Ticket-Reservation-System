<?php
include "ASLinks.php";
include "db.php";

session_start();
$username = $_SESSION["ASusername"];
$sql = mysqli_prepare($conn,"select * from airline_staff where username = ?");
mysqli_stmt_bind_param($sql,"s",$username);
mysqli_stmt_execute($sql);
$result = mysqli_stmt_get_result($sql);
$tuple = mysqli_fetch_assoc($result);
$theName = $tuple["first_name"];
$theAirline = $tuple["airline_name"];

$sql1 = "select customer_email, count(customer_email) as tot from purchases as p, flight as f, ticket as t where t.ticket_id = p.ticket_id and t.flight_num = f.flight_num and f.airline_name = '$theAirline' group by customer_email order by tot desc";
$res = mysqli_query($conn,$sql1);
echo "<br>";

echo "<h1>Most Frequent Customer[s]: <br></h2>";

if(mysqli_num_rows($res) == 0) {
	echo "There are no customers who purchased flights!<br>";
}
else {
	echo "<table border=1>";
	echo "<tr><th>Customer Email <th> Number Tickets Bought </th></tr>";
	$row1 = mysqli_fetch_assoc($res);
	$maxBought = $row1['tot'];
	while($row1['tot'] == $maxBought) {
		$bA = $row1['customer_email'];
		$nS = $row1['tot'];
		echo "<tr><td><center>$bA</td><td><center>$nS</center></td></tr>";
		$row1 = mysqli_fetch_assoc($res);
	}
	echo "</table>";
}

$sql2 = "select distinct p.customer_email, f.flight_num from purchases as p, flight as f, ticket as t where t.ticket_id = p.ticket_id and t.flight_num = f.flight_num and f.airline_name = '$theAirline' ORDER BY p.customer_email ASC";
$res2 = mysqli_query($conn,$sql2);
echo "<br>";

echo "<h1>All customers and the flights: <br></h2>";

if(mysqli_num_rows($res2) == 0) {
	echo "There are no customers who purchased tickets!<br>";
}
else {
	$count1 = 0;
	echo "<table border=1>";
	echo "<tr><th> Customer Email <th> Flight Numbers </th></tr>";
	while($row2 = mysqli_fetch_assoc($res2)) {
		$bA1 = $row2['customer_email'];
		$nC = $row2['flight_num'];
		echo "<tr><td><center>$bA1</td><td><center>$nC</center></td></tr>";
		$count1++;
		if($count1 == 5) break;
	}
	echo "</table>";
}
?>