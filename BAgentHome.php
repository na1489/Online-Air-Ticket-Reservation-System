<?php
include "BAgentLinks.php";
include "db.php";

session_start();
$username = $_SESSION["BAusername"];
$sql = "select booking_agent_id from booking_agent where email = '$username'";
$result = mysqli_query($conn,$sql);
$tuple = mysqli_fetch_assoc($result);
$theName = $tuple["booking_agent_id"];

echo "<h1> Welcome Booking Agent $theName! </h2>";

$conn->close();
?>