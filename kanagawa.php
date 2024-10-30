<?php   /*php says to leave out closing tag*/
    /* 
    Plugin Name: Kanagawa SMS Alerts
    Plugin URI: http://www.kanagawa-sms-alerts.com
    Description: Client plugin for Kanagawa text messaging app
    Author: Mark J. Lorenz
    Version: 1.0 
    Author URI: http://www.dapplebeforedawn.com
    */  

function build_kanagawa_admin() {
  //require('kanagawa_admin.php');
  include('kanagawa_options.php');
}

/*To use, just put `<?php build_kanagawa_public(); ?>` in a public template*/
function build_kanagawa_public() {
  include('kanagawa_public.php');
}

function kanagawa_admin_actions() {  
  add_options_page("Kanagawa SMS Alets", "Kanagawa SMS Alerts", 1, "kanagawa_options.php", "build_kanagawa_admin");  
}  
function register_kanagawa_settings() { // whitelist options
  register_setting( 'kanagawa-group', 'kanagawa-token' );
  add_settings_section( 'kanagawa-group', 'Kanagawa Secret Token', null, 'kanagawa-settings-page' );
}
if ( is_admin() ){ // admin actions
  add_action('admin_menu', 'kanagawa_admin_actions');  
  add_action( 'admin_init', 'register_kanagawa_settings' );
} 

/* -- Register Short Codes */
function kanagawa_subscribe_shortcode($atts, $content = null){
  ob_start();
  include('kanagawa_public.php');
  return ob_get_clean();
}
add_shortcode( 'kanagawa_subscribe', 'kanagawa_subscribe_shortcode' );

/* -- Register Admin Widget */
function build_kanawaga_dashboard_widget() {
  include('kanagawa_admin.php');
}

function kanagawa_add_dashboard_widgets() {
  wp_add_dashboard_widget('kanagawa_admin_widget', 'Broadcast Alerts', 'build_kanawaga_dashboard_widget');
}
add_action('wp_dashboard_setup', 'kanagawa_add_dashboard_widgets' );
