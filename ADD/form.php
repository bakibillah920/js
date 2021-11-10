<?php require_once("dbconnect.php");?>
<?php
 if (isset($_POST['submit'])){
	// echo '<pre>';
	// print_r ($_POST);
	// echo '<pre>';
	$subject = $_POST['subject'];
	$year = $_POST['year'];
	$gpa = $_POST['gpa'];
	$sql_insert = "INSERT INTO `user`(subject,year,gpa) VALUES ";
	foreach ($subject as $key=>$value)
	{
		// $insert = mysql_query("INSERT INTO `user`(subject,year,gpa) VALUES ('$value','{$year[$key]}','{$gpa[$key]}')");
		$sql_insert .= " ('$value','{$year[$key]}','{$gpa[$key]}'),";
	}
	$sql_insert = rtrim($sql_insert,',');
	$query_insert = mysql_query($sql_insert);
	if($query_insert){
		echo "Successfully Inserted";
	}
	
	
 }else{
?>

<html>
	<head>
		<title>bakibillah ajax</title>
		<script type="text/javascript" src="jquery-1.7.2.min.js" /></script>
	</head>
	<body>
		<form name="entry_form" id="entry_form" action="" method="post">
				
			<table id="tbl_inner" width="40%" align="left">
				<thead>
				<tr>
					<th align="left">SUBJECT</th>
					<th align="left">YEAR</th>
					<th align="left">GPA</th>
					<th><input type="button" value="Add" name="add" id="add"></th>
					<th><input type="submit" id="submit" name="submit"  value="submit"/></th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td><input type="text" name="subject[]" size="30" id="subject" value="" /></td>
					<td><input type="text" name="year[]" size="30" id="year" value="" /></td>
					<td><input type="text" name="gpa[]" size="30" id="gpa" value="" /></td>
				</tr>
				</tbody>
			</table>
		</form>
	<script>
		$('#add').click(function (){
			$('table#tbl_inner tbody').append('<tr><td><input type="text" name="subject[]" size="30" id="subject" value="" /></td>\
						<td><input type="text" name="year[]" size="30" id="year" value="" /></td>\
						<td><input type="text" name="gpa[]" size="30" id="gpa" value="" /></td></tr>');
		});
	</script>
	</body>
</html>
<?php
}
?>