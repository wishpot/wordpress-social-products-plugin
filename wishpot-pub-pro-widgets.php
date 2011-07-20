<?php

global $wishpot_plugin_url;

class wishpot_pub_pro_Widget extends WP_Widget 
{


//  public $wishpot_pub_pro_widget_ad_size     = array();
  public $wishpot_pub_pro_widget_ad_template     = array();
  public $wishpot_pub_pro_widget_ad_type         = array();
  public $wishpot_pub_pro_widget_ad_theme        = array();
  public $wishpot_pub_pro_widget_ad_category     = array();
  public $wishpot_pub_pro_widget_ad_country      = array();
  public $wishpot_pub_pro_widget_ad_keywords     = array();
  public $wishpot_pub_pro_widget_ad_placement_id = array();



  function wishpot_pub_pro_Widget() 
  {
/*
    $this->wishpot_pub_pro_widget_ad_size = array(
        0  => __('300x250', 'wishpot_pub_pro'),
        1  => __('160x600', 'wishpot_pub_pro'),
        2  => __('120x600', 'wishpot_pub_pro'),
        3  => __('125x125', 'wishpot_pub_pro'),
        4  => __('300x600', 'wishpot_pub_pro')
      );
*/

    $this->wishpot_pub_pro_widget_ad_template = array(
        1  => __('300x250 - One Product',    'wishpot_pub_pro'),
        2  => __('300x250 - Two Products',   'wishpot_pub_pro'),
        3  => __('160x600 - One Product',    'wishpot_pub_pro'),
        4  => __('160x600 - Two Product',    'wishpot_pub_pro'),
        5  => __('160x600 - Three Product',  'wishpot_pub_pro'),
        6  => __('160x600 - Four Products',  'wishpot_pub_pro'),
        7  => __('120x600 - One Product',    'wishpot_pub_pro'),
        8  => __('120x600 - Two Product',    'wishpot_pub_pro'),
        9  => __('120x600 - Three Product',  'wishpot_pub_pro'),
        10 => __('120x600 - Four Products',  'wishpot_pub_pro'),
        11 => __('300x600 - Eight Products', 'wishpot_pub_pro')
      );

    $this->wishpot_pub_pro_widget_ad_theme = array(
        0  => __('color picker',    'wishpot_pub_pro'),
        1  => __('theme one',   'wishpot_pub_pro')
      );

    $this->wishpot_pub_pro_widget_ad_type = array(
        0  => __('Popular Products',    'wishpot_pub_pro'),
        1  => __('Promotions',   'wishpot_pub_pro')
      );

    //  fill categories
    $wishpot_cat = get_cat_ID( 'Wishpot Publisher Pro' );
    $args = array(    
             'type'          => 'post',    
             'child_of'      => $wishpot_cat,
             'order_by'      => 'id',
             'order'         => 'desc',
             'hide_empty'    => 0
             );
    $wishpot_categories = get_categories( 'hide_empty=0&child_of=' . $wishpot_cat  ); 
    $this->wishpot_pub_pro_widget_ad_category = array();
    $this->wishpot_pub_pro_widget_ad_category[] = array( 'CatId' => '0', 'CatName' => 'All');
    foreach( $wishpot_categories as $wishpot_category )
    {
      $this->wishpot_pub_pro_widget_ad_category[] = array( 'CatId' => $wishpot_category->cat_ID, 'CatName' => $wishpot_category->cat_name);
    }

  
    $this->wishpot_pub_pro_widget_ad_country = array(
        0  => __('Auto-Detect',    'wishpot_pub_pro'),
        1  => __('US',   'wishpot_pub_pro'),
        2  => __('FR',    'wishpot_pub_pro'),
        3  => __('GER',  'wishpot_pub_pro'),
        4  => __('IT',    'wishpot_pub_pro')
      );


    /* Widget settings. */
    $widget_ops = array('classname' => 'wishpot_pub_pro', 'description' => __('Displays various types of Ads.','wishpot-pub-pro') );

    /* Widget control settings. */
    $control_ops = array('width' => 420, 'height' => 510);

    /* Create the widget. */
    $this->WP_Widget('wishpot_pub_pro', __('Wishpot Publisher Pro - Display Ads','wishpot-pub-pro'), $widget_ops, $control_ops);
  }
	

  function widget($args, $instance) 
  {
    extract($args);


    echo $before_widget;
    if ( empty($instance['title']) AND !$instance['wishpot_pub_pro_widget_ad_hide_title'] )
    {
      $instance['title'] = $this->display_types[$instance['display_type']];
      $title = apply_filters('widget_title', $instance['title']);
      echo $before_title.$title.$after_title;
    }

    $html = wishpot_pub_pro_generate_widget($instance);
    echo $html;
    echo $after_widget;
  }
	

  function update($new_instance, $old_instance) 
  {
    $instance = $old_instance;

    $instance['wishpot_pub_pro_widget_ad_template']           = (int) $new_instance['wishpot_pub_pro_widget_ad_template'];
    $instance['wishpot_pub_pro_widget_ad_title']              = strip_tags($new_instance['wishpot_pub_pro_widget_ad_title']);
    $instance['wishpot_pub_pro_widget_ad_hide_title']         = $new_instance['wishpot_pub_pro_widget_ad_hide_title'];
    $instance['wishpot_pub_pro_widget_ad_theme']              = (int) $new_instance['wishpot_pub_pro_widget_ad_theme'];
    $instance['wishpot_pub_pro_widget_ad_fblike']             = $new_instance['wishpot_pub_pro_widget_ad_fblike'];
    $instance['wishpot_pub_pro_widget_ad_fbshare']            = $new_instance['wishpot_pub_pro_widget_ad_fbshare'];
    $instance['wishpot_pub_pro_widget_ad_twshare']            = $new_instance['wishpot_pub_pro_widget_ad_twshare'];
    $instance['wishpot_pub_pro_widget_ad_type']               = (int) $new_instance['wishpot_pub_pro_widget_ad_type'];
    $instance['wishpot_pub_pro_widget_ad_category']           = (array) $new_instance['wishpot_pub_pro_widget_ad_category'];
    $instance['wishpot_pub_pro_widget_ad_keywords']           = strip_tags($new_instance['wishpot_pub_pro_widget_ad_keywords']);
    $instance['wishpot_pub_pro_widget_ad_overwrite_catskeyw'] = $new_instance['wishpot_pub_pro_widget_ad_overwrite_catskeyw'];
    $instance['wishpot_pub_pro_widget_ad_placement_id']       = strip_tags($new_instance['wishpot_pub_pro_widget_ad_placement_id']);
    $instance['wishpot_pub_pro_widget_ad_country']            = strip_tags($new_instance['wishpot_pub_pro_widget_ad_country']);

    return $instance;
  }

