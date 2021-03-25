<?php
	$plantname = $_GET['plantname'];
    $csvdate = $_GET['csvdate'];
    require_once 'dbconnection.php';

    $tablename = '';
    $sql = "SELECT * FROM `tablestructure` WHERE `field2`='$plantname' AND DATE(`table_date`)='$csvdate'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
            // output data of each row
        while($row = $result->fetch_assoc()) {
            $tablename = $row["tablename"];
            $div = "<div>".$row["field1"]."</div>
                <div>".$row["field2"]."</div>
                <div>".$row["field3"]."</div>
                <div>".$row["table_date"]."</div>";
            echo $div;
        }
    }
    // $sql = "SELECT * FROM `tablestructure` WHERE `tablename`='$mydata'";
    // $result = $conn->query($sql);

    // if ($result->num_rows > 0) {
    //     // output data of each row
    //     while($row = $result->fetch_assoc()) {
    //         $div = "<div>".$row["field1"]."</div>
    //             <div>".$row["field2"]."</div>
    //             <div>".$row["field3"]."</div>
    //             <div>".$row["table_date"]."</div>";
    //         echo $div;
    //     }
    // }

    $sql = "SELECT * FROM $tablename LIMIT 1000";
    $result = $conn->query($sql);
    $rows = 1;
    $table = "<div class='table-scrollable'><table class='table table-striped table-bordered table-hover a' id='sample_2'>";
    $thead = "<thead>";
    $tbody = "<tbody>";
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $tr = "";
            if($rows<4){
                $thead = $thead."<tr><th>".$row["field1"]."</th>
                    <th>".$row["field2"]."</th>
                    <th>".$row["field3"]."</th>
                    <th>".$row["field4"]."</th>
                    <th>".$row["field5"]."</th>
                    <th>".$row["field6"]."</th>
                    <th>".$row["field7"]."</th>
                    <th>".$row["field8"]."</th>
                    <th>".$row["field9"]."</th>
                    <th>".$row["field10"]."</th>
                    <th>".$row["field11"]."</th>
                    <th>".$row["field12"]."</th>
                    <th>".$row["field13"]."</th>
                    </tr>";
            }
            else {
                $tbody = $tbody . "<tr class='odd gradeX'><td>".$row["field1"]."</td>
                    <td>".$row["field2"]."</td>
                    <td>".$row["field3"]."</td>
                    <td>".$row["field4"]."</td>
                    <td>".$row["field5"]."</td>
                    <td>".$row["field6"]."</td>
                    <td>".$row["field7"]."</td>
                    <td>".$row["field8"]."</td>
                    <td>".$row["field9"]."</td>
                    <td>".$row["field10"]."</td>
                    <td>".$row["field11"]."</td>
                    <td>".$row["field12"]."</td>
                    <td>".$row["field13"]."</td>
                    </tr>";
            }
             // $table = $table . $tr;
            $rows++;
        }
    }
    $thead = $thead . "</thead>";
    $tbody = $tbody . "</tbody>";
    $table = $table . $thead . $tbody . "</table></div>"; 
    // $table = $table . "</table></div>";
    // echo $table;
    echo $table;

    $pagination = '<div class="row"><div class="col-md-5 col-sm-12"><div class="dataTables_info" id="sample_1_info" role="status" aria-live="polite">Showing 1 to 5 of 25 entries</div></div><div class="col-md-7 col-sm-12"><div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate"><ul class="pagination" style="visibility: visible;"><li class="prev disabled"><a href="#" title="First"><i class="fa fa-angle-double-left"></i></a></li><li class="prev disabled"><a href="#" title="Prev"><i class="fa fa-angle-left"></i></a></li><li class="active"><a href="#">1</a></li><li><a href="#">2</a></li><li><a href="#">3</a></li><li><a href="#">4</a></li><li><a href="#">5</a></li><li class="next"><a href="#" title="Next"><i class="fa fa-angle-right"></i></a></li><li class="next"><a href="#" title="Last"><i class="fa fa-angle-double-right"></i></a></li></ul></div></div></div>';
    echo $pagination;
?>