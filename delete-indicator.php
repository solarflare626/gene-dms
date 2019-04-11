<?php
### code starts here ###
require_once 'core/init.php';
include 'guards/authenticated.php';
include 'guards/admin.php';

$id;

#Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"])){
    
    
   
    $id = trim($_POST["id"]);
    //get indicator
    
    
    $indicator = new Indicator();
    // die("here");
    if($indicator->find($id)){
        
        if($indicator->delete(array('id', '=', $id))){
            Redirect::to("add-indicator.php");
            die("here");
        }else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }else{
        die("there");
        echo "Oops! Something went wrong. Please try again later.";
    }
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
        // URL doesn't contain id parameter. Redirect to error page
        Redirect::to("error.php");
    }else{
        $id = trim($_GET["id"]);
    }
}

### code ends here ###
#Process delete operation after confirmation
// if(isset($_POST["indicator_id"]) && !empty($_POST["indicator_id"])){
    
//     require_once "db.php";
    
// 	$indicator_id = $_POST["indicator_id"];
//     // Prepare a delete statement
//     $sql = "DELETE FROM indicator WHERE indicator_id = $indicator_id";
    
//     if($stmt = mysqli_prepare($con, $sql)){
//         // Bind variables to the prepared statement as parameters
//         mysqli_stmt_bind_param($stmt, "i", $param_id);
        
//         // Set parameters
//         $param_id = trim($_POST["indicator_id"]);
        
//         // Attempt to execute the prepared statement
//         if(mysqli_stmt_execute($stmt)){
//             // Records deleted successfully. Redirect to landing page
//             header("location: add-indicator.php");
//             exit();
//         } else{
//             echo "Oops! Something went wrong. Please try again later.";
//         }
//     }
     
//     // Close statement
//     mysqli_stmt_close($stmt);
    
//     // Close connection
//     mysqli_close($con);
// } else{
//     // Check existence of id parameter
//     if(empty(trim($_GET["indicator_id"]))){
//         // URL doesn't contain id parameter. Redirect to error page
//         header("location: error.php");
//         exit();
//     }
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
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
                        <h1>Delete Record</h1>
                    </div>
                    <form action="" method="post">
                        <div class="alert alert-danger fade in">
                            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                            <p>Are you sure you want to delete this record?</p><br>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="add-indicator.php" class="btn btn-default">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>