<?php
// Include config file
require_once "db.php";
 
// Define variables and initialize with empty values
$indicator_name =  "";
$indicator_id = "";
$indicator_name_err =  "";
 
// Processing form data when form is submitted
if(isset($_POST["indicator_id"]) && !empty($_POST["indicator_id"])){
    // Get hidden input value
    $indicator_id = $_POST["indicator_id"];
	$indicator_name = $_POST["indicator_name"];
    
    // Validate name
    $input_indicator = trim($_POST["indicator_name"]);
    if(empty($input_indicator)){
        $indicator_name_err = "Please enter a name.";
    } elseif(!filter_var($input_indicator, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $indicator_name_err = "Please enter a valid name.";
    } else{
        $indicator_name = $input_indicator;		
    }
    
    
   
    
    // Check input errors before inserting in database
    if(empty($indicator_name_err)){
        // Prepare an update statement
        $sql = "UPDATE indicator SET indicator_name= ? WHERE indicator_id= ?";
         
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_name, $param_id);
            
            // Set parameters
            $param_name = $indicator_name;
            $param_id = $indicator_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["indicator_id"]) && !empty(trim($_GET["indicator_id"]))){
        // Get URL parameter
        $indicator_id =  trim($_GET["indicator_id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM indicator WHERE indicator_id = ?";
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
              mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $indicator_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $indicator_name = $row["indicator_name"];
                    
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
                        <h2>Update Indicator</h2>
                    </div>
                    <p>Please edit the input indicator and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($indicator_name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="indicator_name" class="form-control" value="<?php echo $indicator_name; ?>">
                            <span class="help-block"><?php echo $indicator_name_err;?></span>
                        </div>
                        
                      
                        <input type="hidden" name="indicator_id" value="<?php echo $indicator_id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="add-indicator.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>