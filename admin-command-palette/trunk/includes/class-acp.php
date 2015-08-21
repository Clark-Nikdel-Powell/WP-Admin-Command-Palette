<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    ACP
 * @subpackage ACP/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    ACP
 * @subpackage ACP/includes
 * @author     Your Name <email@example.com>
 */
class ACP {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      ACP_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $admin_command_palette    The string used to uniquely identify this plugin.
	 */
	protected $admin_command_palette;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The admin class
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $admin    Used to access data elements within the admin class
	 */
	public $admin;

	/**
	 * The markup class
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $markup    Used to get markup back for this plugin
	 */
	public $markup;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->admin_command_palette = 'acp';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - ACP_Loader. Orchestrates the hooks of the plugin.
	 * - ACP_i18n. Defines internationalization functionality.
	 * - ACP_Admin. Defines all hooks for the admin area.
	 * - ACP_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-acp-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-acp-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-acp-admin.php';

		/**
		 * The classes responsible for getting data into searchable arrays from the database
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-acp-data.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-acp-user-content.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-acp-admin-pages.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-acp-admin-actions.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-acp-markup.php';

		$this->loader = new ACP_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the ACP_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new ACP_i18n();
		$plugin_i18n->set_domain( $this->get_admin_command_palette() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$this->admin = new ACP_Admin( $this->get_admin_command_palette(), $this->get_version() );

		// instantiate classes
		$this->admin->user_content 	= new ACP_User_Content();
		$this->admin->admin_pages 	= new ACP_Admin_Pages();
		$this->admin->admin_actions = new ACP_Admin_Actions();

		$this->markup = new ACP_Markup();

		// add hooks to load data on admin init
		$this->loader->add_action( 'admin_init', $this->admin->user_content, 	'load' );
		$this->loader->add_action( 'admin_init', $this->admin->admin_pages, 	'load' );
		$this->loader->add_action( 'admin_init', $this->admin->admin_actions, 	'load' );
		$this->loader->add_action( 'admin_init', $this->admin, 'register_settings' );
		$this->loader->add_action( 'admin_menu', $this->admin, 'settings_page' );

		$this->loader->add_action( 'wp_ajax_acp_gad', $this->admin, 'acp_gad' );

		$this->loader->add_action( 'admin_footer', $this->markup, 'search_box' );

		$this->loader->add_action( 'admin_enqueue_scripts', $this->admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $this->admin, 'enqueue_scripts' );

		$this->loader->add_action( 'activated_plugin', $this->admin, 'clear_all_cache' );
		$this->loader->add_action( 'deactivated_plugin', $this->admin, 'clear_all_cache' );
		$this->loader->add_action( 'wp_insert_post', $this->admin, 'clear_all_cache' );
		$this->loader->add_action( 'wp_trash_post', $this->admin, 'clear_all_cache' );
		$this->loader->add_action( 'created_term', $this->admin, 'clear_all_cache' );
		$this->loader->add_action( 'delete_term', $this->admin, 'clear_all_cache' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_admin_command_palette() {
		return $this->admin_command_palette;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    ACP_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
