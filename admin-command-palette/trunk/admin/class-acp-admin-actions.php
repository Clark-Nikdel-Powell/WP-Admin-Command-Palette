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
final class ACP_Admin_Actions extends ACP_Data {


	public $transient_name = 'acp-admin-actions';


	protected $actions = array(
		array(
			"title" => "View Post",
			"target" => "#view-post-btn .button",
			"shortcut" => "shift+v"
		),
		array(
			"title" => "Preview",
			"target" => ".preview",
			"shortcut" => "shift+p"
		),
		array(
			"title" => "Publish",
			"target" => "input[type=submit]#publish",
			"shortcut" => "shift+s"
		),
		array(
			"title" => "Trash",
			"target" => ".submitdelete",
			"shortcut" => "shift+t"
		),
		array(
			"title" => "Set Featured Image",
			"target" => "#set-post-thumbnail",
			"shortcut" => "shift+f"
		),
		array(
			"title" => "Add New",
			"target" => "a[href*='post-new.php']",
			"shortcut" => "shift+n"
		)
	);


	public function load() {

		$this->data = $this->load_data('load_admin_actions');

	}


	/**
	 * Gets all admin actions
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
				$template['shortcut'] = $action['shortcut'];
				$template['name'] = 'admin-action';

				$data[] = $template;

			}

		}

		return $data;

	}


}