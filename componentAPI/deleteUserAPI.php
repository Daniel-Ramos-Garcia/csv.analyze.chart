<?php
    $userid = $_GET['userid'];
 
    require_once '../dbconnection.php';
    $sql = "DELETE FROM `usertable` WHERE `id`=$userid";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    $conn->close();
?>