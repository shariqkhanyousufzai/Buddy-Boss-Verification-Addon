<?php

add_action('admin_menu', 'buddboss_extent_adminmenu');
function buddboss_extent_adminmenu(){
    add_menu_page('Buddy Boss Extend', 'Buddy Boss Extend', '', 'my-menu', 'buddyboss_users', 'dashicons-media-spreadsheet' );
    add_submenu_page('my-menu', 'Submenu', 'All Users', 'manage_options', 'buddyboss_users', 'buddyboss_users');
    add_submenu_page('my-menu', 'Submenu', 'Member Verify Log', 'manage_options', 'verify_member_log', 'verify_member_log');
    add_submenu_page('my-menu', 'Submenu', 'Verify Member Count', 'manage_options', 'verify_member_count', 'verify_member_count');
}

function buddyboss_users(){
	include_once(ABSPATH . 'wp-content/plugins/buddyboss-extend/admin/pages/allusers.php');
}

function verify_member_count(){
	include_once(ABSPATH . 'wp-content/plugins/buddyboss-extend/admin/pages/verify_member_count.php');
}

function verify_member_log(){
	include_once(ABSPATH . 'wp-content/plugins/buddyboss-extend/admin/pages/verify_member_log.php');
}