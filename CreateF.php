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

$airlN = $depA = $arrA = $status =  $airlNEr = $depAEr = $arrAEr = $statusEr = "";
$depD;
$depDEr = NULL;
$arrD;
$arrDEr = NULL;
$fNum;
$fNumEr = NULL;
$price;
$priceEr = NULL;
$airID;
$airIDEr = NULL;

if($_SERVER["REQUEST_METHOD"] == "POST") {

	if(empty($_POST['fNum'])) {
		$fNum = "Flight number required.";
	}
	else {
		$fNum = $_POST['fNum'];
    }

	if(empty($_POST['depA'])) {
		$depAEr = "Departure airport required.";
	}
	else {
		$depA = $_POST['depA'];
	}

	if(empty($_POST['depD'])) {
		$depDEr = "Departure time required.";
	}
	else {
		$depD = $_POST['depD'];
	}

	if(empty($_POST['arrA'])) {
		$arrAEr = "Arrival airport required.";
	}
	else {
		$arrA = $_POST['arrA'];
	}

	if(empty($_POST['arrD'])) {
		$arrDEr = "Arrival time required.";
	}
	else {
		$arrD = $_POST['arrD'];
	}

	if(empty($_POST['price'])) {
		$priceEr = "Price required.";
	}
	else {
		$price = $_POST['price'];
	}

	if(empty($_POST['status'])) {
		$statusEr = "Status required.";
	}
	else {
		$status = $_POST['status'];
	}

	if(empty($_POST['airID'])) {
		$airIDEr = "Airplane id required.";
	}
	else {
		$airID = $_POST['airID'];
	}

	if($fNum != '' && $depA != '' && $depD != '' && $arrA != '' && $arrD != '' && $price != '' && $status != '' && $airID != '') {
			$sql = "insert into `flight` (`airline_name`, `flight_num`, `departure_airport`, `departure_time`, `arrival_airport`, `arrival_time`, `price`, `status`, `airplane_id`) values ('$theAirline', '$fNum', '$depA', '$depD', '$arrA', '$arrD', '$price', '$status', '$airID')";
			mysqli_query($conn,$sql);
			header("Location: ViewFlights.php");
		}
}

?>

<p><span class="error">* Required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">


	<p><span class="error">* <?php echo $fNumEr;?></span>

	Flight Number: <input type="number" name="fNum"> 
	<br><br>

	<p><span class="error">* <?php echo $depAEr;?></span>

	Departure Airport: <input type="text" name="depA"> 
	<br><br>

	<p><span class="error">* <?php echo $depDEr;?></span>

	Departure Time: <input type="datetime-local" name="depD"> 
	<br><br>

	<p><span class="error">* <?php echo $arrA;?></span>

	Arrival Airport: <input type="text" name="arrA"> 
	<br><br>

	<p><span class="error">* <?php echo $arrDEr;?></span>

	Arrival Time: <input type="datetime-local" name="arrD"> 
	<br><br>

	<p><span class="error">* <?php echo $priceEr;?></span>

	Price: <input type="number" name="price"> 
	<br><br>

	<p><span class="error">* <?php echo $statusEr;?></span>

	Status: <input type="text" name="status"> 
	<br><br>

	<p><span class="error">* <?php echo $airIDEr;?></span>

	Airplane ID: <input type="number" name="airID"> 
	<br><br>

	<input type="submit" value="Create Flight">
</form>