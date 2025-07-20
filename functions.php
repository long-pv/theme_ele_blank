<?php
define('CHILD_URI', get_stylesheet_directory_uri());
define('CHILD_PATH', get_stylesheet_directory());
define('TEMPLATE_PATH', CHILD_PATH . '/elementor-widgets/template/');
if (!defined('_S_VERSION')) {
    define('_S_VERSION', '1.0.0');
}
if (!defined('WP_MEMORY_LIMIT')) {
    define('WP_MEMORY_LIMIT', '256M');
}
if (!defined('WP_MAX_MEMORY_LIMIT')) {
    define('WP_MAX_MEMORY_LIMIT', '512M');
}
// turn on auto update core wp
// define('WP_AUTO_UPDATE_CORE', true); // Bật cập nhật tự động WordPress
// define('AUTOMATIC_UPDATER_DISABLED', false); // Đảm bảo cập nhật tự động không bị tắt
// define('WP_AUTO_UPDATE_PLUGINS', true); // Kích hoạt cập nhật tự động cho Plugin
// define('WP_AUTO_UPDATE_THEMES', true); // Kích hoạt cập nhật tự động cho Theme
// add_filter('auto_update_plugin', '__return_true'); // Tự động cập nhật plugin
// add_filter('auto_update_theme', '__return_true'); // Tự động cập nhật theme
// add_filter('auto_update_core', '__return_true'); // Tự động cập nhật WordPress core (cả bản lớn & nhỏ)

// turn off auto update core wp
// define('AUTOMATIC_UPDATER_DISABLED', true); // Vô hiệu hóa mọi cập nhật tự động
// define('WP_AUTO_UPDATE_CORE', false); // Ngăn cập nhật core WordPress
// define('DISALLOW_FILE_MODS', true); // Ngăn chỉnh sửa file từ Admin
// define('DISALLOW_FILE_EDIT', true); // Tắt trình chỉnh sửa file trong Dashboard
// add_filter('auto_update_plugin', '__return_false'); // Ngăn cập nhật tự động plugin

/**
 * Enqueue scripts and styles.
 */
function child_theme_scripts()
{
    wp_enqueue_style('child_theme-style', CHILD_URI, array(), _S_VERSION);

    // normalize
    wp_enqueue_style('child_theme-style-normalize', CHILD_URI . '/assets/inc/normalize/normalize.css', array(), _S_VERSION);

    // bootstrap grid
    wp_enqueue_style('child_theme-style-grid', CHILD_URI . '/assets/inc/bootstrap/grid.css', array(), _S_VERSION);
    wp_enqueue_script('child_theme-script-bootstrap', CHILD_URI . '/assets/inc/bootstrap/bootstrap.min.js', array('jquery'), _S_VERSION, true);

    // jquery ui
    // wp_enqueue_style('child_theme-style-jquery-ui', CHILD_URI . '/assets/inc/jquery-ui/jquery-ui.css', array(), _S_VERSION);
    // wp_enqueue_script('child_theme-script-jquery-ui', CHILD_URI . '/assets/inc/jquery-ui/jquery-ui.js', array('jquery'), _S_VERSION, true);

    // slick
    // wp_enqueue_style('child_theme-style-slick-theme', CHILD_URI . '/assets/inc/slick/slick-theme.css', array(), _S_VERSION);
    // wp_enqueue_style('child_theme-style-slick', CHILD_URI . '/assets/inc/slick/slick.css', array(), _S_VERSION);
    // wp_enqueue_script('child_theme-script-slick', CHILD_URI . '/assets/inc/slick/slick.min.js', array('jquery'), _S_VERSION, true);

    // flatpickr
    // wp_enqueue_style('child_theme-style-flatpickr', CHILD_URI . '/assets/inc/flatpickr/flatpickr.min.css', array(), _S_VERSION);
    // wp_enqueue_script('child_theme-script-flatpickr', CHILD_URI . '/assets/inc/flatpickr/flatpickr.js', array('jquery'), _S_VERSION, true);

    // validate
    // wp_enqueue_script('child_theme-script-validate', CHILD_URI . '/assets/inc/validate/jquery.validate.min.js', array('jquery'), _S_VERSION, true);

    // matchHeight
    wp_enqueue_script('child_theme-script-matchHeight', CHILD_URI . '/assets/inc/matchHeight/jquery.matchHeight.js', array('jquery'), _S_VERSION, true);

    // intlTelInput
    // wp_enqueue_style('child_theme-style-intlTelInput', CHILD_URI . '/assets/inc/intlTelInput/intlTelInput.css', array(), _S_VERSION);
    // wp_enqueue_script('child_theme-script-intlTelInput', CHILD_URI . '/assets/inc/intlTelInput/intlTelInput.js', array('jquery'), _S_VERSION, true);

    // select2
    // wp_enqueue_style('child_theme-style-select2', CHILD_URI . '/assets/inc/select2/select2.css', array(), _S_VERSION);
    // wp_enqueue_script('child_theme-script-select2', CHILD_URI . '/assets/inc/select2/select2.js', array('jquery'), _S_VERSION, true);

    // add custom main css/js
    $main_css_file_path = CHILD_PATH . '/assets/css/main.css';
    $main_js_file_path = CHILD_PATH . '/assets/js/main.js';
    $ver_main_css = file_exists($main_css_file_path) ? filemtime($main_css_file_path) : _S_VERSION;
    $ver_main_js = file_exists($main_js_file_path) ? filemtime($main_js_file_path) : _S_VERSION;
    wp_enqueue_style('dev_theme-style-main', CHILD_URI . '/assets/css/main.css', array(), $ver_main_css);
    wp_enqueue_script('dev_theme-script-main', CHILD_URI . '/assets/js/main.js', array('jquery'), $ver_main_js, true);

    // ajax admin
    wp_localize_script('hello-child-ajax_url', 'custom_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'child_theme_scripts');

// The function "write_log" is used to write debug logs to a file in PHP.
function write_log($log = null, $title = 'Debug')
{
    if ($log) {
        if (is_array($log) || is_object($log)) {
            $log = print_r($log, true);
        }

        $timestamp = date('Y-m-d H:i:s');
        $text = '[' . $timestamp . '] : ' . $title . ' - Log: ' . $log . "\n";
        $log_file = WP_CONTENT_DIR . '/debug.log';
        $file_handle = fopen($log_file, 'a');
        fwrite($file_handle, $text);
        fclose($file_handle);
    }
}

// Tạo menu theme settings chung
// Setup theme setting page
if (function_exists('acf_add_options_page')) {
    // Trang cài đặt chính
    acf_add_options_page(array(
        'page_title' => 'Theme Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug'  => 'theme-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
        'position'   => 80
    ));
}
// end

// stop upgrading ACF pro plugin
add_filter('site_transient_update_plugins', 'disable_plugins_update');
function disable_plugins_update($value)
{
    // disable acf pro
    if (isset($value->response['advanced-custom-fields-pro/acf.php'])) {
        unset($value->response['advanced-custom-fields-pro/acf.php']);
    }
    return $value;
}

// load widgets library by elementor
function load_custom_widgets()
{
    require CHILD_PATH . '/elementor-widgets/index.php';
}
add_action('elementor/init', 'load_custom_widgets');
// end

// tối đa revision
add_filter('wp_revisions_to_keep', function ($num, $post) {
    return 3;
}, 10, 2);

add_shortcode('bcn_display', function () {
    if (function_exists('bcn_display')) {
        ob_start();
        bcn_display();
        return ob_get_clean();
    }
});
