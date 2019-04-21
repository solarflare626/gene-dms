<?php

// php code to Insert data into mysql database from input text
if(isset($_POST['insert']))
{
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $databaseName = "dams";
    
    // get values form input text and number

    $entity = $_POST['entity'];
    $subject = $_POST['subject'];
    $text = $_POST['text'];
	    
    // connect to mysql database using mysqli

    $connect = mysqli_connect($hostname, $username, $password, $databaseName);
    
    // mysql query to insert data

    $query = "INSERT INTO `request`(`entity`, `subject`, `text`) VALUES ('$entity','$subject','$text')";
    
    $result = mysqli_query($connect,$query);
    
    // check if mysql query successful

    if($result)
    {
        header("location: request-note.php");
    }
    
    else{
        echo 'Data Not Inserted';
    }
    
    mysqli_close($connect);
}

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send Request</title>
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
                        <h2>Send Request</h2>
                    </div>
                     <form action="request.php" method="post" align="center">
<div class="form-group">
                    <label style="float:left">Recipient Entity</label>
                        <select class="form-control" name="entity">
                        <option>CPDO</option>
                        <option>CHED</option>
                        <option>ILPI</option>
                        <option>DepEd</option>
                        <option>CTO</option>
                        <option>CITY POLICE</option>
                        <option>PLDT</option>
                        <option>GLOBE</option>
                        </select>
                    <br>
                    <label style="float:left">Subject</label>
                        <input class="form-control" name="subject" type="text"   class="validate[required,length[0,100]] text-input" required aria-required="true" pattern="[A-Za-z]+\[A-Za-z]+" required placeholder="Insert subject here...">
                    <br>
                    <label style="float:left">Text</label>
                        <textarea class="form-control" name="text" type="text"  class="validate[required,length[0,100]] text-input" required aria-required="true" pattern="[A-Za-z]+\[A-Za-z]+" required placeholder="Insert request here..."></textarea>
                    
                   </div>	
				        <input type="submit" class="btn btn-primary" value="Send Request" name="insert">
                        <a href="dashboard-admin.php" class="btn btn-default">Cancel</a>
				</form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
