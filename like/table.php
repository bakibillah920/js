<html lang="en">
<head>
<meta charset="utf-8">
<title>javascript demo</title>
<style>
td {
width: 40px;
background: green;
}
table{
margin:0 auto ;
border-collapse: collapse;
}
input{
	background:#727272;
}
</style>
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="js/jquery-1.7.2.min.js" /></script>
</head>
<body>
<?php
$baki = "bakibillah";
?>
	<table border="1" id="tb_name">
		<p align="center">Bakillah</P>
	<?php
	
		for($i = 50;$i<=54;$i++){
	?>
	<tr>
	<td>
		<input type="button" class="like">
			<span class="like_num"><?php echo $i?></span>
		</td>
		</tr>
	<?php 
		}
	?>
	</table>
<script>
$(document).ready(function(){
  $(".like").click(function(){
		 var count = parseInt($(this).next().text());
			//alert(count);
		  $(this).next().text(count + 1);
  });
});
</script>
</body>
</html>