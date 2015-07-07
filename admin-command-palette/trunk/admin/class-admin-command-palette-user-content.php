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

		// set blank array for false returns
		$data = array();

		// get post types to exclude
		$excluded_post_types = get_option('acp_excluded_post_types');

		// get all published posts
		$sql = "
			SELECT *
			FROM $wpdb->posts
			WHERE post_status = 'publish'
		";

		if ( !empty( $excluded_post_types ) ) {

			foreach ( $excluded_post_types as $post_type_slug => $checked ) {

				$sql .= " AND post_type != '$post_type_slug'";

			}

		}

		$results = $wpdb->get_results($sql, ARRAY_A);

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

		// get taxonomies to exclude
		$excluded_taxonomies = get_option('acp_excluded_taxonomies');

		// get all taxonomies
		$sql = "
			SELECT
				$wpdb->terms.*,
				$wpdb->term_taxonomy.taxonomy,
				$wpdb->posts.post_type
			FROM $wpdb->terms
				JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id
				JOIN $wpdb->term_relationships ON $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id
				JOIN $wpdb->posts ON $wpdb->posts.ID = $wpdb->term_relationships.object_id
			WHERE post_status = 'publish'
		";

		if ( !empty( $excluded_taxonomies ) ) {

			foreach ( $excluded_taxonomies as $taxonomy_slug => $checked ) {

				$sql .= " AND taxonomy != '$taxonomy_slug'";

			}

		}

		$results = $wpdb->get_results($sql, ARRAY_A);

		// loop through our results
		if ( $results && count($results) > 0 ) {

			foreach ( $results as $result ) {

				// copy the template
				$template = $this->template;

				// set all the properties
				$template['title'] 			= $result['name'];
				$template['id'] 			= $result['term_id'];
				$template['object_type'] 	= 'taxonomy';
				$template['object_name'] 	= $result['taxonomy'];
				$template['url'] 			= get_edit_term_link($result['term_id'], $result['taxonomy'], $result['post_type']);

				// set the data in the new array by post ID to avoid duplicates
				$data[] = $template;

			}

		}

		return $data;

	}
}