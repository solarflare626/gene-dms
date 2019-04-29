<?php
 require_once 'core/init.php';
 include 'guards/authenticated.php';
 include 'guards/admin.php';

 $users = (new User)->fetchAll("where id >1");
 $forms = (new Form)->fetchAll();
 $submitted_forms = (new RequestForm)->fetchAll("where is_submitted =1");
 $request_forms = (new RequestForm)->fetchAll();
 $indicators = (new Indicator)->fetchAll();
 $active_nav = "dashboard";

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="images/icon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Open Data-Iligan</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>

    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="assets/css/paper-dashboard.css" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />


    <!--  Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/themify-icons.css" rel="stylesheet">

    
 </head>
<body>

<div class="wrapper">

    <?php include 'includes/admin-sidebar.php' ?>

    <div class="main-panel">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>
                    <a class="navbar-brand" href="#">Home</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
						<li>
                            <a href="logout.php">
								<i class="ti-close"></i>
								<p>Logout</p>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-warning text-center">
                                            <i class="ti-user"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>Total Entity Users</p>
											<?php echo count($users) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-success text-center">
                                            <i class="ti-home"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                        <p>Total </p>
                                        <p>Forms</p>
                                            <?php echo count($forms);?> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-danger text-center">
                                            <i class="ti-money"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                        <p>Total</p><p>Indicators</p>
                                            <?php echo count($indicators);?> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-info text-center">
                                            <i class="ti-cloud"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>Submitted / Request Forms</p>
                                            <?php echo count($submitted_forms);
                                                 echo "/";
                                                 echo count($request_forms);?> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Submitted Forms</h4>
                            </div>
                            <div class="content">
							
 <?php
                        if(count($submitted_forms) > 0){
                            echo "<table id='submitted-forms-table' class='table table-striped'>"; 
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Form ID</th>";
                                        echo "<th>Form Name</th>";
										echo "<th>Indicator</th>";
                                        echo "<th>Entity</th>";
										echo "<th>Date</th>";
										echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                foreach ($submitted_forms as $index => $value) {
                                    $entity = $value->user();
                                    $indicator =  $value->indicator();
                                    $form = $value->form();

                                    echo "<tr>";
                                        echo "<td>" . $form->data()->id . "</td>";
                                        echo "<td>" . $form->data()->name . "</td>";
										echo "<td>" . $indicator->data()->name . "</td>";
                                        echo "<td>" . $entity->data()->name. "</td>";
										echo "<td>" . $value->data()->created_at. "</td>";
                                        echo "<td>";
                                            echo "<a class='btn btn-primary' href='submitted-form.php?id=".$value->data()->id."' title='View Submission' data-toggle='tooltip'> View </a>";
                                           
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                          
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="pull-left title">Users</h4>
                                <a href="add-user.php" class="btn btn-success pull-right">Add New User</a>
                                
                            </div>
                            <br>
                            <br>
                            <div class="content">
							
 <?php
                        if(count($users) > 0){
                            echo "<table  id='users-table'class='table table-striped'>"; 
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>ID</th>";
                                        echo "<th>Name</th>";
										echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                foreach ($users as $index => $value) {
                                    echo "<tr>";
                                        echo "<td>" . $value->data()->id . "</td>";
                                        echo "<td>" . $value->data()->name . "</td>";
                                        echo "<td>";
                                            echo "<a class='btn btn-primary' href='user.php?id=".$value->data()->id."' title='View Submission' data-toggle='tooltip'> View </a>";
                                           
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                          
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Submitted Forms</h4>
                                <p class="category">per user</p>
                            </div>
                            <div class="content">
                                <div id="chartSubmitted" class="ct-chart"></div>
                                <!-- <div class="footer">
                                    <div class="chart-legend">
                                        <i class="fa fa-circle text-info"></i> Open
                                        <i class="fa fa-circle text-danger"></i> Click
                                        <i class="fa fa-circle text-warning"></i> Click Second Time
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        <i class="ti-reload"></i> Updated 3 minutes ago
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Users Behavior</h4>
                                <p class="category">24 Hours performance</p>
                            </div>
                            <div class="content">
                                <div id="chartHours" class="ct-chart"></div>
                                <div class="footer">
                                    <div class="chart-legend">
                                        <i class="fa fa-circle text-info"></i> Open
                                        <i class="fa fa-circle text-danger"></i> Click
                                        <i class="fa fa-circle text-warning"></i> Click Second Time
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        <i class="ti-reload"></i> Updated 3 minutes ago
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				 -->
                <!-- <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Email Statistics</h4>
                                <p class="category">Last Campaign Performance</p>
                            </div>
                            <div class="content">
                                <div id="chartPreferences" class="ct-chart ct-perfect-fourth"></div>

                                <div class="footer">
                                    <div class="chart-legend">
                                        <i class="fa fa-circle text-info"></i> Open
                                        <i class="fa fa-circle text-danger"></i> Bounce
                                        <i class="fa fa-circle text-warning"></i> Unsubscribe
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        <i class="ti-timer"></i> Campaign sent 2 days ago
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card ">
                            <div class="header">
                                <h4 class="title">2015 Sales</h4>
                                <p class="category">All products including Taxes</p>
                            </div>
                            <div class="content">
                                <div id="chartActivity" class="ct-chart"></div>

                                <div class="footer">
                                    <div class="chart-legend">
                                        <i class="fa fa-circle text-info"></i> Tesla Model S
                                        <i class="fa fa-circle text-warning"></i> BMW 5 Series
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        <i class="ti-check"></i> Data information certified
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
            <footer class="footer">
                <div class="container-fluid">
                    <nav class="pull-left">
                        <ul>
                        </ul>
                    </nav>

                </div>
            </footer>
    </div>
</div>
</body>

    <!--   Core JS Files   -->
    <script src="assets/js/jquery.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>

	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="assets/js/bootstrap-checkbox-radio.js"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
	<script src="assets/js/paper-dashboard.js"></script>

	<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
	<script src="assets/js/demo.js"></script>

    <script>
    $(document).ready(function(){
        <?php
            $labels = [];
            $series = [];
            foreach ($users as $key => $value) {
                array_push($labels,$value->data()->name);
                $req_forms = $value->submittedForms();
                array_push($series,count($req_forms));
                
                
            }

            echo "var data = {";
            echo    'labels: '. json_encode($labels).',';
            echo    'series: ['.json_encode($series).']';
            echo "};";

        ?>

        new Chartist.Bar('#chartSubmitted', data);

    });
    </script>
    <script>
    $(document).ready(function(){
        $('#users-table').DataTable();
        $('#submitted-forms-table').DataTable();

    });
    </script>

	<script type="text/javascript">
    	$(document).ready(function(){

        	demo.initChartist();

        	$.notify({
            	icon: 'ti-gift',
            	message: "Welcome to <b>Open Data-Iligan</b> - A Data Management System for the Smart City Capability of Iligan City."

            },{
                type: 'success',
                timer: 4000
            });

    	});
	</script>

</html>
