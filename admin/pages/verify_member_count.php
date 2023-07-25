<?php
global $wpdb;

if(isset($_POST['action']) && $_POST['action'] == 'verify_count_save'){
	$table_name = $wpdb->prefix."buddybossextend_userverify_members_count";
	$wpdb->insert($table_name, array(
	    'count' => $_POST['verify_count'],
	));
}


$get_count_db = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."buddybossextend_userverify_members_count order by id desc limit 1");

$default_count = 3;
if(isset($get_count_db) && !empty($get_count_db)){
    $default_count = $get_count_db[0]->count;
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
			<form action="#" method="post">
				<div class="row">
					<div class="col-sm-12">
						<h2>
							Set Verify Member Count Condition
						</h2>
					</div>
					<div class="col-sm-6">
						<input type="number" name="verify_count" class="form-control" value="<?php echo $default_count?>">
						<small>default count is 3</small>
						<input type="hidden" name="action" value="verify_count_save">
					</div>
					<div class="col-sm-3">
						<button class="btn btn-dark">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>