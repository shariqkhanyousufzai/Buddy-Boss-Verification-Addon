<?php
error_reporting(0);

if(isset($_POST['action']) && $_POST['action'] == 'verify_by_member'){
	global $wpdb;
	$member_id = $_POST['member_id'];
	$current_user = get_current_user_id();

	$get_user_info_email = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."users where ID = ".$member_id." limit 1")[0];
	
	$email_user = $get_user_info_email->user_email;
	$emailnick = $get_user_info_email->user_nicename;
	
	$table_name = $wpdb->prefix."buddybossextend_userverify_members";
		$wpdb->insert($table_name, array(
		    'user_id' => $member_id,
		    'verify_by_members' => $current_user,
		));

	sendmail_verify($email_user,'User Verify','The user with username '.$emailnick.' Verify You');
	$redirectUrl = $_POST['redirect'];
	header("Location: " . $redirectUrl);
	exit();
	

}

if(isset($_POST['action']) && $_POST['action'] == 'un_verify_by_member'){
	global $wpdb;
	$member_id = $_POST['member_id'];
	$current_user = get_current_user_id();
	
	$get_user_info_email = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."users where ID = ".$member_id." limit 1")[0];
	
	$email_user = $get_user_info_email->user_email;
	$emailnick = $get_user_info_email->user_nicename;

	$table_name = $wpdb->prefix."buddybossextend_userverify_members";
    $table = 'eLearning_progress';
    $wpdb->delete( $table_name, array( 'user_id' => $member_id,'verify_by_members' => $current_user ) );

    sendmail_verify($email_user,'User Unverify','The user with username '.$emailnick.' Unverify You');
    $redirectUrl = $_POST['redirect'];
	header("Location: " . $redirectUrl);
	exit();


}
// quries end


function sendmail_verify($to,$subj,$msg){
	$to = $to;
	// $to = 'hackbaby1996@gmail.com';
	$subject = $subj;
	$message = '<html><body>';
	$message .= '<h1>Hello!</h1>';
	$message .= '<p>'.$msg.'</p>';
	$message .= '</body></html>';

	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= 'From: Swinging Rabbits <alice@swingingrabbits.com>' . "\r\n";
	

	mail($to, $subject, $message, $headers);

}


$get_user_info_member_count = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."buddybossextend_userverify_members where user_id ='".$curr_member_id."' ");
// if(count($get_user_info_member_count) < $default_count){
	if($verify_by_admin == 0){
		global $wpdb;
		$get_user_info_member = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."buddybossextend_userverify_members where user_id ='".$curr_member_id."' AND verify_by_members = '".get_current_user_id()."' ");
		if(empty($get_user_info_member)){
			?>
			<script type="text/javascript" src="<?php echo site_url() ?>/wp-includes/js/jquery/jquery.min.js"></script>
			<script type="text/javascript">
				jQuery(document).ready(function($){
					var getIsConnected = jQuery('.is_friend').length;
					if(getIsConnected > 0){
						$('.bp-user .member-header-actions').append(`
						<form style="display: inline-block;" method="post" action="#">
						<button type="submit" style="border:unset; padding-top: 9px;padding-bottom: 9px;" id="verify_member" class="generic-button">Verify Member</button>
						<input type="hidden" name="member_id" value="<?php echo $curr_member_id ?>" />
						<input type="hidden" name="action" value="verify_by_member" />
						<input type="hidden" name="redirect" value="${window.location.href}" />
						</form>`);
					}
					
				})
			</script>
			<?php
		}else{
			?>
			<script type="text/javascript" src="<?php echo site_url() ?>/wp-includes/js/jquery/jquery.min.js"></script>
			<script type="text/javascript">
				jQuery(document).ready(function($){
					var getIsConnected = jQuery('.is_friend').length;
					if(getIsConnected > 0){
						$('.bp-user .member-header-actions').append(`
						<form style="display: inline-block;" method="post" action="#">
						<button type="submit" style="background:#000;border:unset; padding-top: 9px;padding-bottom: 9px;" class="generic-button">Unverify User</button>
						<input type="hidden" name="member_id" value="<?php echo $curr_member_id ?>" />
						<input type="hidden" name="action" value="un_verify_by_member" />
						<input type="hidden" name="redirect" value="${window.location.href}" />
						</form>`);
					}
					
				})
			</script>
			<?php
		}
		?>
		<?php
	}
// }



// wp_new_user_notification(22,null,'HEY');
