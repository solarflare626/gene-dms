<?php
// Include config file
require_once "db.php";

### code starts here ###
require_once 'core/init.php';
include 'guards/authenticated.php';
include 'guards/admin.php';

$db_forms = (new Form)->fetchAll();
$users = (new User)->fetchAll(array("id", ">", 1));

$formOptions = "";

foreach ($db_forms as $index => $value) {
    $form = $value->data();

    $formOptions .= '<option value="'.$form->id.'"> ' .$form->id. ' -- ' .$form->name.'</option>';
}

 // Define variables and initialize with empty values
if (Input::exists('post')) {
    if (Token::check(Input::get('token'))) {
        $forms = Input::get('forms');
        
        #remove empty metrics
        $forms = array_diff($forms, ["",null]);
        $_POST['forms'] = $forms;

        $validate = new Validate();
        $validate->check($_POST, array(
            'user_id' => array('required' => true),
            'subject' => array('required' => true),
            'forms' => array('not-empty' => true)
        ));
        
        if ($validate->passed()) {
            $request = new Request();

            if ($request->create(array(
                'user_id' => Input::get('user_id'),
                'subject' => Input::get('subject'),
                'message' => Input::get('message'),
            ), $forms)) {
                Redirect::to("view-requests.php");
            } else {
                die("error here");
            }
        } else {
            foreach ($validate->errors() as $error) {
                echo $error, '<br>';
            }
        }
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
                    
                        <form  role="form" action="" method="post">

                        <div class="form-group">
                                <label>Recipient Entity</label>
                                <select required type="text" name="user_id" class="form-control">
                                <option value="" disabled selected>Select Recipient</option>
                                <?php
                                    foreach ($users as $index => $value) {
                                        $user = $value->data();
                                        $selected = Input::get('user_id') === (''.$user->id)? 'selected' : '' ;
                                        echo '<option value="'.$user->id.'" '.$selected.'>'.$user->name.'</option>';
                                        # code...
                                    }
                                ?>
                                </select>
                                
                        </div>
                            <div class="form-group">
                                <label>Subject</label>
                                <input  type="text" required name="subject" class="form-control" value="<?php echo Input::get('subject'); ?>">
                            </div>

                            <div class="form-group">
                                <label >message</label>
                                <textarea class="form-control" name="message" type="text"  class="validate[required,length[0,100]] text-input" required aria-required="true" pattern="[A-Za-z]+\[A-Za-z]+" required placeholder="Insert request here..."><?php echo Input::get('message'); ?></textarea>
                            </div>
                            
                            
                            <div class="forms form-group">
                                <label>Forms:</label>
                                <div class="forms-list">
                                    <?php
                                        foreach (Input::get('forms') as $index => $value) {
                                            echo '<div class="entry input-group ">';
                                            echo '     <select class="form-control" name="forms[]" type="text"><option value="" disabled>Select Form</option>';
                                            
                                            foreach ($db_forms as $key => $d) {
                                                $form = $d->data();
                                                
                                                if ($form->id == $value) {
                                                    echo  '<option value="'.$form->id.'" selected> ' .$form->id. ' -- ' .$form->name.'</option>';
                                                } else {
                                                    echo  '<option value="'.$form->id.'"> ' .$form->id. ' -- ' .$form->name.'</option>';
                                                }
                                            }
                                            
                                            echo '</select>';
                                            echo '     <span class="input-group-btn">';
                                            echo '         <button class="btn btn-danger btn-remove" type="button">';
                                            echo '             <span class="glyphicon glyphicon-minus"></span>';
                                            echo '         </button>';
                                            echo '     </span>';
                                            echo ' </div>';
                                        }
                                    ?> 
                                    <div class="entry input-group ">
                                        <select class="form-control" name="forms[]" type="text">
                                            <option value="" disabled selected>Select Form</option>
                                            <?php echo $formOptions ?>
                                        </select>
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

    <script>


/* Dynamic form fields */
$(function(){
    $(document).on('click', '.btn-add', function(e)
    {
        e.preventDefault();

        var controlForm = $('.forms .forms-list:first'),
            currentEntry = $(this).parents('.entry:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('select').val('');
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
</body>

</html>