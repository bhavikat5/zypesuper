<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Register Fields
add_action('admin_init', function () {
      $fields = [
        'interest_range' => 'Interest Range',
        'tenure_range' => 'Tenure Range',
        'processing_range' => 'Processing Range',
        'min_amt' => 'Minimum Amount',
        'max_amt' => 'Maximum Amount',
        'tenure' => 'Tenure',
        'max_amt_lakh' => 'Maximum Amount (Lakh)',
        'time_seconds' => 'Time (Seconds)',
        'time_minutes' => 'Time (Minutes)',
        'low_interest' => 'As Low As Interest',
    ];
    

    $langs = ['en' => 'English', 'hi' => 'Hindi', 'mr' => 'Marathi', 'ta' => 'Tamil'];

    foreach ($fields as $key => $label) {
        foreach ($langs as $lang_code => $lang_label) {
            // Skip download_app_link for hi and mr
            if (
                in_array($key, ['max_amt_lakh', 'time_seconds', 'time_minutes', 'low_interest']) &&
                in_array($lang_code, ['hi', 'mr', 'ta'])
            ) {
                continue;
            }

            $option_name = "{$key}_{$lang_code}";
            // Use different sanitization for download_app_link
            $sanitize_callback = ($key === 'download_app_link')
                ? 'wp_kses_post' // allows basic HTML
                : 'sanitize_text_field';

            register_setting('global_settings_group', $option_name, [
                'sanitize_callback' => $sanitize_callback,
            ]);

            add_settings_field(
                $option_name,
                "$label ($lang_label)",
                function () use ($option_name, $key) {
                    $value = esc_attr(get_option($option_name));
                    $shortcode = '[' . $option_name . ']';

                    
                        echo "<input type='text' name='{$option_name}' value='{$value}' class='regular-text'>";
                

                    echo "<p style='margin-top: 5px; font-size: 12px; color: #666;'>
                        <code class='gvm-shortcode' data-copy='[{$option_name}]'>[{$option_name}]</code>
                      </p>";
                },
                'global-settings',
                'global_settings_section'
            );
        }
    }

    add_settings_section('global_settings_section', '', null, 'global-settings');
});


// Register Shortcodes
add_action('init', function () {
    $fields = ['interest_range', 'tenure_range', 'processing_range', 'min_amt', 'max_amt', 'tenure', 'download_app_link', 'time_seconds', 'time_minutes', 'low_interest'];
    $langs = ['en', 'hi', 'mr','ta'];

    foreach ($fields as $field) {
        foreach ($langs as $lang) {  
            add_shortcode("{$field}_{$lang}", function () use ($field, $lang) {
                $option = get_option("{$field}_{$lang}", '');
                return esc_html($option);
            });
        }
    }
});

// Add script to page footer
add_action('admin_footer', function() {
    if (isset($_GET['page']) && $_GET['page'] == 'zype-global-variables') {
        // Use wp_add_inline_script for better security
        wp_register_script('zype-global-script', '', [], '', true);
        wp_enqueue_script('zype-global-script');
        $script = "
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.gvm-shortcode').forEach(function (el) {
                    el.style.cursor = 'pointer';
                    el.addEventListener('click', function () {
                        const text = el.getAttribute('data-copy');
                        navigator.clipboard.writeText(text).then(() => {
                            el.style.backgroundColor = '#cce5ff';
                            setTimeout(() => {
                                el.style.backgroundColor = '';
                            }, 300);
                        });
                    });
                });
            });
        ";
        wp_add_inline_script('zype-global-script', $script);
    }
});

// Render Settings Page (Unchanged)
function render_global_settings_page() {
    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }
    ?>
    <div class="wrap">
        <h1>Global Variables</h1>
        <form method="post" action="options.php">
          
            <?php
            settings_fields('global_settings_group');
            do_settings_sections('global-settings');
            wp_nonce_field('global_settings_save', 'global_settings_nonce');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
// Nonce Security on Form Submission
add_action('admin_init', function() {
    if (isset($_POST['option_page']) && $_POST['option_page'] === 'global_settings_group') {
        if (!isset($_POST['global_settings_nonce']) || 
            !wp_verify_nonce($_POST['global_settings_nonce'], 'global_settings_save')) {
            wp_die('Security check failed');
        }
    }
}, 9);