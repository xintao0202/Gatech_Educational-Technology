<?php
/*
Plugin Name: SignUpProject
Plugin URI: http://projedemy.org
Description: To sign up a project 
Version: 1.0
Author: Xin Tao
Author URI: http://projedemy.org
*/
?>
<?php
// Create a table once plugin is activated
register_activation_hook( __FILE__, 'SignUpProject_create_db' );
function SignUpProject_create_db() {
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'SignUpProject';

	$sql = "CREATE TABLE $table_name (
		`userid` VARCHAR(50) NOT NULL ,
		`projectid` VARCHAR(50) NOT NULL ,
		PRIMARY KEY (`userid`, `projectid`)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}
// insert data into table
function SignUpProject_insert_db($userid, $projectid) {
	global $wpdb;
	
	$table_name = $wpdb->prefix . 'SignUpProject';
	
	$wpdb->insert( 
		$table_name, 
		array( 
			'userid' => $userid, 
			'projectid' => $projectid, 
		) 
	);
}

// [Signup_insert_db userid="user00" projectid="proj00" ]

function Signup_insert_db_func( $atts ) {
    $a = shortcode_atts( array(
        'userid' => 'user00',
        'projectid' => 'proj00',
    ), $atts );

    return SignUpProject_insert_db($a['userid'], $a['projectid']);
}
add_shortcode( 'Signup_insert_db', 'Signup_insert_db_func' );
?>