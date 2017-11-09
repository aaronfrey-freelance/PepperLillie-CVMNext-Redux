<?php

add_action('admin_init', 'theme_options_init');
add_action('admin_menu', 'theme_options_add_page');

/**
 * Init plugin options to white list our options
 */
function theme_options_init() {
	register_setting('sample_options', 'cvm_theme_options', 'theme_options_validate');
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page( __('Theme Options', 'cvm'), __('Theme Options', 'cvm'), 'edit_theme_options', 'theme_options', 'theme_options_do_page');
}

/**
 * Create the options page
 */
function theme_options_do_page() {

	if (!isset($_REQUEST['settings-updated']))
		$_REQUEST['settings-updated'] = false;
	?>
	<div class="wrap">

		<?php screen_icon(); echo "<h2>" . get_current_theme() . __(' Options', 'cvm') . "</h2>"; ?>

		<?php if(false !== $_REQUEST['settings-updated']) : ?>
		<div class="updated fade"><p><strong><?php _e('Options saved', 'cvm'); ?></strong></p></div>
		<?php endif; ?>

		<form id="admin-options-form" method="post" action="options.php">

			<?php settings_fields('sample_options'); ?>
			<?php $options = get_option('cvm_theme_options'); ?>

			<fieldset>
				
				<label class="description" for="cvm_theme_options[facebook_url]"><?php _e('Facebook URL', 'cvm'); ?></label>
				<input id="cvm_theme_options[facebook_url]" class="regular-text" type="text" name="cvm_theme_options[facebook_url]" value="<?php esc_attr_e($options['facebook_url']); ?>" />

				<br>

				<label class="description" for="cvm_theme_options[linkedin_url]"><?php _e('LinkedIn URL', 'cvm'); ?></label>
				<input id="cvm_theme_options[linkedin_url]" class="regular-text" type="text" name="cvm_theme_options[linkedin_url]" value="<?php esc_attr_e($options['linkedin_url']); ?>" />

			</fieldset>

			<p class="submit">
				<input type="submit" id="admin-options-submit" class="button-primary" value="<?php _e('Save Options', 'cvm'); ?>" />
			</p>

		</form>

	</div>

	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate($input) {

	// Say our text option must be safe text with no HTML tags
	$input['facebook_url'] = wp_filter_nohtml_kses($input['facebook_url']);

	return $input;
}
