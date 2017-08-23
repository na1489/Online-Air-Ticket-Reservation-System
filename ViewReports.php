<?php 
include "db.php";
include "ASLinks.php";
  
include("chartphp/lib/inc/chartphp_dist.php");

session_start();
$username = $_SESSION["ASusername"];
$sql = "select * from airline_staff where username = '$username'";
$result = mysqli_query($conn,$sql);
$tuple = mysqli_fetch_assoc($result);
$theName = $tuple["first_name"];
$theAirline = $tuple["airline_name"];

?>

<br><br>
<form method = "post" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
Date1: <input type="date" name="date1">
Date2: <input type="date" name="date2">
<input type="submit" value="View Report">
</form>

<?php
$sql = "select count(p.ticket_id) as tot from ticket as t, purchases as p where t.ticket_id = p.ticket_id and purchase_date >= date(now()-interval 30 day) and airline_name = '$theAirline'";
$res = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($res);
$tot = $row['tot'];

echo "<h2>Tickets sold last month: $tot </h2>";

$sql1 = "select count(p.ticket_id) as tot from ticket as t, purchases as p where t.ticket_id = p.ticket_id and purchase_date >= date(now()-interval 365 day) and airline_name = '$theAirline'";
$res1 = mysqli_query($conn,$sql1);
$row1 = mysqli_fetch_assoc($res1);
$tot1 = $row1['tot'];

echo "<h2>Tickets sold last year: $tot1 </h2>";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $date1 = $_POST['date1'];
    $date2 = $_POST['date2'];
    if($date1 != '' && $date2 != '') {
        $sql3 = "select count(p.ticket_id) as tot from ticket as t, purchases as p where t.ticket_id = p.ticket_id and purchase_date between '$date1' and '$date2' and airline_name = '$theAirline'";
        $res3 = mysqli_query($conn,$sql3);
        $row3 = mysqli_fetch_assoc($res3);
        $tot3 = $row3['tot'];
        if($tot3 == '') $tot3 = 0;

        echo "<h2>Tickets sold between $date1 and $date2: $tot3 </h2><br>";
    }
}

$query = "select month(p.purchase_date) as Month, count(p.ticket_id) as tot from ticket as t, purchases as p where t.ticket_id = p.ticket_id and airline_name = '$theAirline' group by airline_name, Month";

$p = new chartphp(); 

$result = mysqli_query($conn,$query);
$Arr = array(array());
$i = 0;
while($row = mysqli_fetch_array($result)) {
    if($row[0] == 1) $Arr[$i][0] = "Jan";
    elseif($row[0] == 2) $Arr[$i][0] = "Feb";
    elseif($row[0] == 3) $Arr[$i][0] = "Mar";
    elseif($row[0] == 4) $Arr[$i][0] = "Apr";
    elseif($row[0] == 5) $Arr[$i][0] = "May";
    elseif($row[0] == 6) $Arr[$i][0] = "Jun";
    elseif($row[0] == 7) $Arr[$i][0] = "Jul";
    elseif($row[0] == 8) $Arr[$i][0] = "Aug";
    elseif($row[0] == 9) $Arr[$i][0] = "Sep";
    elseif($row[0] == 10) $Arr[$i][0] = "Oct";
    elseif($row[0] == 11) $Arr[$i][0] = "Nov";
    elseif($row[0] == 12) $Arr[$i][0] = "Dec";
    $Arr[$i][1] = $row[1];
    $i++;
}

$p->data = array($Arr);
$p->chart_type = "bar"; 

// Common Options 
$p->title = "Monthly Ticket Purchases"; 
$p->xlabel = "Months"; 
$p->ylabel = "Tickets Sold"; 
$p->export = false; 
$p->options["legend"]["show"] = true; 
$p->series_label = array('Q1','Q2','Q3');  

$out = $p->render('c1'); 
?> 
<!DOCTYPE html> 
<html> 
    <head> 
        <script src="chartphp/lib/js/jquery.min.js"></script> 
        <script src="chartphp/lib/js/chartphp.js"></script> 
        <link rel="stylesheet" href="chartphp/lib/js/chartphp.css"> 
    </head> 
    <body> 
        <div style="width:40%; min-width:450px;"> 
            <?php echo $out;
			?> 
        </div> 
    </body> 
</html> 
