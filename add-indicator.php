<?php
 require_once 'core/init.php';
 include 'guards/authenticated.php';
 include 'guards/admin.php';

 $indicators = (new Indicator)->fetchAll();
 $active_nav = "indicator";
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

	<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://dixso.github.io/custombox/dist/custombox.min.css'>
	
	
	<!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="assets/css/paper-dashboard.css" rel="stylesheet"/>

    <!--  Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/themify-icons.css" rel="stylesheet">
	
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
  
	<style type="text/css">
	table tr td:last-child a{
		margin-right: 15px;
	}
	</style>
	
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>	


	
</head>


<body>

<div class="wrapper">

    <?php include 'includes/admin-sidebar.php' ?>

<div class="main-panel">
        <nav class="navbar navbar-default">
                <div class="navbar-header">
                   <a class="navbar-brand" href="#">Add Indicator</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">

						<li>
                            <a href="#">
								<i class="ti-close"></i>
								<p>Logout</p>
                            </a>
                        </li>
                    </ul>

                </div>
            
        </nav>
		

		<div class="content">  				
					<div class="card">
						<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Indicator Details</h2>
                        <a href="create-indicator.php" class="btn btn-success pull-right">Add New Indicator</a>
                    </div>
                    <?php
                        if (count($indicators) > 0) {
                            echo "<table class='table table-bordered table-striped'>";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>ID</th>";
                            echo "<th>Indicator Name</th>";
                            echo "<th>Action</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            foreach ($indicators as $index => $value) {
                                $row = $value->data();
                                echo "<tr>";
                                echo "<td>" . $row->id . "</td>";
                                echo "<td>" . $row->name . "</td>";
                                echo "<td>";
                                echo "<a href='update-indicator.php?id=". $row->id ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                echo "<a href='delete-indicator.php?id=". $row->id ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                        } else {
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                        
                    ?>
                </div>
            </div>        
        </div>
    </div>
                           
                        </div>
						
		</div>
			
		

    </div>

	<footer class="footer">
        </footer>

    
	</div>
	


</body>

    <!--   Core JS Files   -->
    <script src="assets/js/jquery.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

</html>
