<?php
/*
Plugin Name: Enqueue Scripts and Styles
Description: Plugin to enqueue custom scripts and styles without requiring a child theme - especially useful for FSE themes.
Version: 1.1
Author: Brandon Meyer
*/

/*
Plugin Name: Enqueue Scripts and Styles
Description: Plugin to enqueue custom scripts and styles without requiring a child theme - especially useful for FSE themes.
Version: 1.1
Author: Brandon Meyer
*/

// Function to create custom folders on plugin activation for each site
function create_custom_folders_per_site($blog_id) {
    switch_to_blog($blog_id);

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

    restore_current_blog();
}
register_activation_hook(__FILE__, 'plugin_activate_per_site');

function plugin_activate_per_site() {
    if (function_exists('is_multisite') && is_multisite()) {
        global $wpdb;
        $blog_ids = $wpdb->get_col("SELECT blog_id FROM {$wpdb->blogs}");

        foreach ($blog_ids as $blog_id) {
            create_custom_folders_per_site($blog_id);
        }
    } else {
        create_custom_folders_per_site(1); // If not multisite, create for the main site
    }
}

add_action('plugins_loaded', 'create_custom_folders');

function enqueue_custom_styles() {
    if (is_multisite()) {
        $current_site_id = get_current_blog_id();
        $cssURL = content_url('/enqueued-scripts-styles/' . $current_site_id . '/css/');
    } else {
        $cssURL = plugins_url('/css/', __FILE__);
    }

    $options = get_option('enqueue_scripts_styles_options');
    $customCSSFileName = isset($options['custom_css_name']) ? $options['custom_css_name'] : '';

    if (!empty($customCSSFileName)) {
        wp_enqueue_style('custom-style', $cssURL . $customCSSFileName, array(), '1.0', 'all');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');

function enqueue_custom_scripts() {
    if (is_multisite()) {
        $current_site_id = get_current_blog_id();
        $jsURL = content_url('/enqueued-scripts-styles/' . $current_site_id . '/js/');
    } else {
        $jsURL = plugins_url('/js/', __FILE__);
    }

    $options = get_option('enqueue_scripts_styles_options');
    $customJSFileName = isset($options['custom_js_name']) ? $options['custom_js_name'] : '';

    if (!empty($customJSFileName)) {
        wp_enqueue_script('custom-script', $jsURL . $customJSFileName, array('jquery'), '1.0', true);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

?>