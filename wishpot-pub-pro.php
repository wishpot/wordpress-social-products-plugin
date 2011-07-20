<?php
/*
Plugin Name: Wishpot Publisher Pro&copy; 
Plugin URI: http://wishpot.com/wordpress-plugins/wishpot-publisher-pro
Description: Wishpot Publisher Pro&copy; allows you to easily add product based ads to your wordpress powered website as widget in a sidebar or as pages.
Version: 1.0.4
Author: Wishpot Inc
Author URI: http://wishpot.com
License: GPL2
*/

global $wpdb;

define('WISPURL', WP_PLUGIN_URL . '/' . str_replace(basename( __FILE__),"",plugin_basename(__FILE__)) );
define('WISPDIR', WP_PLUGIN_DIR . '/' . str_replace(basename( __FILE__),"",plugin_basename(__FILE__)) );

$wishpot_plugin_url = WISPURL;


// relative path to WP_PLUGIN_DIR where the translation files will sit:
$plugin_path = dirname(plugin_basename(__FILE__)) . '/lang';
load_plugin_textdomain( 'wishpot-pub-pro', false, $plugin_path );


if ( function_exists('load_plugin_textdomain') ) 
{
  if ( !defined('WP_PLUGIN_DIR') ) 
  {
    load_plugin_textdomain( 'wishpot-pub-pro', str_replace( ABSPATH, '', dirname(__FILE__)) . '/lang');
  } 
  else 
  {
    load_plugin_textdomain( 'wishpot-pub-pro', false, dirname(plugin_basename(__FILE__)) . '/lang');
  }
}



include_once( dirname(__FILE__) . '/wishpot-pub-pro-widgets.php');
include_once( dirname(__FILE__) . '/wishpot-pub-pro-functions.php');
include_once( dirname(__FILE__) . '/wishpot-pub-pro-option-page.php');

register_activation_hook(   __FILE__, 'wishpot_pub_pro_plugin_activation');   
register_deactivation_hook( __FILE__, 'wishpot_pub_pro_plugin_deactivation'); 

add_action( 'admin_init',       'wishpot_pub_pro_init_method');
add_action( 'widgets_init',     create_function('', 'return register_widget("wishpot_pub_pro_Widget");'));
add_action( 'wp_print_styles',  'wishpot_pub_pro_print_styles');
add_action( 'wp_print_scripts', 'wishpot_pub_pro_print_scripts');
add_action( 'admin_menu',       'wishpot_pub_pro_plugin_add_option_page');
add_action( 'admin_head',       'wishpot_pub_pro_plugin_load_header_tags');
add_action( 'wp_footer',        'wishpot_pub_pro_wp_footer');
add_filter( 'the_content',      'wishpot_pub_pro_content');

//  ajax calls
add_action( 'wp_ajax_wishpot_pub_pro_ajax_action', 'wishpot_pub_pro_ajax_func_get_results');
add_action( 'wp_ajax_nopriv_wishpot_pub_pro_ajax_action', 'wishpot_pub_pro_ajax_func_get_results');


////////////////////////////////////////////////////////////////////////////////
// plugin activation hook
////////////////////////////////////////////////////////////////////////////////
function wishpot_pub_pro_plugin_activation() 
{
  //  check if default cat exists
  if ( !get_cat_ID('Wispot Publisher Pro') ) 
  {
    wp_create_category( 'Wishpot Publisher Pro' );
  }
  wishpot_pub_pro_reload_category();

  add_option( 'wishpot_pub_pro_options', array(), '', 'no');
  wishpot_pub_pro_set_option_defaults();

  wishpot_pub_pro_migrate_old_options();

  //  check if product detail page exists
  wishpot_pub_pro_create_product_search_results_page();

  return; 
}

////////////////////////////////////////////////////////////////////////////////
// plugin deactivation hook
////////////////////////////////////////////////////////////////////////////////
function wishpot_pub_pro_plugin_deactivation() 
{
  wp_clear_scheduled_hook('scheduled_import_articles_custom_hook');

  delete_option('wishpot_pub_pro_options');

  return;
}

