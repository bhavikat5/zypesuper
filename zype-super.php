<?php
/**
 * Plugin Name: Zype Super
 * Description: Combined plugin featuring Global Variables Manager and Custom Widget functionality
 * Version: 1.0.0
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
    
}

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



// Include the two plugins - DO NOT include the widget file directly here
require_once ZYPE_SUPER_PATH . 'includes/global-variables/global-variables.php';