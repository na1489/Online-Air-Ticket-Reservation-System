<html>
<body>
<style>
.error {color: #FF0000;}
</style>

<?php
include "NormLinks.php";
include "db.php";

$email = $password = $emailEr = $passwordEr = "";
$bookingID = NULL;
$bookingIDEr = NULL;

if($_SERVER["REQUEST_METHOD"] == "POST") {

	if(empty($_POST['email'])) {
		$emailEr = "Email required.";
	}
	else {
		$email = $_POST['email'];
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      	$emailEr = "Invalid email format";
      }
	}

	if(empty($_POST['password'])) {
		$passwordEr = "Password required.";
	}
	else {
		$password = md5($_POST['password']);
	}

	if(empty($_POST['bookingID'])) {
		$bookingIDEr = "Booking Agent ID required.";
	}
	else {
		$bookingID = $_POST['bookingID'];
		if($bookingID < 100000) {
			$bookingIDEr = "Invalid booking agent.";
		}
	}

	if($email != '' && $password != '' && $bookingID != '') {
			$sql = "insert into `booking_agent` (`email`, `password`, `booking_agent_id`) VALUES ('$email', '$password', '$bookingID')";
			mysqli_query($conn,$sql);
			header("Location: Login.php");
		}
}

?>

<p><span class="error">* Required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">

	<p><span class="error">* <?php echo $emailEr;?></span>

	Email: <input type="text" name="email"><br><br>

	<p><span class="error">* <?php echo $passwordEr;?></span>

	Password: <input type="password" name="password"> 
	<br><br>

	<p><span class="error">* <?php echo $bookingIDEr;?></span>

	Booking Agent ID: <input type="number" name="bookingID"> 
	<br><br>

	<input type="submit">
</form>