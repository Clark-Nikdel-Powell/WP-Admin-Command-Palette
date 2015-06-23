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


	public $user_content 	= array();
	public $admin_pages 	= array();
	public $admin_actions 	= array();

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


	public function __construct() {

		$this->user_content 	= load_user_content();
		$this->admin_pages 		= load_admin_pages();
		$this->admin_actions 	= load_admin_actions();

	}

	public function load_user_content() {

		global $wpdb;

	}

	public function load_admin_pages() {

		global $wpdb;

	}

	public function load_admin_actions() {

		global $wpdb;

	}
}