<?php
/**
  Plugin Name: Nav Menu search for admin
  Plugin URI: #
  Description: Nav Menu search for admin panel.
  Author: Md. Ruhul Amin
  Version: 1.0
  Author URI: https://profiles.wordpress.org/desert_king
 */
define('searchMenu__PLUGIN_DIR', plugin_dir_path(__FILE__));
require_once( searchMenu__PLUGIN_DIR . 'nMSA_searchClass.php' );

function nMSA_load_Nav_searchMenu_css_and_js() {
    wp_register_style('jqueryUIcss', plugins_url('jquery-ui.css', __FILE__));
    wp_enqueue_style('jqueryUIcss');
    wp_enqueue_script( 'jquery-ui-autocomplete' );
}

add_action('admin_init', 'nMSA_load_Nav_searchMenu_css_and_js');


/**
 * Instantiates the class
 */
add_action('admin_init', array('nMSA_searchClass', 'init'));
