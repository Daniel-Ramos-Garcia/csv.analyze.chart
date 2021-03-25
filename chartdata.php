<?php
header('Content-Type: application/json');

require_once 'dbconnection.php';
$plantname = $_GET['plantname'];
$csvdate = $_GET['csvdate'];
$yaxis = $_GET['yaxis'];
$yaxis2 = $_GET['yaxis2'];
$xaxisfrom = $_GET['xaxisfrom'];
$xaxisto = $_GET['xaxisto'];
$yaxisfieldname_array = array();
$yaxis2fieldname_array = array();

// $plantname = 'Chevilly';
// $csvdate = '2021-02-24';
// $yaxis = array("Brennertemperatur", "Sammeltemperatur");
// $yaxis2 = array("Sekundärluft", "Kühlluft");
// $xaxisfrom = '14:32';
// $xaxisto = '16:32';
// $yaxisfieldname_array = array();
// $yaxis2fieldname_array = array();
$yaxis_label = array();
$yaxis2_label = array();
$tablename = '';
$sql = "SELECT * FROM `tablestructure` WHERE `field2`='$plantname' AND DATE(`table_date`)='$csvdate'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
        // output data of each row
    while($row = $result->fetch_assoc()) {
        $tablename = $row["tablename"];
    }
}
for($i=0; $i<count($yaxis); $i++){
    $sql = "SELECT `fieldname`,`value`,`value_unit` FROM `tablefieldcontent` WHERE `value`='".$yaxis[$i]."' AND `tablename`='$tablename'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
            // output data of each row
        while($row = $result->fetch_assoc()) {
            $temp = $row["value"] . '[' . $row["value_unit"] . ']';
            array_push($yaxisfieldname_array, $row["fieldname"]);
            array_push($yaxis_label, $temp);
        }
    }
}
for($i=0; $i<count($yaxis2); $i++){
    $sql = "SELECT `fieldname`,`value`,`value_unit` FROM `tablefieldcontent` WHERE `value`='".$yaxis2[$i]."' AND `tablename`='$tablename'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
            // output data of each row
        while($row = $result->fetch_assoc()) {
            $temp = $row["value"] . '[' . $row["value_unit"] . ']';
            array_push($yaxis2fieldname_array, $row["fieldname"]);
            array_push($yaxis2_label, $temp);
        }
    }
}
$sql = "SELECT * FROM $tablename WHERE `field2`>'$xaxisfrom' AND `field2`<'$xaxisto'";

$x_axis = array();
$tem_value = array();
$percent_value = array();
for($i=0; $i<count($yaxisfieldname_array);$i++){
    array_push($tem_value, array());
}
for($j=0; $j<count($yaxis2fieldname_array);$j++){
    array_push($percent_value, array());
}

$result = $conn->query($sql);
if ($result->num_rows > 0) {
        // output data of each row
    while($row = $result->fetch_assoc()) {
    	array_push($x_axis, $row["field2"]);

        for($i=0; $i<count($yaxisfieldname_array);$i++){
            array_push($tem_value[$i], $row["$yaxisfieldname_array[$i]"]);
        }
        for($j=0; $j<count($yaxis2fieldname_array);$j++){
            array_push($percent_value[$j], $row["$yaxis2fieldname_array[$j]"]);
        }

    }
}
mysqli_close($conn);
$myresponse = array('x_axis' => $x_axis, 'tem_value' => $tem_value, 'percent_value' => $percent_value, 'yaxis_label' => $yaxis_label, 'yaxis2_label' => $yaxis2_label );
echo json_encode($myresponse);
?>