<?php
	$userstatus = $_GET['userstatus'];
    $userid = $_GET['userid'];
    require_once 'dbconnection.php';
    $updated_at = date("Y-m-d h:i:sa");
    $sql = "UPDATE `usertable` SET `user_status`='$userstatus',`updated_at`='$updated_at' WHERE `id`='$userid'";
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
        exit();
    }
?>