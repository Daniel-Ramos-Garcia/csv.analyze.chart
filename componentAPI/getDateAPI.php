<?php
    header('Content-Type: application/json');
	$plantname = $_GET['plantname'];
    // $plantname = 'Chevilly';
    require_once '../dbconnection.php';
    $sql = "SELECT DISTINCT DATE(`table_date`) AS table_date FROM `tablestructure` WHERE `field2`='$plantname' ORDER BY `table_date` DESC";
    $table_date_array = array();
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
            // output data of each row
        while($row = $result->fetch_assoc()) {

            array_push($table_date_array, $row["table_date"]);
        }
    }
    mysqli_close($conn);
    echo json_encode($table_date_array);
?>