<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    ACP
 * @subpackage ACP/admin/partials
 */

// Set up data
$post_types = get_post_types( array(), 'objects' );
$taxonomies = get_taxonomies( array(), 'objects' );


$threshold = get_option('acp_search_threshold');
$max_results_per_type = get_option('acp_max_results_per_type');
$group_results_by_type = get_option('acp_display_results_by_type');
$included_post_types = get_option('acp_included_post_types');
$included_taxonomies = get_option('acp_included_taxonomies');

// Threshold Check
if ( '' == $threshold ) {
	$threshold = '0.3';
}

// Max Results Check
if ( '' == $max_results_per_type ) {
	$max_results_per_type = '5';
}

// Results by Type Check
$group_results_by_type_checked = '';
if ( is_array( $group_results_by_type ) && '1' == $group_results_by_type['group-by-type'] ) {
	$group_results_by_type_checked = 'checked';
}

// Nav menu items are not editable like other post types
unset( $post_types['nav_menu_item'] );
unset( $post_types['revision'] );

?>

<div>

	<h2>Admin Command Palette Settings</h2>

	<form action="options.php" method="post">

		<?php settings_fields('acp_options'); ?>

		<?php
		/*//////////////////////////////////////////////////////////////////////////////
		//  General Settings  /////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////*/
		?>

		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label for="threshold">Search Threshold</label>
					</th>
					<td>
						<input type="number" name="acp_search_threshold" min="0.0" max="1.0" step="0.1" value="<?php echo $threshold; ?>">
						<p class="description">1.0 will match anything, 0.0 must be a perfect match.</p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="threshold">Max Results Per Type</label>
					</th>
					<td>
						<input type="number" name="acp_max_results_per_type" min="1" step="1" value="<?php echo $max_results_per_type; ?>">
						<p class="description">Number of results to display per post type, taxonomy, etc.</p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="threshold">Group Results by Type</label>
					</th>
					<td>
						<input type="checkbox" name="acp_display_results_by_type[group-by-type]" value="1" <?php echo $group_results_by_type_checked; ?> />
						<p class="description">The default format is a flat list of results, not split out by type.</p>
					</td>
				</tr>

				<?php // Included Post Types ?>
				<tr>
					<th scope="row">
						<label>Included Post Types</label>
					</th>
					<td>

						<?php
						foreach ( $post_types as $post_type_slug => $post_type ) {

							$checked = '';

							if ( isset($included_post_types[$post_type_slug]) && '1' === $included_post_types[$post_type_slug] ) {
								$checked = 'checked';
							}

							// Add count number to label
							$post_type_counts = wp_count_posts( $post_type->name, 'readable' );
							$post_type_count = $post_type_counts->publish;
							$post_type_count_label = 'Published';

							if ( 'attachment' == $post_type_slug ) {

								$post_type_count = $post_type_counts->inherit;
								$post_type_count_label = 'Uploaded';

							}

						?>
							<p><label>
								<input type="checkbox" name="acp_included_post_types[<?php echo $post_type_slug; ?>]" value="1" <?php echo $checked; ?> />
								<?php echo $post_type->labels->name; ?>
								<?php if ( '' !== $post_type_count && '' !== $post_type_count_label ) { ?>
								<em class="count">(<?php echo $post_type_count . ' ' . $post_type_count_label; ?>)</em>
								<?php } ?>
							</label></p>
						<?php } ?>
					</td>
				</tr>

				<?php // Included Taxonomies ?>
				<tr>
					<th scope="row">
						<label>Included Taxonomies</label>
					</th>
					<td>
						<?php
						foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {

							$checked = '';

							if ( '' == $included_taxonomies || empty( $included_taxonomies ) ) {

								if ( 'category' == $taxonomy_slug || 'post_tag' == $taxonomy_slug ) {
									$checked = 'checked';
								}

							}
							else {

								if ( isset($included_taxonomies[$taxonomy_slug]) && '1' === $included_taxonomies[$taxonomy_slug] ) {
									$checked = 'checked';
								}

							}

							// Add count number to label
							$taxonomy_count = wp_count_terms( $taxonomy_slug );

						?>
							<p><label>
								<input type="checkbox" name="acp_included_taxonomies[<?php echo $taxonomy_slug; ?>]" value="1" <?php echo $checked; ?> />
								<?php echo $taxonomy->labels->name; ?>
								<em class="count">(<?php echo $taxonomy_count; ?>)</em>
							</label></p>
						<?php } ?>
					</td>
				</tr>

			</tbody>
		</table>

		<p>
			<input class="button button-primary" name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
		</p>

	</form>
	<form method="post">
		<?php
		if ( isset($_POST['clear_cache']) || isset($_GET['settings-updated']) ) {
			global $ACP;
			$ACP->admin->clear_all_cache();
		}
		?>
		<input class="button button-secondary" type="submit" name="clear_cache" value="<?php esc_attr_e('Clear Content Cache'); ?>" />
	</form>
</div>
