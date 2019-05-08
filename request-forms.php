<?php
 require_once 'core/init.php';
 include 'guards/authenticated.php';
 include 'guards/entity.php';

 $user = new User();
 $requests = (new Request)->fetchAll("where user_id = ". $user->data()->id);

 $request_forms = [];

 foreach ($requests as $index => $request) {
     $rfs = $request->requestForms();
     $request_forms  = array_merge($request_forms,$rfs);
     
 }


 $active_nav = "request-forms";
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
	<link rel='stylesheet' href='https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css'>

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
   <!--  Paper Dashboard core CSS    -->
   <link href="assets/css/paper-dashboard.css" rel="stylesheet"/>
	<style type="text/css">
	table tr td:last-child a{
		margin-right: 15px;
	}

    .unread{
        background-color: #f1f1f1 !important;
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

    <?php include 'includes/entity-sidebar.php' ?>

<div class="main-panel">
        <nav class="navbar navbar-default">
                <div class="navbar-header">
                   <a class="navbar-brand" href="">View Requests</a>
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
            
        </nav>
		

		<div class="content">  				
					<div class="card">
						<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Request Details</h2>
                    </div>
                    <?php
                        if (count($request_forms) > 0) {
                            echo "<table id='request-forms-table' class='table  table-striped'>";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>ID</th>";
                            echo "<th>Request ID</th>";
                            echo "<th>Name</th>";
                            echo "<th>Indicator</th>";
                            echo "<th>Action</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            foreach ($request_forms as $index => $value) {
                                $row = $value->data();
                                $form = $value->form();
                                $indicator = $form->indicator();
                                echo '<tr  class="'. ($row->is_submitted == 0 ? "unread" :"" ).  '">';
                                echo "<td>" . $row->id . "</td>";
                                echo "<td>" . $row->request_id . "</td>";
                                echo "<td>" . $form->data()->name . "</td>";
                                echo "<td>" . $indicator->data()->name . "</td>";
                                echo "<td>";
                                
                                if($row->is_submitted == 0 ){
                                    echo "<a class='btn btn-primary' href='request-form.php?id=". $row->id ."' title='Fill Up Request Form' data-toggle='tooltip'>Fill Up</a>";
                                }else{
                                    echo "<a class='btn btn-primary' href='request-form.php?id=". $row->id ."' title='Update Request Form' data-toggle='tooltip'>Update</a>";
                                
                                }
                                echo "<a class='btn btn-primary' href='export-form.php?id=". $row->id ."' title='Download Request Form to Excel' data-toggle='tooltip'>Download</a>";
                                
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
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>

    <script>
        $(document).ready(function(){
            $('#request-forms-table').DataTable();

        });
    </script>
</html>
