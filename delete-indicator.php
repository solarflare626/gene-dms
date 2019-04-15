<?php
### code starts here ###
require_once 'core/init.php';
include 'guards/authenticated.php';
include 'guards/admin.php';

$id;

#Process delete operation after confirmation
if (Input::exists('post')) {
    if (Token::check(Input::get('token'))) {
        $id = Input::get('id');
        $indicator = new Indicator($id);

        if($indicator->delete()){
            Redirect::to("add-indicator.php");
        }else{
            die("Error deleting page");
        }
        
    }
}else if(Input::exists('get')) {
    $id = Input::get('id');
}

// if(isset($_POST["id"]) && !empty($_POST["id"])){
    
    
   
//     $id = trim($_POST["id"]);
//     //get indicator
    
    
//     $indicator = new Indicator();
//     // die("here");
//     if($indicator->find($id)){
        
//         if($indicator->delete(array('id', '=', $id))){
//             Redirect::to("add-indicator.php");
//             die("here");
//         }else{
//             echo "Oops! Something went wrong. Please try again later.";
//         }
//     }else{
//         die("there");
//         echo "Oops! Something went wrong. Please try again later.";
//     }
// } else{
//     // Check existence of id parameter
//     if(empty(trim($_GET["id"]))){
//         // URL doesn't contain id parameter. Redirect to error page
//         Redirect::to("error.php");
//     }else{
//         $id = trim($_GET["id"]);
//     }
// }

### code ends here ###

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
                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
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