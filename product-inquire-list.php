<div class="wrap">
    <h2>Inquire List</h2>
	 <table class="wp-list-table widefat fixed display" id="inquireList">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>Mobile</th>
				<th>Product Group</th>
				<th>Product Name</th>
				<th>Product Desscription</th>
				<th>Product Quantity</th>
				<th>Action</th>
            </tr>
		</thead>
		<tbody>
<?php

	global $wpdb;	
	$tablename = $wpdb->prefix.'orders';
	$result = $wpdb->get_results("select * from ".$tablename." ORDER BY id DESC");
	
	
		if ($result)
		{


					foreach($result  as $results )
					{
										
						$id        				= $results->id;
						$customer_name  		= $results->customer_name;
						$customer_email  		= $results->customer_email;
						$mobile_number  		= $results->mobile_number;
						$productArray  			= $results->product_data;
						
						$mydata = unserialize($productArray);
						
					?>
					<tr>
						<td><?php echo $id; ?></td>
						<td><?php echo $customer_name; ?></td>
		                <td><?php echo $customer_email; ?></td>
						<td><?php echo $mobile_number;?></td>
						<td><?php echo $mydata['product_group'][0];?></td>
						<td><?php echo $mydata['product_name'][0];?></td>
						<td><?php echo $mydata['product_description'][0];?></td>
						<td><?php echo $mydata['product_qty'][0];?></td>
						<td><a href="#" id="<?php echo $results->id; ?>" class="del_inquire">Delete</a></td>
					</tr>
			<?php }
		} else { ?>
				<tr align="center">
					<td colspan="6">No Record Found!</td>
				<tr>
		<?php } ?>
		</tbody>
		</table>
	
	</div>


<script type="text/javascript">
jQuery(document).ready(function() {
jQuery(".del_inquire").click(function() {
			var del_id = jQuery(this).attr("id");
				
			var user_confirm = confirm("Are you sure to delete this record?");
			if (user_confirm == true) {
					jQuery.ajax({
					url: ajaxurl,
					data: {
						'action':'del_inquire_record',
						'del_id' : del_id
					},
					 success:function(data) {
						location.reload(true);					
				},
			error: function(errorThrown){
				console.log(errorThrown);
				alert("Error in delete");
			}
			});
			} 
		});
		});
</script>		
