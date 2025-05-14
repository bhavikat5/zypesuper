<?php
/**
 * Plugin Name: Zype Super
 * Description: Combined plugin featuring Global Variables Manager and Custom Widget functionality
 * Version: 1.0.1
 * Author: Bhavik
 * Text Domain: zype-super
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('ZYPE_SUPER_PATH', plugin_dir_path(__FILE__));
define('ZYPE_SUPER_URL', plugin_dir_url(__FILE__));

// Create main admin menu
add_action('admin_menu', 'zype_super_add_admin_menu');
function zype_super_add_admin_menu() {
    // Add main Zype Super menu
    add_menu_page(
        'Zype Super',
        'Zype Super',
        'manage_options',
        'zype-super',
        'zype_super_main_page',
        'dashicons-superhero',
        30
    );
    
    // Add Global Variables as submenu
    add_submenu_page(
        'zype-super',                
        'Global Variables',         
        'Global Variables',       
        'manage_options',          
        'zype-global-variables',    
        'render_global_settings_page'
    );

    // Add EMI Table as submenu
   add_submenu_page(
    'zype-super',
    'EMI Table Interest Defaults',
    'EMI Table Interest Defaults',
    'manage_options',
    'zype-super-emi-defaults',
    'zype_super_emi_defaults_page'
);
    
}
add_action('admin_init', function() {
    register_setting('zype_super_emi_group', 'zype_super_default_interest');
});

// Main Zype Super dashboard page
function zype_super_main_page() {
    ?>
    <div class="wrap">
        <h1>Welcome to Zype Super</h1>
        <div class="card" style="max-width: 800px; padding: 20px; margin-top: 20px;">
            <h2>Plugin Features</h2>
            <p>This plugin combines the following functionality:</p>
            <ul style="list-style-type: disc; padding-left: 20px;">
                <li><strong>Global Variables Manager</strong>: Manage multilingual global variables</li>
               
            </ul>
            <p>Use the sidebar menu to access each component.</p>
        </div>
    </div>
    <?php
}

function zype_super_register_widgets($widgets_manager) {
    require_once __DIR__ . '/elementor-widgets/widget-loan-by-amount.php';
    $widgets_manager->register(new \ZypeSuper\ElementorWidgets\Loan_By_Amount_Widget());

    require_once __DIR__ . '/elementor-widgets/widget-loan-by-salary.php';
$widgets_manager->register(new \ZypeSuper\ElementorWidgets\Loan_By_Salary_Widget());
}
add_action('elementor/widgets/register', 'zype_super_register_widgets');

function zype_super_register_styles() {
    wp_register_style(
        'zype-loan-buttons',
        plugin_dir_url(__FILE__) . 'assets/css/widget.css',
        [],
        '1.0.1'
    );
}
add_action('init', 'zype_super_register_styles');



add_action( 'elementor/elements/categories_registered', function( $elements_manager ) {
    $elements_manager->add_category(
        'zype-super',
        [
            'title' => __( 'Zype Super', 'zype-super' ),
            'icon'  => 'fa fa-plug',
        ]
    );
} );

// function zype_super_register_emi_settings() {
//     add_menu_page(
//         'EMI Defaults',
//         'EMI Defaults',
//         'manage_options',
//         'zype-super-emi-defaults',
//         'zype_super_emi_defaults_page',
//         'dashicons-calculator',
//         56
//     );

//     add_action('admin_init', function() {
//         register_setting('zype_super_emi_group', 'zype_super_default_interest');
//     });
// }

// add_action('admin_menu', 'zype_super_register_emi_settings');

function zype_super_emi_defaults_page() {
    ?>
    <div class="wrap">
        <h1>EMI Default Settings</h1>
        <form method="post" action="options.php">
            <?php
                settings_fields('zype_super_emi_group');
                do_settings_sections('zype_super_emi_group');
                $interest = get_option('zype_super_default_interest', 18);
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Default Interest Rate (%)</th>
                    <td><input type="number" step="0.01" name="zype_super_default_interest" value="<?php echo esc_attr($interest); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}


// Load EMI Table widget
add_action('elementor/widgets/register', function($widgets_manager) {
    require_once plugin_dir_path(__FILE__) . 'elementor-widgets/widget-emi-table.php';
    $widgets_manager->register(new \ZypeSuper\Widgets\EMI_Table_Widget());
});

// Include the two plugins - DO NOT include the widget file directly here
require_once ZYPE_SUPER_PATH . 'includes/global-variables/global-variables.php';