////////////////////////////////////////////////////////////////////////////////
// add plugin option page
////////////////////////////////////////////////////////////////////////////////
function wishpot_pub_pro_plugin_add_option_page()
{
  add_menu_page(    'Wishpot Plugin Options',      'Wishpot', 'manage_options', 'wishpot-pub-pro-option-page', 'wishpot_pub_pro_plugin_create_option_page', WISPURL . 'img/wishpot_favicon.ico');
//  add_submenu_page( 'wishpot-pub-pro-option-page', 'About',             'About',            'manage_options', 'wishpot-pub-pro-about', 'wishpot_pub_pro_display_plugin_about');
//  add_submenu_page( 'wishpot-pub-pro-option-page', 'Wishpot Center',    'Wishpot Center',   'manage_options', 'wishpot-sub-page', 'wishpot_pub_pro_javascript_to_redirect_to_wishpotcenter');
}

////////////////////////////////////////////////////////////////////////////////
// load plugin wp-admin css and js
////////////////////////////////////////////////////////////////////////////////
function wishpot_pub_pro_plugin_load_header_tags()
{
  $js_number_categories = get_categories(array('hide_empty' => false));
  $js_category_count=0;
  foreach ($js_number_categories as $category) 
    $js_category_count++;

  echo 	"\n\n";
  echo 	'<!-- Wishpot Publisher Pro - Plugin Option CSS -->' . "\n";
  echo 	'<link rel="stylesheet" type="text/css" media="all" href="' . WISPURL . 'css/plugin-option.php" />';
	
  return;
}



////////////////////////////////////////////////////////////////////////////////
// plugin init method
////////////////////////////////////////////////////////////////////////////////
function wishpot_pub_pro_init_method()
{
  if ( get_magic_quotes_gpc() ) 
  {
    $_POST      = array_map( 'stripslashes_deep', $_POST );
    $_GET       = array_map( 'stripslashes_deep', $_GET );
    $_COOKIE    = array_map( 'stripslashes_deep', $_COOKIE );
    $_REQUEST   = array_map( 'stripslashes_deep', $_REQUEST );
  }

  wp_enqueue_script('dashboard');
  wp_enqueue_script('postbox');
  wp_enqueue_script('jquery-ui-resizable');
  wp_enqueue_script('jquery-ui-droppable');
  wp_enqueue_script('wp-ajax-response');

  $wishpot_pub_pro_products_cache = array();
  $wishpot_pub_pro_ads_cache = array();
  wp_cache_set('wishpot_pub_pro_products', $wishpot_pub_pro_products_cache);
  wp_cache_set('wishpot_pub_pro_ads', $wishpot_pub_pro_ads_cache);

  return;
}

////////////////////////////////////////////////////////////////////////////////
// plugin options functions
////////////////////////////////////////////////////////////////////////////////
function wishpot_pub_pro_get_option($field) 
{
  if (!$options = wp_cache_get('wishpot_pub_pro_options')) 
  {
    $options = get_option('wishpot_pub_pro_options');
    wp_cache_set('wishpot_pub_pro_options',$options);
  }
  return $options[$field];
}

function wishpot_pub_pro_update_option($field, $value) 
{
  wishpot_pub_pro_update_options(array($field => $value));
}

function wishpot_pub_pro_update_options($data) 
{
  $options = array_merge(get_option('wishpot_pub_pro_options'),$data);
  update_option('wishpot_pub_pro_options',$options);
  wp_cache_set('wishpot_pub_pro_options',$options);
}

function wishpot_pub_pro_migrate_old_options() 
{
  global $wpdb;

  //  check for a old Option
  if ( (get_option('wishpot_pub_pro_old_option') === false) ) 
  {
    return;
  }

  $old_fields = array(
       'wishpot_pub_pro_product_detail_page_id'   => NULL,
       'wishpot_pub_pro_widget_ga'         => 'off',
       'wishpot_pub_pro_pp_fblike'        => 'off',
       'wishpot_pub_pro_pp_fbshare'       => 'off',
       'wishpot_pub_pro_pp_twshare'       => 'off'
       );

  $new_fields = array(
       'wishpot_pub_pro_product_detail_page_id'   => NULL,
       'wishpot_pub_pro_widget_ga'         => 'off',
       'wishpot_pub_pro_pp_fblike'        => 'off',
       'wishpot_pub_pro_pp_fbshare'       => 'off',
       'wishpot_pub_pro_pp_twshare'       => 'off'
       );

  foreach($old_fields as $index=>$field) 
  {
    if ( $index == 3 )
    {
      $cats = get_option($old_fields[$index]);
      if ( is_array($cats) )
        wishpot_pub_pro_update_option($new_fields[$index], $cats);
      else
        wishpot_pub_pro_update_option($new_fields[$index], array($cats));
    }
    else
      wishpot_pub_pro_update_option($new_fields[$index], get_option($old_fields[$index]));
    delete_option($old_fields[$index]);
  }
  $wpdb->query("OPTIMIZE TABLE `" . $wpdb->options . "`");

  return;
}

