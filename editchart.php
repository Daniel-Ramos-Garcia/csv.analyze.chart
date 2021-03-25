<?php
	ob_start();
	session_start();

	if(isset($_SESSION["username"]) && $_SESSION["user_status"]!='0') {

	
?>
<!DOCTYPE html>

<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>CSV report system</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css">
<link href="./assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="./assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
<link href="./assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="./assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
<link href="./assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="./assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="./assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="./assets/global/plugins/bootstrap-datepicker/css/datepicker.css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="./assets/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="./assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="./assets/admin/layout4/css/layout.css" rel="stylesheet" type="text/css"/>
<link id="style_color" href="./assets/admin/layout4/css/themes/light.css" rel="stylesheet" type="text/css"/>
<link href="./assets/admin/layout4/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
<script type="text/javascript" src="js/Chart.min.js"></script>
<script src="./assets/global/plugins/jquery.min.js" type="text/javascript"></script>
</head>
<!-- END HEAD -->

<body class="page-header-fixed page-sidebar-closed-hide-logo ">
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
			<a href="">
			<img src="./assets/icon/logo.jpg" alt="logo" class="logo-default" style="height:23px;"/>
			</a>
			<div class="menu-toggler sidebar-toggler">
				<!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
			</div>
		</div>
		<!-- END LOGO -->

		<!-- BEGIN PAGE ACTIONS -->


	</div>
	<!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar-wrapper">
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
				<li class="start ">
					<a href="">
					<i class="icon-home"></i>
					<span class="title">Dashboard</span>
					</a>
				</li>
				<li class="">
					<a href="index.php">
					<i class="icon-settings"></i>
					<span class="title">Import CSV</span>
					</a>
				</li>
				<li class="">
					<a href="show_data.php">
					<i class="fa fa-database"></i>
					<span class="title">Display Daten</span>
					</a>
				</li>
				<li class="">
					<a href="chart.php">
					<i class="fa fa-area-chart"></i>
					<span class="title">Auswertung</span>
					</a>
				</li>	
                <li class="active">
					<a href="editchart.php">
					<i class="fa fa-line-chart"></i>
					<span class="title">Edit Chart</span>
					</a>
				</li>
				<li class="">
					<a href="delete_table.php">
					<i class="fa fa-times"></i>
					<span class="title">Delete Daten</span>
					</a>
				</li>
				<?php
					if($_SESSION["user_status"]=='1'){
				?>
				<li class="">
					<a href="usermanage.php">
					<i class="fa fa-users"></i>
					<span class="title">User Management</span>
					</a>
				</li>
				<?php
					}
				?>
				<li class="">
					<a href="logout.php">
					<i class="fa fa-sign-out"></i>
					<span class="title">Logout</span>
					</a>
				</li>	
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
	<!-- END SIDEBAR -->
	
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
                    <?php require_once 'dbconnection.php';?>
					<!-- Begin: life time stats -->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">Auswertung</span>
								<span class="caption-helper">Auswertung Daten</span>
							</div>

						</div>
						<div class="portlet-body">
							<div class="container">
                                <div class="row form-group">
                                    <div class="col-md-12">
                                    <div class="col-md-2 col-sm-6">
                                        <span class="help-block">
											Name of plant </span>
                                        <select class="form-control select2me" data-placeholder="Select..." id="plantname"  onchange='changeName(this)'>
                                            <option value=""></option>
                                            <?php
                                                $sql = "SELECT DISTINCT `field2` AS plantname FROM `tablestructure`";
                                                $result = $conn->query($sql);

                                                if ($result->num_rows > 0) {
                                                    // output data of each row
                                                    while($row = $result->fetch_assoc()) {
                                                        echo "<option value='".$row["plantname"]."'>".$row["plantname"]."</option>";
                                                    }
                                                }
                                            ?>
                                            
                                        </select>
                                    </div>
									<div class="col-md-2 col-sm-6">
                                        <span class="help-block">
											Date </span>
											<select class="form-control select2me" data-placeholder="Select..." id="selecttabledate" onchange='changeDate(this)'>
										</select>	
                                        <!-- <input type="date" class="form-control" id="csvdate" name="csvdate"/> -->
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <span class="help-block">
											Y axis </span>
                                        <select class="form-control select2me" data-placeholder="Select..." id="yaxis" multiple>
                                            
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <span class="help-block">
											Y axis 2</span>
                                        <select class="form-control select2me" data-placeholder="Select..." id="yaxis2" multiple>
                                            
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <span class="help-block">
											X Axis From </span>
                                        <input type="time" class="form-control" id="xaxisfrom" name="xaxisfrom"/>
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <span class="help-block">
											X Axis To </span>
                                        <input type="time" class="form-control" id="xaxisto" name="xaxisto"/>
                                    </div>
									</div>
                                </div>
                                <div class="row form-group">
                                    <button type="submit" class="col-md-1 btn green" onclick="dataShow()">View</button>

                                </div>
                            </div>
							<div class="" id="tempchart">
											
							</div>
							<div class="" id="perchart">
											
							</div>
							<!-- <canvas id="canvas"></canvas> -->

						</div>
					</div>
					<!-- End: life time stats -->
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="page-footer-inner">
		 2021 &copy; 
	</div>
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<script type="text/javascript">
	

	function changeName(sel){
		var tableselectdate = $("#selecttabledate");
		tableselectdate.empty();
		$.ajax({ //create an ajax request to display.php
			type: "GET",
			url: "componentAPI/getDateAPI.php",
			data: { plantname: sel.value },  // data to submit
			dataType: "json", //expect html to be returned                
			success: function(data) {
				tableselectdate.append("<option value=''></option>");
				
				for(var i in data){
					tableselectdate.append("<option value='"+data[i]+"'>"+data[i]+"</option>");
				}
			}
		});
	}
	function changeDate(sel){
		var plantname = $("#plantname").val();
		if (plantname ==''){
            alert('You did not select Name of plant, please select');
            return;
        }
		
		var yaxis = $("#yaxis");
		yaxis.empty();
		var yaxis2 = $("#yaxis2");
		yaxis2.empty();
		$.ajax({ //create an ajax request to display.php
			type: "GET",
			url: "componentAPI/getYAxisAPI.php",
			data: { plantname: plantname, plantdate: sel.value },  // data to submit
			dataType: "json", //expect html to be returned                
			success: function(data) {
				console.log(data);
				yaxis.append("<option value=''></option>");
				yaxis2.append("<option value=''></option>");
				for(var i in data){
					yaxis.append("<option value='"+data[i]+"'>"+data[i]+"</option>");
					yaxis2.append("<option value='"+data[i]+"'>"+data[i]+"</option>");
				}
			}
		});
	}

	var config;
	var percent_config;
    function dataShow() {
        var plantname = $("#plantname").val();
		var csvdate = $("#selecttabledate").val();
        var yaxis = $("#yaxis").val();
        var yaxis2 = $("#yaxis2").val();
        var xaxisfrom = $("#xaxisfrom").val();;
        var xaxisto = $("#xaxisto").val();
        console.log(yaxis);
        console.log(yaxis2);
        console.log(xaxisfrom);
        console.log(xaxisto);
        if (plantname ==''){
            alert('You did not select Name of plant, please select');
            return;
        }
		if (csvdate ==''){
            alert('You did not select date, please select date');
            return;
        }
        if (yaxis ==null || yaxis ==''){
            alert('You did not select Y Axis, please select');
            return;
        }
        if (yaxis2 ==null || yaxis2 == ''){
            alert('You did not select Y Axis 2, please select');
            return;
        }
        if (xaxisfrom ==''){
			xaxisfrom = '00:00';
            // alert('You did not select Start Time, please select');
            // return;
        }
        if (xaxisto ==''){
			xaxisto = '23:59';
            // alert('You did not select End Time, please select');
            // return;
        }
        if (yaxis.length>10){
            alert('You have chosen a value more than 10., please select correctly');
            return;
        }
        if (yaxis2.length>10){
            alert('You have chosen a value more than 10., please select correctly');
            return;
        }
        config = {
			type: 'line',
			data: {
				labels: [],
				datasets: []

			},
			options: {
				responsive: true,
				title: {
					display: true,
					text: 'Line Chart 1'
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					x: {
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Month'
						}
					},
					y: {
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Value'
						}
					}
				}
			}
		};
		percent_config = {
			type: 'line',
			data: {
				labels: [],
				datasets: []

			},
			options: {
				responsive: true,
				title: {
					display: true,
					text: 'Line Chart 2'
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					x: {
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Month'
						}
					},
					y: {
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Value'
						}
					}
				}
			}
		};
        var color = ["#0000ff", "#ff0000", "#00d0ff" ,"#072329", "#f44336","#e91e63","#9c27b0","#673ab7","#3f51b5","#2196f3"];
        var color2 = ["#ffd425", "#539b17", "#ffc107","#ff9800","#ff5722","#795548","#9e9e9e","#607d8b","#009688","#4caf50"];
        $.ajax({ //create an ajax request to display.php
            type: "GET",
            url: "chartdata.php",
            data: { plantname: plantname,
					csvdate: csvdate,
                    yaxis: yaxis,
                    yaxis2: yaxis2,
                    xaxisfrom: xaxisfrom,
                    xaxisto: xaxisto  },  // data to submit
            dataType: "json", //expect html to be returned                
            success: function(data) {
                console.log(data);
                
                dbData = data;

            	for (var i in data.x_axis) 
            	{
                    config.data.labels.push(data.x_axis[i]);
                    percent_config.data.labels.push(data.x_axis[i]);

                }
                for(var i in data.tem_value){
                    var elementTemplate1 = {
                        label: data.yaxis_label[i],
                        backgroundColor: color[i],
                        borderColor: color[i],
                        borderWidth: 1,
                        pointRadius:0,
                        data: [],
                        fill: false,
                    };
                    for (var j in data.tem_value[i]) 
                    {
                        elementTemplate1.data.push(data.tem_value[i][j]);

                    }
                    config.data.datasets.push(elementTemplate1);
                }
                for(var i in data.percent_value){
                    var elementTemplate1 = {
                        label: data.yaxis2_label[i],
                        backgroundColor: color2[i],
                        borderColor: color2[i],
                        borderWidth: 1,
                        pointRadius:0,
                        data: [],
                        fill: false,
                    };
                    for (var j in data.percent_value[i]) 
                    {
                        elementTemplate1.data.push(data.percent_value[i][j]);

                    }
                    percent_config.data.datasets.push(elementTemplate1);
                }

				
				showGraph();
            }
        });

    }


	function showGraph() {


		$("#tempchart").html('');
		$("#tempchart").html('<canvas id="graphCanvas"></canvas>');

		var graphTarget = $("#graphCanvas");
		$("#perchart").html('');
		$("#perchart").html('<canvas id="graphCanvas1"></canvas>');

		var graphTarget1 = $("#graphCanvas1");
		console.log(config);
			
		var barGraph = new Chart(graphTarget, config);
		var barGraph1 = new Chart(graphTarget1, percent_config);
	}



	
</script>
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="./assets/global/plugins/respond.min.js"></script>
<script src="./assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->

<script src="./assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="./assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="./assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="./assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="./assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="./assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="./assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="./assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="./assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="./assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="./assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="./assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="./assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="./assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="./assets/admin/layout4/scripts/layout.js" type="text/javascript"></script>
<script src="./assets/admin/layout4/scripts/demo.js" type="text/javascript"></script>
<script src="./assets/global/scripts/datatable.js"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<script>
        jQuery(document).ready(function() {    
           Metronic.init(); // init metronic core components
Layout.init(); // init current layout
Demo.init(); // init demo features

        });
    </script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
<?php
	}
	else if(isset($_SESSION["username"]) && $_SESSION["user_status"]=='0') {
		echo "<script>alert('Your account is pending still. please contact to admin');</script>";
		header('Refresh: 1; URL = login.php');
	}
	else{
		header('Refresh: 1; URL = login.php');
	}
?>