  function form($instance) 
  {
    /* Set up some default widget settings. */
    $defaults = array(
                       'wishpot_pub_pro_widget_ad_template'           => 0,
                       'wishpot_pub_pro_widget_ad_title'              => '',
                       'wishpot_pub_pro_widget_ad_hide_title'         => 'on',
                       'wishpot_pub_pro_widget_ad_theme'              => 0,
                       'wishpot_pub_pro_widget_ad_fblike'             => 'on',
                       'wishpot_pub_pro_widget_ad_fbshare'            => 'on',
                       'wishpot_pub_pro_widget_ad_twshare'            => 'on',
                       'wishpot_pub_pro_widget_ad_type'               => 0,
                       'wishpot_pub_pro_widget_ad_category'           => array(0 => 'All'),
                       'wishpot_pub_pro_widget_ad_keywords'           => '',
                       'wishpot_pub_pro_widget_ad_overwrite_catskeyw' => 'on',
                       'wishpot_pub_pro_widget_ad_placement_id'       => '',
                       'wishpot_pub_pro_widget_ad_country'            => 0
		);

    $instance = wp_parse_args((array) $instance, $defaults);

    echo 
    '  <div style="text-align:center">
         <table>' . "\n";
/*
         <tr>
           <th class="wishpot_widget_option_left_part"><label for="' . $this->get_field_name('wishpot_pub_pro_widget_ad_size') . '">' . __('Size', 'wishpot-pub-pro') . '</label></th>
           <td class="wishpot_widget_option_middle_part">
             <select id="' . $this->get_field_id('wishpot_pub_pro_widget_ad_size') . '" name="' . $this->get_field_name('wishpot_pub_pro_widget_ad_size') . '" size="1">' . "\n";

    for ( $i=0; $i < count($this->wishpot_pub_pro_widget_ad_size); $i++ )
    {
      if ( $instance['wishpot_pub_pro_widget_ad_size'] == $i )
        echo '    <option value="' . $i . '" selected="selected">' . $this->wishpot_pub_pro_widget_ad_size[$i] . '</option>' . "\n";
      else
        echo '    <option value="' . $i . '">' . $this->wishpot_pub_pro_widget_ad_size[$i] . '</option>' . "\n";
    }

    echo 
    '
             </select>
           </td>
           <td class="wishpot_widget_option_right_part">' . __('Size of the Ad', 'wishpot-pub-pro') . '</td> 
         </tr>
*/
    echo
    '
         <tr>
           <th class="wishpot_widget_option_left_part"><label for="' . $this->get_field_name('wishpot_pub_pro_widget_ad_template') . '">' . __('Ad template', 'wishpot-pub-pro') . '</label></th>
           <td class="wishpot_widget_option_middle_part">
             <select id="' . $this->get_field_id('wishpot_pub_pro_widget_ad_template') . '" name="' . $this->get_field_name('wishpot_pub_pro_widget_ad_template') . '" size="1">' . "\n";

    for ( $i=1; $i <= count($this->wishpot_pub_pro_widget_ad_template); $i++ )
    {
      if ( $instance['wishpot_pub_pro_widget_ad_template'] == $i )
        echo '    <option value="' . $i . '" selected="selected">' . $this->wishpot_pub_pro_widget_ad_template[$i] . '</option>' . "\n";
      else
        echo '    <option value="' . $i . '">' . $this->wishpot_pub_pro_widget_ad_template[$i] . '</option>' . "\n";
    }

    echo 
    '
             </select>
           </td>
         </tr>
         <tr>
           <th class="wishpot_widget_option_left_part"><label for="' . $this->get_field_name('wishpot_pub_pro_widget_ad_title') . '">' . __('Title', 'wishpot-pub-pro') . '</label></th>
           <td class="wishpot_widget_option_middle_part"><input type="text" size="20" id="' . $this->get_field_id('wishpot_pub_pro_widget_ad_title') . '" name="' . $this->get_field_name('wishpot_pub_pro_widget_ad_title') . '" value="' . esc_attr($instance['wishpot_pub_pro_widget_ad_title']) . '" /></td>
           <td class="wishpot_widget_option_right_part">' . __('Custom Title - shown in sidebar.', 'bbnuke') . '</td>
         </tr>
         <tr>
           <th class="wishpot_widget_option_left_part"><label for="' . $this->get_field_name('wishpot_pub_pro_widget_ad_hide_title') . '">' . __('Hide Title', 'wishpot-pub-pro') . '</label></th>
           <td><input class="checkbox wishpot_widget_option_middle_part" type="checkbox" ' . checked( $instance['wishpot_pub_pro_widget_ad_hide_title'], 'on', false ) . ' id="' . $this->get_field_id('wishpot_pub_pro_widget_ad_hide_title') . '" name="' . $this->get_field_name('wishpot_pub_pro_widget_ad_hide_title') . '" /></td>
           <td class="wishpot_widget_option_right_part">' . __('Hide the title in the Ad box.', 'wishpot_pub_pro') . '</td>
         </tr>' . "\n";

/*

         <tr>
           <th class="wishpot_widget_option_left_part"><label for="' . $this->get_field_name('wishpot_pub_pro_widget_ad_theme') . '">' . __('Theme', 'wishpot-pub-pro') . '</label></th>
           <td class="wishpot_widget_option_middle_part">
             <select id="' . $this->get_field_id('wishpot_pub_pro_widget_ad_theme') . '" name="' . $this->get_field_name('wishpot_pub_pro_widget_ad_theme') . '" size="1">' . "\n";

    for ( $i=0; $i < count($this->wishpot_pub_pro_widget_ad_theme); $i++ )
    {
      if ( $instance['wishpot_pub_pro_widget_ad_theme'] == $i )
        echo '    <option value="' . $i . '" selected="selected">' . $this->wishpot_pub_pro_widget_ad_theme[$i] . '</option>' . "\n";
      else
        echo '    <option value="' . $i . '">' . $this->wishpot_pub_pro_widget_ad_theme[$i] . '</option>' . "\n";
    }

    echo 
    '
             </select>
           </td>
           <td class="wishpot_widget_option_right_part">' . __('Size and count of displayed products in the Ad', 'wishpot-pub-pro') . '</td> 
         </tr>
*/

    echo
    '
         <tr>
           <th class="wishpot_widget_option_left_part"><label for="' . $this->get_field_name('wishpot_pub_pro_widget_ad_fblike') . '">' . __('Enable FB Like', 'wishpot-pub-pro') . '</label></th>
           <td><input class="checkbox wishpot_widget_option_middle_part" type="checkbox" ' . checked( $instance['wishpot_pub_pro_widget_ad_fblike'], 'on', false ) . ' id="' . $this->get_field_id('wishpot_pub_pro_widget_ad_fblike') . '" name="' . $this->get_field_name('wishpot_pub_pro_widget_ad_fblike') . '" /></td>
         </tr>' . "\n";

/*
         <tr>
           <th class="wishpot_widget_option_left_part"><label for="' . $this->get_field_name('wishpot_pub_pro_widget_ad_fbshare') . '">' . __('Enable FB Share', 'wishpot-pub-pro') . '</label></th>
           <td><input class="checkbox wishpot_widget_option_middle_part" type="checkbox" ' . checked( $instance['wishpot_pub_pro_widget_ad_fbshare'], 'on', false ) . ' id="' . $this->get_field_id('wishpot_pub_pro_widget_ad_fbshare') . '" name="' . $this->get_field_name('wishpot_pub_pro_widget_ad_fbshare') . '" /></td>
         </tr>
         <tr>
           <th class="wishpot_widget_option_left_part"><label for="' . $this->get_field_name('wishpot_pub_pro_widget_ad_twshare') . '">' . __('Enable Twitter Share', 'wishpot-pub-pro') . '</label></th>
           <td><input class="checkbox wishpot_widget_option_middle_part" type="checkbox" ' . checked( $instance['wishpot_pub_pro_widget_ad_twshare'], 'on', false ) . ' id="' . $this->get_field_id('wishpot_pub_pro_widget_ad_twshare') . '" name="' . $this->get_field_name('wishpot_pub_pro_widget_ad_twshare') . '" /></td>
         </tr>
         <tr>
           <th class="wishpot_widget_option_left_part"><label for="' . $this->get_field_name('wishpot_pub_pro_widget_ad_type') . '">' . __('Type', 'wishpot-pub-pro') . '</label></th>
           <td class="wishpot_widget_option_middle_part">
             <select id="' . $this->get_field_id('wishpot_pub_pro_widget_ad_type') . '" name="' . $this->get_field_name('wishpot_pub_pro_widget_ad_type') . '" size="1">' . "\n";

    for ( $i=0; $i < count($this->wishpot_pub_pro_widget_ad_type); $i++ )
    {
      if ( $instance['wishpot_pub_pro_widget_ad_type'] == $i )
        echo '    <option value="' . $i . '" selected="selected">' . $this->wishpot_pub_pro_widget_ad_type[$i] . '</option>' . "\n";
      else
        echo '    <option value="' . $i . '">' . $this->wishpot_pub_pro_widget_ad_type[$i] . '</option>' . "\n";
    }

    echo 
    '
             </select>
           </td>
           <td class="wishpot_widget_option_right_part">' . __('Size and count of displayed products in the Ad', 'wishpot-pub-pro') . '</td> 
         </tr>
*/

    echo
    '
         <tr>
           <th class="wishpot_widget_option_left_part"><label for="' . $this->get_field_name('wishpot_pub_pro_widget_ad_category') . '">' . __('Category', 'wishpot-pub-pro') . '</label></th>
           <td class="wishpot_widget_option_middle_part">
             <select id="' . $this->get_field_id('wishpot_pub_pro_widget_ad_category') . '" name="' . $this->get_field_name('wishpot_pub_pro_widget_ad_category') . '" size="1">' . "\n";

    $sels = $instance['wishpot_pub_pro_widget_ad_category'];
    for ( $i=0; $i < count($this->wishpot_pub_pro_widget_ad_category); $i++ )
    {
      //  check if selected
      $selected = 0;
      foreach ( $sels as $key => $value )
      {
        if ( $value == $this->wishpot_pub_pro_widget_ad_category[$i]['CatId'] )
          $selected = 1;
      }
      if ( $selected )
        echo '    <option value="' . $this->wishpot_pub_pro_widget_ad_category[$i]['CatId'] . '" selected="selected">' . $this->wishpot_pub_pro_widget_ad_category[$i]['CatName'] . '</option>' . "\n";
      else
        echo '    <option value="' . $this->wishpot_pub_pro_widget_ad_category[$i]['CatId'] . '">' . $this->wishpot_pub_pro_widget_ad_category[$i]['CatName'] . '</option>' . "\n";
    }

    echo 
    '
             </select>
           </td>
         </tr>
         <tr>
           <th class="wishpot_widget_option_left_part"><label for="' . $this->get_field_name('wishpot_pub_pro_widget_ad_keywords') . '">' . __('Keywords', 'wishpot-pub-pro') . '</label></th>
           <td class="wishpot_widget_option_middle_part"><input type="text" size="30" id="' . $this->get_field_id('wishpot_pub_pro_widget_ad_keywords') . '" name="' . $this->get_field_name('wishpot_pub_pro_widget_ad_keywords') . '" value="' . esc_attr($instance['wishpot_pub_pro_widget_ad_keywords']) . '" /></td>
         </tr>
         <tr>
           <th class="wishpot_widget_option_left_part"><label for="' . $this->get_field_name('wishpot_pub_pro_widget_ad_overwrite_catskeyw') . '"><b>' . __('Enable posts to overwrite category and keywords', 'wishpot-pub-pro') . '</b></label></th>
           <td><input class="checkbox wishpot_widget_option_middle_part" type="checkbox" ' . checked( $instance['wishpot_pub_pro_widget_ad_overwrite_catskeyw'], 'on', false ) . ' id="' . $this->get_field_id('wishpot_pub_pro_widget_ad_overwrite_catskeyw') . '" name="' . $this->get_field_name('wishpot_pub_pro_widget_ad_overwrite_catskeyw') . '" /></td>
         </tr>
         <tr>
           <th class="wishpot_widget_option_left_part"><label for="' . $this->get_field_name('wishpot_pub_pro_widget_ad_placement_id') . '">' . __('Placement Id', 'wishpot-pub-pro') . '</label></th>
           <td class="wishpot_widget_option_middle_part"><input type="text" size="20" id="' . $this->get_field_id('wishpot_pub_pro_widget_ad_placement_id') . '" name="' . $this->get_field_name('wishpot_pub_pro_widget_ad_placement_id') . '" value="' . esc_attr($instance['wishpot_pub_pro_widget_ad_placement_id']) . '" /></td>
         </tr>
         <tr>
           <th class="wishpot_widget_option_left_part"><label for="' . $this->get_field_name('wishpot_pub_pro_widget_ad_country') . '">' . __('Country', 'wishpot-pub-pro') . '</label></th>
           <td class="wishpot_widget_option_middle_part">
             <select id="' . $this->get_field_id('wishpot_pub_pro_widget_ad_country') . '" name="' . $this->get_field_name('wishpot_pub_pro_widget_ad_country') . '" size="1">' . "\n";

    for ( $i=0; $i < count($this->wishpot_pub_pro_widget_ad_country); $i++ )
    {
      if ( $instance['wishpot_pub_pro_widget_ad_country'] == $i )
        echo '    <option value="' . $i . '" selected="selected">' . $this->wishpot_pub_pro_widget_ad_country[$i] . '</option>' . "\n";
      else
        echo '    <option value="' . $i . '">' . $this->wishpot_pub_pro_widget_ad_country[$i] . '</option>' . "\n";
    }

    echo 
    '
             </select>
           </td>
         </tr>
         </table>
       </div>' . "\n";
  }


}



