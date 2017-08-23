<html>
<body>

<?php
include "CustLinks.php";
include "db.php";

session_start();
$username = $_SESSION["Cusername"];
$sql = "select name from customer where email = '$username'";
$result = mysqli_query($conn,$sql);
$tuple = mysqli_fetch_assoc($result);
$theName = $tuple["name"];

echo "<h1> Welcome $theName! </h2>";

$conn->close();
?>

</body>
</html>