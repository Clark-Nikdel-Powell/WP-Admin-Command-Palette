<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Admin_Command_Palette
 * @subpackage Admin_Command_Palette/admin/partials
 */

// Set up data
$post_types = get_post_types( array(), 'objects' );
?>

<div>

	<h2>Admin Command Palette</h2>

	<form action="options.php" method="post">

		<?php settings_fields('acp_options'); ?>
		<?php do_settings_sections('acp_options'); ?>

		<?php $options = get_option('acp_post_types'); ?>

		<h3>Included Post Types</h3>
		<p class="description">Content from selected post types will be included in search.</p>

		<?php
		foreach ( $post_types as $post_type_slug => $post_type ) {

			$checked = '';

			if ( '' == $options || empty( $options ) ) {

				if ( 'page' == $post_type_slug || 'post' == $post_type_slug ) {
					$checked = 'checked';
				}

			}
			else {

				if ( '1' == $options[$post_type_slug] ) {
					$checked = 'checked';
				}

			}

		?>
			<p><label><input type="checkbox" name="acp_post_types[<?php echo $post_type_slug; ?>]" value="1" <?php echo $checked; ?> /> <?php echo $post_type->labels->name; ?></label></p>
		<?php } ?>

		<p>
			<input class="button button-primary" name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
		</p>

	</form>
</div>
