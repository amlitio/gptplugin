<?php

/**
 * Plugin Name: ChatGPT Content Generator & Ai Website Tools
 * Plugin URI: https://ordinarygems.com/
 * Description: This plugin utilizes the ChatGPT 3 API to generate AI-powered content for WordPress websites.
 * Version: 1.1
 * Author: amlitio
 * Author URI: https://github.com/amlitio
 * License: GPL2
 */

// Include required files
require_once plugin_dir_path( __FILE__ ) . 'includes/content.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/settings.php';

// API URL
define( 'CHATGPT_API_URL', 'https://api.openai.com/v1/engines/davinci-codex/completions' );

// Add plugin settings page
add_action( 'admin_menu', 'cgpt_plugin_settings_page' );

function cgpt_plugin_settings_page() {
    add_menu_page(
        'ChatGPT 3 Settings',
        'ChatGPT 3',
        'manage_options',
        'chatgpt-plugin',
        'cgpt_plugin_settings_page_callback'
    );
}

function cgpt_plugin_settings_page_callback() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form method="post" action="options.php">
            <?php settings_fields( 'chatgpt_plugin_settings_group' ); ?>
            <?php do_settings_sections( 'chatgpt_plugin_settings_page' ); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Add plugin settings
add_action( 'admin_init', 'cgpt_plugin_settings' );

function cgpt_plugin_settings() {
    register_setting(
        'chatgpt_plugin_settings_group',
        'chatgpt_api_options',
        'cgpt_sanitize_options'
    );

    add_settings_section(
        'chatgpt_plugin_settings_section',
        'ChatGPT 3 API Settings',
        'chatgpt_plugin_settings_section_callback',
        'chatgpt_plugin_settings_page'
    );

    add_settings_field(
        'chatgpt_api_key',
        'API Key',
        'chatgpt_api_key_callback',
        'chatgpt_plugin_settings_page',
        'chatgpt_plugin_settings_section'
    );

    add_settings_field(
        'chatgpt_api_language',
        'Language',
        'chatgpt_api_language_callback',
        'chatgpt_plugin_settings_page',
        'chatgpt_plugin_settings_section'
    );

    add_settings_field(
        'chatgpt_api_tone',
        'Tone',
        'chatgpt_api_tone_callback',
        'chatgpt_plugin_settings_page',
        'chatgpt_plugin_settings_section'
    );

    add_settings_field(
        'chatgpt_api_model',
        'Model',
        'chatgpt_api_model_callback',
        'chatgpt_plugin_settings_page',
        'chatgpt_plugin_settings_section'
    );
    
    add_settings_field(
        'chatgpt_api_temperature',
        'Temperature',
        'chatgpt_api_temperature_callback',
        'chatgpt_plugin_settings_page',
        'chatgpt_plugin_settings_section'
    );
    
    add_settings_field(
        'chatgpt_api_length',
        'Length',
        'chatgpt_api_length_callback',
        'chatgpt_plugin_settings_page',
        'chatgpt_plugin_settings_section'
    );
    
    add_settings_field(
        'chatgpt_api_stop',
        'Stop',
        'chatgpt_api_stop_callback',
        'chatgpt_plugin_settings_page',
        'chatgpt_plugin_settings_section'
    );
    
    add_settings_field(
        'chatgpt_generate_content',
        'Generate Content',
        'chatgpt_generate_content_callback',
        'chatgpt_plugin_settings_page',
        'chatgpt_plugin_settings_section'
    );
}

// Register settings
register_setting(
    'chatgpt_plugin_settings_group',
    'chatgpt_api_options',
    'chatgpt_sanitize_options'
);

// Settings section callback
function chatgpt_plugin_settings_section_callback() {
    echo 'Enter your ChatGPT 3 API settings below:';
}

// API key field callback
function chatgpt_api_key_callback() {
    $options = get_option( 'chatgpt_api_options' );
    $api_key = isset( $options['api_key'] ) ? $options['api_key'] : '';
    echo '<input type="text" name="chatgpt_api_options[api_key]" value="' . esc_attr( $api_key ) . '" />';
}

