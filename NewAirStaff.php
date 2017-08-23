<html>
<body>
<style>
.error {color: #FF0000;}
</style>

<?php
include "NormLinks.php";
include "db.php";

$username = $password = $fname = $street = $lname = $airline = $usernameEr = $passwordEr = $fnameEr = $lnameEr = $airlineEr = "";
$dob;
$dobEr = NULL;

if($_SERVER["REQUEST_METHOD"] == "POST") {

	if(empty($_POST['username'])) {
		$usernameEr = "Username required.";
	}
	else {
		$username = $_POST['username'];
	}

	if(empty($_POST['password'])) {
		$passwordEr = "Password required.";
	}
	else {
		$password = md5($_POST['password']);
	}

	if(empty($_POST['fname'])) {
		$fnameEr = "First name required.";
	}
	else {
		$fname = $_POST['fname'];
		if (!preg_match("/^[a-zA-Z ]*$/",$fname)) {
    		$fnameEr = "Only letters and white space allowed.";
    	}
	}

	if(empty($_POST['lname'])) {
		$lnameEr = "Last name required.";
	}
	else {
		$lname = $_POST['lname'];
		if (!preg_match("/^[a-zA-Z ]*$/",$lname)) {
    		$lnameEr = "Only letters and white space allowed.";
    	}
	}

	if(empty($_POST['airline'])) {
		$airlineEr = "Airline name required.";
	}
	else {
		$airline = $_POST['airline'];
		if (!preg_match("/^[a-zA-Z ]*$/",$airline)) {
    		$airlineEr = "Only letters and white space allowed.";
    	}
	}

	if(empty($_POST['dob'])) {
		$dobEr = "Date of birth required.";
	}
	else {
		$dob = $_POST['dob'];
	}


	if($username != '' && $password != '' && $fname != '' && $lname != '' && $airline != '' && $dob != '') {
			$sql = "insert into `airline_staff` (`username`, `password`, `first_name`, `last_name`, `date_of_birth`, `airline_name`) VALUES ('$username', '$password', '$fname', '$lname', '$dob', '$airline')";
			mysqli_query($conn,$sql);
			header("Location: Login.php");
		}
}

?>

<p><span class="error">* Required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">

	<p><span class="error">* <?php echo $usernameEr;?></span>

	Username: <input type="text" name="username"><br><br>

	<p><span class="error">* <?php echo $passwordEr;?></span>

	Password: <input type="password" name="password"> 
	<br><br>

	<p><span class="error">* <?php echo $fnameEr;?></span>

	First Name: <input type="text" name="fname"> 
	<br><br>
A
	<p><span class="error">* <?php echo $lnameEr;?></span>

	Last Name: <input type="text" name="lname"> 
	<br><br>

	<p><span class="error">* <?php echo $dobEr;?></span>

	Date of Birth: <input type="date" name="dob"> 
	<br><br>

	<p><span class="error">* <?php echo $airlineEr;?></span>

	Airline Name: <input type="text" name="airline"> 
	<br><br>

	<input type="submit">
</form>