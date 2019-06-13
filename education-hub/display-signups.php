<?php

/*

Template Name: Display SignUps

*/

?>

<?php

 $current_user = wp_get_current_user();
 $username = $current_user->user_login;
//$username = mysql_real_escape_string($username );

global $wpdb;
 
$result = $wpdb->get_results( "SELECT projectid FROM " .$wpdb->prefix . "SignUpProject WHERE userid = '$username'");


$projectid=[];
foreach($result as $result ) {
     $projectid[]=$result->projectid;
} 

$projects = $wpdb->get_results( "SELECT post_title, post_name FROM wp_posts WHERE ID IN (".implode(',',$projectid).")");
 
foreach($projects as $projects ) {
	
	echo " <br> <a href='http://www.projedemy.org/project/".$projects->post_name."'>$projects->post_title</a> <br>";
 }
?>