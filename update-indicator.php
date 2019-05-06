<?php

### code starts here ###
require_once 'core/init.php';
include 'guards/authenticated.php';
include 'guards/admin.php';


// Define variables and initialize with empty values
$name =  "";
$id = "";
$indicator_name_err =  "";
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    
     // Validate name
     $input_indicator = trim($_POST["name"]);
     if(empty($input_indicator)){
         $indicator_name_err = "Please enter a name.";
     } elseif(!filter_var($input_indicator, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
         $indicator_name_err = "Please enter a valid name.";
     } else{
         $name = $input_indicator;		
     }

     // Check input errors before inserting in database
    if(empty($indicator_name_err)){
        $indicator = new Indicator();

        #update indicator
        if($indicator->update(array("name" => $name),$id)){
            Redirect::to("view-indicators.php");
        }else{
            echo "Something went wrong. Please try again later.";
        }
    }

}else{
    
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        //get indicator
        $indicator = new Indicator();
        // die("there");
        if($indicator->find($id)){
            // die("there");
            $name = $indicator->data()->name;
            

        }else{
            // die("there");
            echo "Oops! Something went wrong. Please try again later.";
        }
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}


### code ends here ###
 
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
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $indicator_name_err;?></span>
                        </div>
                        
                      
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="view-indicators.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>