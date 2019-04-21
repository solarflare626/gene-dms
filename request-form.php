<?php
// Include config file
require_once "db.php";

### code starts here ###
require_once 'core/init.php';
include 'guards/authenticated.php';
include 'guards/entity.php';




 // Define variables and initialize with empty values
$name =  "";
$indicator_name_err = "";

$metrics = [];

if(Input::exists('post')) {
    if(Token::check(Input::get('token'))) {
        $request_form_id = Input::get('id');
        $answers = Input::get('answers');
        $validate = new Validate();

        $validate->check($_POST, array(
            'answers' => array('not-empty' => true)
        ));

        $request_form = new RequestForm($request_form_id);
        if($validate->passed()) {
            $ans = $request_form->answers();
            foreach ($ans as $index => $answer) {
                if(!$answer->update(array(
                    'answer' => $answers[$index]
                ))){
                    die("error here");
                }
                
            }
            $request_form->update(array(
                'is_submitted' => 1
            ));
            Redirect::to("requests.php");

           
        } else {
            foreach($validate->errors() as $error) {
                echo $error, '<br>';
            }
        }
    }else{
        die("Please Refresh page");
    }
}else if(Input::exists('get')) {
    $request_form_id = Input::get('id');
    
    $request_form = new RequestForm($request_form_id);
    $form = $request_form->form();

    $indicator = new Indicator($form->data()->indicator_id);
    $name = $form->data()->name;
    $indicator_id = $form->data()->indicator_id;


    $ans = $request_form->answers();
    $answers = [];
    $metrics = [];
    foreach ($ans as $key => $value) {
        array_push($answers,$value->data()->answer);
        array_push($metrics,$value->metric()->data()->metric);
    }

}

### code ends here ###
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="js/jquery-1.11.3.min.js"></script>
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
        .entry:not(:first-of-type)
        {
            margin-top: 10px;
        }

        .glyphicon
        {
            font-size: 12px;
        }
    </style>
    <!--   Core JS Files   -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Fill Up Request Form</h2>
                    </div>
                    <p>Please fill this form and submit to admin.</p>
                    
                        <form  role="form" action="" method="post">
                            <div class="form-group">
                                <label>Form Name</label>
                                <input disabled  type="text" class="form-control" value="<?php echo $name; ?>">
                            </div>
                            <div class="form-group">
                                <label>Form Name</label>
                                <input disabled  type="text" class="form-control" value="<?php echo $indicator->data()->name; ?>">
                            </div>
                            
                            <div class="metrics form-group">
                                <label>Metrics:</label>
                                
                                    <?php 
                                        foreach ($metrics as $index => $value) {
                                           echo '<div class="row">';
                                                echo '<div class="col-md-8">';
                                                echo $value;
                                                echo '</div>';
                                                echo '<div class="col-md-4">';
                                                echo '<input required class="form-control" name="answers[]" type="number" value="'.$answers[$index].'"/>';
                                                echo '</div>';
                                           echo '</div><br>';

                                        }
                                    ?>
                                    
                            </div>
                            <br><br><br>
                            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                            <input type="hidden" name="id" value="<?php echo $request_form_id; ?>">
                            <button type="submit" class="btn btn-primary" > Submit</button>
                            <a href="view-forms.php" class="btn btn-default">Cancel</a>
                        </form>
                    
                </div>
            </div>        
        </div>
    </div>
    

</html>