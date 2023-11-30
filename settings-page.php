// Add a menu item for the settings page
function enqueue_scripts_styles_menu() {
    add_options_page(
        'Enqueue Scripts & Styles Settings',
        'Enqueue Scripts & Styles',
        'manage_options',
        'enqueue-scripts-styles-settings',
        'enqueue_scripts_styles_page'
    );
}
add_action('admin_menu', 'enqueue_scripts_styles_menu');

// Callback function to render the settings page
function enqueue_scripts_styles_page() {
    ?>
    <div class="wrap">
        <h1>Enqueue Scripts & Styles Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('enqueue_scripts_styles_options');
            do_settings_sections('enqueue-scripts-styles-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register settings and fields
function enqueue_scripts_styles_settings_init() {
    register_setting(
        'enqueue_scripts_styles_options',
        'enqueue_scripts_styles_options',
        'enqueue_scripts_styles_options_validate'
    );

    add_settings_section(
        'enqueue_scripts_styles_section',
        'Custom CSS and JS File Names',
        'enqueue_scripts_styles_section_callback',
        'enqueue-scripts-styles-settings'
    );

    add_settings_field(
        'custom_css_name',
        'Custom CSS File Name',
        'custom_css_name_callback',
        'enqueue-scripts-styles-settings',
        'enqueue_scripts_styles_section'
    );

    add_settings_field(
        'custom_js_name',
        'Custom JS File Name',
        'custom_js_name_callback',
        'enqueue-scripts-styles-settings',
        'enqueue_scripts_styles_section'
    );
}
add_action('admin_init', 'enqueue_scripts_styles_settings_init');

// Settings section callback
function enqueue_scripts_styles_section_callback() {
    echo '<p>Enter the file names for your custom CSS and JS files.</p>';
}

// Callback for custom CSS file name field
function custom_css_name_callback() {
    $options = get_option('enqueue_scripts_styles_options');
    echo "<input type='text' id='custom_css_name' name='enqueue_scripts_styles_options[custom_css_name]' value='" . esc_attr($options['custom_css_name']) . "' />";
}

// Callback for custom JS file name field
function custom_js_name_callback() {
    $options = get_option('enqueue_scripts_styles_options');
    echo "<input type='text' id='custom_js_name' name='enqueue_scripts_styles_options[custom_js_name]' value='" . esc_attr($options['custom_js_name']) . "' />";
}

// Validation callback
function enqueue_scripts_styles_options_validate($input) {
    $valid = array();
    $valid['custom_css_name'] = sanitize_text_field($input['custom_css_name']);
    $valid['custom_js_name'] = sanitize_text_field($input['custom_js_name']);
    return $valid;
}
