<?php

if(isset($_POST['submit_csv'])) {
    require_once 'dbconnection.php';
								
    $field_array = array('field1','field2','field3','field4','field5','field6','field7','field8','field9','field10',
    'field11','field12','field13','field14','field15','field16','field17','field18','field19','field20',
    'field21','field22','field23','field24','field25','field26','field27','field28','field29','field30',
    'field31','field32','field33','field34','field35','field36','field37','field38','field39','field40',
    'field41','field42','field43','field44','field45','field46','field47','field48','field49','field50');
    // collect value of input field
    if (empty($_FILES["fileToUpload"]["name"][0])) {
        echo "<font color='red'>Sorry, csv field is empty</font>";
        exit();
    }
    $sucesscount = 0;
    $succsssfiles = array();
    for($p=0; $p<count($_FILES["fileToUpload"]["name"]); $p++){
        $csvfilename = basename($_FILES["fileToUpload"]["name"][$p]);
        // $csvFileType = strtolower(pathinfo($csvfilename,PATHINFO_EXTENSION));
        
        // if ($csvFileType != "csv") {
        //     echo "<font color='red'>Sorry, only csv file is allowed.</font>";
        //     exit();;
        // }
        $csvfile = $_FILES["fileToUpload"]["tmp_name"][$p];
        // echo $csvfilename;
    
        $realcsvfilename = explode(".", $csvfilename)[0];
        // echo $tablename;
        
        
        $colum_count = 0;
        $c = 0;
        $handle = fopen($_FILES["fileToUpload"]["tmp_name"][$p], "r");
        $plantname = '';
        $table_date = '';
        $table_header = array();
        while (($data = fgetcsv($handle)) !== FALSE) {
            if($c == 1){
                $plantname = utf8_encode($data[0]);
                // echo $field2;
            }
            else if($c == 3){
                $table_date = utf8_encode($data[0]);
                // echo $table_date;
            }
            else if ($c == 4){
                $value_row = utf8_encode($data[0]);
                $colums = explode(";", $value_row);
                $colum_count = count($colums);
                $table_header = $colums;
    
            }
    
            $c++;
    
        }
        fclose($handle);
        $sql = "SELECT * FROM `tablestructure` WHERE `field2`='$plantname' AND `table_date`='$table_date'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $sucesscount ++;
            // echo "<font color='red'>Sorry, this csv file saved already.</font>";
            // exit();
        }
        else {
            array_push($succsssfiles, $realcsvfilename);
            $tablename = date("Ymdhisa");
            $create_sql = "CREATE TABLE $tablename (
                    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY";
            for ($i=0; $i < $colum_count; $i++) {
                $create_sql = $create_sql . ',' . $field_array[$i] . ' VARCHAR(30) NOT NULL';
        
            }
            $create_sql =  $create_sql . ')';
            $conn->query($create_sql);
            // if ($conn->query($create_sql) === TRUE) {
            //     // echo "Table MyGuests created successfully";
            // } else {
            //     // echo "Error creating table: " . $conn->error;
            //     // exit();
            // }
            
            $field1 = $field2 = $field3 = $table_date = "";
        
            $c = 0;
            $handle = fopen($_FILES["fileToUpload"]["tmp_name"][$p], "r");
            while (($data = fgetcsv($handle)) !== FALSE) {
                if($c == 0){
                    $field1 = utf8_encode($data[0]);
                    // echo $field1;
                }
                else if($c == 1){
                    $field2 = utf8_encode($data[0]);
                    // echo $field2;
                }
                else if($c == 2){
                    $field3 = utf8_encode($data[0]);
                    // echo $field3;
                }
                else if($c == 3){
                    $table_date = utf8_encode($data[0]);
                    // echo $table_date;
                }
                else if ($c > 3){
                    
                    $value_row = utf8_encode($data[0]);
                    // echo "<br>" . $data[0] . "<br>";
                    $colums = explode(";", $value_row);
                    // echo count($colums) . "<br>";
                    // // if($c == 5){
                    // 	var_dump($colums);
                    // // }
                    $statue = 0;
                    if($c == 6) {
                        for($m=0; $m < $colum_count; $m++){
                            $insert_sql1 = "INSERT INTO `tablefieldcontent`(`fieldname`, `value`, `tablename`, `value_unit`) VALUES ('" . $field_array[$m] . "','" . $table_header[$m] . "','$tablename','".$colums[$m]."')";
                            $conn->query($insert_sql1);
                        }
                        // $insert_sql1 = "INSERT INTO `tablefieldcontent`(`fieldname`, `value`, `tablename`) VALUES ('','','')";
                    }	
                    $insert_sql = "INSERT INTO " . $tablename . '(';
                    for ($i=0; $i < $colum_count; $i++) {
                        
                        if($i == ($colum_count - 1)){
                            $insert_sql = $insert_sql . $field_array[$i] . ') VALUES (';
                        }
                        else {
                            $insert_sql = $insert_sql . $field_array[$i] . ',';
                        }
                    }
                    $count_temp = count($colums);
                    if($colum_count == $count_temp){
                        $statue = 1;
                        for($j=0; $j < $colum_count; $j++){
                        
                            if($j == ($colum_count-1)){
                                $insert_sql = $insert_sql . "'" . $colums[$j] . "')";
                            }
                            else{
                                $insert_sql = $insert_sql . "'" . $colums[$j] . "',";
                            }
                        }
                    }
                    else if($colum_count > $count_temp){
                        $statue = 2;
                        for($j=0; $j < $colum_count; $j++){
                        
                            if($j < $count_temp){
                                $insert_sql = $insert_sql . "'" . $colums[$j] . "',";
                            }
                            else if($j == ($colum_count-1)){
                                $insert_sql = $insert_sql . "'')";
                            }
                            else if($j < ($colum_count-1)){
                                $insert_sql = $insert_sql . "'',";
                            }
                        }
                    }
                    else if($colum_count < $count_temp){
                        $statue = 3;
                        for($j=0; $j < $colum_count; $j++){
                        
                            if($j == ($colum_count-1)){
                                $insert_sql = $insert_sql . "'" . $colums[$j] . "')";
                            }
                            else{
                                $insert_sql = $insert_sql . "'" . $colums[$j] . "',";
                            }
                        }
                    }
                    if(!($result2 = $conn->query($insert_sql))) {
                        print($statue.' '.$colum_count.'    '. $count_temp . " Invalid query: " . mysqli_error()."\n");
                        print("SQL: $insert_sql\n");
                        die();
                    }
        
                }
                
                $c++;
        
            }
            $sql = "INSERT INTO `tablestructure`(`field1`, `field2`, `field3`, `table_date`, `tablename`) 
            VALUES ('$field1','$field2','$field3','$table_date','$tablename')";
            if ($conn->query($sql) !== TRUE) {
                echo "Error: " . $sql . "<br>" . $conn->error;
                exit();
            }
            fclose($handle);
        }

        
        
    }
    if(count($succsssfiles) > 0){
        $successfullmessage = "<font color='green'>";
        for($j=0; $j<count($succsssfiles); $j++){
            $successfullmessage = $successfullmessage . $succsssfiles[$j] . ', ';
        }
        $successfullmessage = $successfullmessage  . "Successfully.</font>";
        // $conn->close();
        echo $successfullmessage;
        exit();
    }
    else{
        echo "<font color='red'>Sorry, csv files you choose saved already.</font>";
        $conn->close();
        exit();
    }
    
}
?>