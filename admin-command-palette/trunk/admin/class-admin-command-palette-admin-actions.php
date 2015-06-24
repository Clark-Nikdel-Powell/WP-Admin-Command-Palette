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
final class Admin_Command_Palette_Admin_Actions extends Admin_Command_Palette_Data {


	public function load() {

		$this->admin_actions = $this->load_data('acp-admin-actions', 'load_admin_actions');

	}


	/**
	 * Gets all admin actions - DO YOUR EDITING HERE
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