<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-purple rounded-0 shadow">
	<div class="card-header">
		<h3 class="card-title">List of Categories</h3>
		<div class="card-tools">
			<button type="button" id="create_new" class="btn btn-flat btn-success btn-sm"><span class="fas fa-plus"></span>  Add New Category</button>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<table class="table table-bordered table-stripped table-hover">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="10%">
					<col width="15%">
					<col width="30%">
					<col width="10%">
					<col width="15%">
				</colgroup>
				<thead>
				<tr class="bg-gradient-dark text-light">
						<th>#</th>
						<th>Type</th>
						<th>Seater</th>
						<th>Cost</th>
						<th>Description</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
						$qry = $conn->query("SELECT * from `category_list` where delete_flag = 0 order by `id` asc "); // Change 'type' to 'id'

						// Check if the query was successful
						if (!$qry) {
							// Output MySQL error for debugging
							die("Query failed: " . $conn->error);
						}

						// If the query succeeded, fetch the data
						while($row = $qry->fetch_assoc()):
						?>
							<tr>
								<td class="text-center"><?php echo $i++; ?></td>
								<td><?php echo $row['type'] ?></td>
								<td><?php echo $row['seater'] ?></td>
								<td><?php echo $row['cost'] ?></td>
								<td><p class="m-0 truncate-1"><?php echo $row['description'] ?></p></td>
								<td class="text-center">
									<?php if($row['status'] == 1): ?>
										<span class="badge badge-success px-3 rounded-pill">Active</span>
									<?php else: ?>
										<span class="badge badge-danger px-3 rounded-pill">Inactive</span>
									<?php endif; ?>
								</td>
								<td align="center">
									<button type="button" class="btn btn-flat btn-info btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
										Action
									<span class="sr-only">Toggle Dropdown</span>
									</button>
									<div class="dropdown-menu" role="menu">
									<a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
									</div>
								</td>
							</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#create_new').click(function(){
			uni_modal("Add New Category","categories/manage_category.php");
		})
		$('.edit_data').click(function(){
			uni_modal("Edit Category","categories/manage_category.php?id="+$(this).attr('data-id'));
		})
		$('.view_data').click(function(){
			uni_modal("View Category","categories/view_category.php?id="+$(this).attr('data-id'));
		})
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this category permanently?","delete_category",[$(this).attr('data-id')])
		})
		$('.table').dataTable();
	})
	function delete_category($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_category",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>
