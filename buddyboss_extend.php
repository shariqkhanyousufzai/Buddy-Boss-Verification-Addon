<?php
/*
* Plugin Name: Buddyboss Extend
* Plugin URI: https://rudrastyh.com/woocommerce/payment-gateway-plugin.html
* Description: Extend version for verify
* Author: Buddyboss Rudrastyh
* Author URI: http://rudrastyh.com
* Version: 1.0.1
*/

/*
* This action hook registers our PHP class as a WooCommerce payment gateway
*/

require_once( ABSPATH . 'wp-load.php' );
error_reporting(0);




add_filter( 'login_redirect', 'kp_login_redirect', 10, 3 );

function kp_login_redirect( $redirect_to, $request, $user ) {
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {
        if ( in_array( 'subscriber', $user->roles )) {
             $redirect_to = 'https://swingingrabbits.com/news-feed';
        }
    }
    return $redirect_to;
}

// on activate plugin
function plugin_activate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'buddybossextend_userverify';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        user_id varchar(55) DEFAULT '' NOT NULL,
        verify_by_admin varchar(55) DEFAULT '0' NOT NULL,
        verify_by_members varchar(55) DEFAULT '0' NOT NULL,
        UNIQUE KEY id (id)
    ) $charset_collate;";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    $table_name_2 = $wpdb->prefix . 'buddybossextend_userverify_members';
    $sql_2 = "CREATE TABLE $table_name_2 (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        user_id varchar(55) DEFAULT '' NOT NULL,
        verify_by_members varchar(55) DEFAULT '0' NOT NULL,
        UNIQUE KEY id (id)
    ) $charset_collate;";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql_2 );


    $table_name_3 = $wpdb->prefix . 'buddybossextend_userverify_members_count';
    $sql_3 = "CREATE TABLE $table_name_3 (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        count varchar(55) DEFAULT '' NOT NULL,
        UNIQUE KEY id (id)
    ) $charset_collate;";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql_3 );

}
register_activation_hook( __FILE__, 'plugin_activate' );
include_once( ABSPATH . 'wp-includes/pluggable.php' );




// on activate plugin end
$verify_by_admin = 0;
$curr_member_id = 0;
global $wpdb;

$get_count_db = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."buddybossextend_userverify_members_count order by id desc limit 1");

$default_count = 3;
if(isset($get_count_db) && !empty($get_count_db)){
    $default_count = $get_count_db[0]->count;
}

$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$getUserProfile = $uriSegments[count($uriSegments) - 2];
$getUserProfile_Own = $uriSegments[count($uriSegments) - 3];

$get_user_info = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."users where user_nicename = '".$getUserProfile."' ");
$get_user_info_own = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."users where user_nicename = '".$getUserProfile_Own."' ");
include_once(ABSPATH . 'wp-content/plugins/buddyboss-extend/admin/menu.php');
include_once(ABSPATH . 'wp-content/plugins/buddyboss-extend/verify_badge_admin.php');
if(!empty($get_user_info_own) || !empty($get_user_info)){
    include_once(ABSPATH . 'wp-content/plugins/buddyboss-extend/verify_badge_by_member.php');
}







// Adding custom buttons on the Members loop
function test_add_button_in_members_loop() {

$has_verify_badge = 0;
global $wpdb;
$get_user_verify = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."buddybossextend_userverify WHERE user_id= '".bp_get_member_user_id()."' AND verify_by_admin = 1 ");
$get_count_db = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."buddybossextend_userverify_members_count order by id desc limit 1");

$default_count = 3;
if(isset($get_count_db) && !empty($get_count_db)){
    $default_count = $get_count_db[0]->count;
}

if(!empty($get_user_verify)){
    $has_verify_badge = 1;
}

$get_verify_badge_count = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."buddybossextend_userverify_members where user_id = '".bp_get_member_user_id()."'");

if(count($get_verify_badge_count) >= $default_count){
    $has_verify_badge = 1;
}

    if($has_verify_badge == 1){
        ?>
        <div class="member_verify"><img width="30px" src="https://ik.imagekit.io/mvdx4cwsf/verifybadge.png?updatedAt=1683406245859" /></div>
        <?php
    }
}
add_action( 'bp_member_members_list_item', 'test_add_button_in_members_loop' );




