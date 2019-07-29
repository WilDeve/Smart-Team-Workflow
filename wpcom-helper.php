<?php
/**
 * Ensure Smart Team Workflow is instantiated
 */
add_action( 'after_setup_theme', 'stworkflow' );

/**
 * Don't load caps on install for WP.com. Instead, let's add
 * them with the WP.com + core caps approach
 */
add_filter( 'stworkflow_kill_add_caps_to_role', '__return_true' );
add_filter( 'stworkflow_view_calendar_cap', function() { return 'edit_posts'; } );
add_filter( 'stworkflow_view_story_budget_cap', function() { return 'edit_posts'; } );
add_filter( 'stworkflow_edit_post_subscriptions_cap', function() { return 'edit_others_posts'; } );
add_filter( 'stworkflow_manage_usergroups_cap', function() { return 'manage_options'; } );

/**
 * Smart Team Workflow loads elements after plugins_loaded, which has already been fired on WP.com
 * Let's run the method at after_setup_themes
 */
add_filter( 'after_setup_theme', 'st_workflow_wpcom_load_elements' );
function st_workflow_wpcom_load_elements() {
	global $st_workflow;
	if ( method_exists( $st_workflow, 'action_stworkflow_loaded_load_elements' ) ) {
		$st_workflow->action_stworkflow_loaded_load_elements();
	}
}

/**
 * Share A Draft on WordPress.com breaks when redirect canonical is enabled
 * get_permalink() doesn't respect custom statuses
 *
 * @see http://core.trac.wordpress.org/browser/tags/3.4.2/wp-includes/canonical.php#L113
 */
add_filter( 'redirect_canonical', 'st_workflow_wpcom_redirect_canonical' );
function st_workflow_wpcom_redirect_canonical( $redirect ) {

	if ( ! empty( $_GET['shareadraft'] ) ) {
		return false;
	}

	return $redirect;
}

// This should fix a caching race condition that can sometimes create a published post with an empty slug
add_filter( 'stworkflow_fix_post_name_post', 'st_workflow_fix_fix_post_name' );
function st_workflow_fix_fix_post_name( $post ) {
	global $wpdb;
	$post_status = $wpdb->get_var( $wpdb->prepare( 'SELECT post_status FROM ' . $wpdb->posts . ' WHERE ID = %d', $post->ID ) );
	if ( null !== $post_status ) {
		$post->post_status = $post_status;
	}

	return $post;
}