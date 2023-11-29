<?php
/*
Plugin Name: Enqueue Scripts and Styles
Description: Plugin to enqueue custom scripts and styles without requiring a child theme - especially useful for FSE themes.
Version: 1.0
Author: Brandon Meyer
*/

function enqueue_custom_styles() {
    // Enqueue CSS
    wp_enqueue_style('custom-style', plugins_url('/css/custom.css', __FILE__), array(), '1.0', 'all');
    //wp_enqueue_style('another-style', plugins_url('/css/another-style.css', __FILE__), array(), '1.0', 'all');
    // ... enqueue other styles
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');

function enqueue_custom_scripts() {
    // Enqueue JavaScript
    wp_enqueue_script('custom-script', plugins_url('/js/custom.js', __FILE__), array('jquery'), '1.0', true);
    //wp_enqueue_script('another-script', plugins_url('/js/another-script.js', __FILE__), array('jquery'), '1.0', true);
    // ... enqueue other scripts
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
