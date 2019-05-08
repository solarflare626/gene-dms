<?php
### code starts here ###
require_once 'core/init.php';
include 'guards/authenticated.php';




 // Define variables and initialize with empty values
$name =  "";
$indicator_name_err = "";

$metrics = [];


if(Input::exists('get')) {
    $request_form_id = Input::get('id');
    
    $request_form = new RequestForm($request_form_id);
    if($request_form->data() == null){
        die("Page not found.");
    }
    $form = $request_form->form();
    
    $entity = $request_form->user(); 

    $user = new User();

    if($user->is_admin() == false && ($entity->data()->id != $user->data()->id) ){
        die("Unauthorized access.");
    }

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
    <title>Export Form Data</title>
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/xlsx.full.min.js"></script>
    <script src="js/FileSaver.min.js"></script>
    <!--   Core JS Files   -->

</head>
<body>
    
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

                saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), '<?php echo "".$request_form->data()->id."-".  $entity->data()->name ."-". $form->data()->name ?>.xlsx');
            
        });


    </script>
</body>
</html>