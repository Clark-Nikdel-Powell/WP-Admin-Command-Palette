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
abstract class ACP_Data {


	/**
	 * The data to hold
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $user_content    The array of data
	 */
	public $data = array();


	/**
	 * The name of this classes' transient
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $transient_name    The string name
	 */
	public $transient_name = "";


	/**
	 * A template array to use when generating content data
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $template    The array of data
	 */
	protected $template = array(

		'title' 		=> '',
		'url' 			=> '',
		'name'          => '',

	);


	/**
	 * The method called in our wordpress action
	 *
	 * @since    1.0.0
	 */
	public function load() { }


	/**
	 * The method to create a transient name uniquely for each user
	 *
	 * @since 	1.0.0
	 * @return 	string 	The modified transient name
	 */
	public function create_unique_transient_name() {

		// get the current user
		$user =  wp_get_current_user();

		// set the modified transient name to include this user id. This keeps our caching specific for each user
		return $this->transient_name . '-user-' . $user->ID;

	}


	/**
	 * The method to remove a transient
	 *
	 * @since 	1.0.0
	 * @return 	null
	 */
	public function clear_transient() {

		// get modified name (unique for each user)
		$transient_modified_name = $this->create_unique_transient_name();

		// removes the transient
		delete_transient( $transient_modified_name );

		return;
	}


	/**
	 * Load properties with data from either the transient name or live-pull function
	 *
	 * @since    1.0.0
	 * @param      string   $transient_name    The name of the transient
	 * @param      string   $method_name    	The string version of the method name in this class
	 * @param      int    	$expires    		The expire time of this transient
	 */
	public function load_data($method_name, $expires = 0) {

		// get modified name (unique for each user)
		$transient_modified_name = $this->create_unique_transient_name();

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