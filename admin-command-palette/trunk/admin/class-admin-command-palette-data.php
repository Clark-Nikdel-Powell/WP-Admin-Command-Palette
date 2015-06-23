<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Admin_Command_Palette
 * @subpackage Admin_Command_Palette/data
 * @author     Your Name <email@example.com>
 */
class Admin_Command_Palette_Data {


	/**
	 * The array of user generated content.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $user_content    The array of data
	 */
	public $user_content 	= array();


	/**
	 * The array of admin page content.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $admin_pages    The array of data
	 */
	public $admin_pages 	= array();


	/**
	 * The array of admin actions.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $admin_actions    The array of data
	 */
	public $admin_actions 	= array();


	/**
	 * An template array to use when generating content data
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $template    The array of data
	 */
	private $template = array(

		// all arrays
		'title' 		=> ''
	,	'object_type' 	=> ''
	,	'object_name' 	=> ''
	,	'url' 			=> ''

		// user generated content only
	,	'id' 			=> 0

		// admin pages only
	,	'dashicon' 		=> ''

		// admin actions only
	, 	'target' 		=> ''
	,	'action' 		=> ''
	,	'shortcut' 		=> ''		
	);


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->user_content 	= load_data('acp-user-content',	'load_user_content');
		$this->admin_pages 		= load_data('acp-admin-pages',	'load_admin_pages');
		$this->admin_actions 	= load_data('acp-admin-actions','load_admin_actions');

	}


	/**
	 * Load properties with data from either the transient name or live-pull function
	 *
	 * @since    1.0.0
	 * @param      string   $transient_name    The name of the transient
	 * @param      string   $method_name    	The string version of the method name in this class
	 * @param      int    	$expires    		The expire time of this transient
	 */
	public function load_data($transient_name, $method_name, $expires = 0) {

		$data = array();

		// if the cache exists
		$cache = get_transient($transient_name);
		if ( $cache ) {
			return $cache;
		}

		// otherwise get it live
		$live = $this->$method_name();
		set_transient( $transient_name, $live, $expires );
		return $live;

	}


	/**
	 * Gets all user content
	 *
	 * @since    1.0.0
	 * @return   array      The requested user content
	 */
	public function load_user_content() {

		// globals
		global $wpdb;

		// set template
		$template = $this->template;

		
		$results = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_status = 'publish'");

		// get data
		$data = array();

		return $data;

	}


	/**
	 * Gets all admin pages
	 *
	 * @since    1.0.0
	 * @return   array      The requested admin pages
	 */
	public function load_admin_pages() {

		// globals
		global $wpdb;

		// set template
		$template = $this->template;

		// get data
		$data = array();

		return $data;

	}


	/**
	 * Gets all admin actions
	 *
	 * @since    1.0.0
	 * @return   array      The requested admin actions
	 */
	public function load_admin_actions() {

		// globals
		global $wpdb;

		// set template
		$template = $this->template;

		// get data
		$data = array();

		return $data;

	}

}