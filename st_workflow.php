<?php
/*
Plugin Name: Smart Team Workflow
Plugin URI: http://
Description: Remixing the WordPress admin for better editorial workflow options.
Author: Saad Geek
Version: 0.1
Author URI: http://

Copyright 2019 ,Saad Geek , Team Work .
*/

/**
 * Print admin notice regarding having an old version of PHP.
 *
 * @since 0.9
 */
function _stworkflow_print_php_version_admin_notice() {
	?>
	<div class="notice notice-error">
			<p><?php esc_html_e( 'Smart Team Workflow requires PHP 5.4+. Please contact your host to update your PHP version.', 'st-workflow' ); ?></p>
		</div>
	<?php
}

if ( version_compare( phpversion(), '5.4', '<' ) ) {
	add_action( 'admin_notices', '_stworkflow_print_php_version_admin_notice' );
	return;
}

// Define contants
define( 'ST_WORKFLOW_VERSION' , '0.9' );
define( 'ST_WORKFLOW_ROOT' , dirname(__FILE__) );
define( 'ST_WORKFLOW_FILE_PATH' , ST_WORKFLOW_ROOT . '/' . basename(__FILE__) );
define( 'ST_WORKFLOW_URL' , plugins_url( '/', __FILE__ ) );
define( 'ST_WORKFLOW_SETTINGS_PAGE' , add_query_arg( 'page', 'stworkflow-settings', get_admin_url( null, 'admin.php' ) ) );

// Core class
class st_workflow {

	// Unique identified added as a prefix to all options
	var $options_group = 'st_workflow_';
	var $options_group_name = 'st_workflow_options';

	/**
	 * @var STworkflow The one true STworkflow
	 */
	private static $instance;

