<?php
global $wpdb;


$get_member_logs = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."buddybossextend_userverify_members order by id desc");


function getUserNameById($id){
	global $wpdb;
	$getUserNameById = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."users where ID = $id ");
	return $getUserNameById[0]->user_nicename;
}

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
</style>
<div class="container-fluid" style="margin-top: 20px">
	<div class="row">
		<div class="col-sm-12 mt-5">
			<table class="table table-light" id="managertable_member" class="display" style="width:100%;margin-top: 20px">
			   			<thead>
			   				<tr>
			   					<th>s.no</th>
			   					<th>Member Verified</th>
			   					<th>Member Verified By</th>
			   					<th>Status</th>
			   					<th>Date</th>
			   				</tr>
			   			</thead>
			   			<tbody>
			   				<?php
			   				$x = 1;
			   				foreach($get_member_logs as $get_member_log){
			   					$getUserName_1 = getUserNameById($get_member_log->user_id);
			   					$getUserName_2 = getUserNameById($get_member_log->verify_by_members );
			   				?>
			   				 <tr>
			   					<td><?php echo $x  ?></td>
			   					<td><?php echo $getUserName_1  ?></td>
			   					<td><?php echo $getUserName_2  ?></td>
			   					<td><div class="badge badge-success ">Verified</div></td>
			   					<td><?php echo $get_member_log->created_on ?></td>
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