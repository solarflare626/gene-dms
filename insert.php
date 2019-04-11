<?php

$con = mysqli_connect("localhost","root","","dams");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
 
// Escape user inputs for security
$indicator_name = mysqli_real_escape_string($con, $_REQUEST['indicator_name']);

 
// Attempt insert query execution
$sql = "INSERT INTO indicator (indicator_name) VALUES ('$indicator_name')";
if(mysqli_query($con, $sql)){
    echo "Indicator added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
}
 
// Close connection
mysqli_close($con);
?>