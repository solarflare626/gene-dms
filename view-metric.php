<?php
include ('db.php');
$sql= mysqli_query($con,"SELECT * FROM answer");
?>

<!doctype html>
<html lang="en">
<head>

	<meta charset="utf-8" />
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/icon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

	
	<title>DAMs</title>

	
	
	</head>


<body>

<table id="table_id" class="display">
    <thead>
        <tr>
            <th>ID</th>
            <th>ICT</th>
			<th>Business</th>	
			<th>Engineering</th>
			<th>Accounting and Finance</th>
			<th>Medicine</th>
			<th>Social Sciences</th>
			<th>Education</th>
        </tr>
    </thead>
    <tbody>
        <tr>
		<?php while($row = mysqli_fetch_array($sql)): ?>
            <td align="center"><?php echo $row['answer_id']; ?></td>
			<td align="center"><?php echo $row['ict']; ?></td>
			<td align="center"><?php echo $row['business']; ?></td>
			<td align="center"><?php echo $row['engineering']; ?></td>
			<td align="center"><?php echo $row['accounting']; ?></td>
			<td align="center"><?php echo $row['medicine']; ?></td>
			<td align="center"><?php echo $row['social']; ?></td>
			<td align="center"><?php echo $row['educ']; ?></td>
        </tr>
        <?php endwhile ?>
    </tbody>
</table>
		
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
		

		

	<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>	
	
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>


	
		
<script type="text/javascript">	
$(document).ready( function () {
    $('#table_id').DataTable({
		 dom: 'Bfrtip',
		buttons: [
		'copy', 'csv','excel', 'pdf', 'print'
	]}
		);
} );
</script>
	
	

</body>

  

</html>
