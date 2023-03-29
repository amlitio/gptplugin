<?php
function chatgpt_plugin_admin() {
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'chatgpt_plugin_settings' ); ?>
			<?php do_settings_sections( 'chatgpt_plugin' ); ?>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
