<?php
/*
Plugin Name: Enqueue Scripts and Styles
Description: Plugin to enqueue custom scripts and styles without requiring a child theme - especially useful for FSE themes.
Version: 1.1
Author: Brandon Meyer
*/

function create_custom_folders() {
    $cssFolder = WP_CONTENT_DIR . '/enqueued-scripts-styles/css';
    $jsFolder = WP_CONTENT_DIR . '/enqueued-scripts-styles/js';

    if (!is_dir($cssFolder)) {
        mkdir($cssFolder, 0755, true); // Recursive flag to create nested folders
    }

    if (!is_dir($jsFolder)) {
        mkdir($jsFolder, 0755, true); // Recursive flag to create nested folders
    }

    $customCssFile = $cssFolder . '/custom.css';
    $resetCssFile = plugin_dir_path(__FILE__) . 'reset.css'; // Path to your reset.css file

    if (!is_file($customCssFile)) {
        $cssResetCode = file_get_contents($resetCssFile);
        file_put_contents($customCssFile, $cssResetCode);
    }
}
add_action('plugins_loaded', 'create_custom_folders');

function enqueue_custom_styles() {
    $options = get_option('enqueue_scripts_styles_options');
    $customCSSFileName = isset($options['custom_css_name']) ? $options['custom_css_name'] : '';

    if (!empty($customCSSFileName)) {
        wp_enqueue_style('custom-style', plugins_url('/css/' . $customCSSFileName, __FILE__), array(), '1.0', 'all');
    }
    // Enqueue other styles if needed
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');

function enqueue_custom_scripts() {
    $options = get_option('enqueue_scripts_styles_options');
    $customJSFileName = isset($options['custom_js_name']) ? $options['custom_js_name'] : '';

    if (!empty($customJSFileName)) {
        wp_enqueue_script('custom-script', plugins_url('/js/' . $customJSFileName, __FILE__), array('jquery'), '1.0', true);
    }
    // Enqueue other scripts if needed
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
