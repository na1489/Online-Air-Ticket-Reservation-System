<html>
<body>

<?php

include "NormLinks.php";

echo "<b>Are you a Customer, Booking Agent, or Airline Staff?</b><br><br>";

?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
	<input type="radio" name="UserT" value="Customer"> Customer <br><br>
	<input type="radio" name="UserT" value="Booking Agent"> Booking Agent <br><br>
	<input type="radio" name="UserT" value="Airline Staff"> Airline Staff <br><br>
	<input type="submit" value="Continue">
</form>

<?php

$User="";

if($_SERVER["REQUEST_METHOD"] == "POST") {
	if(empty($_POST)) {
		echo "<font color='red'>***Please select one of the above!***</font>";
	}
	else {
		$User = $_POST["UserT"];
		if($User == "Customer") {
			header("Location:NewCust.php");
		}
		elseif($User == "Booking Agent") {
			header("Location:NewBookA.php");
		}
		else {
			header("Location:NewAirStaff.php");
		}
	}
}
?>

</body>