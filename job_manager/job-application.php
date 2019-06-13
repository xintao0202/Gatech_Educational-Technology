<?php
/**
 * Show job application when viewing a single job listing.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-application.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager
 * @category    Template
 * @version     1.16.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! is_admin() ) {
    require_once( ABSPATH . 'wp-admin/includes/post.php' );
}

global $job_manager;
global $post;
global $wpdb;

?>

<?php
$slug=wpjm_get_the_job_title();
$slug=strtolower($slug);
$slug=str_replace(' ','-',$slug);
?>
<?php $project_id = (string) (get_the_ID());?>
<?php $current_user = wp_get_current_user();?>
<?php $username = $current_user->user_login;?>
<?php $field = "display_name";?>
<?php $authorname=get_the_author_name($field); ?>
<?php $role=$current_user->roles;?>
<?php $project_title=wpjm_get_the_job_title();?>


<!-- Learning goal part below -->
<?php 
$postid= post_exists( $title=$project_title." learning goal", $content, $date); 
?>
 

<?php if ( !has_tag("learning-goal",$post=$postid) and ((implode(', ', $role)=='instructor')or (implode(', ', $role)=='expert'))) : ?>
 <div>
     <p>
	<style> 
	input[type=button] {
    	background-color: #20B2AA;
    	border-radius: 12px;
    	color: white;
    	padding: 10px 32px;
    	text-decoration: none;
    	margin: 4px 2px;
    	cursor: pointer;
	box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
	}
	.button2 {background-color: #FF6347;} 
	</style>
	<form>
	<input type="button" value="learning goal" onclick="window.location.href='http://projedemy.org/learning-goal/'" />
</form>
     </p>
</div>
<?php else : ?>
	<p>
	<div><h4><?php echo "Learning goal";?></h4></div>
	<?php 
	if ($postid!=0){
	echo do_shortcode("[display-posts id=$postid tag='learning-goal']"); 
	}?>
	</p>
<?php endif; ?>

<hr>

<?php
$result = $wpdb->get_results( "SELECT projectid FROM " .$wpdb->prefix . "SignUpProject WHERE userid = '$username' AND projectid ='$project_id'");
$existence=count($result);
?>


<html>
        <head>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>            
	<script type="text/javascript">
			
                        function signup() {
			var username=<?php echo(json_encode($username)); ?>;
			var projectid=<?php echo(json_encode($project_id)); ?>;
			//var myData={"username":username,"projectid":projectid}
                        
			$.ajax({
    				cache: false,
				timeout: 8000,
				url : php_array.admin_ajax,
				type: "POST",
    				data : ({action:'single',"username":username,"projectid":projectid}),
				success: function(result){ // Show returned data using the function.
				alert(result);
				}
				});                   
		 
                }
		
	
            </script>
		<body><p id="exist"><button class="button button2" onclick='signup()'>Sign Up for this Project!</button></p></body>
	     <script type="text/javascript">
		var existence=parseInt(<?php echo(json_encode($existence)); ?>);
		if (existence>0) {
 			 document.getElementById("exist").innerHTML = "<span style='color: red;'>You already signed-up for this project</span>";			
			}
	     </script>

        </head>
    </html>


<h4><?php echo "Project Breakdowns";?></h4>



<?php if ($username == $authorname) : ?>
	<form>
	<input type="button" value="Add Breakdowns" onclick="window.location.href='http://projedemy.org/index.php/add-breakdowns/'" />
	</form>
<?php else : ?>
	<?php echo "You don't have permission to add breakdowns"; ?>
<?php endif; ?> 

<?php echo do_shortcode("[display-posts tag=$slug include_excerpt='true' order='ASC']"); ?>


<!-- Assessment part below -->
<?php 
$postid= post_exists( $title=$project_title." assessment", $content, $date); 
?>
 


<?php if ( !has_tag("assessment",$post=$postid) and (implode(', ', $role)=='instructor')) : ?>
 <div>
     <p>
	<form>
	<input type="button" value="Assessment" onclick="window.location.href='http://projedemy.org/assessment/'" />
	</form>
     </p>
</div>
<?php else : ?>
	<p>
	<div><h4><?php echo "Assessment and Status";?></h4></div>
	<?php 
	if ($postid!=0){
	echo do_shortcode("[display-posts id=$postid tag='assessment']"); 
	}?>
	</p>
<?php endif; ?> 

<?php if ($project_title=="Online Project Based Learning Tool"):?>

<div class = "content-dir-item">
    <p><h4>Knowledge Graph</h4></p>
    <img src="http://projedemy.org/wp-content/uploads/2018/04/knowledge.JPG" alt="knowledge" width="800" height="600">
</div>
<?php endif; ?> 


 <?php  
function get_the_author_name( $field = '', $user_id = false ) {
    $original_user_id = $user_id;
 
    if ( ! $user_id ) {
        global $authordata;
        $user_id = isset( $authordata->ID ) ? $authordata->ID : 0;
    } else {
        $authordata = get_userdata( $user_id );
    }
 
    if ( in_array( $field, array( 'login', 'pass', 'nicename', 'email', 'url', 'registered', 'activation_key', 'status' ) ) )
        $field = 'user_' . $field;
 
    $value = isset( $authordata->$field ) ? $authordata->$field : '';
 
    /**
     * Filters the value of the requested user metadata.
     *
     * The filter name is dynamic and depends on the $field parameter of the function.
     *
     * @since 2.8.0
     * @since 4.3.0 The `$original_user_id` parameter was added.
     *
     * @param string   $value            The value of the metadata.
     * @param int      $user_id          The user ID for the value.
     * @param int|bool $original_user_id The original user ID, as passed to the function.
     */
    return apply_filters( "get_the_author_{$field}", $value );
}
 
;?>



