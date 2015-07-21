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


	protected $actions = array(
		array(
			"title" => "View Post",
			"target" => "#view-post-btn .button",
			"action" => "click",
			"shortcut" => "shift+v"
		),
		array(
			"title" => "Preview",
			"target" => ".preview",
			"action" => "click",
			"shortcut" => "shift+p"
		),
		array(
			"title" => "Publish",
			"target" => "input[type=submit]#publish",
			"action" => "click",
			"shortcut" => "shift+s"
		),
		array(
			"title" => "Trash",
			"target" => ".submitdelete",
			"action" => "click",
			"shortcut" => "shift+t"
		),
		array(
			"title" => "Set Featured Image",
			"target" => "#set-post-thumbnail",
			"action" => "click",
			"shortcut" => "shift+f"
		),
		// TODO: Add Screen Options
	);


	public function load() {

		$this->data = $this->load_data('acp-admin-actions', 'load_admin_actions');

	}


	/**
	 * Gets all admin actions - DO YOUR EDITING HERE
	 *
	 * @since    1.0.0
	 * @return   array      The requested admin actions
	 */
	public function load_admin_actions() {

		// get data
		$data = array();

		$actions = $this->actions;

		if (isset($actions) && count($actions) > 0) {

			// set template
			$template = $this->template;

			foreach ($actions as $action) {

				$template['title'] = $action['title'];
				$template['target'] = $action['target'];
				$template['action'] = $action['action'];
				$template['shortcut'] = $action['shortcut'];
				$template['name'] = 'admin-action';

				$data[] = $template;

			}

		}

		return $data;

	}


}