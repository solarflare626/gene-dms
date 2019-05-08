<?php
### code starts here ###
require_once 'core/init.php';
include 'guards/authenticated.php';
include 'guards/admin.php';

$indicators = (new Indicator)->fetchAll();

 // Define variables and initialize with empty values
$name =  "";
$indicator_name_err = "";

$metrics =[];
if(Input::exists('post')) {
    if(Token::check(Input::get('token'))) {
        $metrics = Input::get('metrics');
        
        #remove empty metrics
        $metrics = array_diff($metrics,["",null]);
        $_POST['metrics'] = $metrics;

        $validate = new Validate();
        $validate->check($_POST, array(
            'name' => array('required' => true),
            'indicator_id' => array('required' => true),
            'metrics' => array('not-empty' => true)
        ));
        
       
		
		

        if($validate->passed()) {
            $form = new Form();

            if($form->create(array(
                'name' => Input::get('name'),
                'indicator_id' => Input::get('indicator_id'),
            ), $metrics)){

                echo 'hahaha';
                Redirect::to("view-forms.php");
            }else{
                die("error here");
            }

            
            // echo  $form->table();

			// $remember = (Input::get('remember') === 'on') ? true : false;
            // $login = $user->login(Input::get('username'), Input::get('password'), $remember);

            // if($login) {
            //     Redirect::to('index.php');
            // } else {
            //     echo '<p>Incorrect username or password</p>';
            // }
        } else {
            foreach($validate->errors() as $error) {
                echo $error, '<br>';
            }
        }
    }
}
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $indicator = new Indicator();
//     // Validate name
//     $input_indicator = trim($_POST["name"]);
//     if (empty($input_indicator)) {
//         $indicator_name_err = "Please enter indicator.";
//     } elseif (!filter_var($input_indicator, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))) {
//         $indicator_name_err = "Please enter a valid indicator.";
//     } else {
//         $name = $input_indicator;
//     }
    
    
//     // Check input errors before inserting in database
//     if (empty($indicator_name_err)) {
//         if ($indicator->create(array( 'name' => $name ))) {
//             Redirect::to("add-indicator.php");
//         } else {
//             echo "Something went wrong. Please try again later.";
//         }
//         // Prepare an insert statement
//         $sql = "INSERT INTO indicator (indicator_name) VALUES ('$indicator_name')";
//     }
// }
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
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Create Form</h2>
                    </div>
                    <!-- <p>Please fill this form and submit to add indicator to the database.</p> -->
                    
                        <form  role="form" action="" method="post">
                            <div class="form-group">
                                <label>Form Name</label>
                                <input  type="text" name="name" class="form-control" value="<?php echo Input::get('name'); ?>">
                            </div>
                            <div class="form-group">
                                <label>Indicator</label>
                                <select required type="text" name="indicator_id" class="form-control">
                                <option value="" disabled selected>Select Indicator</option>
                                <?php
                                    foreach ($indicators as $index => $value) {
                                        $indicator = $value->data();
                                        $selected = Input::get('indicator_id') === (''.$indicator->id)? 'selected' : '' ;
                                        echo '<option value="'.$indicator->id.'" '.$selected.'>'.$indicator->name.'</option>';
                                        # code...
                                    }
                                ?>
                                </select>
                                
                            </div>
                            
                            <div class="metrics form-group">
                                <label>Metrics</label>
                                <div class="metrics-list">
                                    <?php 
                                        foreach ($metrics as $index => $value) {

                                           echo '<div class="entry input-group ">';
                                           echo '     <input class="form-control" name="metrics[]" type="text" placeholder="Type something" value="'.$value.'" />';
                                           echo '     <span class="input-group-btn">';
                                           echo '         <button class="btn btn-danger btn-remove" type="button">';
                                           echo '             <span class="glyphicon glyphicon-minus"></span>';
                                           echo '         </button>';
                                           echo '     </span>';
                                           echo ' </div>';
                                            
                                        }
                                    ?>
                                    <div class="entry input-group ">
                                        <input class="form-control" name="metrics[]" type="text" placeholder="Type something" />
                                        <span class="input-group-btn">
                                            <button class="btn btn-success btn-add" type="button">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <br><br><br>
                            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                            <button type="submit" class="btn btn-primary" > Submit</button>
                            <a href="view-forms.php" class="btn btn-default">Cancel</a>
                        </form>
                    
                </div>
            </div>        
        </div>
    </div>
</body>
<script>
/* Dynamic form fields */
$(function(){
    $(document).on('click', '.btn-add', function(e)
    {
        e.preventDefault();

        var controlForm = $('.metrics .metrics-list:first'),
            currentEntry = $(this).parents('.entry:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');
        controlForm.find('.entry:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="glyphicon glyphicon-minus"></span>');
    }).on('click', '.btn-remove', function(e)
    {
		$(this).parents('.entry:first').remove();

		e.preventDefault();
		return false;
	});
});
</script>
</html>