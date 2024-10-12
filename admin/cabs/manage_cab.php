<?php
// Correct the path to your config file here
require_once('./../config.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fetch cab details if an ID is set in the URL
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * FROM `cab_list` WHERE id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = stripslashes($v);
        }
    }
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Gather the form data
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $reg_code = $_POST['reg_code']; // Assuming you add a reg_code field to your form
    $category_id = $_POST['type_id'];
    $cab_reg_no = $_POST['cab_reg_no'];
    $body_no = $_POST['body_no'];
    $cab_model = $_POST['cab_model'];
    $cab_driver = $_POST['cab_driver'];
    $driver_contact = $_POST['driver_contact'];
    $driver_address = $_POST['driver_address'];
    $password = isset($_POST['password']) ? $_POST['password'] : null; // Check if password is set
    $image_path = ''; // Initialize image path (handle file upload separately)
    $status = $_POST['status'];

    // Optional: Handle file upload for image_path
    if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
        $uploadDir = 'uploads/'; // Set your upload directory
        $fileName = basename($_FILES['img']['name']);
        $uploadFilePath = $uploadDir . $fileName;

        // Move uploaded file
        if (move_uploaded_file($_FILES['img']['tmp_name'], $uploadFilePath)) {
            $image_path = $uploadFilePath; // Set the image path if upload is successful
        }
    }

    // Hash the password if it's set
    if ($password) {
        $password = password_hash($password, PASSWORD_BCRYPT); // Secure password hashing
    }

    // Prepare the INSERT query
    $stmt = $conn->prepare("INSERT INTO cab_list (reg_code, category_id, cab_reg_no, body_no, cab_model, cab_driver, driver_contact, driver_address, password, image_path, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters
    $stmt->bind_param("sisssssssss", $reg_code, $category_id, $cab_reg_no, $body_no, $cab_model, $cab_driver, $driver_contact, $driver_address, $password, $image_path, $status);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo json_encode(array('status' => 'success', 'message' => 'Cab successfully added.'));
    } else {
        echo json_encode(array('status' => 'failed', 'message' => 'Error occurred: ' . $stmt->error));
    }

    // Close the statement
    $stmt->close();
}

// Display the form
?>

<style>
    #cimg {
        width: 15vw;
        height: 20vh;
        object-fit: scale-down;
        object-position: center center;
    }
</style>
<div class="card card-outline card-purple rounded-0">
    <div class="card-header">
        <h3 class="card-title"><?php echo isset($id) ? "Update " : "Create New "; ?> Cab</h3>
    </div>
    <div class="card-body">
        <form action="" id="cab-form" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
            <div class="form-group">
                <label for="reg_code" class="control-label">Registration Code</label>
                <input name="reg_code" id="reg_code" type="text" class="form-control rounded-0" value="<?php echo isset($reg_code) ? $reg_code : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="type_id" class="control-label">Category</label>
                <select name="type_id" id="type_id" class="custom-select select2" required>
                    <option value="" <?= !isset($type_id) ? "selected" : ""; ?> disabled></option>
                    <?php 
                    $types = $conn->query("SELECT * FROM category_list WHERE delete_flag = 0 " . (isset($type_id) ? " OR id = '{$type_id}'" : "") . " ORDER BY `type` ASC ");
                    while ($row = $types->fetch_assoc()):
                    ?>
                    <option value="<?= $row['id']; ?>" <?= isset($type_id) && $type_id == $row['id'] ? "selected" : ""; ?>>
                        <?= $row['type']; ?> <?= $row['delete_flag'] == 1 ? "<small>Deleted</small>" : ""; ?>
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="cab_reg_no" class="control-label">Plate #/Vehicle Reg #</label>
                <input name="cab_reg_no" id="cab_reg_no" type="text" class="form-control rounded-0" value="<?php echo isset($cab_reg_no) ? $cab_reg_no : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="cab_model" class="control-label">Vehicle Model</label>
                <input name="cab_model" id="cab_model" type="text" class="form-control rounded-0" value="<?php echo isset($cab_model) ? $cab_model : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="body_no" class="control-label">Cab's Body #</label>
                <input name="body_no" id="body_no" type="text" class="form-control rounded-0" value="<?php echo isset($body_no) ? $body_no : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="cab_driver" class="control-label">Driver Name</label>
                <input name="cab_driver" id="cab_driver" type="text" class="form-control rounded-0" value="<?php echo isset($cab_driver) ? $cab_driver : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="driver_contact" class="control-label">Driver's Contact #</label>
                <input name="driver_contact" id="driver_contact" type="text" class="form-control rounded-0" value="<?php echo isset($driver_contact) ? $driver_contact : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="driver_address" class="control-label">Driver's Address</label>
                <textarea name="driver_address" id="driver_address" class="form-control rounded-0" required><?php echo isset($driver_address) ? $driver_address : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="password" class="control-label">Driver's Account Password</label>
                <div class="input-group">
                    <input name="password" id="password" type="password" class="form-control rounded-0" <?php echo !isset($password) ? 'required' : ''; ?>>
                    <div class="input-group-append">
                        <button class="btn btn-outline-default pass_view" type="button"><i class="fa fa-eye-slash"></i></button>
                    </div>
                </div>
                <small class="text-muted"><i>Leave this field blank if you don't wish to update the driver's account password.</i></small>
            </div>
            <div class="form-group col-md-6">
                <label for="" class="control-label">Driver's Image</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this, $(this))">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>
            <div class="form-group col-md-6 d-flex justify-content-center">
                <img src="<?php echo validate_image(isset($image_path) ? $image_path : ""); ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
            </div>
            <div class="form-group">
                <label for="status" class="control-label">Status</label>
                <select name="status" id="status" class="custom-select select2">
                    <option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : ''; ?>>Active</option>
                    <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-sm rounded-0" type="submit">Submit</button>
                <button class="btn btn-danger btn-sm rounded-0" type="button" onclick="$('#cab-form').get(0).reset();">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Show or hide the password
    $('.pass_view').click(function(){
        const input = $('#password');
        const type = input.attr('type') === 'password' ? 'text' : 'password';
        input.attr('type', type);
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });

    function displayImg(input, elem) {
        const img = $('#cimg');
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = function (e) {
            img.attr('src', e.target.result);
        }
        reader.readAsDataURL(file);
    }
</script>
