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
    // Enqueue CSS
    wp_enqueue_style('custom-style', WP_CONTENT_URL . '/enqueued-scripts-styles/css/custom.css', array(), '1.0', 'all');
    //wp_enqueue_style('another-style', WP_CONTENT_URL . '/enqueued-scripts-styles/css/another-style.css', array(), '1.0', 'all');
    // ... enqueue other styles
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');

function enqueue_custom_scripts() {
    // Enqueue JavaScript
    wp_enqueue_script('custom-script', WP_CONTENT_URL . '/enqueued-scripts-styles/js/custom.js', array('jquery'), '1.0', true);
    //wp_enqueue_script('another-script', WP_CONTENT_URL . '/enqueued-scripts-styles/js/another-script.js', array('jquery'), '1.0', true);
    // ... enqueue other scripts
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
