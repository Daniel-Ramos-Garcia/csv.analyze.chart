<?php
    // header('Content-Type: application/json');
	$plantname = $_GET['plantname'];
    $csvdate = $_GET['csvdate'];
    // $plantname = 'Saint Maximin';
    // $csvdate = array("2019-02-05", "2019-02-04");
    require_once 'dbconnection.php';
    $sucessstatue = "false";
    for($i=0; $i<count($csvdate); $i++){
        $tablename = '';
        $sql = "SELECT * FROM `tablestructure` WHERE `field2`='$plantname' AND DATE(`table_date`)='".$csvdate[$i]."'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
                // output data of each row
            while($row = $result->fetch_assoc()) {
                $tablename = $row["tablename"];

            }
        }
        else{
            echo "The data you want to delete is not exist";
            exit();
        }
        $sql = "DELETE FROM `tablestructure` WHERE `tablename`='$tablename'";
        $conn->query($sql);
        $sql = "DELETE FROM `tablefieldcontent` WHERE `tablename`='$tablename'";
        $conn->query($sql);
        $sql = "DROP TABLE $tablename";
        if ($conn->query($sql) === TRUE) {
            $sucessstatue = "true";
            // echo "true";
        } else {
            $sucessstatue = "false";
            // echo "false";
        }
    }
    // mysqli_close($conn);
    if($sucessstatue == "true"){
        echo "Records deleted successfully";
        exit();
    }
    else {
        echo "failed";
        exit();
    }

?>