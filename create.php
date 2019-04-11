<?php
// Include config file
require_once "db.php";
 
// Define variables and initialize with empty values
$indicator_name =  "";
$indicator_name_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_indicator = trim($_POST["indicator_name"]);
    if(empty($input_indicator)){
        $indicator_name_err = "Please enter indicator.";
    } elseif(!filter_var($input_indicator, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $indicator_name_err = "Please enter a valid indicator.";
    } else{
        $indicator_name = $input_indicator;
    }
    
    
    // Check input errors before inserting in database
    if(empty($indicator_name_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO indicator (indicator_name) VALUES ('$indicator_name')";
         
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, $param_name);
            
            // Set parameters
            $param_name = $indicator_name;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: add-indicator.php");
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
                        <h2>Create Indicator</h2>
                    </div>
                    <p>Please fill this form and submit to add indicator to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($indicator_name_err)) ? 'has-error' : ''; ?>">
                            <label>Indicator Name</label>
                            <input type="text" name="indicator_name" class="form-control" value="<?php echo $indicator_name; ?>">
                            <span class="help-block"><?php echo $indicator_name_err;?></span>
                        </div>
                       
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="add-indicator.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>