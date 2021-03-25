<?php
    header('Content-Type: application/json');
	$plantname = $_GET['plantname'];
    $plantdate = $_GET['plantdate'];
    // $plantname = 'Saint Maximin';
    // $plantdate = '2019-02-05';
    // $plantname = 'Chevilly';
    require_once '../dbconnection.php';
    $table_name = "";
    $sql = "SELECT `tablename` FROM `tablestructure` WHERE `field2`='$plantname' AND DATE(`table_date`)='$plantdate'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
            // output data of each row
        while($row = $result->fetch_assoc()) {

            $table_name = $row["tablename"];
        }
    }
    $yaxis_array = array();
    $sql = "SELECT `value` FROM `tablefieldcontent` WHERE `tablename`='$table_name' AND `value`<>'' AND `value`<>'Datum' AND `value`<>'Uhrzeit' ORDER BY `id` ASC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
            // output data of each row
        while($row = $result->fetch_assoc()) {

            array_push($yaxis_array, $row["value"]);
        }
    }
    mysqli_close($conn);
    // var_dump($yaxis_array);
    echo json_encode($yaxis_array);
?>