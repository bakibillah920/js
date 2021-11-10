<?php
include('includes/session.inc');
//include('includes/DateFunctions.inc');

$method = '_'.$_SERVER['REQUEST_METHOD'];
$req = &$$method;
$action = (empty($req['action']))?'create':$req['action'];
$error = 0;
$msg = '';
$title = _('Sale');
	switch($action){
	case 'ajax':
		$sub_action = $req['sub_action'];
		switch($sub_action){
			case 'get_customer':
				$territory_id = $req['territory_id'];
				$sq_get_customer = "SELECT c.name,c.debtorno FROM debtorsmaster c 
									INNER JOIN market m ON m.id = c.market_id
									WHERE m.teritoryid = '$territory_id'";
				$res_customer =  DB_query($sq_get_customer,$db);
				while($data_customer = DB_fetch_assoc($res_customer)){
					?>
						<option value="<?php echo $data_customer['debtorno'] ?>">	<?php echo $data_customer['name'] ?>	</option>
					<?php
				}
									
			break;
		case 'get_product_details';
			$product_id =  $req['product_id'];
			// SELECT level_name FROM smc_property_value WHERE property_id = '4' AND level_value = '".substr($smart_code, 9, 2)."'", $db
			
			$sql_get_prod_detail = "SELECT s.units,p.price,.smc.level_name strength FROM stockmaster s 
									LEFT JOIN prod_price p ON s.stockid = p.stockid
									INNER JOIN smc_property_value smc ON smc.level_value = substr(s.smart_code, 9, 2)
									WHERE s.stockid = '$product_id' AND smc.property_id = '4' 
									ORDER BY s.stockid DESC
									Limit 1";
			$res_prod_detail = DB_query($sql_get_prod_detail,$db);
			$data = DB_fetch_assoc($res_prod_detail);
			echo json_encode($data);
		break;
		}
	exit;
	break;
	
	case 'save':
		printr($_POST);exit;
		$territory = $req['territory'];
		$order_category = $req['order_category'];
		$customer = $req['customer'];
		$orderdate = $req['orderdate'];
		$deliverydate = $req['deliverydate'];
		$product_id = $req['product_id'];
		$commercialname = $req['commercialname'];
		$strength = $req['strength'];
		$unit = $req['unit'];
		$unit_price = $req['unit_price'];
		$available_qty = $req['available_qty'];
		$order_qty = $req['order_qty'];
		$deliverydate_sahadat = FormatDateForSQL($deliverydate);
		$orderdate_sahadat = FormatDateForSQL($orderdate);
		//`id`, `customer_id`, `product_id`, `territory_id`, `market_id`, `area_id`, `region_id`, `depo_id`, `mpo_id`, `asm_id`, `rsm_id`, `cod`
		$sql_sales = "INSERT INTO sales_order (territory_id, cod,customer_id,delivery_date)
				VALUES('$territory', '$order_category','$customer','$deliverydate_sahadat')";
			$res_insert = DB_query($sql_sales, $db);
			if($res_insert){
				$sales_order_id = $_SESSION['LastInsertId'];
				
			}
		
		$sql_insert = "INSERT INTO sales_order_details(sales_order_id,product_id,order_qty,unit_price) VALUES ";
			foreach ($product_id as $k=>$product)
			{
				$sql_insert .= " ('$sales_order_id','$product','{$order_qty[$k]}','{$unit_price[$k]}'),";
			}
			$sql_insert = rtrim($sql_insert,',');
			$query_insert = DB_query($sql_insert, $db);
			if($query_insert){
				
				//header('location:'.$_SERVER['PHP_SELF']);
				echo 'Success :)';
			}
	
	break;
	
	}
	include('includes/header.inc');
	echo '<p class="page_title_text"><img src="' . $rootpath . '/css/' . $theme . '/images/supplier.png" title="' .
		_('Search') . '" alt="" />' . ' ' . _('sales').'</p>';

	if(!empty($msg)){
		prnMsg(_($msg), $status);
	}

	
	switch($action){
	case 'create':
	?>
		<form name="form" id="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'],ENT_QUOTES,'UTF-8') ?>"  method="post">
			<input type="hidden" id="action" name="action"  value="save"/>
			<input type="hidden"  name="FormID" value="<?php echo $_SESSION['FormID']; ?>" />
			<input type="hidden" id="user_from_id" name="user_from_id" value="<?php echo uniqid($_SESSION['UserID'].'_'); ?>" />
			<table id="tbl_inner2" width="30%" >
				<tbody>
				<tr>
					<td width="750px">
						<table id="tbl_inner2" width="41%" class="selection">
							<tbody>
							<tr>
								<td colspan="2">Enter Sale Information</td>
							</tr>
							<tr>
								 <td>Select Territory:</td>
								 <td><select name="territory" id="territory" class="chosen-select" style="width:190px;border:1px solid #999;">
									<option value="" selected="selected" disabled="disabled">Select Territory</option>
									 <?php
									 echo $sql_territory = "SELECT * FROM `territory` where area_id in (select id from area where depo = ".$_SESSION['depo_id'].")";
									 $result = DB_query("select id,description from territory",$db);

									 while($region = DB_fetch_assoc( $result ))

									 {
										echo '<option value="'.$region['id'].'">'.$region['description'];
									 }

								  echo '</select>';
								  ?>
								 </td>
							  </tr>
							
							<tr>
								<td>Customer:</td>
								<td>
									<select name="customer" id="customer" class="chosen-select" style="width:190px;border:1px solid #999;">
											<option value="" selected="selected" disabled="disabled">Select Customer</option>
									 
									</select>
								</td>
							</tr>
							<tr>
								<td>Category </td>
								<td>
									<select name="order_category" id="order_category" class="chosen-select" style="width:190px;border:1px solid #999;">
										<option value="" selected="selected" disabled="disabled">Select Category</option>
										<option value="1">COD</option>
										<option value="2">Non COD</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Order Date (d/m/Y):</td>
								<?php echo'
								<td><input type="text" name="orderdate" class="date" alt="'.$_SESSION['DefaultDateFormat'].'"  value="" /></td>'?>
							</tr>
							<tr>
								<td>Delivery Date (d/m/Y):</td>
								<?php echo '
								<td><input type="text" name="deliverydate"  class="date" alt="'.$_SESSION['DefaultDateFormat'].'"  value="" /></td>'?>
							</tr>
							</tbody>
						</table>
						<br />
						<table id="tbl_add" width="100%">
							<thead>
							<tr>

								
								<th align="left">Commercial Name</th>
								<th align="left">Strength</th>
								<th align="left">Unit</th>
								<th align="left">Unit Price</th>
								<th align="left">Available Quantity</th>
								<th align="left">Order Quantity</th>
								<th><input type="button" value="Add" name="add" id="add"></th>
							</tr>
							</thead>
							<tbody>
							<tr>

								
								<td>
									<select name="product_id[]" id="product_id" class="chosen-select prod">
										<option value="" selected="selected" disabled="disabled">Select Product(Code or Name)</option>
										<?php
										$sql_commercial= "SELECT description,stockid
											FROM `stockmaster`
											WHERE `categoryid` = 'FG'";
											$res_commercial =  DB_query($sql_commercial,$db);
										while($data_commercial = DB_fetch_assoc($res_commercial)){
											echo '<option value="'.$data_commercial['stockid'].'">'.$data_commercial['description'].' ( '.$data_commercial['stockid'].' )</option>';
										}
										?>
									</select>
								</td>
								<td><input type="text" name="strength[]"  id="" value="" /></td>
								<td><input type="text" name="unit[]"  id="" value="" /></td>
								<td><input type="text" name="unit_price[]"  id="" value="" /></td>
								<td><input type="text" name="available_qty[]"  id="" value="" /></td>
								<td><input type="text" name="order_qty[]"  id="" value="" /></td>
							</tr>
							</tbody>
						</table>
					</td>
				</tr>
				</tbody>
			</table>
				<br />
				<div align="center">
				<input type="submit" name="save" id="save" value="save" />
				</div>
				<br>
		</form>
	<?php
	break;
		}
	?>
		</body>
		<script>
			
			$(function(){
				var $product_list =  $('#product_id').html();
				
				$('#add').click(function (){
				// $select =  $(document.createElement('select')).addClass('chosen-select').chosen();
				
					$('table#tbl_add tbody').append('<tr><td><select name="product_id[]"  class="chosen-select prod">'+ $product_list +'</select></td>\
									<td><input type="text" name="" name="strength[]" id="" value="" /></td><td><input type="text" name="unit[]" id="" value="" /></td>\
									<td><input type="text" name="unit_price[]"  id="" value="" /></td><td><input type="text" name="available_qty[]"  id="" value="" /></td>\
									<td><input type="text" name="order_qty[]"  id="" value="" /></td></tr>');
					$('select.chosen-select').chosen();
				});


				$('#territory').change(function(){
					var territory_id = this.value;
					$.ajax({
						data: {
							territory_id:territory_id,
							action:"ajax",
							sub_action:"get_customer"
						}
						
					}).done(function(data){
						$('#customer').html('<option value="" selected="selected" disabled="disabled">Select Customer</option>');
						if(data!==''){
							$('#customer').append(data);
							$("#customer").trigger("chosen:updated");
						}
					});
				});

				$('select.prod').live('change',function(){
					$this = $(this);
					$.ajax({
						data:{action:"ajax",sub_action:"get_product_details",product_id:this.value}
					}).done(function(data){
						if(data!=='null'){
							var $product = JSON.parse(data);
							console.log($this.parent().next().next().children());
							// $this.parent().next().next().children();.val($product.unit)
						}else{
							console.log('nothing');
						}
						
					});
				});
				
			});
			
		</script>
</html>
<?php 
include('includes/footer.inc');
?>