function wishpot_pub_pro_set_option_defaults()
{
  $current_user_id=1;
  global $current_user;    
  get_currentuserinfo();

  if ( $current_user->ID != '' ) 
    $current_user_id=$current_user->ID;

  $default_options = array(
       'wishpot_pub_pro_product_detail_page_id'   => NULL,
       'wishpot_pub_pro_product_search_results_page_id'   => NULL,
       'wishpot_pub_pro_pagesize'                 => '18',
       'wishpot_pub_pro_widget_ga'                => 'off',
       'wishpot_pub_pro_pp_fblike'                => 'off',
       'wishpot_pub_pro_pp_fbshare'               => 'off',
       'wishpot_pub_pro_pp_twshare'               => 'off'
        );

  $wishpot_pub_pro_options = get_option('wishpot_pub_pro_options');

  foreach ($default_options as $def_option => $value )
  {
    if ( !$wishpot_pub_pro_options[$def_option] )
    {
      wishpot_pub_pro_update_option( $def_option, $value );
    }
  }

  return;
}



////////////////////////////////////////////////////////////////////////////////
// print plugin option page and check post data
////////////////////////////////////////////////////////////////////////////////
function wishpot_pub_pro_plugin_create_option_page()
{
  if ( $_POST['wishpot_pub_pro_add_cat_btn'] )
  {
    wishpot_pub_pro_add_category();
  }
  if ( $_POST['wishpot_pub_pro_reload_cats_btn'] )
  {
    wishpot_pub_pro_reload_category();
  }

  if ( $_POST['wishpot_pub_pro_update_options_btn'] )
  {
    wishpot_pub_pro_save_plugin_options();

    echo '<div id="message" class="updated fade">';
    echo '<strong>Plugin Settings saved !!!</strong></div>';
  }


  wishpot_pub_pro_plugin_print_option_page();

  return;
}



function wishpot_pub_pro_is_min_wp($version) 
{
  return version_compare( $GLOBALS['wp_version'], $version. 'alpha', '>=');
}



function wishpot_pub_pro_print_styles()
{
  if ( is_admin() )
  {
  }
  else
  {
    wp_register_style('wishpot_pub_pro_frontend_styles', WISPURL . 'css/wishpot-pub-pro-frontend-plugin.php');
    wp_register_style('wishpot_pub_pro_widget_styles', WISPURL . 'css/wishpot-pub-pro-widget.php');
    wp_enqueue_style( 'wishpot_pub_pro_frontend_styles' );
    wp_enqueue_style( 'wishpot_pub_pro_widget_styles' );
  }

  return;
}


function wishpot_pub_pro_print_scripts()
{
  global $wishpot_plugin_url;

  if ( is_admin() )
  {
  }
  else
  {
    //  print scripts for the public and frontend
    wp_enqueue_script(jquery);
    wp_enqueue_script(json);
    wp_enqueue_script(json2);
    wp_enqueue_script( 'wishpot_pub_pro_css_browser_script', plugin_dir_url( __FILE__ ) . 'js/css_browser_selector.js', false, false, false);
    wp_enqueue_script( 'wishpot_pub_pro_script', plugin_dir_url( __FILE__ ) . 'js/wishpot_pub_pro.js', array('jquery'), false, false);
    echo
    '
      <script type="text/javascript" language="javascript">
      //<![CDATA[
         var wishpot_plugin_url = "' . $wishpot_plugin_url . '";
         var ajaxurl  = "' . admin_url('admin-ajax.php') . '";
      //]]>
      </script>
    ';
  }

  return;
}


?>