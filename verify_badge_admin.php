<?php
error_reporting(0);
if(isset($getUserProfile)){
    $get_user_info = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."users where user_nicename = '".$getUserProfile."' ");
    $get_user_info_own = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."users where user_nicename = '".$getUserProfile_Own."' ");

    if (isset($get_user_info) && !empty($get_user_info)) {
        $profile_userId = $get_user_info[0]->ID;
        $curr_member_id = $profile_userId;
        $get_user_verify = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."buddybossextend_userverify where user_id = '".$profile_userId."' ");
        if (isset($get_user_verify) && !empty($get_user_verify)) {
            if($get_user_verify[0]->verify_by_admin == 1){
            	$verify_by_admin = 1;
                ?>
                <style type="text/css">
                    h2.user-nicename.verify_badge:after {
                        content: '';
                        position: relative;
                        height: 30px;
                        width: 30px;
                        background: url(https://ik.imagekit.io/mvdx4cwsf/verifybadge.png?updatedAt=1683406245859);
                          background-repeat: repeat;
                          background-size: auto;
                        background-size: 100%;
                        background-repeat: no-repeat;
                        top: 3px;
                        right: -11px;
                        display: inline-block;
                    }
                    .verify_badge{
                        cursor: pointer;
                    }
                    a.bb_more_options_action {
                        padding: 18px !important;
                    }
                </style>
                <script type="text/javascript" src="<?php echo site_url() ?>/wp-includes/js/jquery/jquery.min.js"></script>
                <script type="text/javascript">
                    // https://ik.imagekit.io/mvdx4cwsf/verifybadge.png?updatedAt=1683406245859
                    jQuery(document).ready(function($){
                        $('.bp-user .user-nicename').addClass('verify_badge');
                        $('.bp-user .user-nicename').attr('title','Verified By Admin');
                    });
                </script>
                <?php
            }
        }
    }else if(isset($get_user_info_own) && !empty($get_user_info_own)){
        $profile_userId = $get_user_info_own[0]->ID;
        $curr_member_id = $profile_userId;
        $get_user_verify = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."buddybossextend_userverify where user_id = '".$profile_userId."' ");
        if (isset($get_user_verify) && !empty($get_user_verify)) {
            if($get_user_verify[0]->verify_by_admin == 1){
            	$verify_by_admin = 1;
                ?>
                <style type="text/css">
                    h2.user-nicename.verify_badge:after {
                        content: '';
                        position: relative;
                        height: 30px;
                        width: 30px;
                        background: url(https://ik.imagekit.io/mvdx4cwsf/verifybadge.png?updatedAt=1683406245859);
                          background-repeat: repeat;
                          background-size: auto;
                        background-size: 100%;
                        background-repeat: no-repeat;
                        top: 3px;
                        right: -11px;
                        display: inline-block;
                    }
                    .verify_badge{
                        cursor: pointer;
                    }
                    a.bb_more_options_action {
                        padding: 18px !important;
                    }
                </style>
                <script type="text/javascript" src="<?php echo site_url() ?>/wp-includes/js/jquery/jquery.min.js"></script>
                <script type="text/javascript">
                    // https://ik.imagekit.io/mvdx4cwsf/verifybadge.png?updatedAt=1683406245859
                    jQuery(document).ready(function($){
                        $('.bp-user .user-nicename').addClass('verify_badge');
                        $('.bp-user .user-nicename').attr('title','Verified By Admin');
                    });
                </script>
                <?php
            }
        }
    }

    if (isset($get_user_info) && !empty($get_user_info)) {
        $profile_userId = $get_user_info[0]->ID;
        $get_user_info_member_count_badge = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."buddybossextend_userverify_members where user_id ='".$profile_userId."' ");
    }else if (isset($get_user_info_own) && !empty($get_user_info_own)) {
        $profile_userId = $get_user_info_own[0]->ID;
        $get_user_info_member_count_badge = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."buddybossextend_userverify_members where user_id ='".$profile_userId."' ");
    }

    if(count($get_user_info_member_count_badge) >= $default_count){
        $WhoUsers = [];
        foreach ($get_user_info_member_count_badge as $get_user_info_member_count_badg) {
            $get_user_info_email = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."users where ID = ".$get_user_info_member_count_badg->verify_by_members." limit 1")[0];

            array_push($WhoUsers, $get_user_info_email->user_nicename);
        }

        $WhoUsers_json = json_encode($WhoUsers);
        ?>
        <style type="text/css">
            h2.user-nicename.verify_badge:after {
                content: '';
                position: relative;
                height: 30px;
                width: 30px;
                background: url(https://ik.imagekit.io/mvdx4cwsf/verifybadge.png?updatedAt=1683406245859);
                  background-repeat: repeat;
                  background-size: auto;
                background-size: 100%;
                background-repeat: no-repeat;
                top: 3px;
                right: -35px;
                display: inline-block;
            }
            .verify_badge{
                        cursor: pointer;
                    }
        </style>
        <script type="text/javascript" src="<?php echo site_url() ?>/wp-includes/js/jquery/jquery.min.js"></script>
        <script type="text/javascript">

            // https://ik.imagekit.io/mvdx4cwsf/verifybadge.png?updatedAt=1683406245859
            jQuery(document).ready(function($){
                var getCountMember = '<?php echo count($get_user_info_member_count_badge) ?>';
                var allWhoMember = '<?php echo $WhoUsers_json ?>';
                var allWhoMember_Json = JSON.parse(allWhoMember);
                var Who_HTML = `<div class="group-separator-block" bis_skin_checked="1">
                <header class="entry-header profile-loop-header profile-header flex align-items-center">
                <h1 class="entry-title bb-profile-title">Verified By</h1>
                </header>
                <div class="bp-widget details" bis_skin_checked="1">
                <table class="profile-fields bp-tables-user">
                <tbody>`;
                var countNum = 1;
                for(i in allWhoMember_Json){
                    Who_HTML += `<tr class="field_3 field_nickname field_order_0 required-field visibility-public field_type_textbox">
                        <td class="label">${countNum}</td>
                        <td class="data"><p>${allWhoMember_Json[i]}</p>
                        </td>
                        </tr>`;
                    countNum++;
                }
                Who_HTML += `</tbody></table>
                            </div>
                            </div>`;
                $('.bp-profile-content .profile.public').append(Who_HTML);
                $('.bp-user .user-nicename').addClass('verify_badge');
                $('.bp-user .user-nicename').attr('title','Verified By '+getCountMember+' Members');
            });
        </script>
        <?php
    }
   
}

