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
abstract class Admin_Command_Palette_Data {


	/**
	 * The data to hold
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $user_content    The array of data
	 */
	public $data = array();


	/**
	 * A template array to use when generating content data
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $template    The array of data
	 */
	protected $template = array(

		// all arrays
		'title' 		=> '',
		'url' 			=> '',
		'type'          => '',

		// user generated content only
		'id' 			=> 0,
		'object_type' 	=> '',
		'object_name' 	=> '',

		// admin pages only
		'dashicon' 		=> '',

		// admin actions only
	 	'target' 		=> '',
		'action' 		=> '',
		'shortcut' 		=> ''
	);


	/**
	 * The method called in our wordpress action
	 *
	 * @since    1.0.0
	 */
	public function load() { }


	/**
	 * Load properties with data from either the transient name or live-pull function
	 *
	 * @since    1.0.0
	 * @param      string   $transient_name    The name of the transient
	 * @param      string   $method_name    	The string version of the method name in this class
	 * @param      int    	$expires    		The expire time of this transient
	 */
	public function load_data($transient_name, $method_name, $expires = 0) {


		// get the current user
		$user =  wp_get_current_user();

		// set the modified transient name to include this user id. This keeps our caching specific for each user
		$transient_modified_name = $transient_name . '-user-' . $user->ID;

		// if the cache exists
		if ( ACP_CACHE ) {
			$cache = get_transient($transient_modified_name);
			if ( $cache ) {
				return $cache;
			}
		}

		// otherwise get it live
		$live = $this->$method_name();
		set_transient( $transient_modified_name, $live, $expires );
		return $live;

	}

}