<?php
### code starts here ###
require_once 'core/init.php';
include 'guards/authenticated.php';
include 'guards/admin.php';




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
    $entity = $request_form->user(); 
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
    <title>Submitted Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/xlsx.full.min.js"></script>
    <script src="js/FileSaver.min.js"></script>
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

</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2></h2>
                    </div>
                    <p></p>
                    
                        <form  role="form" action="" method="post">
                            <div class="form-group">
                                <label>Form Name</label>
                                <input disabled  type="text" class="form-control" value="<?php echo $name; ?>">
                            </div>
                            <div class="form-group">
                                <label>Form Name</label>
                                <input disabled  type="text" class="form-control" value="<?php echo $indicator->data()->name; ?>">
                            </div>
                            <div class="form-group">
                                <label>Year</label>
                                <input  type="number" disabled value="<?php echo $request_form->data()->year  ?>" class="form-control" >
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
                                                echo '<input disabled required class="form-control" name="answers[]" type="number" value="'.$answers[$index].'"/>';
                                                echo '</div>';
                                           echo '</div><br>';

                                        }
                                    ?>
                                    
                            </div>
                            <br><br><br>
                            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                            <input type="hidden" name="id" value="<?php echo $request_form_id; ?>">
                            
                            <a href="dashboard-admin.php" class="btn btn-primary">Back</a>
                            <a id="btnExport" class="btn btn-danger">Export</a>
                        </form>
                    
                </div>
            </div>        
        </div>
    </div>

   
    
    <script>
   
               
        $(document).ready(function(){
           
            var wb = XLSX.utils.book_new();
            wb.SheetNames.push("<?php echo $form->data()->name ?>");


            var ws_data = [
                ["Form ID" , "<?php echo $form->data()->id?>","Entity" , "<?php echo  $entity->data()->name?>"],
                ["" , "" , "" , ""],                
                ["Form Name" , "<?php echo $form->data()->name?>","Year" , "<?php echo  $request_form->data()->year?>"],
                ["" , "" , "" , ""],         
                ["Metrics" , "Value" , "" , ""],
                ["" , "" , "" , ""],                
                <?php
                    foreach ($metrics as $index => $value) {
                       echo  '["'.$value.'" , "'.$answers[$index].'","" , ""],';
                
                    }
                ?>
                         
            ];  //a row with 2 columns
            var ws = XLSX.utils.aoa_to_sheet(ws_data);
            
            wb.Sheets["<?php echo $form->data()->name ?>"] = ws;
            var wbout = XLSX.write(wb, {bookType:'xlsx',  type: 'binary'});
            function s2ab(s) { 
                var buf = new ArrayBuffer(s.length); //convert s to arrayBuffer
                var view = new Uint8Array(buf);  //create uint8array as viewer
                for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF; //convert to octet
                return buf;    
            }

            $("#btnExport").click(function(){
                saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), '<?php echo "".$request_form->data()->id."-".  $entity->data()->name ."-". $form->data()->name ?>.xlsx');
            });
        });


    </script>
</body>
</html>