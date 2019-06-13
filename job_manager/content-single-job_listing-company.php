<?php
/**
 * Single view Company information box
 *
 * Hooked into single_job_listing_start priority 30
 *
 * This template can be overridden by copying it to yourtheme/job_manager/content-single-job_listing-company.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager
 * @category    Template
 * @since       1.14.0
 * @version     1.28.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! get_the_company_name() ) {
	return;
}
global $job_manager;
global $post;
global $wpdb;
?>

<?php 
$project_id = (string) (get_the_ID());
$results = $wpdb->get_results( "SELECT userid FROM " .$wpdb->prefix . "SignUpProject WHERE projectid = '$project_id'");
?>

<div class="company">
	<?php echo "Minimum Group size:&nbsp;"; ?> 
	<?php the_company_name( '<strong>', '</strong>' ); ?>
	<?php echo "<br>Signed-up Users:";
	foreach($results as $result ) {
	$user_info = get_user_by('login',$result->userid);
	if ( ! empty( $user_info ) ){
	$user_role= implode(',', $user_info->roles);
	echo " <a href='http://www.projedemy.org/user/".$result->userid."'>$result->userid: $user_role</a>&nbsp ";
	}
	} 
	echo "<br>";
	?>
	<p class="name">
		<?php if ( $website = get_the_company_website() ) : ?>
			<a class="website" href="<?php echo esc_url( $website ); ?>" target="_blank" rel="nofollow"><?php _e( 'Project External Link', 'wp-job-manager' ); ?></a>
		<?php endif; ?>
		<?php the_company_twitter(); ?>
		
		
	</p>
	<?php echo "Project Deadline:&nbsp;"; ?>
	<?php echo get_the_project_deadline(); ?>
	<?php the_company_tagline( '<p class="tagline">', '</p>' ); ?>
	<?php the_company_video(); ?>
</div>