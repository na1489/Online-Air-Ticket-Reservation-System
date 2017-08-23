<?php
include "CustLinks.php";
include "db.php";

session_start();
echo "<br><br>";

$username = $_SESSION["Cusername"];
$flightNum = $_POST['fnum'];
$sql = "select * from flight where flight_num = '$flightNum'";
$result = mysqli_query($conn,$sql);
echo "<table border=1>";
	echo "<tr><th>Airline</th><th>Flight Number</th><th>Dep. Airport</th><th>Arr. Airport</th><th> Departure Time </th><th> Arrival Time </th><th>Price</th><th> </th></tr>";
	$row = mysqli_fetch_assoc($result);
	$airline = $row['airline_name'];
	$fnum = $row['flight_num'];
	$dAir = $row['departure_airport'];
	$aAir = $row['arrival_airport'];
	$dTime = $row['departure_time'];
	$aTime = $row['arrival_time'];
	$price = $row['price'];
	echo "<tr><td>$airline</td><td><center>$fnum</center></td><td><center>$dAir</center></td><td><center>$aAir</center></td><td>$dTime</td><td>$aTime</td><td>$$price</td>'<td>";
	echo "</table>";

echo "<h2> How many tickets for Flight $flightNum would you like to purchase?<br>";


?>

<form method="post" action="buy.php">
Quantity: <input type="number" name="quan">
<input type="submit" value="purchase">
<input type="hidden" name="flightNum" value="<?php echo $flightNum;?>" />
</form>