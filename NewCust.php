<html>
<body>
<style>
.error {color: #FF0000;}
</style>

<?php
include "NormLinks.php";
include "db.php";

$email = $name = $password = $building_num = $street = $city = $state = $passport_num = $passport_cntry = $emailEr = $nameEr = $passwordEr = $building_numEr = $streetEr = $cityEr = $stateEr = $passport_numEr = $passport_cntryEr = "";
$phone;
$phoneEr = NULL;
$passport_exp;
$passport_expEr = NULL;
$dob;
$dobEr = NULL;

if($_SERVER["REQUEST_METHOD"] == "POST") {

	if(empty($_POST['email'])) {
		$emailEr = "Email required.";
	}
	else {
		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      	$emailEr = "Invalid email format";
    	}
    	else {
			$email = $_POST['email'];
    	}
	}

	if(empty($_POST['password'])) {
		$passwordEr = "Password required.";
	}
	else {
		$password = md5($_POST['password']);
	}

	if(empty($_POST['name'])) {
		$nameEr = "Name required.";
	}
	else {
		if (!preg_match("/^[a-zA-Z ]*$/",$_POST['name'])) {
    		$nameEr = "Only letters and white space allowed.";
    	}
    	else {
			$name = $_POST['name'];
    	}
	}

	if(empty($_POST['building_num'])) {
		$building_numEr = "Building number required.";
	}
	else {
		$building_num = $_POST['building_num'];
	}

	if(empty($_POST['street'])) {
		$streetEr = "Street required.";
	}
	else {
		$street = $_POST['street'];
	}

	if(empty($_POST['city'])) {
		$cityEr = "City required.";
	}
	else {
		$city = $_POST['city'];
	}

	if(empty($_POST['state'])) {
		$stateEr = "State required.";
	}
	else {
		$state = $_POST['state'];
	}

	if(empty($_POST['passport_num'])) {
		$passport_numEr = "Passport number required.";
	}
	else {
		$passport_num = $_POST['passport_num'];
	}

	if(empty($_POST['passport_cntry'])) {
		$passport_cntryEr = "Passport country required.";
	}
	else {
		$passport_cntry = $_POST['passport_cntry'];
	}

	if(empty($_POST['phone'])) {
		$phoneEr = "Phone number required.";
	}
	else {
		$phone = $_POST['phone'];
	}

	if(empty($_POST['passport_exp'])) {
		$passport_expEr = "Passport expiration date required.";
	}
	else {
		$passport_exp = $_POST['passport_exp'];
	}

	if(empty($_POST['dob'])) {
		$dobEr = "Date of birth required.";
	}
	else {
		$dob = $_POST['dob'];
	}

	if($email != '' && $password != '' && $name != '' && $building_num != '' && $street != '' && $city != '' && $state != '' && $passport_num != '' && $passport_cntry != '' && $phone != '' && $passport_exp != '' && $dob != '') {
			$sql = "insert into `customer` (`email`, `name`, `password`, `building_number`, `street`, `city`, `state`, `phone_number`, `passport_number`, `passport_expiration`, `passport_country`, `date_of_birth`) VALUES ('$email', '$name', '$password', '$building_num', '$street', '$city', '$state', '$phone', '$passport_num', '$passport_exp', '$passport_cntry', '$dob')";
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

	<p><span class="error">* <?php echo $nameEr;?></span>

	Name: <input type="text" name="name"> 
	<br><br>

	<p><span class="error">* <?php echo $building_numEr;?></span>

	Building Number: <input type="text" name="building_num"> 
	<br><br>

	<p><span class="error">* <?php echo $streetEr;?></span>

	Street: <input type="text" name="street"> 
	<br><br>

	<p><span class="error">* <?php echo $cityEr;?></span>

	City: <input type="text" name="city"> 
	<br><br>

	<p><span class="error">* <?php echo $stateEr;?></span>

	State: <input type="text" name="state"> 
	<br><br>

	<p><span class="error">* <?php echo $phoneEr;?></span>

	Phone Number: <input type="tel" name="phone"> 
	<br><br>

	<p><span class="error">* <?php echo $passport_numEr;?></span>

	Passport Number: <input type="text" name="passport_num"> 
	<br><br>

	<p><span class="error">* <?php echo $passport_cntryEr;?></span>

	Passport Country: <input type="text" name="passport_cntry"> 
	<br><br>

	<p><span class="error">* <?php echo $passport_expEr;?></span>

	Passport Expiration: <input type="date" name="passport_exp"> 
	<br><br>

	<p><span class="error">* <?php echo $dobEr;?></span>

	Date of Birth: <input type="date" name="dob"> 
	<br><br>

	<input type="submit">
</form>