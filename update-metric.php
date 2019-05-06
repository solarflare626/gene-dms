<?php

// Define variables and initialize with empty values
$metric_name =  "";
$metric_id = "";
$metric_name_err =  "";
 
// Processing form data when form is submitted
if(isset($_POST["metric_id"]) && !empty($_POST["metric_id"])){
    // Get hidden input value
    $metric_id = $_POST["metric_id"];
	$metric_name = $_POST["metric_name"];
    
    // Validate name
    $input_metric = trim($_POST["metric_name"]);
    if(empty($input_metric)){
        $metric_name_err = "Please enter a name.";
    } elseif(!filter_var($input_metric, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $metric_name_err = "Please enter a valid name.";
    } else{
        $metric_name = $input_metric;		
    }
    
    
   
    
    // Check input errors before inserting in database
    if(empty($metric_name_err)){
        // Prepare an update statement
        $sql = "UPDATE metric SET metric_name= ? WHERE metric_id= ?";
         
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_name, $param_id);
            
            // Set parameters
            $param_name = $metric_name;
            $param_id = $metric_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: metrics.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($con);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["metric_id"]) && !empty(trim($_GET["metric_id"]))){
        // Get URL parameter
        $metric_id =  trim($_GET["metric_id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM metric WHERE metric_id = ?";
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
              mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $metric_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $metric_name = $row["metric_name"];
                    
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($con);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
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
                        <h2>Update Metric</h2>
                    </div>
                    <p>Please edit the input metric and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($metric_name_err)) ? 'has-error' : ''; ?>">
                            <label>Metric</label>
                            <input type="text" name="metric_name" class="form-control" value="<?php echo $metric_name; ?>">
                            <span class="help-block"><?php echo $metric_name_err;?></span>
                        </div>
                        
                      
                        <input type="hidden" name="metric_id" value="<?php echo $metric_id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="metrics.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>