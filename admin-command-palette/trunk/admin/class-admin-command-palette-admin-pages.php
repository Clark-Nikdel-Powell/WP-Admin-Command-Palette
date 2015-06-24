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
final class Admin_Command_Palette_Admin_Pages extends Admin_Command_Palette_Data {


	public function load() {

		$this->admin_pages 	= $this->load_data('acp-admin-pages', 'load_admin_pages');

	}


	/**
	 * Gets all admin pages
	 *
	 * @since    1.0.0
	 * @return   array      The requested admin pages
	 */
	public function load_admin_pages() {

		// Get the admin menu.
		global $menu;

		// Get the admin submenu items.
		global $submenu;

		// get data
		$data = array();

		// Keep these separate so that we don't accidentally modify it.
		$admin_menu_arr = $menu;
		$admin_submenu_arr = $submenu;

		// Loop through the admin pages and add the data to an array.
		foreach ( $admin_menu_arr as $menu_order => $admin_menu_item ) {

			// Copy template
			$template = $this->template;

			// If this is a separator, then we don't need it.
			if ( 'wp-menu-separator' == $admin_menu_item[4] ) {

				continue;

			}

			$menu_title = $admin_menu_item[0];
			$menu_url = $admin_menu_item[2];

			// Clean the title
			$span_position = strpos( $menu_title, ' <span' );

			if ( 0 != $span_position ) {

				$menu_title = substr( $menu_title, 0, $span_position );

			}

			// Add the admin page to the array
			$template['title'] = $menu_title;
			$template['url'] = $menu_url;

			if ( '' != $admin_menu_item[6] ) {

				$template['dashicon'] = $admin_menu_item[6];

			}

			$data[] = $template;

		}

		// Loop through the admin submenu pages and add the data to an array.
		foreach ( $admin_submenu_arr as $parent_slug => $admin_submenu_items ) {

			// The submenu pages are grouped in sub-arrays under the parent slug, hence the extra loop.
			foreach ( $admin_submenu_items as $menu_order => $admin_submenu_item ) {

				// Copy template
				$template = $this->template;

				$submenu_title = $admin_submenu_item[0];
				$submenu_url = $admin_submenu_item[2];

				// If "Add" is present, we need to append the post type name to the title for context.
				if ( False !== strpos( $submenu_title, 'Add') && 0 != strpos( $submenu_url, 'post_type=' ) ) {

					$equal_position = strpos( $submenu_url, '=' );

					$submenu_post_type_slug = substr( $submenu_url, $equal_position + 1 );

					$submenu_title .= ' ' . ucfirst( $submenu_post_type_slug );

				}

				// A couple of special cases for title
				if ( 'post-new.php' == $submenu_url ) {

					$submenu_title .= ' Post';

				}
				if ( 'upload.php' == $submenu_url ) {

					continue;

				}
				if ( 'media-new.php' == $submenu_url ) {

					$submenu_title .= ' Attachment';

				}
				if ( 'plugin-install.php' == $submenu_url ) {

					$submenu_title .= ' Plugin';

				}
				if ( 'user-new.php' == $submenu_url ) {

					$submenu_title .= ' User';

				}

				// Clean the title
				$span_position = strpos( $submenu_title , ' <span' );

				if ( 0 != $span_position ) {

					$submenu_title = substr( $submenu_title, 0, $span_position );

				}

				$template['title'] = $submenu_title;
				$template['url'] = $submenu_url;

				$data[] = $template;

			}

		}

		return $data;

	}
}