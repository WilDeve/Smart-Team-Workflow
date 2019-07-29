<?php
/**
 * Ensure Smart Team Workflow is instantiated
 */
add_action( 'after_setup_theme', 'stworkflow' );

/**
 * Caps don't get loaded on install on VIP Go. Instead, let's add
 * them via filters.
 */
add_filter( 'stworkflow_kill_add_caps_to_role', '__return_true' );
add_filter( 'stworkflow_view_calendar_cap', function() {return 'edit_posts'; } );
add_filter( 'stworkflow_view_story_budget_cap', function() { return 'edit_posts'; } );
add_filter( 'stworkflow_edit_post_subscriptions_cap', function() { return 'edit_others_posts'; } );
add_filter( 'stworkflow_manage_usergroups_cap', function() { return 'manage_options'; } );

/**
 * Smart Team Workflow loads elements after plugins_loaded, which has already been fired when loading via wpcom_vip_load_plugins
 * Let's run the method at after_setup_themes
 */
add_filter( 'after_setup_theme', 'st_workflow_wpcom_load_elements' );
function st_workflow_wpcom_load_elements() {
	global $st_workflow;
	if ( method_exists( $st_workflow, 'action_stworkflow_loaded_load_elements' ) ) {
		$st_workflow->action_stworkflow_loaded_load_elements();
	}
}
