<?php
/**
 * Plugin Name: KDrexler Plugin
 * Plugin URI: http://kdrexler.com
 * Description: The very first plugin that I have ever created.
 * Version: 1.0
 * Author: Kasey Drexler
 * Author URI: http://kdrexler.com
 */









/// functions to call and print ads out on screens

function kdrexler_horizontal_ad ($content) {
    if ( is_singular() && in_the_loop() && is_main_query() ) {
        $options = get_option( 'kdrexler_values' );
        if (isset($options['ad_slot_horizontal']) && strlen($options['ad_slot_horizontal'])>0 && isset($options['ad_slot_horizontal_visible']) && isset($options['ad_slot_horizontal_visible'])==1) {
            echo $content.'<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><!-- Display Ad1 --><ins class="adsbygoogle" style="display:block" data-ad-client="'.esc_attr($options['api_key']).'" data-ad-slot="'.$options['ad_slot_horizontal'].'" data-ad-format="auto" data-full-width-responsive="false"></ins><script>     (adsbygoogle = window.adsbygoogle || []).push({});</script>';
        }
    }
}
function kdrexler_square_ad ($content) {
    if ( is_singular() && in_the_loop() && is_main_query() ) {
        $options = get_option( 'kdrexler_values' );
        if (isset($options['ad_slot_square']) && strlen($options['ad_slot_square'])>0 && isset($options['ad_slot_square_visible']) && isset($options['ad_slot_square_visible'])==1) {
            echo $content.'<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><!-- Display Ad1 --><ins class="adsbygoogle" style="display:block" data-ad-client="'.esc_attr($options['api_key']).'" data-ad-slot="'.$options['ad_slot_square'].'" data-ad-format="auto" data-full-width-responsive="true"></ins><script>     (adsbygoogle = window.adsbygoogle || []).push({});</script>';
        }
    }
}
function kdrexler_vertical_ad ($content) {
    if ( is_singular() && in_the_loop() && is_main_query() ) {
        $options = get_option( 'kdrexler_values' );
        if (isset($options['ad_slot_vertical']) && strlen($options['ad_slot_vertical'])>0 && isset($options['ad_slot_vertical_visible']) && isset($options['ad_slot_vertical_visible'])==1) {
            echo $content.'<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><!-- Display Ad1 --><ins class="adsbygoogle" style="display:block" data-ad-client="'.esc_attr($options['api_key']).'" data-ad-slot="'.$options['ad_slot_vertical'].'" data-ad-format="auto" data-full-width-responsive="true"></ins><script>     (adsbygoogle = window.adsbygoogle || []).push({});</script>';
        }
    }
}

// Setup horizontal ads below each post

if (! is_admin() && !wp_doing_ajax() ) {
    add_action('the_content', 'kdrexler_horizontal_ad', 1);
}
// add a new option


function kdrexler_add_settings_page() {
    add_options_page( 'Kdrexler Plugin Settings', 'Kdrexler Plugin Settings', 'manage_options', 'kdrexler-example-plugin', 'kdrexler_render_plugin_settings_page' );
}
add_action( 'admin_menu', 'kdrexler_add_settings_page' );
function kdrexler_render_plugin_settings_page() {
    ?>
    <h2>K Plugin Settings</h2>
    <form action="options.php" method="post">
        <?php 
        settings_fields( 'kdrexler_example_plugin_options' );
        do_settings_sections( 'kdrexler_example_plugin' ); ?>
        <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save' ); ?>" />
    </form>
    <div style="background-color:white;padding:10px;margin-top:20px;">
        <h2>How to Use:</h2>
        <p>Currently only horizontal ads are used. When horizontal ads are allowed to be visible they will display underneath each post on the site. </p>
        <p><b>API Key</b> is your google <b>data-ad-client</b> value from AdSense.</p>
        <p><b>Google Data Horizontal Ad Slot #</b> is the <b>data-ad-slot</b> value from a horizontal ad from your AdSense account.</p>
        <p><b>Google Data Square Ad Slot #</b> is the <b>data-ad-slot</b> value from a horizontal ad from your AdSense account.</p>
        <p><b>Google Data Vertical Ad Slot #</b> is the <b>data-ad-slot</b> value from a horizontal ad from your AdSense account.</p>
        <p>Use the "Visible" checkboxes to make an ad of that type visible or not on the site.</p> 
        <p>You can use these ads in any content by calling the following functions in php:</p>
        <pre>
        function kdrexler_horizontal_ad()
    	function kdrexler_square_ad()
    	function kdrexler_vertical_ad()
    	
    	// adding as a hook
    	add_action('the_content', 'kdrexler_horizontal_ad', 1); // NOTE: this one is baked into this plugin. 
    	</pre>
    </div>
    <?php
}


