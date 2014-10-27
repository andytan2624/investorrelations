<?php
/*
Plugin Name: Investors Hub
Plugin URI: http://jumbodisposition.com
Description: Provides share price information
Author: Andy Tan
Version: 1.0
Author URI: http://www.jumbodisposition.com
License: GPL2
*/

//Include admin
include dirname( __FILE__ ) .'/wpinvestors-admin.php';

function wp_investors_backend_styles() {
    wp_enqueue_style('wp_investors_backend_css',plugins_url('wpinvestors/css/style.css'));
    wp_enqueue_script('wp_investors_frontend_js',plugins_url('wpinvestors/js/front.js'), array('jquery'),'',true);

}
add_action('admin_head','wp_investors_backend_styles');

function wp_investors_frontend_scripts_and_styles() {
    wp_enqueue_style('wp_investors_backend_css',plugins_url('wpinvestors/css/style.css'));
    wp_enqueue_script('wp_investors_frontend_js',plugins_url('wpinvestors/js/front.js'), array('jquery'),'',true);

}
add_action('wp_enqueue_scripts','wp_investors_frontend_scripts_and_styles');

//register_activation_hook( __FILE__, array($this, 'run_on_activate') );
//
//function run_on_activate()
//{
//    // for notifications
//    if( !wp_next_scheduled( 'content_scheduler_notify' ) )
//    {
//        wp_schedule_event( time(), 'hourly', 'content_scheduler_notify' );
//    }
//
//
//} // end run_on_activate()
//
