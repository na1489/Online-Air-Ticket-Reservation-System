<?php
include "BAgentLinks.php";
include "db.php";

session_start();
$username = $_SESSION["BAusername"];
$sql = "select booking_agent_id from booking_agent where email = '$username'";
$result = mysqli_query($conn,$sql);
$tuple = mysqli_fetch_assoc($result);
$theName = $tuple["booking_agent_id"];

if($_SERVER["REQUEST_METHOD"] == "POST") {
	if($_POST['date1'] != '' && $_POST['date2'] != '') {
		$date1 = $_POST['date1'];
		$date2 = $_POST['date2'];
		$sql20 = "select booking_agent_id, avg(0.1*price) as avgg from purchases as p, flight as f, ticket as t where t.ticket_id = p.ticket_id and t.flight_num = f.flight_num and booking_agent_id = '$theName' and purchase_date between '$date1' and '$date2'";
		$sql21 = "select booking_agent_id, sum(0.1*price) as tot from purchases as p, flight as f, ticket as t where t.ticket_id = p.ticket_id and t.flight_num = f.flight_num and booking_agent_id = '$theName' and purchase_date between '$date1' and '$date2'";
		$result20 = mysqli_query($conn,$sql20);
		$result21 = mysqli_query($conn,$sql21);
		$row20 = mysqli_fetch_assoc($result20);
		$row21 = mysqli_fetch_assoc($result21);
		$avgCom = $row20['avgg'];
		$totCom = $row21['tot'];
	}
	else {
		$sql1 = "select booking_agent_id, avg(0.1*price) as avgg from purchases as p, flight as f, ticket as t where t.ticket_id = p.ticket_id and t.flight_num = f.flight_num and booking_agent_id = '$theName' and purchase_date >= date(now()-interval 30 day)";
		$sql2 = "select booking_agent_id, sum(0.1*price) as tot from purchases as p, flight as f, ticket as t where t.ticket_id = p.ticket_id and t.flight_num = f.flight_num and booking_agent_id = '$theName' and purchase_date >= date(now()-interval 30 day)";
		$result1 = mysqli_query($conn,$sql1);
		$result2 = mysqli_query($conn,$sql2);
		$row1 = mysqli_fetch_assoc($result1);
		$row2 = mysqli_fetch_assoc($result2);
		$totCom = $row2['tot'];
		$avgCom = $row1['avgg'];
	}

}
else {
	$sql = "select booking_agent_id, avg(0.1*price) as avgg from purchases as p, flight as f, ticket as t where t.ticket_id = p.ticket_id and t.flight_num = f.flight_num and booking_agent_id = '$theName' and purchase_date >= date(now()-interval 30 day)";
	$sql10 = "select booking_agent_id, sum(0.1*price) as tot from purchases as p, flight as f, ticket as t where t.ticket_id = p.ticket_id and t.flight_num = f.flight_num and booking_agent_id = '$theName' and purchase_date >= date(now()-interval 30 day)";
	$result = mysqli_query($conn,$sql);
	$result10 = mysqli_query($conn,$sql10);
	$row = mysqli_fetch_assoc($result);
	$row10 = mysqli_fetch_assoc($result10);
	$totCom = $row10['tot'];
	$avgCom = $row['avgg'];

}

echo "<h1> Commissions: </h2><br>";

echo "<h1> Total for Past Month: $$totCom </h2><br>";
echo "<h1> Average for Past Month: $$avgCom </h2><br>";

$conn->close();
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
Date1: <input type="date" name="date1">
Date2: <input type="date" name="date2">
<input type="submit" value="View Commission">
</form>
