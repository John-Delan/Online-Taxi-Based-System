<?php
require_once('./../../config.php');

// Check database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Validate ID parameter
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    echo "Invalid ID.";
    exit;
}

$booking_id = intval($_GET['id']);

// Query booking details
$qry = $conn->query("SELECT b.*, CONCAT(c.lastname, ', ', c.firstname, ' ', c.middlename) AS client 
                     FROM `booking_list` b 
                     INNER JOIN client_list c ON b.client_id = c.id 
                     WHERE b.id = '$booking_id'");

// Check if the query was successful
if ($qry === false) {
    echo "Error with query: " . $conn->error . "<br> Query: SELECT b.*, CONCAT(c.lastname, ', ', c.firstname, ' ', c.middlename) AS client FROM `booking_list` b INNER JOIN client_list c ON b.client_id = c.id WHERE b.id = '$booking_id'";
    exit;
}

// Check if any booking details were returned
if ($qry->num_rows > 0) {
    // Fetch results
    $bookingData = $qry->fetch_assoc();
    foreach ($bookingData as $k => $v) {
        $$k = $v; // Dynamic variable assignment
    }

    // Query cab details
    $qry2 = $conn->query("SELECT c.*, cc.name AS category 
                          FROM `cab_list` c 
                          INNER JOIN category_list cc ON c.category_id = cc.id 
                          WHERE c.id = '{$cab_id}'");

    // Check if the second query was successful
    if ($qry2 === false) {
        echo "Error with second query: " . $conn->error . "<br> Query: SELECT c.*, cc.name AS category FROM `cab_list` c INNER JOIN category_list cc ON c.category_id = cc.id WHERE c.id = '{$cab_id}'";
        exit;
    }

    // Check if any cab details were returned
    if ($qry2->num_rows > 0) {
        $cabData = $qry2->fetch_assoc();
        foreach ($cabData as $k => $v) {
            if (!isset($$k)) $$k = $v; // Ensure no overwrite of existing variables
        }
    } else {
        echo "No cab found with the given ID.";
        exit;
    }
} else {
    echo "No booking found with the given ID.";
    exit;
}
?>
<style>
    #uni_modal .modal-footer {
        display: none;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <fieldset class="border-bottom">
                <legend class="h5 text-muted">Cab Details</legend>
                <dl>
                    <dt class="">Cab Body No</dt>
                    <dd class="pl-4"><?= isset($body_no) ? $body_no : "" ?></dd>
                    <dt class="">Vehicle Category</dt>
                    <dd class="pl-4"><?= isset($category) ? $category : "" ?></dd>
                    <dt class="">Vehicle Model</dt>
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
                <legend class="h5 text-muted">Booking Details</legend>
                <dl>
                    <dt class="">Ref. Code</dt>
                    <dd class="pl-4"><?= isset($ref_code) ? $ref_code : "" ?></dd>
                    <dt class="">Client</dt>
                    <dd class="pl-4"><?= isset($client) ? $client : "" ?></dd>
                    <dt class="">Pickup Zone</dt>
                    <dd class="pl-4"><?= isset($pickup_zone) ? $pickup_zone : "" ?></dd>
                    <dt class="">Drop Off Zone</dt>
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
    <div class="clear-fix my-3"></div>
    <div class="text-right">
        <button class="btn btn-danger btn-flat bg-gradient-red" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
    </div>
</div>
