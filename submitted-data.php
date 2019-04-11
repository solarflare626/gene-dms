<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submitted Data</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 750px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
					<button onclick="myFunction()" style="float: right;">Print this page</button>
                        <h1>Submission Details</h1>
                    </div>
                    <div class="alert alert-success fade in">
                        <?php
                    // Include db file
                    require_once "db.php";
					$sql = "SELECT * FROM answer";
                    if($result = mysqli_query($con, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>ICT</th>";
                                        echo "<th>Business</th>";
										echo "<th>Engineering</th>";
										echo "<th>Accounting</th>";
										echo "<th>Medicine</th>";
										echo "<th>Social Sciences</th>";
										echo "<th>Education</th>";
										
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['ict'] . "</td>";
                                        echo "<td>" . $row['business'] . "</td>";
										echo "<td>" . $row['engineering'] . "</td>";
										echo "<td>" . $row['accounting'] . "</td>";
										echo "<td>" . $row['medicine'] . "</td>";
										echo "<td>" . $row['social'] . "</td>";
										echo "<td>" . $row['educ'] . "</td>";
                                        
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                          
							// Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
                    }
 
                    // Close connection
                    mysqli_close($con);
                    ?>
                    </div>
                </div>
            </div>        
        </div>
    </div>
	
	<script>
function myFunction() {
    window.print();
}
</script>

</body>
</html>
















