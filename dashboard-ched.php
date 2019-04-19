<?php

include 'server.php';
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
    <div class="sidebar" data-background-color="white" data-active-color="danger">

    <!--
		Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
		Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
	-->

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="dashboard-ched.php" class="simple-text">
                    Open Data-Iligan
                </a>
            </div>

            <ul class="nav">
                <li class="active">
                    <a href="dashboard-ched.php">
                        <i class="ti-pencil"></i>
                        <p>Input Data</p>
                    </a>
                </li>
                <li>
                    <a href="user-ched.php">
                        <i class="ti-user"></i>
                        <p>User Profile</p>
                    </a>
                </li>
          		
            </ul>
    	</div>
    </div>

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
                    <a class="navbar-brand" href="#">Input Data</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">

						<li>
                            <a href="index.php">
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

                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
							
<h4 class="title" style="float: right">Needed Data</h4>
 
                                
                            </div>
                            <div class="content">
					<form action="submit.php" method="post">	
					<table class="table table-striped">
								<thead>
                                        <th>Metric/s</th>
                                    	<th></th>	
                                    </thead>
									
									<tbody>
									
                                        <tr>
                                        	<td>Number of all college graduates in the field of ICT</td>
                                        	<td><input type="text" name="ict" autocomplete="off" class="form-control" style="width: 50%; padding: 1px 7px;margin: 2px 0;box-sizing: border-box;border: 3px solid #ccc;" ></td>
                                        </tr>
										<tr>
                                        	<td>Number of all college graduates in the field of Business</td>
                                        	<td><input type="text" name="business" autocomplete="off" class="form-control" style="width: 50%; padding: 1px 7px;margin: 2px 0;box-sizing: border-box;border: 3px solid #ccc;" ></td>
                                        </tr>
										<tr>
                                        	<td>Number of all college graduates in the field of Engineering</td>
                                        	<td><input type="text" name="engineering" autocomplete="off" class="form-control" style="width: 50%; padding: 1px 7px;margin: 2px 0;box-sizing: border-box;border: 3px solid #ccc;" ></td>
                                        </tr>
										<tr>
                                        	<td>Number of all college graduates in the field of Finance and Accounting</td>
                                        	<td><input type="text" name="accounting" autocomplete="off" class="form-control" style="width: 50%; padding: 1px 7px;margin: 2px 0;box-sizing: border-box;border: 3px solid #ccc;" ></td>
                                        </tr>
										<tr>
                                        	<td>Number of all college graduates in the field of Medicine</td>
                                        	<td><input type="text" name="medicine" autocomplete="off" class="form-control" style="width: 50%; padding: 1px 7px;margin: 2px 0;box-sizing: border-box;border: 3px solid #ccc;" ></td>
                                        </tr>
																				<tr>
                                        	<td>Number of all college graduates in the field of Social Sciences</td>
                                        	<td><input type="text" name="social" autocomplete="off" class="form-control" style="width: 50%; padding: 1px 7px;margin: 2px 0;box-sizing: border-box;border: 3px solid #ccc;" ></td>
                                        </tr>
																				<tr>
                                        	<td>Number of all college graduates in the field of Education</td>
                                        	<td><input type="text" name="educ" autocomplete="off" class="form-control" style="width: 50%; padding: 1px 7px;margin: 2px 0;box-sizing: border-box;border: 3px solid #ccc;" ></td>
                                        </tr>
										</tbody>
										</table>
										<input type="submit" class="btn btn-primary" value="Submit" name="insert" style=>
										</form>
							
							
						<!--	<br>
							<form action="submit.php" method="post" align="left">
                        <div class="form-group" align="left">
							<label>Number of all college graduates in the field of ICT</label>
                            <input type="text" name="ict" class="form-control" style="width: 22%; padding: 1px 7px;margin: 2px 0;box-sizing: border-box;border: 3px solid #ccc;" >
							<br>
							<label>Number of all college graduates in the field of Business</label>
                            <input type="text" name="business" class="form-control" style="width: 22%; padding: 1px 7px;margin: 2px 0;box-sizing: border-box;border: 3px solid #ccc;" >
                            <br>
							<label>Number of all college graduates in the field of Engineering</label>
                            <input type="text" name="engineering" class="form-control" style="width: 22%; padding: 1px 7px;margin: 2px 0;box-sizing: border-box;border: 3px solid #ccc;" >
							<br>
							<label>Number of all college graduates in the field of Finance and Accounting</label>
                            <input type="text" name="accounting" class="form-control" style="width: 22%; padding: 1px 7px;margin: 2px 0;box-sizing: border-box;border: 3px solid #ccc;" >
							<br>
							<label>Number of all college graduates in the field of Medicine</label>
                            <input type="text" name="medicine" class="form-control" style="width: 22%; padding: 1px 7px;margin: 2px 0;box-sizing: border-box;border: 3px solid #ccc;" >
							<br>
							<label>Number of all college graduates in the field of Social Sciences</label>
                            <input type="text" name="social" class="form-control" style="width: 22%; padding: 1px 7px;margin: 2px 0;box-sizing: border-box;border: 3px solid #ccc;" >
							<br>
							<label>Number of all college graduates in the field of Education</label>
                            <input type="text" name="educ" class="form-control" style="width: 22%; padding: 1px 7px;margin: 2px 0;box-sizing: border-box;border: 3px solid #ccc;" >
							<br>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit" name="insert">
                    </form>-->
										
                        </div>
                    </div>
                </div>
            </div>
        </div>


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

<script type="text/javascript">
    	$(document).ready(function(){

        	demo.initChartist();

        	$.notify({
            	icon: 'ti-gift',
            	message: "Welcome to Open Data-Iligan, <b>CHED</b>  - A Data Management System for the Smart City Capability of Iligan City."

            },{
                type: 'success',
                timer: 4000
            });

    	});
	</script>


</html>



