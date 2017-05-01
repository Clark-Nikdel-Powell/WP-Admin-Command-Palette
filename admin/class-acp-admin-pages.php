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
final class ACP_Admin_Pages extends ACP_Data {


	public $transient_name = 'acp-admin-pages';


	public function load() {

		$this->data	= $this->load_data('load_admin_pages');

	}


	/**
	 * Gets all admin pages - DO YOUR EDITING HERE
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

		if ( !empty( $admin_menu_arr ) ) {

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
				$template['name'] = 'admin-page';

				if ( '' != $admin_menu_item[6] ) {

					$template['dashicon'] = $admin_menu_item[6];

				}

				$data[] = $template;

			}

		}

		if ( !empty( $admin_submenu_arr ) ) {

			// Loop through the admin submenu pages and add the data to an array.
			foreach ( $admin_submenu_arr as $parent_slug => $admin_submenu_items ) {

				// The submenu pages are grouped in sub-arrays under the parent slug, hence the extra loop.
				foreach ( $admin_submenu_items as $menu_order => $admin_submenu_item ) {

					// Copy template
					$template = $this->template;

					$submenu_title = $admin_submenu_item[0];
					$submenu_url = $admin_submenu_item[2];

					// When dealing with a submenu URL, if there isn't a .php suffix,
					// then the full URL is built based on the parent slug.
					if ( FALSE === strpos($submenu_url, '.php') ) {
						$submenu_url = $parent_slug . '?page=' . $admin_submenu_item[2];
					}

					// If "Add" is present, we need to append the post type name to the title for context.
					if ( FALSE !== strpos( $submenu_title, 'Add') && 0 != strpos( $submenu_url, 'post_type=' ) ) {

						$equal_position = strpos( $submenu_url, '=' );

						$submenu_post_type_slug = substr( $submenu_url, $equal_position + 1 );

						$submenu_title .= ' ' . ucfirst( $submenu_post_type_slug );

					}

					// Don't include the dashboard twice
					if ( 'index.php' == $submenu_url ) {
						continue;
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
					$template['name'] = 'admin-page';

					$data[] = $template;

				}

			}

		}

		return $data;

	}
}