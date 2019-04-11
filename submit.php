<?php

// php code to Insert data into mysql database from input text
if(isset($_POST['insert']))
{
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $databaseName = "dams";
    
    // get values form input text and number
	$ict = $_POST['ict'];
    $business = $_POST['business'];
    $engineering = $_POST['engineering'];
	    $accounting = $_POST['accounting'];
		    $medicine = $_POST['medicine'];
			    $social = $_POST['social'];
				    $educ = $_POST['educ'];
    
    // connect to mysql database using mysqli

    $connect = mysqli_connect($hostname, $username, $password, $databaseName);
    
    // mysql query to insert data

    $query = "INSERT INTO `answer`(`ict`,  `business`, `engineering`, `accounting`, `medicine`, `social`, `educ` ) VALUES ('$ict','$business','$engineering', '$accounting', '$medicine', '$social', '$educ')";
    
    $result = mysqli_query($connect,$query);
    
    // check if mysql query successful

    if($result)
    {
        header("location: submit-note.php");
    }
    
    else{
        echo 'Data Not Inserted';
    }
    
    mysqli_close($connect);
}

?>

