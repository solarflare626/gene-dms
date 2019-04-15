<?php
// Include config file
require_once "db.php";

### code starts here ###
require_once 'core/init.php';
include 'guards/authenticated.php';
include 'guards/admin.php';

 // Define variables and initialize with empty values
$name =  "";
$indicator_name_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $indicator = new Indicator();
    // Validate name
    $input_indicator = trim($_POST["name"]);
    if(empty($input_indicator)){
        $indicator_name_err = "Please enter indicator.";
    } elseif(!filter_var($input_indicator, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $indicator_name_err = "Please enter a valid indicator.";
    } else{
       $name = $input_indicator;
    }
    
    
    // Check input errors before inserting in database
    if(empty($indicator_name_err)){
        if($indicator->create(array( 'name' => $name ))){
            Redirect::to("add-indicator.php");
        }else{
            echo "Something went wrong. Please try again later.";
        }
        // Prepare an insert statement
        $sql = "INSERT INTO indicator (indicator_name) VALUES ('$indicator_name')";
         
       
         
    }
    
}
### code ends here ###
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
                    <form action="" method="post">
                        <div class="form-group <?php echo (!empty($indicator_name_err)) ? 'has-error' : ''; ?>">
                            <label>Indicator Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
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