function kdrexler_settings_init() {
    // register a new setting for "reading" page
    
    register_setting( 'kdrexler_example_plugin_options', 'kdrexler_values' );
    add_settings_section( 'api_settings', 'API Settings', 'kdrexler_plugin_section_text', 'kdrexler_example_plugin' );

    add_settings_field( 'kdrexler_plugin_setting_api_key', 'API Key', 'kdrexler_plugin_setting_api_key', 'kdrexler_example_plugin', 'api_settings' );
    add_settings_field( 'kdrexler_plugin_setting_ad_slot_horizontal', 'Google Data Horizontal Ad Slot #', 'kdrexler_plugin_setting_ad_slot_horizontal', 'kdrexler_example_plugin', 'api_settings');
    add_settings_field( 'kdrexler_plugin_setting_ad_slot_square', 'Google Data Square Ad Slot #', 'kdrexler_plugin_setting_ad_slot_square', 'kdrexler_example_plugin', 'api_settings');
    add_settings_field( 'kdrexler_plugin_setting_ad_slot_vertical', 'Google Data Vertical Ad Slot #', 'kdrexler_plugin_setting_ad_slot_vertical', 'kdrexler_example_plugin', 'api_settings');
    add_settings_field( 'kdrexler_plugin_setting_ad_slot_horizontal_visible', 'Horizontal Ads Visible', 'kdrexler_plugin_setting_ad_slot_horizontal_visible', 'kdrexler_example_plugin', 'api_settings');
    add_settings_field( 'kdrexler_plugin_setting_ad_slot_square_visible', 'Square ads visible', 'kdrexler_plugin_setting_ad_slot_square_visible', 'kdrexler_example_plugin', 'api_settings');
    add_settings_field( 'kdrexler_plugin_setting_ad_slot_vertical_visible', 'Vertical ads visible', 'kdrexler_plugin_setting_ad_slot_vertical_visible', 'kdrexler_example_plugin', 'api_settings');
    
}
 
/**
 * register wporg_settings_init to the admin_init action hook
 */
add_action('admin_init', 'kdrexler_settings_init');
function kdrexler_plugin_section_text() {
    echo '<p>Here you can set all the options for using the API</p>';
}

function kdrexler_plugin_setting_api_key() {
    $options = get_option( 'kdrexler_values' );
    echo "<input id='kdrexler_values_api_key' name='kdrexler_values[api_key]' type='text' value='".esc_attr($options['api_key'])."' />";
}

function kdrexler_plugin_setting_ad_slot_horizontal() {
    $options = get_option( 'kdrexler_values' );
    echo "<input id='kdrexler_values_ad_slot_horizontal' name='kdrexler_values[ad_slot_horizontal]' type='text' value='".esc_attr($options['ad_slot_horizontal'])."' />";
}
function kdrexler_plugin_setting_ad_slot_horizontal_visible() {
    $options = get_option( 'kdrexler_values' );
    echo "<input id='kdrexler_values_ad_slot_horizontal_visible' name='kdrexler_values[ad_slot_horizontal_visible]' type='checkbox' value='1' ".(esc_attr($options['ad_slot_horizontal_visible'])==1 ? 'checked' : '')." />";
}

function kdrexler_plugin_setting_ad_slot_square() {
    $options = get_option( 'kdrexler_values' );
    echo "<input id='kdrexler_values_ad_slot_square' name='kdrexler_values[ad_slot_square]' type='text' value='".esc_attr($options['ad_slot_square'])."' />";
}
function kdrexler_plugin_setting_ad_slot_square_visible() {
    $options = get_option( 'kdrexler_values' );
    echo "<input id='kdrexler_values_ad_slot_square_visible' name='kdrexler_values[ad_slot_square_visible]' type='checkbox' value='1' ".(esc_attr($options['ad_slot_square_visible'])==1 ? 'checked' : '')." />";
}

function kdrexler_plugin_setting_ad_slot_vertical() {
    $options = get_option( 'kdrexler_values' );
    echo "<input id='kdrexler_values_ad_slot_vertical' name='kdrexler_values[ad_slot_vertical]' type='text' value='".esc_attr($options['ad_slot_vertical'])."' />";
}
function kdrexler_plugin_setting_ad_slot_vertical_visible() {
    $options = get_option( 'kdrexler_values' );
    echo "<input id='kdrexler_values_ad_slot_vertical_visible' name='kdrexler_values[ad_slot_vertical_visible]' type='checkbox' value='1' ".(esc_attr($options['ad_slot_vertical_visible'])==1 ? 'checked' : '')." />";
}


// get an option
//$option = get_option('kdrexler_custom_option');


// add menu
function kdrexler_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "kdrexler_options"
            settings_fields( 'kdrexler_example_plugin_options' );
            // output setting sections and their fields
            do_settings_sections( 'api_settings' );
            // output save settings button
            submit_button( __( 'Save Settings', 'textdomain' ) );
            ?>
        </form>
    </div>
    <?php
}

function kdrexler_options_page()
{
    add_submenu_page(
        'tools.php',
        'Kdrexler Options',
        'Kdrexler Options',
        'manage_options',
        'kdrexler',
        'kdrexler_options_page_html'
    );
}
add_action('admin_menu', 'kdrexler_options_page');



?>