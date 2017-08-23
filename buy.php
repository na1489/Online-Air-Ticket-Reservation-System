<?php
include "CustLinks.php";
include "db.php";

session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = $_SESSION["Cusername"];
	$numBuy = $_POST['quan'];
	$fNum = $_POST['flightNum'];
	$sql2 = "select seats from flight as f, airplane as a where f.airline_name = a.airline_name and f.airplane_id = a.airplane_id and f.flight_num = '$fNum'";
	$result2 = mysqli_query($conn,$sql2);
	$row2 = mysqli_fetch_assoc($result2);
	$seats = $row2['seats'];
	$sql4 = "select count(flight_num) as c from ticket where flight_num = '$fNum'";
	$result = mysqli_query($conn,$sql4);
	$row = mysqli_fetch_assoc($result);
	$seatsBought = $row['c'];
	if($seatsBought + $numBuy > $seats) {
		echo "<h2> This flight does not have $numBuy ticket[s] left!</h2>";
		echo '<a href="CustSearchFlights.php">Go back to search page</a>';
	}
	else {
		$total = 0;
		$sql = "select * from flight where flight_num = '$fNum'";
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($result);
		$sql1 = "select max(ticket_id) as m from ticket where flight_num = '$fNum'";
		$result1 = mysqli_query($conn,$sql1);
		$row1 = mysqli_fetch_assoc($result1);
		$dA = $row['departure_airport'];
		$airlineN = $row['airline_name'];
		$airplaneID = $row['airplane_id'];
		$aA = $row['arrival_airport'];
		$price = $row['price'];
		echo "<h2> You have bought $numBuy ticket[s] for Flight $fNum from $dA to $aA! Thank you for your purchase.<br><br>";
		$total = $numBuy*$price;
		echo "Your total is $$total.";

		$ticketID = $row1['m'];
		if($ticketID == NULL) {
			$ticketID = $fNum*1000;
		}
		for($i = 0; $i < $numBuy; $i++) {
			$ticketID++;
			$dd = date("Y:m:d");
			$sql5 = "insert into ticket (ticket_id, airline_name, flight_num) values ('$ticketID', '$airlineN', '$fNum')";
			mysqli_query($conn,$sql5);
			$sql6 = "insert into purchases (ticket_id, customer_email, purchase_date) values ('$ticketID', '$username', '$dd')";
			mysqli_query($conn,$sql6);
		}
	}

}
?>







