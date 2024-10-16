<?php
require_once('./config.php');

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $bookingId = $_GET['id'];
    
    // Prepare the query to avoid SQL injection
    $qry = $conn->query("SELECT * FROM `booking_list` WHERE id = '$bookingId'");

    // Check if the query was successful
    if ($qry === false) {
        echo "Error: " . mysqli_error($conn); // Output the error message
        exit; // Exit if there's a database error
    }

    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }

        $qry2 = $conn->query("SELECT c.*, cc.type as category FROM `cab_list` c INNER JOIN category_list cc ON c.category_id = cc.id WHERE c.id = '{$cab_id}'");

        // Check if the second query was successful
        if ($qry2 === false) {
            echo "Error: " . mysqli_error($conn); // Output the error message
            exit; // Exit if there's a database error
        }

        if ($qry2->num_rows > 0) {
            foreach ($qry2->fetch_assoc() as $k => $v) {
                if (!isset($$k)) {
                    $$k = $v;
                }
            }
        }
    } else {
        echo "No booking found."; // Informative message if no booking is found
        exit;
    }
} else {
    echo "Invalid booking ID."; // Informative message if ID is not valid
    exit;
}
?>

<style>
    #uni_modal .modal-footer{
        display:none
    }
</style>
<div class="container-fluid">

    <div class="row">
        <div class="col-md-6">
            <fieldset class="bor">
                <legend class="h5 text-muted"> Cab Details</legend>
                <dl>
                    <dt class="">Cab Body No</dt>
                    <dd class="pl-4"><?= isset($body_no) ? $body_no : "" ?></dd>
                    <dt class="">Vehicle Category</dt>
                    <dd class="pl-4"><?= isset($category) ? $category : "" ?></dd>
                    <dt class="">Vehicle model</dt>
                    <dd class="pl-4"><?= isset($cab_model) ? $cab_model : "" ?></dd>
                    <dt class="">Driver</dt>
                    <dd class="pl-4"><?= isset($cab_driver) ? $cab_driver : "" ?></dd>
                    <dt class="">Driver Contact</dt>
                    <dd class="pl-4"><?= isset($driver_contact) ? $driver_contact : "" ?></dd>
                    <dt class="">Driver Address</dt>
                    <dd class="pl-4"><?= isset($driver_address) ? $driver_address : "" ?></dd>
                </dl>
            </fieldset>
        
            
        </div>

        <div class="col-md-6">
            <fieldset class="bor">
                <legend class="h5 text-muted"> Booking Details</legend>
                <dl>
                    <dt class="">Ref. Code</dt>
                    <dd class="pl-4"><?= isset($ref_code) ? $ref_code : "" ?></dd>
                    <dt class="">Pickup Zone</dt>
                    <dd class="pl-4"><?= isset($pickup_zone) ? $pickup_zone : "" ?></dd>
                    <dt class="">Drop off Zone</dt>
                    <dd class="pl-4"><?= isset($drop_zone) ? $drop_zone : "" ?></dd>
                    <dt class="">Status</dt>
                    <dd class="pl-4">
                        <?php 
                            switch($status){
                                case 0:
                                    echo "<span class='badge badge-secondary bg-gradient-secondary px-3 rounded-pill'>Pending</span>";
                                    break;
                                case 1:
                                    echo "<span class='badge badge-primary bg-gradient-primary px-3 rounded-pill'>Driver Confirmed</span>";
                                    break;
                                case 2:
                                    echo "<span class='badge badge-warning bg-gradient-warning px-3 rounded-pill'>Picked-up</span>";
                                    break;
                                case 3:
                                    echo "<span class='badge badge-success bg-gradient-success px-3 rounded-pill'>Dropped off</span>";
                                    break;
                                case 4:
                                    echo "<span class='badge badge-danger bg-gradient-danger px-3 rounded-pill'>Cancelled</span>";
                                    break;
                            }
                        ?>
                    </dd>
                </dl>
            </fieldset>
        </div>
    </div>
    <!-- <div class="clear-fix my-2"></div> -->
    
    
    <div class="text-right">
        
        <?php if(isset($status) && $status == 0): ?>
        <button class="btn btn-danger btn-flat bg-gradient-danger" type="button" id="cancel_booking">Cancel Bookings</button>
        <?php endif; ?>
        <button class="btn btn-dark btn-flat bg-gradient-dark" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
    </div>
</div>
<script>
    $(function(){
        $('#cancel_booking').click(function(){
            _conf("Are you sure to cancel your cab booking [Ref. Code: <b><?= isset($ref_code) ? $ref_code : "" ?></b>]?", "cancel_booking",["<?= isset($id) ? $id : "" ?>"])
        })
    })
    function cancel_booking($id){
        start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=update_booking_status",
			method:"POST",
			data:{id: $id,status:4},
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