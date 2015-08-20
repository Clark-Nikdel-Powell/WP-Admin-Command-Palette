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
 * @package    ACP
 * @subpackage ACP/data
 * @author     Your Name <email@example.com>
 */
final class ACP_User_Content extends ACP_Data {


	public $transient_name = 'acp-user-content';


	public function load() {

		$this->data = $this->load_data('load_user_content');

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

		// get post types to include
		$included_post_types = array();
		$included_post_types = get_option('acp_included_post_types');

		if ( !empty( $included_post_types ) ) {

			// get all posts
			$sql = "
				SELECT *
				FROM $wpdb->posts
			";

			// include any included post types from the query
			foreach ( $included_post_types as $post_type_slug => $checked ) {

				if ( FALSE === strpos($sql, 'WHERE') ) {
					$prefix = 'WHERE';
				}
				else {
					$prefix = 'OR';
				}

				$sql .= " $prefix post_type = '$post_type_slug'";

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
					$template['url'] 			= get_edit_post_link($result['ID'], 'noencode');
					$template['name']           = $result['post_type'];

					// set the data in the new array by post ID to avoid duplicates
					$data[] = $template;

				}

			}

		}

		// get taxonomies to include
		$included_taxonomies = get_option('acp_included_taxonomies');

		if ( !empty( $included_taxonomies ) ) {

			// get all taxonomies
			$sql = "
				SELECT DISTINCT
					$wpdb->terms.*,
					$wpdb->term_taxonomy.taxonomy
				FROM $wpdb->terms
					JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id
					JOIN $wpdb->term_relationships ON $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id
			";

			// exclude any included taxonomies from the query
			if ( !empty( $included_taxonomies ) ) {

				foreach ( $included_taxonomies as $taxonomy_slug => $checked ) {

					if ( FALSE === strpos($sql, 'WHERE') ) {
						$prefix = 'WHERE';
					}
					else {
						$prefix = 'OR';
					}

					$sql .= " $prefix taxonomy = '$taxonomy_slug'";

				}

			}

			$results = $wpdb->get_results($sql, ARRAY_A);

			// loop through our results
			if ( $results && count($results) > 0 ) {

				foreach ( $results as $result ) {

					// copy the template
					$template = $this->template;

					$url = 'edit-tags.php?action=edit&taxonomy='. $result['taxonomy'] .'&tag_ID='. $result['term_id'];

					if ( 'nav_menu' == $result['taxonomy'] ) {

						$url = 'nav-menus.php?action=edit&menu='. $result['term_id'];

					}

					// set all the properties
					$template['title'] 			= $result['name'];
					$template['id'] 			= $result['term_id'];
					$template['object_type'] 	= 'taxonomy';
					$template['url'] 			= $url;
					$template['name']           = $result['taxonomy'];

					// set the data in the new array by post ID to avoid duplicates
					$data[] = $template;

				}
			}

		}

		// get users if user has permission
		if ( current_user_can('edit_user') ) {

			$user_sql = "SELECT * FROM $wpdb->users";

			$user_results = $wpdb->get_results($user_sql, ARRAY_A);

			// loop through our results
			if ( $user_results && count($user_results) > 0 ) {

				foreach ( $user_results as $user_result ) {

					// copy the template
					$template = $this->template;

					// set all the properties
					$template['title'] 			= $user_result['user_nicename'] . '(' . $user_result['user_email'] . ')';
					$template['id'] 			= $user_result['ID'];
					$template['object_type'] 	= 'user';
					$template['url'] 			= 'user-edit.php?user_id='. $user_result['ID'];
					$template['name']           = 'edit-user';

					// set the data in the new array by post ID to avoid duplicates
					$data[] = $template;

				}
			}

		}
		return $data;
	}
}