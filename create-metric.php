<?php
// Include config file
require_once "db.php";
 
// Define variables and initialize with empty values
$metric_name =  "";
$metric_name_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_metric = trim($_POST["metric_name"]);
    if(empty($input_metric)){
        $metric_name_err = "Please enter indicator.";
    } elseif(!filter_var($input_metric, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $metric_name_err = "Please enter a valid indicator.";
    } else{
        $metric_name = $input_metric;
    }
    
    
    // Check input errors before inserting in database
    if(empty($metric_name_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO metric (metric_name) VALUES ('$metric_name')";
         
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, $param_name);
            
            // Set parameters
            $param_name = $metric_name;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
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
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Indicator</title>
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
                        <h2>Create Metric</h2>
                    </div>
                    <p>Please fill this form and submit to add metric to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($metric_name_err)) ? 'has-error' : ''; ?>">
                            <label>Metric</label>
                            <input type="text" name="metric_name" class="form-control" value="<?php echo $metric_name; ?>">
                            <span class="help-block"><?php echo $metric_name_err;?></span>
                        </div>
                       
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="metrics.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>