	/**
	 * Main STworkflow Instance
	 *
	 * Insures that only one instance of STworkflow exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since STworkflow 0.7.4
	 * @staticvar array $instance
	 * @uses STworkflow::setup_globals() Setup the globals needed
	 * @uses STworkflow::includes() Include the required files
	 * @uses STworkflow::setup_actions() Setup the hooks and actions
	 * @see STworkflow()
	 * @return The one true STworkflow
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new st_workflow;
			self::$instance->setup_globals();
			self::$instance->setup_actions();
			// Backwards compat for when we promoted use of the $st_workflow global
			global $st_workflow;
			$st_workflow = self::$instance;
		}
		return self::$instance;
	}

	private function __construct() {
		/** Do nothing **/
	}

	private function setup_globals() {

		$this->elements = new stdClass();

	}

	/**
	 * Include the admin resources to Smart Team Workflow and dynamically load the elements
	 */
	private function load_elements() {

		// We use the WP_List_Table API for some of the table gen
		if ( !class_exists( 'WP_List_Table' ) )
			require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

		// Smart Team Workflow  base element
		require_once( ST_WORKFLOW_ROOT . '/admin/php/class-element.php' );

		// Smart Team Workflow Editor Compat trait
		require_once( ST_WORKFLOW_ROOT . '/admin/php/trait-block-editor-compatible.php' );

		// Scan the elements directory and include any elements that exist there
		$element_dirs = scandir( ST_WORKFLOW_ROOT . '/elements/' );
		$class_names = array();
		foreach( $element_dirs as $element_dir ) {
			if ( file_exists( ST_WORKFLOW_ROOT . "/elements/{$element_dir}/$element_dir.php" ) ) {
				include_once( ST_WORKFLOW_ROOT . "/elements/{$element_dir}/$element_dir.php" );

				// Try to load Gutenberg compat files
				if ( file_exists( ST_WORKFLOW_ROOT . "/elements/{$element_dir}/compat/block-editor.php" ) ) {
					include_once( ST_WORKFLOW_ROOT . "/elements/{$element_dir}/compat/block-editor.php" );
				}
				// Prepare the class name because it should be standardized
				$tmp = explode( '-', $element_dir );
				$class_name = '';
				$slug_name = '';
				foreach( $tmp as $word ) {
					$class_name .= ucfirst( $word ) . '_';
					$slug_name .= $word . '_';
				}
				$slug_name = rtrim( $slug_name, '_' );
				$class_names[$slug_name] = 'stworkflow_' . rtrim( $class_name, '_' );
			}
		}

		// Instantiate ST_Workflow_Element as $helpers for back compat and so we can
		// use it in this class
		$this->helpers = new stworkflow_element();

		// Other utils
		require_once( ST_WORKFLOW_ROOT . '/admin/php/util.php' );

		// Instantiate all of our classes onto the Smart Team Workflow object
		// but make sure they exist too
		foreach( $class_names as $slug => $class_name ) {
			if ( class_exists( $class_name ) ) {
				$this->$slug = new $class_name();
				$compat_class_name = "{$class_name}_Block_Editor_Compat";
				if ( class_exists( $compat_class_name ) ) {
					$this->$slug->compat = new $compat_class_name( $this->$slug, $this->$slug->get_compat_hooks() );
				}
			}
		}

		/**
		 * Fires after st_workflow has loaded all Smart Team Workflow internal elements.
		 *
		 * Plugin authors can hook into this action, include their own elements add them to the $st_workflow object
		 *
		 */
		do_action( 'st_workflow_elements_loaded' );

	}

	/**
	 * Setup the default hooks and actions
	 *
	 * @since SmartTeamWorkflow 0.7.4
	 * @access private
	 * @uses add_action() To add various actions
	 */
	private function setup_actions() {
		add_action( 'init', array( $this, 'action_init' ) );
		add_action( 'init', array( $this, 'action_init_after' ), 1000 );

		add_action( 'admin_init', array( $this, 'action_admin_init' ) );

		/**
		 * Fires after setup of all st_workflow actions.
		 *
		 * Plugin authors can hook into this action to manipulate the st_workflow class after initial actions have been registered.
		 *
		 * @param st_workflow $this The core smart team workflow class
		 */
		do_action_ref_array( 'stworkflow_after_setup_actions', array( &$this ) );
	}

	/**
	 * Inititalizes the smart team workflow!
	 * Loads options for each registered element and then initializes it if it's active
	 */
	function action_init() {

		load_plugin_textdomain( 'st-workflow', null, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		$this->load_elements();

		// Load all of the element options
		$this->load_element_options();

		// Load all of the elements that are enabled.
		// Elements won't have an options value if they aren't enabled
		foreach ( $this->elements as $mod_name => $mod_data )
			if ( isset( $mod_data->options->enabled ) && $mod_data->options->enabled == 'on' )
				$this->$mod_name->init();

		/**
		 * Fires after st_workflow has loaded all elements and element options.
		 *
		 * Plugin authors can hook into this action to trigger functionaltiy after all smart team workflow element's have been loaded.
		 *
		 */
		do_action( 'stworkflow_init' );
	}

	/**
	 * Initialize the plugin for the admin
	 */
	function action_admin_init() {

		// Upgrade if need be but don't run the upgrade if the plugin has never been used
		$previous_version = get_option( $this->options_group . 'version' );
		if ( $previous_version && version_compare( $previous_version, ST_WORKFLOW_VERSION, '<' ) ) {
			foreach ( $this->elements as $mod_name => $mod_data ) {
				if ( method_exists( $this->$mod_name, 'upgrade' ) )
						$this->$mod_name->upgrade( $previous_version );
			}
			update_option( $this->options_group . 'version', ST_WORKFLOW_VERSION );
		} else if ( !$previous_version ) {
			update_option( $this->options_group . 'version', ST_WORKFLOW_VERSION );
		}

		// For each element that's been loaded, auto-load data if it's never been run before
		foreach ( $this->elements as $mod_name => $mod_data ) {
			// If the element has never been loaded before, run the install method if there is one
			if ( !isset( $mod_data->options->loaded_once ) || !$mod_data->options->loaded_once ) {
				if ( method_exists( $this->$mod_name, 'install' ) )
					$this->$mod_name->install();
				$this->update_element_option( $mod_name, 'loaded_once', true );
			}
		}

		$this->register_scripts_and_styles();

	}

	/**
	 * Register a new element with Smart Team Workflow
	 */
	public function register_element( $name, $args = array() ) {

		// A title and name is required for every element
		if ( !isset( $args['title'], $name ) )
			return false;

		$defaults = array(
			'title' => '',
			'short_description' => '',
			'extended_description' => '',
			'img_url' => false,
			'slug' => '',
			'post_type_support' => '',
			'default_options' => array(),
			'options' => false,
			'configure_page_cb' => false,
			'configure_link_text' => __( 'Configure', 'st-workflow' ),
			// These messages are applied to elements and can be overridden if custom messages are needed
			'messages' => array(
				'settings-updated' => __( 'Settings updated.', 'st-workflow' ),
				'form-error' => __( 'Please correct your form errors below and try again.', 'st-workflow' ),
				'nonce-failed' => __( 'Cheatin&#8217; uh?', 'st-workflow' ),
				'invalid-permissions' => __( 'You do not have necessary permissions to complete this action.', 'st-workflow' ),
				'missing-post' => __( 'Post does not exist', 'st-workflow' ),
			),
			'autoload' => false, // autoloading a element will remove the ability to enable or disable it
		);
		if ( isset( $args['messages'] ) )
			$args['messages'] = array_merge( (array)$args['messages'], $defaults['messages'] );
		$args = array_merge( $defaults, $args );
		$args['name'] = $name;
		$args['options_group_name'] = $this->options_group . $name . '_options';
		if ( !isset( $args['settings_slug'] ) )
			$args['settings_slug'] = 'stworkflow-' . $args['slug'] . '-settings';
		if ( empty( $args['post_type_support'] ) )
			$args['post_type_support'] = 'stworkflow_' . $name;
		// If there's a Help Screen registered for the element, make sure we
		// auto-load it
		if ( !empty( $args['settings_help_tab'] ) )
			add_action( 'load-st-workflow_page_' . $args['settings_slug'], array( &$this->$name, 'action_settings_help_menu' ) );

		$this->elements->$name = (object) $args;

		/**
		 * Fires after st_workflow has registered a element.
		 *
		 * Plugin authors can hook into this action to trigger functionaltiy after a element has been loaded.
		 *
		 * @param string $name The name of the registered element
		 */
		do_action( 'stworkflow_element_registered', $name );
		return $this->elements->$name;
	}

	/**
	 * Load all of the element options from the database
	 * If a given option isn't yet set, then set it to the element's default (upgrades, etc.)
	 */
	function load_element_options() {

		foreach ( $this->elements as $mod_name => $mod_data ) {

			$this->elements->$mod_name->options = get_option( $this->options_group . $mod_name . '_options', new stdClass );
			foreach ( $mod_data->default_options as $default_key => $default_value ) {
				if ( !isset( $this->elements->$mod_name->options->$default_key ) )
					$this->elements->$mod_name->options->$default_key = $default_value;
			}

			$this->$mod_name->element = $this->elements->$mod_name;
		}

		/**
		 * Fires after st_workflow has loaded all of the element options from the database.
		 *
		 * Plugin authors can hook into this action to read and manipulate element settings.
		 *
		 */
		do_action( 'stworkflow_element_options_loaded' );
	}

	/**
	 * Load the post type options again so we give add_post_type_support() a chance to work
	 *
	 * @see http://k
	 */
	function action_init_after() {
		foreach ( $this->elements as $mod_name => $mod_data ) {

			if ( isset( $this->elements->$mod_name->options->post_types ) )
				$this->elements->$mod_name->options->post_types = $this->helpers->clean_post_type_options( $this->elements->$mod_name->options->post_types, $mod_data->post_type_support );

			$this->$mod_name->element = $this->elements->$mod_name;
		}
	}

	/**
	 * Get a element by one of its descriptive values
	 *
	 * @param string|int|array $value The value to compare (using ==)
	 * @param string $key The property to use for searching a element (ex: 'name')

	 */
	function get_element_by( $key, $value ) {
		$element = false;
		foreach ( $this->elements as $mod_name => $mod_data ) {

			if ( $key == 'name' && $value == $mod_name ) {
				$element =  $this->elements->$mod_name;
			} else {
				foreach( $mod_data as $mod_data_key => $mod_data_value ) {
					if ( $mod_data_key == $key && $mod_data_value == $value )
						$element = $this->elements->$mod_name;
				}
			}
		}
		return $element;
	}

	/**
	 * Update the $st_workflow object with new value and save to the database
	 */
	function update_element_option( $mod_name, $key, $value ) {
		$this->elements->$mod_name->options->$key = $value;
		$this->$mod_name->element = $this->elements->$mod_name;
		return update_option( $this->options_group . $mod_name . '_options', $this->elements->$mod_name->options );
	}

	function update_all_element_options( $mod_name, $new_options ) {
		if ( is_array( $new_options ) )
			$new_options = (object)$new_options;
		$this->elements->$mod_name->options = $new_options;
		$this->$mod_name->element = $this->elements->$mod_name;
		return update_option( $this->options_group . $mod_name . '_options', $this->elements->$mod_name->options );
	}

	/**
	 * Registers commonly used scripts + styles for easy enqueueing
	 */
	function register_scripts_and_styles() {
		wp_enqueue_style( 'stworkflow-admin-css', ST_WORKFLOW_URL . 'admin/css/st-workflow-admin.css', false, ST_WORKFLOW_VERSION, 'all' );

		wp_register_script( 'jquery-listfilterizer', ST_WORKFLOW_URL . 'admin/js/jquery.listfilterizer.js', array( 'jquery' ), ST_WORKFLOW_VERSION, true );
		wp_register_style( 'jquery-listfilterizer', ST_WORKFLOW_URL . 'admin/css/jquery.listfilterizer.css', false, ST_WORKFLOW_VERSION, 'all' );


		wp_localize_script( 'jquery-listfilterizer',
		                    '__i18n_jquery_filterizer',
		                    array(
			                    'all'      => esc_html__( 'All', 'st-workflow' ),
			                    'selected' => esc_html__( 'Selected', 'st-workflow' ),
		                    ) );

		wp_register_script( 'jquery-quicksearch', ST_WORKFLOW_URL . 'admin/js/jquery.quicksearch.js', array( 'jquery' ), ST_WORKFLOW_VERSION, true );

	}

}

function stworkflow() {
	return st_workflow::instance();
}
add_action( 'plugins_loaded', 'stworkflow' );
