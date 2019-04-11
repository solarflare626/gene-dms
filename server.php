<?php 
	include 'db.php';
	session_start();
	if (isset($_POST['login'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$query = mysqli_query($con,"SELECT * FROM user WHERE username = '$username' and password = '$password'");
		$row = mysqli_fetch_array($query);
		if (mysqli_num_rows($query)==1) {
			$_SESSION['user_id']=$row['user_id'];
			if ($row['usertype']=='admin') {
				header('location: dashboard-admin.php'
			);
			}else {
				header('location: dashboard-ched.php');
			}
		}else{
			header('location: https://www.w3schools.com/sql/sql_orderby.asp');
		}

	}
?>