<?php
function chatgpt_plugin_settings_init() {
	register_setting(
		'chatgpt_plugin_settings',
		'chatgpt_api_key'
	);

	add_settings_section(
		'chatgpt_plugin_section',
		'ChatGPT 3 API Settings',
		'chatgpt_plugin_section_callback',
		'chatgpt_plugin'
	);

	add_settings_field(
		'chatgpt_api_key',
		'API Key',
		'chatgpt_api_key_callback',
		'chatgpt_plugin',
		'chatgpt_plugin_section'
	);
}

add_action( 'admin_init', 'chatgpt_plugin_settings_init' );

function chatgpt_plugin_section_callback() {
	echo '<p>Enter your ChatGPT 3 API key below:</p>';
}

function chatgpt_api_key_callback() {
	$value = get_option( 'chatgpt_api_key' );
	echo '<input type="text" name="chatgpt_api_key" value="' . esc_attr( $value ) . '">';
}
