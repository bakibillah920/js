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
	<form action="" method="post">
		<p align="center">BIPLOB</P>
	<tr>
		<td>
			<input type="text" id="second1" name="name0" value="50"  />
		</td>
		<td>
			<input type="text" id="first" name="name1" placeholder="Click" value=""  />
		</td>
		<td>
			<input type="text" id="second" name="name2" value="10"  />
		</td>
		<td>
			<input type="text" id="second1" name="name3" value="20"  />
		</td>
	</tr>
	<tr>
		<td id="second9">
			<input type="text" id="second2" name="name4" value="46"  />
		</td>
		<td>
			<input type="text" id="second3" name="name4" value="61"  />
		</td>
		<td>
			 <select class="opt">
			 <option selected="selected" value="">Select Name</option>
			  <option value="1">ADD</option>
			  <option value="2">Rimon</option>
			  <option value="3">Ekram</option>
			  <option value="4">bakibillah</option>
			</select> 
		</td>
		<td>
			<input type="text" name="name5" value="41"  />
		</td>
	</tr>
	<tr>
		<td id="second9">
			<input type="number" id="math" name="name4" placeholder="add" value=""  />
		</td>
		<td>
			<input type="number" id="math1" name="name4" placeholder="add" value=""  />
		</td>
		<td>
			 <select class="name">
			  <option selected="selected" >Select row add</option>
			  <option value="5">5</option>
			  <option value="6">6</option>
			  <option value="7">7</option>
			  <option value="8">8</option>
			</select> 
		</td>
		<td>
			<input type="number" id="sum" name="math3" placeholder="sum" value=""  />
		</td>
	</tr>
	</form>
	</table>
<script>
$(document).ready(function(){
		$("#first").click(function() {
			//var value = $(this).parent().next().children().val();
			var value = $(this).parent().next().next().children().val();
			//var value = $(this).parent().prev().children().val();
			//var value = $(this).parent().prev().parent().next().children().children().val();
			//var value = $(this).parent().prev().parent().next().children().next().children().val();
			//var value = $(this).parent().prev().parent().next().children().next().next().next().children().val();
			//alert('<?php echo $baki ;?>');
			alert(value);
			
		 });
		 $("select.opt").change(function(index){
			var name = this.value;
			if(name == '3'){
				//$("#opt option").remove();
				$("#second2").val('');
				return false;
			}else if(name == '1'){
				$("#tb_name").append('<tr class="tr_delete"><td>bakibilah</td><td>remon</td><td>ekram</td><td ><a href="javascript:void(0)" class="remove">X</a></td></tr>');
			}else if(name == '2'){
				$("#second9").html('<input type="text" id="second2" name="name4" value="90"  />');
				return false;
			}else if((name == '4')){
				alert('thanks you');
				return false;
			}
		 });
		 $("#math1").keyup(function(){
			var math1 = this.value;
			var math = $(this).parent().prev().children().val();
			var sum = parseFloat(math)  +  parseFloat(math1);
			//$("#sum").html('<input type="namber" id="sum" name="math3" value="'+sum+'"  />');
			$("#sum").val(sum);
		 
		 });
		$("a.remove").live('click',function(){
			$(this).parent().parent().remove();
		
		});
		$("select.name").change(function(){
			var name = this.value;
			var exist = 0;
			$('.tr_delete').each(function(){
				var	$this_value = $(this).html();
				if($this_value == $this_value){
					exist = exist + 1;
				}
			});
			if(exist>0){
				$(".tr_delete").remove();
				for($i = 0; $i<=name;$i++){
					if($i){
						$("#tb_name").append('<tr class="tr_delete"><td>bakibilah</td><td>remon</td><td>ekram</td><td ><a href="javascript:void(0)" class="remove">X</a></td></tr>');
						
					}
				
				}
				return false
			}else{
				for($i = 0; $i<=name;$i++){
					if($i){
						$("#tb_name").append('<tr class="tr_delete"><td>bakibilah</td><td>remon</td><td>ekram</td><td ><a href="javascript:void(0)" class="remove">X</a></td></tr>');
						
					}
				
				}
			}
			
			
		})
});
</script>
</body>
</html>