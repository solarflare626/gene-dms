<?php

### code starts here ###
require_once 'core/init.php';
include 'guards/authenticated.php';
include 'guards/entity.php';


 // Define variables and initialize with empty values
$id = Input::get('id');
$db_forms = (new Form)->fetchAll();
$users = (new User)->fetchAll(array("id", ">", 1));
$formOptions = "";

foreach ($db_forms as $index => $value) {
    $form = $value->data();

    $formOptions .= '<option value="'.$form->id.'"> ' .$form->id. ' -- ' .$form->name.'</option>';
    
}
if(Input::exists('get')) {

    $request = new Request(Input::get('id'));

   

    $user_id = $request->data()->user_id;
    $subject = $request->data()->subject;
    $message = $request->data()->message;
    
    $forms = [];
    
    $requestForms = [];
    $rf = $request->requestForms();
    foreach ($rf as $key => $value) {
        array_push($forms,$value->data()->form_id);
        array_push($requestForms,$value->data()->id);
    }

    // mark request as unread;
    if($request->data()->is_read == 0){
        $request->update(array(
            'is_read' => 1
        ),$forms);
    }
        

}
### code ends here ###
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Request</title>
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
                        <h2>View Request</h2>
                    </div>
                    <p>Admin sent you a request.</p>
                            <div class="form-group">
                                <label>Subject</label>
                                <input disabled  type="text" required name="subject" class="form-control" value="<?php echo $subject; ?>">
                            </div>

                            <div class="form-group">
                                <label >Message</label>
                                <textarea  disabled class="form-control" name="message" type="text"  class="validate[required,length[0,100]] text-input" required aria-required="true" pattern="[A-Za-z]+\[A-Za-z]+" required placeholder="Insert request here..."><?php echo $message; ?></textarea>
                            </div>
                            
                            <div class="forms form-group">
                                <label>Forms:</label>
                                <div class="forms-list">
                                    <?php
                                        foreach ($forms as $index => $value) {
                                            
                                            echo '<div class="entry input-group ">';
                                            echo '     <select  disabled class="form-control" name="forms[]" type="text"><option value="" disabled>Select Form</option>';
                                            
                                            
                                            foreach ($db_forms as $key => $d) {
                                                $form = $d->data();
                                                if($form->id == $value){
                                                    echo  '<option value="'.$form->id.'" selected> ' .$form->id. ' -- ' .$form->name.'</option>';
                                                }else{
                                                  echo  '<option value="'.$form->id.'"> ' .$form->id. ' -- ' .$form->name.'</option>';
                                                }
                                            }
                                            
                                            echo '</select>';
                                            echo '     <span class="input-group-btn">';
                                        
                                            echo '         <a class="btn btn-primary" href="request-form.php?id='.$requestForms[$index].'" title="Fill Up Form" data-toggle="tooltip">';
                                            echo ($rf[$index]->data()->is_submitted == 0) ? 'Fill Up': 'Update';
                                            echo '         </a';
                                        
                                            echo '     </span>';
                                            echo ' </div>';
                                        }
                                    ?> 
                                </div>
                            </div>
                            <br><br><br>              
                </div>
            </div>        
        </div>
    </div>

    <script>


/* Dynamic form fields */
$(function(){
    $(document).on('click', '.btn-add', function(e)
    {
        console.log("hahaha");
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