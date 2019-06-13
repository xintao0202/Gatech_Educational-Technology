<?php

	wp_enqueue_script('my-ajax-request', admin_url('admin-ajax.php'), array('jquery'));
	wp_localize_script('my-ajax-request', 'MyAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
	global $wpdb;
	$table_name = $wpdb->prefix . 'SignUpProject';
	$userid = $_REQUEST['username'];
	$projectid = $_REQUEST['projectid'];
	echo "$userid is Signed-Up for project $projectid";
	$wpdb->insert( 
		$table_name, 
		array( 
			'userid' => $userid, 
			'projectid' => $projectid, 
		)

 
	); 

?>
