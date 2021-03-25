<?php
header('Content-Type: application/json');

require_once 'dbconnection.php';
$plantname = $_GET['plantname'];
$csvdate = $_GET['csvdate'];

$tablename = '';
$sql = "SELECT * FROM `tablestructure` WHERE `field2`='$plantname' AND DATE(`table_date`)='$csvdate'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
		// output data of each row
	while($row = $result->fetch_assoc()) {
		$tablename = $row["tablename"];

	}
}
$sql = "SELECT * FROM $tablename LIMIT 25000 OFFSET 3";
$result = $conn->query($sql);
$rows = 1;
$x_axis = array();
$Brenner = array();
$Sammel = array();
$Sekundarluft = array();
$Kuhlluft = array();
if ($result->num_rows > 0) {
        // output data of each row
    while($row = $result->fetch_assoc()) {
    	array_push($x_axis, $row["field2"]);
    	array_push($Brenner, $row["field3"]);
    	array_push($Sammel, $row["field4"]);
    	array_push($Sekundarluft, $row["field7"]);
    	array_push($Kuhlluft, $row["field8"]);
    }
}
mysqli_close($conn);
$myresponse = array('x_axis' => $x_axis, 'Brenner' => $Brenner, 'Sammel' => $Sammel , 'Sekundarluft' => $Sekundarluft, 'Kuhlluft' => $Kuhlluft );
echo json_encode($myresponse);
?>