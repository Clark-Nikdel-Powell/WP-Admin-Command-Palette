<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Admin_Command_Palette
 * @subpackage Admin_Command_Palette/data
 * @author     Your Name <email@example.com>
 */
final class Admin_Command_Palette_Markup {

	public function search_box() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/search_box_markup.php';

	}

}