<!DOCTYPE HTML >
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>

<?php
include "NormLinks.php";
include "db.php";

$usernameError = $passwordError = $username = $password = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
	if(empty($_POST['name'])) {
		$usernameError = "Username required.";
	}
	else {
		$username = testThis($_POST['name']);
	}

	$password = $_POST['pass'];
	if(empty($_POST['pass'])) {
		$passwordError = "Password required.";
	}
	else {
		$password = md5(testThis($_POST['pass']));
	}

	if(!empty($_POST['name']) && !empty($_POST['pass'])) {
		$sql1 = "Select email from customer where email='$username' and password='$password'";
		$sql2 = "Select email from booking_agent where email='$username' and password='$password'";
		$sql3 = "Select username from airline_staff where username='$username' and password='$password'";
		$mysqli_result1 = mysqli_query($conn,$sql1);
		$mysqli_result2 = mysqli_query($conn,$sql2);
		$mysqli_result3 = mysqli_query($conn,$sql3);
		if(mysqli_num_rows($mysqli_result1) == 1) {
			session_start();
			$_SESSION['Cusername'] = $username;
			$conn->close();
			header("Location:CustHome.php");
		}
		elseif(mysqli_num_rows($mysqli_result2) == 1) {
			session_start();
			$_SESSION['BAusername'] = $username;
			$conn->close();
			header("Location:BAgentHome.php");
		}
		elseif(mysqli_num_rows($mysqli_result3) == 1) {
			session_start();
			$_SESSION['ASusername'] = $username;
			$conn->close();
			header("Location:AirStaffHome.php");
		}
		else {
			echo "<br><font color='red'>Invalid username or password!</font>";
		}
	}
}

function testThis($info) {
	$info = trim($info);
	$info = stripslashes($info);
	$info = htmlspecialchars($info);
	return $info;
}

?>

<p><span class="error">* Required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
	<p><span class="error">* <?php echo $usernameError;?></span>

	Username: <input type="text" name="name"> <?php echo $username;?> <br><br>

	<p><span class="error">* <?php echo $passwordError;?></span>

	Password: <input type="password" name="pass"> 
	<br><br>
	<input type="submit" value="login">
</form>

<?php

echo "<br><h2> New User?</h2>";
echo '<a href="Register.php">Register</a>';
?>