// API language field callback
function chatgpt_api_language_callback() {
    $options = get_option( 'chatgpt_api_options' );
    $language = isset( $options['language'] ) ? $options['language'] : 'en';
    echo '<select name="chatgpt_api_options[language]">';
    echo '<option value="en"' . selected( $language, 'en', false ) . '>English</option>';
    echo '<option value="es"' . selected( $language, 'es', false ) . '>Spanish</option>';
    echo '<option value="fr"' . selected( $language, 'fr', false ) . '>French</option>';
    echo '</select>';
}
    
    // API tone field callback
    function chatgpt_api_tone_callback() {
        $options = get_option( 'chatgpt_api_options' );
        $tone = isset( $options['tone'] ) ? $options['tone'] : '';
        echo '<input type="text" name="chatgpt_api_options[tone]" value="' . esc_attr( $tone ) . '" />';
    }
    
    // API model field callback
    function chatgpt_api_model_callback() {
        $options = get_option( 'chatgpt_api_options' );
        $model = isset( $options['model'] ) ? $options['model'] : 'davinci-codex';
        echo '<select name="chatgpt_api_options[model]">';
        echo '<option value="davinci-codex"' . selected( $model, 'davinci-codex', false ) . '>Davinci Codex</option>';
        echo '<option value="davinci"' . selected( $model, 'davinci', false ) . '>Davinci</option>';
        echo '<option value="curie"' . selected( $model, 'curie', false ) . '>Curie</option>';
        echo '</select>';
    }
    
// API temperature field callback
function chatgpt_api_temperature_callback() {
    $options = get_option( 'chatgpt_api_options' );
    $temperature = isset( $options['temperature'] ) ? $options['temperature'] : 0.5;
    echo '<input type="text" name="chatgpt_api_options[temperature]" value="' . esc_attr( $temperature ) . '" />';
}

// API length field callback
function chatgpt_api_length_callback() {
    $options = get_option( 'chatgpt_api_options' );
    $length = isset( $options['length'] ) ? $options['length'] : 300;
    echo '<input type="text" name="chatgpt_api_options[length]" value="' . esc_attr( $length ) . '" />';
}

// API stop field callback
function chatgpt_api_stop_callback() {
    $options = get_option( 'chatgpt_api_options' );
    $stop = isset( $options['stop'] ) ? $options['stop'] : '';
    echo '<input type="text" name="chatgpt_api_options[stop]" value="' . esc_attr( $stop ) . '" />';
}

// Generate content callback
function chatgpt_generate_content_callback() {

    $options = get_option( 'chatgpt_api_options' );

    $api_key = isset( $options['api_key'] ) ? $options['api_key'] : '';

    $language = isset( $options['language'] ) ? $options['language'] : 'en';

    $tone = isset( $options['tone'] ) ? $options['tone'] : '';

    $model = isset( $options['model'] ) ? $options['model'] : 'davinci-codex';

    $temperature = isset( $options['temperature'] ) ? $options['temperature'] : 0.5;

    $length = isset( $options['length'] ) ? $options['length'] : 300;

    $stop = isset( $options['stop'] ) ? $options['stop'] : '';

    $content = isset( $_POST['chatgpt_content'] ) ? $_POST['chatgpt_content'] : '';

    // Make API request
    $data = array(

        'prompt' => $content,

        'max_tokens' => $length,

        'temperature' => $temperature,

        'model' => $model,

        'stop' => array( '\n', '.' ),

        'n' => 1,

        'stream' => false,

        'logprobs' => 0,

        'user' => 'chatgpt-plugin',

        'metadata' => array(

            'language' => $language,

            'tone' => $tone

        )

    );

    $headers = array(

        'Content-Type: application/json',

        'Authorization: Bearer ' . $api_key

    );

    $args = array(

        'body' => json_encode( $data ),

        'headers' => $headers,

        'timeout' => 60

    );

    $response = wp_remote_post( CHATGPT_API_URL, $args );

    if ( !is_wp_error( $response ) && $response['response']['code'] == 200 ) {

        $data = json_decode( $response['body'], true );

        $generated_content = $data['choices'][0]['text'];

        $generated_content = preg_replace( '/(\n\n+)/', "\n\n", $generated_content );

        $generated_content = preg_replace( '/\n(?!$)/', "\n\n", $generated_content );

        $generated_content = preg_replace( '/\n$/', '', $generated_content );

        $generated_content = esc_attr( $generated_content );

        echo '<p>' . $generated_content . '</p>';

    } else {

        echo '<p>Sorry, there was an error generating content. Please try again later.</p>';

    }

}

// Register shortcode
add_shortcode( 'chatgpt_content', 'cgpt_generate_content_shortcode' );

function cgpt_generate_content_shortcode() {
    ob_start();
    cgpt_generate_content_callback();
    return ob_get_clean();
}
