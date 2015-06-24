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
final class Admin_Command_Palette_User_Content extends Admin_Command_Palette_Data {


	public function load() {

		$this->data = $this->load_data('acp-user-content',	'load_user_content');

	}


	/**
	 * Gets all user content - DO YOUR EDITING HERE
	 *
	 * @since    1.0.0
	 * @return   array      The requested user content
	 */
	public function load_user_content() {

		// globals
		global $wpdb;

		// get all published posts
		$results = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_status = 'publish'", ARRAY_A);

		// set blank array for false returns
		$data = array();

		// loop through our results
		if ( $results && count($results) > 0 ) {

			foreach ( $results as $result ) {

				// copy the template
				$template = $this->template;

				// set all the properties
				$template['title'] 			= $result['post_title'];
				$template['id'] 			= $result['ID'];
				$template['object_type'] 	= 'post_type';
				$template['object_name'] 	= $result['post_type'];
				$template['url'] 			= get_edit_post_link($result['ID']);

				// set the data in the new array by post ID to avoid duplicates
				$data[] = $template;

			}

		}

		return $data;

	}
}