function  wishpot_pub_pro_generate_widget($instance)
{
  global $wishpot_plugin_url;


  $template = $instance['wishpot_pub_pro_widget_ad_template'];
  $theme    = $instance['wishpot_pub_pro_widget_ad_theme'];
  $fblike   = $instance['wishpot_pub_pro_widget_ad_fblike'];
  $fbshare  = $instance['wishpot_pub_pro_widget_ad_fbshare'];
  $twshare  = $instance['wishpot_pub_pro_widget_ad_twshare'];
  $type     = $instance['wishpot_pub_pro_widget_ad_type'] + 1;
  $cat_id   = $instance['wishpot_pub_pro_widget_ad_category'];
  if ( $cat_id )
  {
    $cat_id   = intval($cat_id[0]);
    $category = get_cat_name( $cat_id );
  }
  else
    $category = NULL;
  $keywords = $instance['wishpot_pub_pro_widget_ad_keywords'];
  $placement_id = $instance['wishpot_pub_pro_widget_ad_placement_id'];

  $type = 1;
  $args = array(
               'wishpot_category'     => rawurlencode(htmlentities($category, ENT_QUOTES)),
               'wishpot_keywords'     => htmlentities($keywords , ENT_QUOTES),
               'wishpot_placement_id' => htmlentities($placement_id, ENT_QUOTES)
              );
  $results = wishpot_pub_pro_get_ads( $type, $args);
  $wishpot_ads_products = $results[0];
  $product_cnt = count($wishpot_ads_products);

  $html =
  '<div id="wishpot_pub_pro_widget_wrapper">' . "\n" .
  '<!-- Start Epik Widget -->' . "\n";
 
  switch ($instance['wishpot_pub_pro_widget_ad_template'])
  {
    case 1:
      $html .= 
      '<div class="epik_widget widget300x250">' . "\n";
      break;
    case 2:
      $html .= 
      '<div class="epik_widget widget300x250">' . "\n";
      break;
    case 3:
      $html .= 
      '<div class="epik_widget widget160x600">' . "\n";
      break;
    case 4:
      $html .= 
      '<div class="epik_widget widget160x600">' . "\n";
      break;
    case 5:
      $html .= 
      '<div class="epik_widget widget160x600">' . "\n";
      break;
    case 6:
      $html .= 
      '<div class="epik_widget widget160x600">' . "\n";
      break;
    case 7:
      $html .= 
      '<div class="epik_widget widget120x600">' . "\n";
      break;
    case 8:
      $html .= 
      '<div class="epik_widget widget120x600">' . "\n";
      break;
    case 9:
      $html .= 
      '<div class="epik_widget widget120x600">' . "\n";
      break;
    case 10:
      $html .= 
      '<div class="epik_widget widget120x600">' . "\n";
      break;
    case 11:
      $html .= 
      '<div class="epik_widget widget300x600">' . "\n";
      break;
  }


  $html .=
  '<div class="wishpot_pub_pro_widget_search">' . "\n";

  if ( ($instance['wishpot_pub_pro_widget_ad_hide_title'] == 'on') OR (empty($instance['wishpot_pub_pro_widget_ad_title'])) )
  {
    $html .=
    '<h2>Powered by Wishpot</h2>' . "\n";
  }
  else
  {
    $html .=
    '<h2>' . $instance['wishpot_pub_pro_widget_ad_title'] . '</h2>' . "\n";
  }

  $html .=
  '  <form method="post" action="">' . "\n" .
  '    <input type="text" name="wishpot_widget_search" id="s_4" />' . "\n" .
  '    <a href="javascript:void();" onclick="wishpot_pub_pro_widget_show_search_results(this.parentNode); return false;" class="widget_btn_search"></a>' . "\n" .
  '    <input type="hidden" name="wishpot_category" value="' . rawurldecode($args['wishpot_category']) . '" />' . "\n" .
  '    <input type="hidden" name="wishpot_keywords" value="' . rawurldecode($args['wishpot_keywords']) . '" />' . "\n" .
  '    <input type="hidden" name="wishpot_placement_id" value="' . $args['wishpot_placement_id'] . '" />' . "\n" .
  '  </form>' . "\n" .
  '</div>' . "\n" .
  '<ul class="product">' . "\n";
  switch ($instance['wishpot_pub_pro_widget_ad_template'])
  {
    case 1:
      for ( $i = 0; ($i <= $product_cnt) AND ($i < 1); $i++ )
      {
        $html .=
        '<li>
           <a href="' . $wishpot_ads_products[$i]['url'] . '" class="thumb"><img src="' . $wishpot_ads_products[$i]['image_source'] . '" alt="" /></a>
           <p>' . $wishpot_ads_products[$i]['title'] . ' <a href="javascript:void(0)" onclick="wishpot_pub_pro_show_product_details(\'' . $placement_id . '\', \'' . $wishpot_ads_products[$i]['item_num'] . '\');" title="' . __('See more product details', 'wishpot-pub-pro') . '" target="_blank">' . __('More ...', 'wishpot-pub-pro') . '</a></p>
           <div class="wishpot_form" style="display:none">
             <input name="pkey" value="' . $placement_id . '" type="hidden"/>
             <input name="WishUrl" value="' . $wishpot_ads_products[$i]['url'] . '" type="hidden" />
             <input name="WishTitle" value="' . $wishpot_ads_products[$i]['title'] . '" type="hidden" />
             <input name="Price" value="' . $wishpot_ads_products[$i]['price'] . '" type="hidden" />
             <input name="ImgSrc" value="' . $wishpot_ads_products[$i]['image_source'] . '" type="hidden" />
             <input name="Description" value="' . $wishpot_ads_products[$i]['description'] . '" type="hidden" />
             <input name="Brand" value="' . $wishpot_ads_products[$i]['brand'] . '" type="hidden" />
             <input name="Sku" value="' . $wishpot_ads_products[$i]['item_num'] . '" type="hidden" />
           </div>
           <ul class="star-rating">
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
           </ul>
           <h3>Price: <span>' . $wishpot_ads_products[$i]['price'] . '</span></h3>
           <a href="' . $wishpot_ads_products[$i]['url'] . '" class="widget_btn_buy" target="_blank">Buy Now</a>' . "\n";

        if ( $fblike == 'on' )
          $html .=
           '<iframe src="http://www.facebook.com/plugins/like.php?href=' . $wishpot_ads_products[$i]['url'] . '&layout=button_count&show_faces=false&width=100&action=like&colorscheme=light&height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>' . "\n";
        $html .=
        ' </li>' . "\n";
      }
      break;
    case 2:
      for ( $i = 0; ($i <= $product_cnt) AND ($i < 2); $i++ )
      {
        $html .=
        '<li>
           <a href="' . $wishpot_ads_products[$i]['url'] . '" class="thumb"><img src="' . $wishpot_ads_products[$i]['image_source'] . '" alt="" /></a>
           <p>' . $wishpot_ads_products[$i]['title'] . ' <a href="javascript:void(0)" onclick="wishpot_pub_pro_show_product_details(\'' . $placement_id . '\', \'' . $wishpot_ads_products[$i]['item_num'] . '\');" title="' . __('See more product details', 'wishpot-pub-pro') . '" target="_blank">' . __('More ...', 'wishpot-pub-pro') . '</a></p>
           <div class="wishpot_form" style="display:none">
             <input name="pkey" value="' . $wishpot_placement_id . '" type="hidden"/>
             <input name="WishUrl" value="' . $wishpot_ads_products[$i]['url'] . '" type="hidden" />
             <input name="WishTitle" value="' . $wishpot_ads_products[$i]['title'] . '" type="hidden" />
             <input name="Price" value="' . $wishpot_ads_products[$i]['price'] . '" type="hidden" />
             <input name="ImgSrc" value="' . $wishpot_ads_products[$i]['image_source'] . '" type="hidden" />
             <input name="Description" value="' . $wishpot_ads_products[$i]['description'] . '" type="hidden" />
             <input name="Brand" value="' . $wishpot_ads_products[$i]['brand'] . '" type="hidden" />
             <input name="Sku" value="' . $wishpot_ads_products[$i]['item_num'] . '" type="hidden" />
           </div>
           <ul class="star-rating">
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
           </ul>
           <h3>Price: <span>' . $wishpot_ads_products[$i]['price'] . '</span></h3>
           <a href="' . $wishpot_ads_products[$i]['url'] . '" class="widget_btn_buy" target="_blank">Buy Now</a>' . "\n";

        if ( $fblike == 'on' )
          $html .=
           '<iframe src="http://www.facebook.com/plugins/like.php?href=' . $wishpot_ads_products[$i]['url'] . '&layout=button_count&show_faces=false&width=100&action=like&colorscheme=light&height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>' . "\n";
        $html .=
        ' </li>' . "\n";
      }
      break;
    case 3:
      for ( $i = 0; ($i <= $product_cnt) AND ($i < 1); $i++ )
      {
        $html .=
        '<li>
           <a href="' . $wishpot_ads_products[$i]['url'] . '" class="thumb"><img src="' . $wishpot_ads_products[$i]['image_source'] . '" alt="" /></a>
           <p>' . $wishpot_ads_products[$i]['title'] . ' <a href="javascript:void(0)" onclick="wishpot_pub_pro_show_product_details(\'' . $placement_id . '\', \'' . $wishpot_ads_products[$i]['item_num'] . '\');" title="' . __('See more product details', 'wishpot-pub-pro') . '" target="_blank">' . __('More ...', 'wishpot-pub-pro') . '</a></p>
           <div class="wishpot_form" style="display:none">
             <input name="pkey" value="' . $wishpot_placement_id . '" type="hidden"/>
             <input name="WishUrl" value="' . $wishpot_ads_products[$i]['url'] . '" type="hidden" />
             <input name="WishTitle" value="' . $wishpot_ads_products[$i]['title'] . '" type="hidden" />
             <input name="Price" value="' . $wishpot_ads_products[$i]['price'] . '" type="hidden" />
             <input name="ImgSrc" value="' . $wishpot_ads_products[$i]['image_source'] . '" type="hidden" />
             <input name="Description" value="' . $wishpot_ads_products[$i]['description'] . '" type="hidden" />
             <input name="Brand" value="' . $wishpot_ads_products[$i]['brand'] . '" type="hidden" />
             <input name="Sku" value="' . $wishpot_ads_products[$i]['item_num'] . '" type="hidden" />
           </div>
           <ul class="star-rating">
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
           </ul>
           <h3>Price: <span>' . $wishpot_ads_products[$i]['price'] . '</span></h3>' . "\n";

        if ( $fblike == 'on' )
          $html .=
           '<iframe src="http://www.facebook.com/plugins/like.php?href=' . $wishpot_ads_products[$i]['url'] . '&layout=button_count&show_faces=false&width=100&action=like&colorscheme=light&height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>' . "\n";
        $html .=
        '   <a href="' . $wishpot_ads_products[$i]['url'] . '" class="widget_btn_buy" target="_blank">Buy Now</a>
         </li>' . "\n";
      }
      break;
    case 4:
      for ( $i = 0; ($i <= $product_cnt) AND ($i < 2); $i++ )
      {
        $html .=
        '<li>
           <a href="' . $wishpot_ads_products[$i]['url'] . '" class="thumb"><img src="' . $wishpot_ads_products[$i]['image_source'] . '" alt="" /></a>
           <p>' . $wishpot_ads_products[$i]['title'] . ' <a href="javascript:void(0)" onclick="wishpot_pub_pro_show_product_details(\'' . $placement_id . '\', \'' . $wishpot_ads_products[$i]['item_num'] . '\');" title="' . __('See more product details', 'wishpot-pub-pro') . '" target="_blank">' . __('More ...', 'wishpot-pub-pro') . '</a></p>
           <div class="wishpot_form" style="display:none">
             <input name="pkey" value="' . $wishpot_placement_id . '" type="hidden"/>
             <input name="WishUrl" value="' . $wishpot_ads_products[$i]['url'] . '" type="hidden" />
             <input name="WishTitle" value="' . $wishpot_ads_products[$i]['title'] . '" type="hidden" />
             <input name="Price" value="' . $wishpot_ads_products[$i]['price'] . '" type="hidden" />
             <input name="ImgSrc" value="' . $wishpot_ads_products[$i]['image_source'] . '" type="hidden" />
             <input name="Description" value="' . $wishpot_ads_products[$i]['description'] . '" type="hidden" />
             <input name="Brand" value="' . $wishpot_ads_products[$i]['brand'] . '" type="hidden" />
             <input name="Sku" value="' . $wishpot_ads_products[$i]['item_num'] . '" type="hidden" />
           </div>
           <ul class="star-rating">
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
           </ul>
           <h3>Price: <span>' . $wishpot_ads_products[$i]['price'] . '</span></h3>' . "\n";

        if ( $fblike == 'on' )
          $html .=
           '<iframe src="http://www.facebook.com/plugins/like.php?href=' . $wishpot_ads_products[$i]['url'] . '&layout=button_count&show_faces=false&width=100&action=like&colorscheme=light&height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>' . "\n";
        $html .=
        '   <a href="' . $wishpot_ads_products[$i]['url'] . '" class="widget_btn_buy" target="_blank">Buy Now</a>
         </li>' . "\n";
      }
      break;
    case 5:
      for ( $i = 0; ($i <= $product_cnt) AND ($i < 3); $i++ )
      {
        $html .=
        '<li>
           <a href="' . $wishpot_ads_products[$i]['url'] . '" class="thumb"><img src="' . $wishpot_ads_products[$i]['image_source'] . '" alt="" /></a>
           <p>' . $wishpot_ads_products[$i]['title'] . ' <a href="javascript:void(0)" onclick="wishpot_pub_pro_show_product_details(\'' . $placement_id . '\', \'' . $wishpot_ads_products[$i]['item_num'] . '\');" title="' . __('See more product details', 'wishpot-pub-pro') . '" target="_blank">' . __('More ...', 'wishpot-pub-pro') . '</a></p>
           <div class="wishpot_form" style="display:none">
             <input name="pkey" value="' . $wishpot_placement_id . '" type="hidden"/>
             <input name="WishUrl" value="' . $wishpot_ads_products[$i]['url'] . '" type="hidden" />
             <input name="WishTitle" value="' . $wishpot_ads_products[$i]['title'] . '" type="hidden" />
             <input name="Price" value="' . $wishpot_ads_products[$i]['price'] . '" type="hidden" />
             <input name="ImgSrc" value="' . $wishpot_ads_products[$i]['image_source'] . '" type="hidden" />
             <input name="Description" value="' . $wishpot_ads_products[$i]['description'] . '" type="hidden" />
             <input name="Brand" value="' . $wishpot_ads_products[$i]['brand'] . '" type="hidden" />
             <input name="Sku" value="' . $wishpot_ads_products[$i]['item_num'] . '" type="hidden" />
           </div>
           <ul class="star-rating">
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
           </ul>
           <h3>Price: <span>' . $wishpot_ads_products[$i]['price'] . '</span></h3>' . "\n";

        if ( $fblike == 'on' )
          $html .=
           '<iframe src="http://www.facebook.com/plugins/like.php?href=' . $wishpot_ads_products[$i]['url'] . '&layout=button_count&show_faces=false&width=100&action=like&colorscheme=light&height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>' . "\n";
        $html .=
        '   <a href="' . $wishpot_ads_products[$i]['url'] . '" class="widget_btn_buy" target="_blank">Buy Now</a>
         </li>' . "\n";
      }
      break;
    case 6:
      for ( $i = 0; ($i <= $product_cnt) AND ($i < 4); $i++ )
      {
        $html .=
        '<li>
           <a href="' . $wishpot_ads_products[$i]['url'] . '" class="thumb"><img src="' . $wishpot_ads_products[$i]['image_source'] . '" alt="" /></a>
           <p>' . $wishpot_ads_products[$i]['title'] . ' <a href="javascript:void(0)" onclick="wishpot_pub_pro_show_product_details(\'' . $placement_id . '\', \'' . $wishpot_ads_products[$i]['item_num'] . '\');" title="' . __('See more product details', 'wishpot-pub-pro') . '" target="_blank">' . __('More ...', 'wishpot-pub-pro') . '</a></p>
           <div class="wishpot_form" style="display:none">
             <input name="pkey" value="' . $wishpot_placement_id . '" type="hidden"/>
             <input name="WishUrl" value="' . $wishpot_ads_products[$i]['url'] . '" type="hidden" />
             <input name="WishTitle" value="' . $wishpot_ads_products[$i]['title'] . '" type="hidden" />
             <input name="Price" value="' . $wishpot_ads_products[$i]['price'] . '" type="hidden" />
             <input name="ImgSrc" value="' . $wishpot_ads_products[$i]['image_source'] . '" type="hidden" />
             <input name="Description" value="' . $wishpot_ads_products[$i]['description'] . '" type="hidden" />
             <input name="Brand" value="' . $wishpot_ads_products[$i]['brand'] . '" type="hidden" />
             <input name="Sku" value="' . $wishpot_ads_products[$i]['item_num'] . '" type="hidden" />
           </div>
           <ul class="star-rating">
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
           </ul>
           <h3>Price: <span>' . $wishpot_ads_products[$i]['price'] . '</span></h3>' . "\n";

        if ( $fblike == 'on' )
          $html .=
           '<iframe src="http://www.facebook.com/plugins/like.php?href=' . $wishpot_ads_products[$i]['url'] . '&layout=button_count&show_faces=false&width=100&action=like&colorscheme=light&height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>' . "\n";
        $html .=
        '   <a href="' . $wishpot_ads_products[$i]['url'] . '" class="widget_btn_buy" target="_blank">Buy Now</a>
         </li>' . "\n";
      }
      break;
    case 7:
      for ( $i = 0; ($i <= $product_cnt) AND ($i < 1); $i++ )
      {
        $html .=
        '<li>
           <a href="' . $wishpot_ads_products[$i]['url'] . '" class="thumb"><img src="' . $wishpot_ads_products[$i]['image_source'] . '" alt="" /></a>
           <p>' . $wishpot_ads_products[$i]['title'] . ' <a href="javascript:void(0)" onclick="wishpot_pub_pro_show_product_details(\'' . $placement_id . '\', \'' . $wishpot_ads_products[$i]['item_num'] . '\');" title="' . __('See more product details', 'wishpot-pub-pro') . '" target="_blank">' . __('More ...', 'wishpot-pub-pro') . '</a></p>
           <div class="wishpot_form" style="display:none">
             <input name="pkey" value="' . $wishpot_placement_id . '" type="hidden"/>
             <input name="WishUrl" value="' . $wishpot_ads_products[$i]['url'] . '" type="hidden" />
             <input name="WishTitle" value="' . $wishpot_ads_products[$i]['title'] . '" type="hidden" />
             <input name="Price" value="' . $wishpot_ads_products[$i]['price'] . '" type="hidden" />
             <input name="ImgSrc" value="' . $wishpot_ads_products[$i]['image_source'] . '" type="hidden" />
             <input name="Description" value="' . $wishpot_ads_products[$i]['description'] . '" type="hidden" />
             <input name="Brand" value="' . $wishpot_ads_products[$i]['brand'] . '" type="hidden" />
             <input name="Sku" value="' . $wishpot_ads_products[$i]['item_num'] . '" type="hidden" />
           </div>
           <ul class="star-rating">
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
           </ul>
           <h3>Price: <span>' . $wishpot_ads_products[$i]['price'] . '</span></h3>' . "\n";

        if ( $fblike == 'on' )
          $html .=
           '<iframe src="http://www.facebook.com/plugins/like.php?href=' . $wishpot_ads_products[$i]['url'] . '&layout=button_count&show_faces=false&width=100&action=like&colorscheme=light&height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>' . "\n";
        $html .=
        '   <a href="' . $wishpot_ads_products[$i]['url'] . '" class="widget_btn_buy" target="_blank">Buy Now</a>
         </li>' . "\n";
      }
      break;
    case 8:
      for ( $i = 0; ($i <= $product_cnt) AND ($i < 2); $i++ )
      {
        $html .=
        '<li>
           <a href="' . $wishpot_ads_products[$i]['url'] . '" class="thumb"><img src="' . $wishpot_ads_products[$i]['image_source'] . '" alt="" /></a>
           <p>' . $wishpot_ads_products[$i]['title'] . ' <a href="javascript:void(0)" onclick="wishpot_pub_pro_show_product_details(\'' . $placement_id . '\', \'' . $wishpot_ads_products[$i]['item_num'] . '\');" title="' . __('See more product details', 'wishpot-pub-pro') . '" target="_blank">' . __('More ...', 'wishpot-pub-pro') . '</a></p>
           <div class="wishpot_form" style="display:none">
             <input name="pkey" value="' . $wishpot_placement_id . '" type="hidden"/>
             <input name="WishUrl" value="' . $wishpot_ads_products[$i]['url'] . '" type="hidden" />
             <input name="WishTitle" value="' . $wishpot_ads_products[$i]['title'] . '" type="hidden" />
             <input name="Price" value="' . $wishpot_ads_products[$i]['price'] . '" type="hidden" />
             <input name="ImgSrc" value="' . $wishpot_ads_products[$i]['image_source'] . '" type="hidden" />
             <input name="Description" value="' . $wishpot_ads_products[$i]['description'] . '" type="hidden" />
             <input name="Brand" value="' . $wishpot_ads_products[$i]['brand'] . '" type="hidden" />
             <input name="Sku" value="' . $wishpot_ads_products[$i]['item_num'] . '" type="hidden" />
           </div>
           <ul class="star-rating">
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
           </ul>
           <h3>Price: <span>' . $wishpot_ads_products[$i]['price'] . '</span></h3>' . "\n";

        if ( $fblike == 'on' )
          $html .=
           '<iframe src="http://www.facebook.com/plugins/like.php?href=' . $wishpot_ads_products[$i]['url'] . '&layout=button_count&show_faces=false&width=100&action=like&colorscheme=light&height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>' . "\n";
        $html .=
        '   <a href="' . $wishpot_ads_products[$i]['url'] . '" class="widget_btn_buy" target="_blank">Buy Now</a>
         </li>' . "\n";
      }
      break;
    case 9:
      for ( $i = 0; ($i <= $product_cnt) AND ($i < 3); $i++ )
      {
        $html .=
        '<li>
           <a href="' . $wishpot_ads_products[$i]['url'] . '" class="thumb"><img src="' . $wishpot_ads_products[$i]['image_source'] . '" alt="" /></a>
           <p>' . $wishpot_ads_products[$i]['title'] . ' <a href="javascript:void(0)" onclick="wishpot_pub_pro_show_product_details(\'' . $placement_id . '\', \'' . $wishpot_ads_products[$i]['item_num'] . '\');" title="' . __('See more product details', 'wishpot-pub-pro') . '" target="_blank">' . __('More ...', 'wishpot-pub-pro') . '</a></p>
           <div class="wishpot_form" style="display:none">
             <input name="pkey" value="' . $wishpot_placement_id . '" type="hidden"/>
             <input name="WishUrl" value="' . $wishpot_ads_products[$i]['url'] . '" type="hidden" />
             <input name="WishTitle" value="' . $wishpot_ads_products[$i]['title'] . '" type="hidden" />
             <input name="Price" value="' . $wishpot_ads_products[$i]['price'] . '" type="hidden" />
             <input name="ImgSrc" value="' . $wishpot_ads_products[$i]['image_source'] . '" type="hidden" />
             <input name="Description" value="' . $wishpot_ads_products[$i]['description'] . '" type="hidden" />
             <input name="Brand" value="' . $wishpot_ads_products[$i]['brand'] . '" type="hidden" />
             <input name="Sku" value="' . $wishpot_ads_products[$i]['item_num'] . '" type="hidden" />
           </div>
           <ul class="star-rating">
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
           </ul>
           <h3>Price: <span>' . $wishpot_ads_products[$i]['price'] . '</span></h3>' . "\n";

        if ( $fblike == 'on' )
          $html .=
           '<iframe src="http://www.facebook.com/plugins/like.php?href=' . $wishpot_ads_products[$i]['url'] . '&layout=button_count&show_faces=false&width=100&action=like&colorscheme=light&height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>' . "\n";
        $html .=
        '   <a href="' . $wishpot_ads_products[$i]['url'] . '" class="widget_btn_buy" target="_blank">Buy Now</a>
         </li>' . "\n";
      }
      break;
    case 10:
      for ( $i = 0; ($i <= $product_cnt) AND ($i < 4); $i++ )
      {
        $html .=
        '<li>
           <a href="' . $wishpot_ads_products[$i]['url'] . '" class="thumb"><img src="' . $wishpot_ads_products[$i]['image_source'] . '" alt="" /></a>
           <p>' . $wishpot_ads_products[$i]['title'] . ' <a href="javascript:void(0)" onclick="wishpot_pub_pro_show_product_details(\'' . $placement_id . '\', \'' . $wishpot_ads_products[$i]['item_num'] . '\');" title="' . __('See more product details', 'wishpot-pub-pro') . '" target="_blank">' . __('More ...', 'wishpot-pub-pro') . '</a></p>
           <div class="wishpot_form" style="display:none">
             <input name="pkey" value="' . $wishpot_placement_id . '" type="hidden"/>
             <input name="WishUrl" value="' . $wishpot_ads_products[$i]['url'] . '" type="hidden" />
             <input name="WishTitle" value="' . $wishpot_ads_products[$i]['title'] . '" type="hidden" />
             <input name="Price" value="' . $wishpot_ads_products[$i]['price'] . '" type="hidden" />
             <input name="ImgSrc" value="' . $wishpot_ads_products[$i]['image_source'] . '" type="hidden" />
             <input name="Description" value="' . $wishpot_ads_products[$i]['description'] . '" type="hidden" />
             <input name="Brand" value="' . $wishpot_ads_products[$i]['brand'] . '" type="hidden" />
             <input name="Sku" value="' . $wishpot_ads_products[$i]['item_num'] . '" type="hidden" />
           </div>
           <ul class="star-rating">
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
           </ul>
           <h3>Price: <span>' . $wishpot_ads_products[$i]['price'] . '</span></h3>' . "\n";

        if ( $fblike == 'on' )
          $html .=
           '<iframe src="http://www.facebook.com/plugins/like.php?href=' . $wishpot_ads_products[$i]['url'] . '&layout=button_count&show_faces=false&width=100&action=like&colorscheme=light&height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>' . "\n";
        $html .=
        '   <a href="' . $wishpot_ads_products[$i]['url'] . '" class="widget_btn_buy" target="_blank">Buy Now</a>
         </li>' . "\n";
      }
      break;
    case 11:
      for ( $i = 0; ($i <= $product_cnt) AND ($i < 8); $i++ )
      {
        $html .=
        '<li>
           <a href="' . $wishpot_ads_products[$i]['url'] . '" class="thumb"><img src="' . $wishpot_ads_products[$i]['image_source'] . '" alt="" /></a>
           <p>' . $wishpot_ads_products[$i]['title'] . ' <a href="javascript:void(0)" onclick="wishpot_pub_pro_show_product_details(\'' . $placement_id . '\', \'' . $wishpot_ads_products[$i]['item_num'] . '\');" title="' . __('See more product details', 'wishpot-pub-pro') . '" target="_blank">' . __('More ...', 'wishpot-pub-pro') . '</a></p>
           <div class="wishpot_form" style="display:none">
             <input name="pkey" value="' . $wishpot_placement_id . '" type="hidden"/>
             <input name="WishUrl" value="' . $wishpot_ads_products[$i]['url'] . '" type="hidden" />
             <input name="WishTitle" value="' . $wishpot_ads_products[$i]['title'] . '" type="hidden" />
             <input name="Price" value="' . $wishpot_ads_products[$i]['price'] . '" type="hidden" />
             <input name="ImgSrc" value="' . $wishpot_ads_products[$i]['image_source'] . '" type="hidden" />
             <input name="Description" value="' . $wishpot_ads_products[$i]['description'] . '" type="hidden" />
             <input name="Brand" value="' . $wishpot_ads_products[$i]['brand'] . '" type="hidden" />
             <input name="Sku" value="' . $wishpot_ads_products[$i]['item_num'] . '" type="hidden" />
           </div>
           <ul class="star-rating">
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
             <li><a href="#"><img src="' . $wishpot_plugin_url . '/img/widget/star.png" alt="star"/></a></li>
           </ul>
           <h3>Price: <span>' . $wishpot_ads_products[$i]['price'] . '</span></h3>
           <a href="' . $wishpot_ads_products[$i]['url'] . '" class="widget_btn_buy" target="_blank">Buy Now</a>' . "\n";

        if ( $fblike == 'on' )
          $html .=
           '<iframe src="http://www.facebook.com/plugins/like.php?href=' . $wishpot_ads_products[$i]['url'] . '&layout=button_count&show_faces=false&width=100&action=like&colorscheme=light&height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>' . "\n";
        $html .=
        ' </li>' . "\n";
      }
      break;
    case 12:
      break;
    case 13:
      break;
    case 14:
      break;
    case 15:
      break;
  }

/*
        $wishpot_ads_products[] = array(
           'title'        => $searchNode->getElementsByTagName( 'title' )->item(0)->nodeValue,
           'item_num'     => $searchNode->getElementsByTagName( 'item_num' )->item(0)->nodeValue,
           'price'        => $searchNode->getElementsByTagName( 'price' )->item(0)->nodeValue,
           'currency'     => $searchNode->getElementsByTagName( 'currency' )->item(0)->nodeValue,
           'url'          => $url,
           'description'  => $searchNode->getElementsByTagName( 'description' )->item(0)->nodeValue,
           'brand'        => $searchNode->getElementsByTagName( 'brand' )->item(0)->nodeValue,
           'image_width'  => $imageNode->getElementsByTagName( 'width' )->item(0)->nodeValue,
           'image_height' => $imageNode->getElementsByTagName( 'height' )->item(0)->nodeValue,
           'image_source' => $image_url
           );
*/

  $html .=
  '  </ul>
   </div>
   <!-- End Epik Widget -->' .  "\n";

  return $html;
}


?>