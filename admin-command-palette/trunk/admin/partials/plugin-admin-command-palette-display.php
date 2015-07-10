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
$taxonomies = get_taxonomies( array(), 'objects' );

$excluded_post_types = get_option('acp_excluded_post_types');
$excluded_taxonomies = get_option('acp_excluded_taxonomies');

?>

<div>

	<h2>Admin Command Palette</h2>

	<form action="options.php" method="post">

		<?php settings_fields('acp_options'); ?>
		<?php do_settings_sections('acp_options'); ?>

		<?php ?>

		<h3>Excluded Post Types</h3>

		<?php
		foreach ( $post_types as $post_type_slug => $post_type ) {

			$checked = '';

			if ( '' == $excluded_post_types || empty( $excluded_post_types ) ) {

				if ( 'attachment' == $post_type_slug || 'revision' == $post_type_slug || 'nav_menu_item' == $post_type_slug ) {
					$checked = 'checked';
				}

			}
			else {

				if ( isset($excluded_post_types[$post_type_slug]) && '1' === $excluded_post_types[$post_type_slug] ) {
					$checked = 'checked';
				}

			}

		?>
			<p><label><input type="checkbox" name="acp_excluded_post_types[<?php echo $post_type_slug; ?>]" value="1" <?php echo $checked; ?> /> <?php echo $post_type->labels->name; ?></label></p>
		<?php } ?>

		<h3>Excluded Taxonomies</h3>

		<?php
		foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {

			$checked = '';

			if ( '' == $excluded_taxonomies || empty( $excluded_taxonomies ) ) {

				if ( 'nav_menu' == $taxonomy_slug || 'link_category' == $taxonomy_slug || 'post_format' == $taxonomy_slug ) {
					$checked = 'checked';
				}

			}
			else {

				if ( isset($excluded_taxonomies[$taxonomy_slug]) && '1' === $excluded_taxonomies[$taxonomy_slug] ) {
					$checked = 'checked';
				}

			}

		?>
			<p><label><input type="checkbox" name="acp_excluded_taxonomies[<?php echo $taxonomy_slug; ?>]" value="1" <?php echo $checked; ?> /> <?php echo $taxonomy->labels->name; ?></label></p>
		<?php } ?>

		<p>
			<input class="button button-primary" name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
		</p>

	</form>
</div>
