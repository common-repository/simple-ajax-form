<?php
/*
Plugin Name: Simple AJAX Form
Plugin URI: http://www.tcbarrett.com
Description: Shows how to build some standard AJAX forms in WordPress
Version: 1.0
Author: tcbarrett
Author URI: http://www.tcbarrett.com
*/
define( 'TCBAJAXPLUGINDIR', dirname(__FILE__) );
define( 'TCBAJAXPLUGINURL', plugin_dir_url(__FILE__) );

add_action('wp_ajax_simpleajaxform', 'tcb_wp_ajax_simpleajaxform');
function tcb_wp_ajax_simpleajaxform(){
  $message = $_POST['message'];
  die("<p><strong>Your message</strong>: $message</p>");
}

add_action('admin_menu', 'tcb_admin_menu');
function tcb_admin_menu(){
  $menu = add_menu_page( 'SimpleAJAX', 'Simple AJAX', 'read', 'simple-ajax-form', 'tcb_menu_simpleajaxform' ); 
  add_action('admin_print_styles-'.$menu, 'tcb_admin_enqueue_scripts');
}
function tcb_admin_enqueue_scripts(){
  wp_register_script( 'tcb-jquery-form-validate', TCBAJAXPLUGINURL.'/js/jquery.validate.min.js', array('jquery-form') );
  wp_register_script( 'tcb-simple-ajax-form',     TCBAJAXPLUGINURL.'/js/simple-ajax-form.js',    array('tcb-jquery-form-validate'));
  wp_enqueue_script('tcb-jquery-form-validate');
  wp_enqueue_script('tcb-simple-ajax-form');
}
function tcb_menu_simpleajaxform(){
  global $wpdb;
  $ajax  = admin_url('admin-ajax.php');
  echo '<h1>Simple AJAX Form Example</h1>';

  $form = <<<FORM
 <form action="{$ajax}" method="post" class="simpleajaxform" target="example-response">
  <input type="hidden" name="action" value="simpleajaxform"/>
  <input type="text" name="message" class="required"/>
  <input type="submit" name="submit" value="SEND"/>
 </form>
 <div id="example-response"></div>
<style>
.updating {
    background-color: #FFE0FF;
    border-color: #E6DB55;
    border-radius: 3px 3px 3px 3px;
    border-style: solid;
    border-width: 1px;
    margin: 5px 15px 2px;
    padding: 0 0.6em;
    display: block;
}
</style>
FORM;
  echo $form;
}
