<?php
global $wpdb;

if(isset($_GET['action']) && $_GET['action'] == 'verify_now'){
	$user_id = $_GET['user_id'];
	$get_user_info = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."buddybossextend_userverify where user_id = ".$user_id." ");
	if(isset($get_user_info) && !empty($get_user_info)){
		$table_name = $wpdb->prefix."buddybossextend_userverify";
		$wpdb->query($wpdb->prepare("UPDATE $table_name SET verify_by_admin=1 WHERE user_id=$user_id"));
	}else{
		$table_name = $wpdb->prefix."buddybossextend_userverify";
		$wpdb->insert($table_name, array(
		    'user_id' => $user_id,
		    'verify_by_admin' => '1',
		));
	}
}


if(isset($_GET['action']) && $_GET['action'] == 'unverify_now'){
	$user_id = $_GET['user_id'];
	$wpdb->query($wpdb->prepare("DELETE FROM ".$wpdb->prefix."buddybossextend_userverify_members where user_id = ".$user_id." "));
	$get_user_info = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."buddybossextend_userverify where user_id = ".$user_id." ");
	if(isset($get_user_info) && !empty($get_user_info)){
		$table_name = $wpdb->prefix."buddybossextend_userverify";
		$wpdb->query($wpdb->prepare("UPDATE $table_name SET verify_by_admin=0 WHERE user_id=$user_id"));
	}else{
		$table_name = $wpdb->prefix."buddybossextend_userverify";
		$wpdb->insert($table_name, array(
		    'user_id' => $user_id,
		    'verify_by_admin' => '0',
		));
	}
}

global $wpdb;

$get_count_db = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."buddybossextend_userverify_members_count order by id desc limit 1");

$default_count = 3;
if(isset($get_count_db) && !empty($get_count_db)){
    $default_count = $get_count_db[0]->count;
}


$subscribers = get_users([ 'role__in' => [ 'subscriber', 'administrator', 'author' ]]);
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" type="text/css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css" type="text/css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<style type="text/css">
	td,th{
		text-align: center;	
	}
	#adminmenuwrap{
		margin: 0px !important;
	}
	[data-action="verify_now"],[data-action="unverify_now"] {
	    font-size: 12px !important;
	    padding: 2px 11px !important;
	}
</style>
<div class="container-fluid" style="margin-top: 20px">
	<div class="row">
		<div class="col-sm-12 mt-5">
			<table id="managertable" class="display" style="width:100%;margin-top: 20px">
			   			<thead>
			   				<tr>
			   					<th>s.no</th>
			   					<th>User Email</th>
			   					<th>Username</th>
			   					<th>Status</th>
			   					<th>Action</th>
			   				</tr>
			   			</thead>
			   			<tbody>
			   				<?php
			   				$x = 1;
			   				foreach ( $subscribers as $subscriber) {
			   					$get_user_info = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."buddybossextend_userverify where user_id = ".$subscriber->ID." And verify_by_admin != '' order by id desc limit 1")[0];

			   					$get_verify_badge_count = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."buddybossextend_userverify_members where user_id ='".$subscriber->ID."' ");
			   					?>
			   					<tr>
			   						<td><?=$x?></td>
			   						<td><?=$subscriber->user_email?></td>
			   						<td><?=$subscriber->user_nicename?></td>
			   						<?php
			   						if(isset($get_user_info) && !empty($get_user_info) && $get_user_info->verify_by_admin == 1){
			   							?>
			   							<td>
			   								<div class="badge badge-success ">Verified</div>
			   							</td>
			   							<?php
			   						}else if(count($get_verify_badge_count) >= $default_count){
			   							?>
			   							<td>
			   								<div class="badge badge-warning ">Verified By Members (<?= count($get_verify_badge_count) ?> Members)</div>
			   							</td>
			   							<?php
			   						}else 
			   						{
			   							?>
			   							<td>
			   								<div class="badge badge-danger ">Not Verified</div>
			   							</td>
			   							<?php
			   						}
			   						?>

			   						<?php
			   						if(isset($get_user_info) && !empty($get_user_info)  && $get_user_info->verify_by_admin == 1){
			   							?>
			   							<td>
			   								<button class="btn btn-sm btn-danger unverify_user" data-action="unverify_now" data-userid="<?=$subscriber->ID?>">Unverify Now</button>
			   							</td>
			   							<?php
			   						}else if(count($get_verify_badge_count) >= $default_count){
			   							?>
			   							<td>
			   								<button class="btn btn-sm btn-danger unverify_user" data-action="unverify_now" data-userid="<?=$subscriber->ID?>">Unverify Now</button>
			   							</td>
			   							<?php
			   						}else{
			   							?>
			   							<td>
			   								<button class="btn btn-sm btn-success verify_user" data-action="verify_now" data-userid="<?=$subscriber->ID?>">Verify Now</button>
			   							</td>
			   							<?php
			   						}
			   						?>
			   					</tr>
			   					<?php
			   					$x++;
			   				}
			   				?>
			   			</tbody>
			   		</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$('#managertable').DataTable({
				        dom: 'Bfrtip',
				        buttons: [
				            'copyHtml5',
				            'excelHtml5',
				            'csvHtml5',
				            'pdfHtml5'
				        ]
				    } );

		$(document).on('click','.verify_user',function(){
			getUserId = $(this).attr('data-userid');
			getAction = $(this).attr('data-action');
			window.location.href = '<?=site_url()?>/wp-admin/admin.php?page=buddyboss_users&user_id='+getUserId+'&action='+getAction
		});

		$(document).on('click','.unverify_user',function(){
			getUserId = $(this).attr('data-userid');
			getAction = $(this).attr('data-action');
			window.location.href = '<?=site_url()?>/wp-admin/admin.php?page=buddyboss_users&user_id='+getUserId+'&action='+getAction
		});
	})
</script>