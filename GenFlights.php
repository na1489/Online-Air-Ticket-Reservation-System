<html>
<body>

<?php
include "NormLinks.php";

echo "<h2> Search for upcoming flights:</h2>";

?>

<form method="post" action="CheckFlights.php">
Departure City or Airport: <input type="search" name="DepCoAName"> <br><br>
Arrival City or Airport: <input type="search" name="ArrCoAName"> <br><br>
Departure Date: <input type="date" name="date"> <br><br>
<input type="submit" value="Search">
</form>

<?php

echo "<br><h2> Check flight statuses:</h2>";

?>

<form method="post" action="FlightStatuses.php">
Flight Number: <input type="search" name="fNum"> <br><br>
Departure Date: <input type="date" name="Depdate"> <br><br>
Arrival Date: <input type="date" name="Arrdate"> <br><br>
<input type="submit" value="Search">
</form>

</body>