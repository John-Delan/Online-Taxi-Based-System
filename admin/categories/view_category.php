<?php
require_once('./../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `category_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k = $v;
        }
    }
}
?>
<style>
    #uni_modal .modal-footer{
        display:none;
    }
</style>
<div class="container-fluid">
    <dl>
        <dt class="text-muted"><b>Type</b></dt>
        <dd class="pl-4"><?= isset($type) ? $type : "" ?></dd>
        
        <dt class="text-muted"><b>Seater</b></dt>
        <dd class="pl-4"><?= isset($seater) ? $seater : '' ?></dd>
        
        <dt class="text-muted"><b>Cost</b></dt>
        <dd class="pl-4"><?= isset($cost) ? $cost : '' ?></dd>
        
        <dt class="text-muted"><b>Description</b></dt>
        <dd class="pl-4"><?= isset($description) ? $description : '' ?></dd>
        
        <dt class="text-muted"><b>Status</b></dt>
        <dd class="pl-4">
            <?php if(isset($status) && $status == 1): ?>
                <span class="badge badge-success px-3 rounded-pill">Active</span>
            <?php elseif(isset($status)): ?>
                <span class="badge badge-danger px-3 rounded-pill">Inactive</span>
            <?php else: ?>
                <span class="badge badge-secondary px-3 rounded-pill">Unknown</span>
            <?php endif; ?>
        </dd>
    </dl>
    <div class="clear-fix mb-3"></div>
    <div class="text-right">
        <button class="btn btn-dark bg-gradient-dark btn-flat" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
    </div>
</div>
