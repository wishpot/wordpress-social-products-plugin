<?php

global $wpdb;
global $wishpot_plugin_url;

////////////////////////////////////////////////////////////////////////////////
// save plugin options
////////////////////////////////////////////////////////////////////////////////
function wishpot_pub_pro_save_plugin_options()
{
  if (!isset( $_POST['wishpot_pub_pro_widget_ga'] ))
  {
    $_POST['wishpot_pub_pro_widget_ga'] = 'off';
    $wishpot_pub_pro_widget_ga = 'off';
  }
  else
  {
    $_POST['wishpot_pub_pro_widget_ga'] = 'on';
    $wishpot_pub_pro_widget_ga = 'on';
  }
  if (!isset( $_POST['wishpot_pub_pro_pp_fblike'] ))
  {
    $_POST['wishpot_pub_pro_pp_fblike'] = 'off';
    $wishpot_pub_pro_pp_fblike = 'off';
  }
  else
  {
    $_POST['wishpot_pub_pro_pp_fblike'] = 'on';
    $wishpot_pub_pro_pp_fblike = 'on';
  }
  if (!isset( $_POST['wishpot_pub_pro_pp_fbshare'] ))
  {
    $_POST['wishpot_pub_pro_pp_fbshare'] = 'off';
    $wishpot_pub_pro_pp_fbshare = 'off';
  }
  else
  {
    $_POST['wishpot_pub_pro_pp_fbshare'] = 'on';
    $wishpot_pub_pro_pp_fbshare = 'on';
  }
  if (!isset( $_POST['wishpot_pub_pro_pp_twshare'] ))
  {
    $_POST['wishpot_pub_pro_pp_twshare'] = 'off';
    $wishpot_pub_pro_pp_twshare = 'off';
  }
  else
  {
    $_POST['wishpot_pub_pro_pp_twshare'] = 'on';
    $wishpot_pub_pro_pp_twshare = 'on';
  }

  $options = array(
       'wishpot_pub_pro_pagesize'                 => $_POST['wishpot_pub_pro_pagesize'],
       'wishpot_pub_pro_widget_ga'                => $wishpot_pub_pro_widget_ga,
       'wishpot_pub_pro_pp_fblike'                => $wishpot_pub_pro_pp_fblike,
       'wishpot_pub_pro_pp_fbshare'               => $wishpot_pub_pro_pp_fbshare,
       'wishpot_pub_pro_pp_twshare'               => $wishpot_pub_pro_pp_twshare
        );

  wishpot_pub_pro_update_options($options);

  return;
}


////////////////////////////////////////////////////////////////////////////////
// ajax call to show search results from widget search text input
////////////////////////////////////////////////////////////////////////////////
function  wishpot_pub_pro_ajax_func_get_results()
{
  global $wpdb,
         $responses;

  global $wishpot_plugin_url;


  $wishpot_call_type = $_POST['wishpot_call_type'];
  switch ( $wishpot_call_type )
  {
    case 1:
      //  get search results for widget search
      //  if search is clicked
      if ( !empty($_POST['wishpot_widget_search']) )
      {
        $wishpot_category =  $_POST['wishpot_category'];
        $wishpot_keywords =  $_POST['wishpot_keywords'];
        $wishpot_placement_id = $_POST['wishpot_placement_id'];
        $wishpot_search_text  = $_POST['wishpot_widget_search'];
        $wishpot_keywords = $wishpot_keywords . ' ' . $wishpot_search_text;

        //  build content
        $wishpot_content = '[wishpot_ads_product_page]' .
        '[wishpot_ads_category=' . $wishpot_category . ']' .
        '[wishpot_ads_keywords=' . $wishpot_keywords . ']' .
        '[wishpot_ads_placement_id=' . $wishpot_placement_id . ']' .
        '[wishpot_ads_search_text=' . $wishpot_search_text . ']';

        //  check if page exists
        $temp_page = get_page_by_title( 'Wishpot Publisher Pro - Product Search Results Page' );
        if ( ($temp_page) )
        {
          $wishpot_post = array(
           'ID'           => $temp_page->ID,
           'post_content' => $wishpot_content
          );
          wp_update_post( $wishpot_post ); 
          $page_id = $temp_page->ID;
        }
        else
        {
          //  create temp page and fill with content
          $wishpot_post = array(
             'menu_order'     => -1,
             'comment_status' => 'closed',
             'ping_status'    => 'closed',
             'post_author'    => 1,
             'post_content'   => $wishpot_content,
             'post_name'      => 'wishpot-publisher-pro-product-search-results-page',
             'post_status'    => 'publish',
             'post_title'     => 'Wishpot Publisher Pro - Product Search Results Page',
             'post_parent'    => 0,
             'post_type'      => 'page'
           );  
  
          $page_id = wp_insert_post( $wishpot_post );
        }
      }

      $url = get_bloginfo('url') . '/?p=' . $page_id;

      $return_obj = array( 'post_id' => $page_id, 'url' => $url );
      break;
    case 2:
      //  get product detail infos
      $html = '';

      $wishpot_item_num     = $_POST['wishpot_item_num'];
      $wishpot_placement_id = $_POST['wishpot_placement_id'];

      $type = 3;
      $args = array(
              'wishpot_placement_id' => $wishpot_placement_id,
              'wishpot_item_num'     => $wishpot_item_num
              );
      $wishpot_results = wishpot_pub_pro_get_ads( $type, $args);

      $wishpot_product_details = $wishpot_results[0];
      $wishpot_pub_pro_products_brands = $wishpot_results[1];
      $wishpot_pub_pro_products_brands = wishpot_array_msort($wishpot_pub_pro_products_brands, array( 'name' => SORT_ASC));

      $wishpot_pub_pro_products_count  = $wishpot_results[2];
      $wishpot_pub_pro_page_count      = $wishpot_results[3];
      $wishpot_pub_pro_offers          = $wishpot_results[4];

      $action = "if(document.getElementById){window.WISHPOT_FORM=this.parentNode;var x=document.getElementsByTagName('head').item(0);var o=document.createElement('script');if(typeof(o)!='object') o=document.standardCreateElement('script');o.setAttribute('src',(('https:' == document.location.protocol) ? 'https' : 'http')+'://www.wishpot.com/scripts/bm.js?v=100');o.setAttribute('type','text/javascript');x.appendChild(o);} return false;";

      //  build html
      $html =
      '<html><head><title>Product Detail Page</title>' . "\n" .
      '<link rel="stylesheet" href="' . $wishpot_plugin_url . 'css/wishpot-pub-pro-frontend-plugin.php">' . "\n" .
      '</head><body>' . "\n" .
      '<div class="wishpot_pub_pro_clear_floats"></div>' . "\n" .
      '<a name="top" href=""></a>' . "\n" .
      '<div id="wishpot_pub_pro_products_detail_page_wrapper">' . "\n" .
      '  <div class="wishpot_product_detail_product_page_item">' . "\n" .
      '    <div class="wishpot_pub_pro_detail_product_item_img">' . "\n" .
      '      <a href="' . $wishpot_product_details[0]['url'] . '" title="' . $wishpot_product_details[0]['title'] . '" target="_blank">' . "\n" .
      '        <img src="' . $wishpot_product_details[0]['image_source'] . '" alt="" />' . "\n" .
      '      </a>' . "\n" .
      '    </div>' . "\n" .
      '    <div class="wishpot_pub_pro_detail_product_title">' . "\n" .
      '      <label for="">' . $wishpot_product_details[0]['title'] . '</label>' . "\n" .
      '    </div><br /><br />' . "\n" .
      '    <div class="wishpot_pub_pro_detail_product_brand">' . "\n" .
      '      <b>' . __('Brand:', 'wishpot-pub-pro') . '</b>&nbsp;<label for="">' . $wishpot_product_details[0]['brand'] . '</label>' . "\n" .
      '    </div><br /><br />' . "\n" .
      '    <div class="wishpot_pub_pro_detail_product_price">' . "\n" .
      '      <b>' . __('Price:', 'wishpot-pub-pro') . '</b> ' . $wishpot_product_details[0]['price'] . "\n" .
      '    </div>' . "\n" .
      '    <div class="wishpot_pub_pro_product_buttons">' . "\n" .
      '      <div class="wishpot_form" style="display:none">' . "\n" .
      '        <input name="pkey" value="' . $wishpot_placement_id . '" type="hidden"/>' . "\n" .
      '        <input name="WishUrl" value="' . $wishpot_product_details[0]['url'] . '" type="hidden" />' . "\n" .
      '        <input name="WishTitle" value="' . $wishpot_product_details[0]['title'] . '" type="hidden" />' . "\n" .
      '        <input name="Price" value="' . $wishpot_product_details[0]['price'] . '" type="hidden" />' . "\n" .
      '        <input name="ImgSrc" value="' . $wishpot_product_details[0]['image_source'] . '" type="hidden" />' . "\n" .
      '        <input name="Sku" value="' . $wishpot_item_num . '" type="hidden" />' . "\n" .
      '      </div>' . "\n" .
      '      <a href="' . $wishpot_product_details[0]['url'] . '" title="" target="_blank">' . "\n" .
      '        <img width="120" height="22" alt="" src="http://s3.amazonaws.com/wp4domains/buttons/product-buynow.png" complete="complete" rel="nofollow"/>' . "\n" .
      '      </a>' . "\n" .
      '      <a title="Add to your universal wish list or wedding registry" onclick="' . $action . '" href="http://www.wishpot.com/" target="_blank" rel="nofollow">' . "\n" .
      '        <img alt="Add to Wish List" src="http://s3.amazonaws.com/wp4domains/buttons/add2wishpot.gif" border="0" complete="complete"/>' . "\n" .
      '      </a>' . "\n" .
      '    </div>' . "\n" .
      '    <div class="wishpot_pub_pro_detail_product_description">' . "\n" .
      '      <b>Description:</b><br />' . "\n" .
      '      <p>' . $wishpot_product_details[0]['description'] . '</p>' . "\n" .
      '    </div>' . "\n" .
      '    <div class="wishpot_pub_pro_detail_product_offers">' . "\n" .
      '      <b>Offers:</b><br />' . "\n";

      $wishpot_pub_pro_offers = $wishpot_product_details[0]['offers'];
      foreach ( $wishpot_pub_pro_offers as $key => $offer )
      {
        $html .=
        '      <div class="wishpot_pub_pro_detail_product_offer">' . "\n" .
        '        <img src="' . $offer['merchant']['logo'] . '" alt="' . $offer['merchant']['name'] . '" />' . "\n" .
        '        <div class="wishpot_pub_pro_detail_product_offers_price">' . "\n" .
        '          <b>' . __('Price:', 'wishpot-pub-pro') . '</b> ' . $offer['price'] . "\n" .
        '        </div>' . "\n" .
        '        <div class="wishpot_pub_pro_detail_product_offers_buttons">' . "\n" .
        '          <div class="wishpot_form" style="display:none">' . "\n" .
        '            <input name="pkey" value="' . $wishpot_placement_id . '" type="hidden"/>' . "\n" .
        '            <input name="WishUrl" value="' . $offer['url'] . '" type="hidden" />' . "\n" .
        '            <input name="WishTitle" value="' . $wishpot_product_details[0]['title'] . '" type="hidden" />' . "\n" .
        '            <input name="Price" value="' . $offer['price'] . '" type="hidden" />' . "\n" .
        '            <input name="ImgSrc" value="' . $wishpot_product_details[0]['image_source'] . '" type="hidden" />' . "\n" .
        '            <input name="Sku" value="' . $wishpot_item_num . '" type="hidden" />' . "\n" .
        '          </div>' . "\n" .
        '          <a href="' . $offer['url'] . '" title="" target="_blank">' . "\n" .
        '            <img width="120" height="22" alt="" src="http://s3.amazonaws.com/wp4domains/buttons/product-buynow.png" complete="complete" rel="nofollow"/>' . "\n" .
        '          </a>' . "\n" .
        '          <a title="Add to your universal wish list or wedding registry" onclick="' . $action . '" href="http://www.wishpot.com/" target="_blank" rel="nofollow">' . "\n" .
        '            <img alt="Add to Wish List" src="http://s3.amazonaws.com/wp4domains/buttons/add2wishpot.gif" border="0" complete="complete"/>' . "\n" .
        '          </a>' . "\n" .
        '        </div>' . "\n" .
        '      </div>' . "\n";
      }

      $html .=
      '    </div>' . "\n" .
      '  </div>' . "\n" .
      '  <div class="wishpot_pub_pro_product_page_footer">' . "\n" .
      '    <div class="wishpot_pub_pro_product_page_footer_link">' . "\n" .
      '      <a href="#top">Back To Top</a>' . "\n" .
      '    </div>' . "\n" .
      '  </div>' . "\n" .
      '</div>' . "\n" .
      '<div class="wishpot_pub_pro_clear_floats"></div>' . "\n" .
      '</body></html>' . "\n";

      $return_obj = array( 'html' => $html );
      break;
  }
    

/*
  $x = new WP_Ajax_Response( array(
              'what' => 'post_id',
              'id'   => $post_id,
              'data' => $url,
              'supplemental' => $url
          ) );
  $x->send();
*/

  if ( function_exists('json_encode') )
    $return_obj = json_encode($return_obj);

  die($return_obj);
}


////////////////////////////////////////////////////////////////////////////////
// add category
////////////////////////////////////////////////////////////////////////////////
function wishpot_pub_pro_add_category()
{
  wishpot_pub_pro_save_plugin_options();

  if ( !empty($_POST['wishpot_pub_pro_new_cat_name']) )
  {
    $new_cat = $_POST['wishpot_pub_pro_new_cat_name'];
    $cat_parent = get_cat_ID( 'Wishpot Publisher Pro' );
    wp_create_category( $new_cat, $cat_parent ); 

    echo '<div id="message" class="updated fade">';
    echo '<strong>' . __('Category added !!!', 'wishpot-pub-pro') . '</strong>.</div>';
  }
  else
  {
    echo '<div id="message" class="error fade">';
    echo '<strong>' . __('Category Name missing !!!', 'wishpot-pub-pro') . '</strong>.</div>';
  }

  return;
}


////////////////////////////////////////////////////////////////////////////////
// reload categories
////////////////////////////////////////////////////////////////////////////////
function     wishpot_pub_pro_reload_category()
{
  //  delete all categories from parent cat
  $cat_parent = get_cat_ID( 'Wishpot Publisher Pro' );
  $args = array(    
             'type'          => 'post',    
             'child_of'      => $cat_parent,
             'order_by'      => 'id',
             'order'         => 'desc',
             'hide_empty'    => 0
             );
  $temp_categories = get_categories( $args ); 
  foreach( $temp_categories as $temp_category )
  {
    wp_delete_category( $temp_category->cat_ID );
  }
  wp_delete_category($cat_parent);

  //  get all categories
  $url = 'http://productportals.wishpot.com/master_category_xml';

  $xml = file_get_contents( $url );

  $DomDoc = new DOMDocument();
  $DomDoc->loadXML($xml);

  $searchNodes = $DomDoc->getElementsByTagName( 'category' )->item(0)->firstChild->nextSibling->firstChild; 
  if ($searchNodes)
  {
    do
    {
      $wishpot_categories[] =  array(
        'name'  => $searchNodes->getElementsByTagName( 'name' )->item(0)->nodeValue
        );
    }while( $searchNodes = $searchNodes->nextSibling );
  }

/*
  $wishpot_def_cat_arr = array(
          'Appliances',
          'Automotive',
          'Babies & Kids',
          'Books & Magazines',
          'Clothing & Accessories',
          'Computers & Software',
          'DVDs & Videos',
          'Electronics',
          'Gifts, Flowers & Food',
          'Health & Beauty Supplies',
          'Home & Garden',
          'Jewelry & Watches',
          'Mature',
          'Music',
          'Musical Instruments & Accessories',
          'Office Supplies',
          'Other Products',
          'Pet Supplies',
          'Sports Equipment & Outdoor Gear',
          'Toys & Games',
          'Video Games'
          );
*/

  //  create each category in wp
  $cat_parent = wp_create_category( 'Wishpot Publisher Pro' );
  foreach ( $wishpot_categories  as $key => $new_cat )
  {
    wp_create_category( $new_cat['name'], $cat_parent ); 
  }

  wp_cache_delete('all_ids', 'category');
  wp_cache_delete('get', 'category');
  delete_option("category_children");
  // Regenerate {$taxonomy}_children
  _get_term_hierarchy('category');

  return;
}

    

function wishpot_pub_pro_custom_htmlspecialchars_decode($str, $options="") 
{
  $trans = get_html_translation_table(HTML_SPECIALCHARS);
  //$trans = get_html_translation_table(HTML_SPECIALCHARS, $options);
  $decode = ARRAY();

  foreach ($trans AS $char=>$entity) 
  {
    $decode[$entity] = $char;
  }
  $str = strtr($str, $decode);

  return $str;
}




////////////////////////////////////////////////////////////////////////////////
// customized post content
////////////////////////////////////////////////////////////////////////////////
function wishpot_pub_pro_content($content = false) 
{
  global $post,
         $wp_query,
         $wpdb;

  if ( $content )
  {
//    $content = apply_filters( 'the_content', $content);
//    $content = strip_shortcodes($content);
//    $content = str_replace(']]>', ']]&gt;', $content);
//    $content = strip_tags($content);

    //
    //  check for the short tag [wishpot_pub_pro_product_detail_page]
    //
    if ( !(strpos( $content, '[wishpot_pub_pro_product_detail_page]') === false) )
    {                         
      $wishpot_start_pos = strpos( $content, '[wishpot_pub_pro_product_detail_page]');
      $content = substr_replace( $content, '', $wishpot_start-pos, 37);
      //  get all parameters from $_GET
      $args = array(
        'placement_id' => $_GET['placement_id'],
        'title'        => $_GET['title'],
        'item_num'     => $_GET['item_num'],
        'price'        => $_GET['price'],
        'currency'     => $_GET['currency'],
        'url'          => $_GET['url'],
        'description'  => $_GET['description'],
        'brand'        => $_GET['brand'],
        'image_source' => rawurldecode($_GET['image_source'])
        );

      //  create content for product detail page
      $wishpot_content = wishpot_pub_pro_create_product_detail_page( $args );
      $content = substr_replace( $content, $wishpot_content, $wishpot_start_pos, 1);
    }



    //
    //  search for the keywords
    //  [wishpot_ads_product_page]
    //  [wishpot_ads_category= ]
    //  [wishpot_ads_keywords=  ]
    //  [wishpot_ads_number_of_products= ]
    //  [wishpot_ads_display_filters=    ]
    //  [wishpot_ads_placement_id=       ]
    //  [wishpot_ads_source=   ]

    $pos = 0;
    if ( !(strpos( $content, '[wishpot_ads_product_page]') === false) )
    {
      $wishpot_start_pos  = strpos( $content, '[wishpot_ads_product_page]' );
      $content = substr_replace( $content, '', $wishpot_start_pos, 26);
      //  get category
      if ( ($pos  = strpos( $content, '[wishpot_ads_category=' )) === false )
        $wishpot_category = 'All';
      else
      {
        $pos1 = strpos( $content, ']', $pos + 22);
        $wishpot_category = substr( $content, $pos + 22, $pos1 - ($pos + 22));
        $content = substr_replace( $content, '', $pos, $pos1 - $pos + 1);
      }
      //  get keywords
      $pos  = strpos( $content, '[wishpot_ads_keywords=' );
      if ( !($pos === false) )
      {
        $pos1 = strpos( $content, ']', $pos + 22);
        $wishpot_keywords = substr( $content, $pos + 22, $pos1 - ($pos + 22));
        $content = substr_replace( $content, '', $pos, $pos1 - $pos + 1);
      }
      //  get placement_id
      $pos  = strpos( $content, '[wishpot_ads_placement_id=' );
      if ( !($pos === false) )
      {
        $pos1 = strpos( $content, ']', $pos + 26);
        $wishpot_placement_id = substr( $content, $pos + 26, $pos1 - ($pos + 26));
        $content = substr_replace( $content, '', $pos, $pos1 - $pos + 1);
      }
      //  get source
      $pos  = strpos( $content, '[wishpot_ads_source=' );
      if ( !($pos === false) )
      {
        $pos1 = strpos( $content, ']', $pos + 20);
        $wishpot_source = substr( $content, $pos + 20, $pos1 - ($pos + 20));
        $content = substr_replace( $content, '', $pos, $pos1 - $pos + 1);
      }

      $type = 1;
      $args = array(
               'wishpot_category'     => rawurlencode(htmlentities($wishpot_category, ENT_QUOTES)),
               'wishpot_keywords'     => rawurlencode(htmlentities($wishpot_keywords, ENT_QUOTES)),
               'wishpot_placement_id' => htmlentities($wishpot_placement_id, ENT_QUOTES),
               'wishpot_source'       => rawurlencode(htmlentities($wishpot_source, ENT_QUOTES))
              );

      //
      //  display products 
      //
      //  get input params search, page, number items per page
      $wishpot_content = wishpot_pub_pro_process_page( $args );
      $content = substr_replace( $content, $wishpot_content, $wishpot_start_pos, 1);
    }
  }

  return $content;
}


////////////////////////////////////////////////////////////////////////////////
// get ads
////////////////////////////////////////////////////////////////////////////////
function wishpot_pub_pro_get_ads( $type = NULL, $args = NULL ) 
{
  $wishpot_limit = wishpot_pub_pro_get_option('wishpot_pub_pro_pagesize');

  $url = 'http://productportals.wishpot.com/product_api/';
  //  parse args
  extract( $args, EXTR_OVERWRITE );

  //  check if page, price or brand is set
  if (empty($wishpot_page))
    $wishpot_page = 1;

  $required = 0;
  //  required is set to not null if one of the required parameter is empty
  //  1 --> wishpot_placement id
  //  2 --> wishpot_category
  //  4 --> wishpot_keywords
  //  8 --> wishpot_domain_id
  // 16 --> wishpot_item_number
  switch ($type)
  {
    case '1':
      $url .= '?placement_id=' . $wishpot_placement_id . '&category=' . $wishpot_category . 
              '&term=' . $wishpot_keywords . '&page=' . $wishpot_page;
      if ( !empty($wishpot_source) )
        $url .= '&source=' . $wishpot_source;
      break;
    case '2':
      //  get results by brand
      $url .= '?placement_id=' . $wishpot_placement_id . '&category=' . $wishpot_category . 
              '&term=' . $wishpot_keywords . '&brand=' . $wishpot_brand . '&page=' . $wishpot_page;
      if ( !empty($wishpot_source) )
        $url .= '&source=' . $wishpot_source;
      break;
    case '3':
      //  get product details with placement_id
      $url .= '?placement_id=' . $wishpot_placement_id . '&item_num=' . $wishpot_item_num; 
      break;
    default:
  }

  if ( !empty($wishpot_limit) )
    $url .= '&limit=' . $wishpot_limit;
  if ( !($wishpot_min === NULL) AND !($wishpot_max === NULL) )
  {
    $url .= '&min=' . $wishpot_min . '&max=' . $wishpot_max;
  }
  $xml = file_get_contents( $url );

  $DomDoc = new DOMDocument();
  $DomDoc->loadXML($xml);

  //   get brands
  $searchNodes = $DomDoc->getElementsByTagName( 'brands' )->item(0); 
  if ($searchNodes)
  {
    $brandNodes  = $searchNodes->getElementsByTagName( 'brand' );
    foreach( $brandNodes as $brandNode ) 
    {
      $brands[] =  array(
        'name'  => $brandNode->getElementsByTagName( 'name' )->item(0)->nodeValue,
        'code'  => $brandNode->getElementsByTagName( 'code' )->item(0)->nodeValue
        );
    }
  }

  //   get price ranges
  $searchNodes = $DomDoc->getElementsByTagName( 'price_ranges' )->item(0); 
  if ($searchNodes)
  {
    $priceNodes  = $searchNodes->getElementsByTagName( 'range' );
    foreach( $priceNodes as $priceNode ) 
    {
      $price_ranges[] =  array(
        'min'  => $priceNode->getElementsByTagName( 'min' )->item(0)->nodeValue,
        'max'  => $priceNode->getElementsByTagName( 'max' )->item(0)->nodeValue
        );
    }
  }


  //   get page count and product count
  $products_count = $DomDoc->getElementsByTagName( 'totalProducts' )->item(0)->nodeValue; 
  $page_count = $DomDoc->getElementsByTagName( 'totalPages' )->item(0)->nodeValue; 

  switch ($type)
  {
    case 1:
    case 2:
      $searchNodes = $DomDoc->getElementsByTagName( 'product' ); 
      foreach( $searchNodes as $searchNode ) 
      { 
        $imageNode = $searchNode->getElementsByTagName( 'image' )->item(0);
        $url = $searchNode->getElementsByTagName( 'url' )->item(0)->nodeValue;
        $image_url = $imageNode->getElementsByTagName( 'source' )->item(0)->nodeValue;
        $image_url = str_replace( "&", "&amp;", $image_url);
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
      }
      $result[0] = $wishpot_ads_products;
      break;
    case 3:
      //  get product details and offers
      $searchNodes = $DomDoc->getElementsByTagName( 'product' ); 
      foreach( $searchNodes as $searchNode ) 
      { 
        $imageNode = $searchNode->getElementsByTagName( 'image' )->item(0);
        $url = $searchNode->getElementsByTagName( 'url' )->item(0)->nodeValue;
        $image_url = $imageNode->getElementsByTagName( 'source' )->item(0)->nodeValue;
        $image_url = str_replace( "&", "&amp;", $image_url);
 
        //  get offers
        $offersNodes = $searchNode->getElementsByTagName( 'offers' ); 
        $offers = array();
        foreach( $offersNodes as $offerNode )
        {
          $merchantNode = $offerNode->getElementsByTagName( 'merchant' )->item(0);
          $offers[] = array(
              'price'     => $offerNode->getElementsByTagName( 'price' )->item(0)->nodeValue,
              'url'       => $offerNode->getElementsByTagName( 'url' )->item(0)->nodeValue,
              'merchant'  => array(
                                'name'  => $merchantNode->getElementsByTagName( 'name' )->item(0)->nodeValue,
                                'logo'  => $merchantNode->getElementsByTagName( 'logo' )->item(0)->nodeValue
                             )
              );
        }
        $wishpot_ads_products[] = array(
           'title'        => $searchNode->getElementsByTagName( 'title' )->item(0)->nodeValue,
           'item_num'     => $searchNode->getElementsByTagName( 'item_num' )->item(0)->nodeValue,
           'price'        => $searchNode->getElementsByTagName( 'price' )->item(0)->nodeValue,
           'currency'     => $searchNode->getElementsByTagName( 'currency' )->item(0)->nodeValue,
           'url'          => $url,
           'description'  => $searchNode->getElementsByTagName( 'description' )->item(0)->nodeValue,
           'brand'        => $searchNode->getElementsByTagName( 'brand' )->item(0)->nodeValue,
           'offers'       => $offers,
           'image_width'  => $imageNode->getElementsByTagName( 'width' )->item(0)->nodeValue,
           'image_height' => $imageNode->getElementsByTagName( 'height' )->item(0)->nodeValue,
           'image_source' => $image_url
           );
      }
      $result[0] = $wishpot_ads_products;
      break;
  }

  $result[1] = $brands;
  $result[2] = $products_count;
  $result[3] = $page_count;
  $result[4] = $price_ranges;

  return $result;
}



////////////////////////////////////////////////////////////////////////////////
// prepare product page display
////////////////////////////////////////////////////////////////////////////////
function wishpot_pub_pro_process_page( $args )
{
  global $wishpot_plugin_url;
  global $post;

  //  parse args
  extract( $args, EXTR_OVERWRITE );
  $type = 1;

  $wishpot_pub_pro_item_list_search  = $_SESSION['wishpot_pub_pro_item_list_search'];
  $wishpot_pub_pro_products_per_page = NULL;
  $wishpot_pub_pro_item_list_price   = $_SESSION['wishpot_pub_pro_item_list_price'];
  $wishpot_pub_pro_item_list_brands  = $_SESSION['wishpot_pub_pro_item_list_brands'];
  $wishpot_pub_pro_item_list_page    = $_SESSION['wishpot_pub_pro_item_list_page'];

  //
  //  before product request
  //
  //  get all $_POST variables

  //
  //  SORT Order 
  //
  //  user has clicked price range buttons
  if ( $_POST['wishpot_pub_pro_item_list_prices_all'] )
  {
    $wishpot_pub_pro_item_list_price = 0;
    $_SESSION['wishpot_pub_pro_item_list_price'] = 0;
    $wishpot_pub_pro_item_list_search = NULL;
    $_SESSION['wishpot_pub_pro_item_list_search'] = NULL;
  }
  if ( $_POST['wishpot_pub_pro_item_list_prices'] )
  {
    $wishpot_pub_pro_item_list_price = 1;
    $_SESSION['wishpot_pub_pro_item_list_price'] = 1;
    $wishpot_pub_pro_item_list_price_min = $_POST['wishpot_pub_pro_item_list_prices_min'];
    $wishpot_pub_pro_item_list_price_max = $_POST['wishpot_pub_pro_item_list_prices_max'];
    $wishpot_pub_pro_item_list_search = NULL;
    $_SESSION['wishpot_pub_pro_item_list_search'] = NULL;
  }

  //  user has clicked brand range buttons
  if ( $_POST['wishpot_pub_pro_item_list_brands_all'] )
  {
    $wishpot_pub_pro_item_list_brands = 0;
    $_SESSION['wishpot_pub_pro_item_list_brands'] = 0;
    $wishpot_pub_pro_item_list_search = NULL;
    $_SESSION['wishpot_pub_pro_item_list_search'] = NULL;
  }
  if ( $_POST['wishpot_pub_pro_item_list_brand'] )
  {
    $wishpot_pub_pro_item_list_brands = $_POST['wishpot_pub_pro_item_list_brand_code'];
    $_SESSION['wishpot_pub_pro_item_list_brands'] = $_POST['wishpot_pub_pro_item_list_brand_code'];
    // set page to first back
    $wishpot_pub_pro_item_list_page = 1;
    $_SESSION['wishpot_pub_pro_item_list_page'] = $wishpot_pub_pro_item_list_page;
    $wishpot_pub_pro_item_list_search = NULL;
    $_SESSION['wishpot_pub_pro_item_list_search'] = NULL;
  }

  //  user has clicked search icon
  if ( isset($_POST['wishpot_pub_pro_item_list_search_submit']) )
  {
    $wishpot_pub_pro_item_list_search = $_POST['wishpot_pub_pro_item_list_search'];
    $_SESSION['wishpot_pub_pro_item_list_search'] = $_POST['wishpot_pub_pro_item_list_search'];
  }

  //  process submitted data
  //   get input vars
  if ( isset($_POST['wishpot_pub_pro_item_list_page_last']) )
  {
    $wishpot_pub_pro_item_list_page = $wishpot_pub_pro_page_count;
    $_SESSION['wishpot_pub_pro_item_list_page'] = $wishpot_pub_pro_item_list_page;
  }

  //  page number
  if ( $_POST['wishpot_pub_pro_item_list_page'] )
  {
    $wishpot_pub_pro_item_list_page = intval($_POST['wishpot_pub_pro_item_list_page']);
    $_SESSION['wishpot_pub_pro_item_list_page'] = $wishpot_pub_pro_item_list_page;
  }
  if ( (!$wishpot_pub_pro_item_list_page OR isset($_POST['wishpot_pub_pro_item_list_page_first'])) )
  {
    $wishpot_pub_pro_item_list_page = 1;
    $_SESSION['wishpot_pub_pro_item_list_page'] = $wishpot_pub_pro_item_list_page;
  }
  if ( isset($_POST['wishpot_pub_pro_item_list_page_next']) )
  {
    $wishpot_pub_pro_item_list_page = $_SESSION['wishpot_pub_pro_item_list_page'] + 1;
    $_SESSION['wishpot_pub_pro_item_list_page'] = $wishpot_pub_pro_item_list_page;
  }
  if ( isset($_POST['wishpot_pub_pro_item_list_page_prev']) )
  {
    $wishpot_pub_pro_item_list_page = $_SESSION['wishpot_pub_pro_item_list_page'] - 1;
    $_SESSION['wishpot_pub_pro_item_list_page'] = $wishpot_pub_pro_item_list_page;
  }
  if ( isset($_POST['wishpot_pub_pro_item_list_page_last']) )
  {
    $wishpot_pub_pro_item_list_page = $wishpot_pub_pro_page_count;
    $_SESSION['wishpot_pub_pro_item_list_page'] = $wishpot_pub_pro_item_list_page;
  }

  if ( $wishpot_pub_pro_item_list_brands )
  {
    // get results by brand
    $type = 2;
    $args['wishpot_brand'] = $wishpot_pub_pro_item_list_brands;
  }

  $wishpot_keywords = str_replace( ' ', '+', $wishpot_keywords);

  if ( $wishpot_pub_pro_item_list_search )
  {
    $wishpot_pub_pro_item_list_search = str_replace( ' ', '+', $wishpot_pub_pro_item_list_search);
    $wishpot_keywords = $wishpot_pub_pro_item_list_search;
    $args['wishpot_keywords'] = $wishpot_keywords;

/*    
    // search array and filter by brand
    $cnt = count($wishpot_ads_products);
    $new_indx = 0;
    $new_array = array();
    foreach ( $wishpot_ads_products as $index => $product )
    {
      if ( wishpot_array_search( $wishpot_pub_pro_item_list_search, $product) )
      {
        $new_array[$new_indx] = $product;
        $new_indx++;
      }
    }
    $wishpot_ads_products = $new_array;
    $wishpot_pub_pro_products_count = count($wishpot_ads_products);
*/
  }

  if ( $wishpot_pub_pro_item_list_price )
  {
    $args['wishpot_min'] = $wishpot_pub_pro_item_list_price_min;
    $args['wishpot_max'] = $wishpot_pub_pro_item_list_price_max;
  }
  else
  {
    $args['wishpot_min'] = NULL;
    $args['wishpot_max'] = NULL;
  }

  $args['wishpot_page'] = $wishpot_pub_pro_item_list_page;

  $wishpot_pub_pro_products_per_page = wishpot_pub_pro_get_option('wishpot_pub_pro_pagesize');
  $args['wishpot_limit'] = $wishpot_pub_pro_products_per_page;
  $results = wishpot_pub_pro_get_ads( $type, $args);

  $wishpot_ads_products = $results[0];
  $wishpot_pub_pro_products_brands = $results[1];
  $wishpot_pub_pro_products_brands = wishpot_array_msort($wishpot_pub_pro_products_brands, array( 'name' => SORT_ASC));

  $wishpot_pub_pro_products_count  = $results[2];
  $wishpot_pub_pro_page_count      = $results[3];
  $wishpot_pub_pro_price_ranges    = $results[4];


/*
  $wishpot_pub_pro_products_count = count($wishpot_ads_products);
  $pages = intval($wishpot_pub_pro_products_count / $wishpot_pub_pro_products_per_page);
  $rest  = $wishpot_pub_pro_products_count % $wishpot_pub_pro_products_per_page;
  if ( $rest )
    $pages++;
  $wishpot_pub_pro_page_count = $pages;
*/


  $wishpot_pub_pro_item_counter = 1;

//  $wishpot_pub_pro_item_counter = ($wishpot_pub_pro_products_per_page * ($wishpot_pub_pro_item_list_page - 1)) + 1;

  $content = 
  '<div class="wishpot_pub_pro_clear_floats"></div>' . "\n" .
  '<a name="top" href=""></a>' . "\n" .
  '<div id="wishpot_pub_pro_products_page_wrapper">' . "\n" .
  '  <div class="wishpot_pub_pro_product_page_header">' . "\n" .
  '    <div class="wishpot_pub_pro_category"><h3>' . rawurldecode($wishpot_category) . ': ' . rawurldecode($wishpot_keywords) . '</h3></div>' . "\n" .
  '    <div class="wishpot_pub_pro_search">' . "\n" .
  '      <form class="form_item_list_search" method="post" action="">' . "\n" .
  '        <input type="text" size="20" name="wishpot_pub_pro_item_list_search" id="wishpot_pub_pro_search_input" value="' . __('Search ....', 'wishpot-pub-pro') . '" />' . "\n" .
  '        <input type="submit" class="input_item_list_search" name="wishpot_pub_pro_item_list_search_submit" value="" />' . "\n" .
  '      </form>' . "\n" .
  '    </div>' . "\n" .
  '  </div>' . "\n" .
  '  <div class="wishpot_pub_pro_clear_floats"></div>' . "\n" .
  '  <div class="wishpot_product_page_list_sidebar">' . "\n" . 
  '    <div class="wishpot_pub_pro_page_list_sidebar_prices">' . "\n" .
  '      <h4>' . __('Prices', 'wishpot-pub-pro') . '</h4>' . "\n";

  if ( !empty($wishpot_pub_pro_price_ranges) )
  {          
    $content .=
    '      <form class="form_item_list_prices" method="post" action=""><input type="submit" class="input_item_list_prices" name="wishpot_pub_pro_item_list_prices_all" value="' . __('All', 'wishpot-pub-pro') . '" /> </form>' . "\n";
    $indx = 1;
    foreach( $wishpot_pub_pro_price_ranges as $range)
    {
      if ( $range['max'] == '-1' )
        $max = '....';
      else
        $max = $range['max'];
      $content .=
      '      <form class="form_item_list_prices" method="post" action="">' . "\n" .
      '        <input type="submit" class="input_item_list_prices" name="wishpot_pub_pro_item_list_prices" value="' . $range['min'] . '-' . $max . '" />' . "\n" .
      '        <input type="hidden" class="input_item_list_prices" name="wishpot_pub_pro_item_list_prices_min" value="' . $range['min'] . '" />' . "\n" .
      '        <input type="hidden" class="input_item_list_prices" name="wishpot_pub_pro_item_list_prices_max" value="' . $range['max'] . '" />' . "\n" .
      '      </form>' . "\n";
      $indx++;
    }
  }

  $content .=
  '    </div>' . "\n" .
  '    <div class="wishpot_pub_pro_page_list_sidebar_brands">' . "\n" .
  '      <h4>' . __('Brands', 'wishpot-pub-pro') . '</h4>' . "\n";

  if ( !empty($wishpot_pub_pro_products_brands) )
  {          
    $content .=
    '      <form class="form_item_list_brands" method="post" action=""><input type="submit" class="input_item_list_brands" name="wishpot_pub_pro_item_list_brands_all" value="' . __('All', 'wishpot-pub-pro') . '" /> </form>' . "\n";
    foreach( $wishpot_pub_pro_products_brands as $brand)
    {
      $content .=
      '      <form class="form_item_list_brands" method="post" action="">' . "\n" .
      '        <input type="submit" class="input_item_list_brands" name="wishpot_pub_pro_item_list_brand" value="' . $brand['name'] . '" />' . "\n" .
      '        <input type="hidden" class="input_item_list_brands" name="wishpot_pub_pro_item_list_brand_code" value="' . $brand['code'] . '" />' . "\n" .
      '      </form>' . "\n";
    }
  }

  $content .=
  '    </div>' . "\n" .
  '  </div>' . "\n" .
  '  <div class="wishpot_product_page_list">' . "\n";

  if ( $wishpot_pub_pro_products_count > 0 )
  {
    switch($wishpot_pub_pro_products_per_page)
    {
      case 15:
        $rows = 5;
        $cols = 3;
        break;
      case 18:
        $rows = 6;
        $cols = 3;
        break;
      case 20:
        $rows = 5;
        $cols = 4;
        break;
    }
    for ( $i = 0; ($i < $rows) AND ($wishpot_pub_pro_item_counter <= $wishpot_pub_pro_products_count); $i++ )
    {
      $content .=  
      '    <div class="wishpot_pub_pro_product_items_row">' . "\n";
      for ( $m = 0; ($m < $cols) AND ($wishpot_pub_pro_item_counter <= $wishpot_pub_pro_products_count); $m++ )
      {
        $indx = $wishpot_pub_pro_item_counter - 1;
        $action = "if(document.getElementById){window.WISHPOT_FORM=this.parentNode;var x=document.getElementsByTagName('head').item(0);var o=document.createElement('script');if(typeof(o)!='object') o=document.standardCreateElement('script');o.setAttribute('src',(('https:' == document.location.protocol) ? 'https' : 'http')+'://www.wishpot.com/scripts/bm.js?v=100');o.setAttribute('type','text/javascript');x.appendChild(o);} return false;";

        $title = $wishpot_ads_products[$indx]['title'];
        if ( str_word_count($title, 0, '0123456789') > 7 )
        {
          $title_arr = explode(' ', $title);
          $title = '';
          for ( $k = 0; $k < 7; $k++ )
          {
            $title .= $title_arr[$k] . ' ';
          }
        }
        else
          $title .= ' ';
        $more = '<a href="javascript:void(0)" onclick="wishpot_pub_pro_show_product_details(\'' . $wishpot_placement_id . '\',\'' . $wishpot_ads_products[$indx]['item_num'] . '\'); return false;" title="' . __('See more product details', 'wishpot-pub-pro') . '" target="_blank">' . __('More ...', 'wishpot-pub-pro') . '</a>';

        $content .= 
        '        <div class="wishput_pub_pro_product_item_wrapper">' . "\n" .
        '          <div class="wishpot_pub_pro_product_item_img">' . "\n" .
        '            <a href="' . $wishpot_ads_products[$indx]['url'] . '" title="" target="_blank">' . "\n" .
        '            <img src="' . $wishpot_ads_products[$indx]['image_source'] . '" alt="" />' . "\n" .
        '            </a>' . "\n" .
        '          </div>' . "\n" .
        '          <div class="wishpot_pub_pro_product_title">' . "\n" .
        '            <label for="">' . $title . '</label>' . $more . "\n" .
        '          </div>' . "\n" .
        '          <div class="wishpot_pub_pro_product_price">' . "\n" .
        '            <label for="">' . $wishpot_ads_products[$indx]['price'] . '</label>' . "\n" .
        '          </div>' . "\n" .
        '          <div class="wishpot_pub_pro_product_buttons">' . "\n" .
        '            <div class="wishpot_form" style="display:none">' . "\n" .
        '              <input name="pkey" value="' . $wishpot_placement_id . '" type="hidden"/>' . "\n" .
        '              <input name="WishUrl" value="' . $wishpot_ads_products[$indx]['url'] . '" type="hidden" />' . "\n" .
        '              <input name="WishTitle" value="' . $wishpot_ads_products[$indx]['title'] . '" type="hidden" />' . "\n" .
        '              <input name="Price" value="' . $wishpot_ads_products[$indx]['price'] . '" type="hidden" />' . "\n" .
        '              <input name="ImgSrc" value="' . $wishpot_ads_products[$indx]['image_source'] . '" type="hidden" />' . "\n" .
        '              <input name="Description" value="' . $wishpot_ads_products[$indx]['description'] . '" type="hidden" />' . "\n" .
        '              <input name="Brand" value="' . $wishpot_ads_products[$indx]['brand'] . '" type="hidden" />' . "\n" .
        '              <input name="Sku" value="' . $wishpot_ads_products[$indx]['item_num'] . '" type="hidden" />' . "\n" .
        '            </div>' . "\n" .
        '            <a href="' . $wishpot_ads_products[$indx]['url'] . '" title="" target="_blank">' . "\n" .
        '              <img width="120" height="22" alt="" src="http://s3.amazonaws.com/wp4domains/buttons/product-buynow.png" complete="complete" rel="nofollow"/>' . "\n" .
        '            </a>' . "\n" .
        '            <a title="Add to your universal wish list or wedding registry" onclick="' . $action . '" href="http://www.wishpot.com/" target="_blank" rel="nofollow">' . "\n" .
        '              <img alt="Add to Wish List" src="http://s3.amazonaws.com/wp4domains/buttons/add2wishpot.gif" border="0" complete="complete"/>' . "\n" .
        '            </a>' . "\n" .
        '          </div>' . "\n" .
        '        </div>' . "\n";
        $wishpot_pub_pro_item_counter++;
      }
      $content .=
      '    </div>' . "\n";
    }
  }
  else
  {
    $content .=  
    '    <div class="wishpot_pub_pro_product_items_row">' . "\n" .
    '      <p><b>No Results were found - you can widen your search criteria to get more results.</b></p>' . "\n" .
    '    </div>' . "\n";
  }

/*
      '              <noscript>Visit Wishpot add this item to your wish list.</noscript>' . "\n" .
<input name="ImgWidth" value="<%= dimensions[:width] %>" type="hidden" /> 
<input name="ImgHeight" value="<%= dimensions[:height] %>" type="hidden" /> 
<img border="0" src="<%= buttons[:wishpot] %>" alt="Add to Wish List" /> 
*/

  $content .=
  '  </div>' . "\n" .
  '  <div class="wishpot_pub_pro_product_page_footer">' . "\n" .
  '    <div class="wishpot_pub_pro_product_page_footer_link">' . "\n" .
  '      <a href="#top">Back To Top</a>' . "\n" .
  '    </div>' . "\n" .
  '    <div class="wishpot_pub_pro_product_page_footer_nav">' . "\n" .
  '      <form class="form_item_list_page" method="post" action=""><input type="submit" class="input_item_list_page_first" name="wishpot_pub_pro_item_list_page_first" value="" /> </form>' . "\n" .
  '      <form class="form_item_list_page" method="post" action=""><input type="submit" class="input_item_list_page_prev" name="wishpot_pub_pro_item_list_page_prev" value="" /> </form>' . "\n";
  if ( $wishpot_pub_pro_item_list_page >= 10 )
    $wishpot_pub_pro_list_page_start = $wishpot_pub_pro_item_list_page - 5;
  else
    $wishpot_pub_pro_list_page_start = 1;
  for ( $i=$wishpot_pub_pro_list_page_start; (($i <= $wishpot_pub_pro_page_count) AND ($i <= ($wishpot_pub_pro_list_page_start + 9))); $i++ )
  { 
    if ( $i == $wishpot_pub_pro_item_list_page )
      $content .= '<form class="form_item_list_page" method="post" action=""><input type="submit" class="input_item_list_page active" name="wishpot_pub_pro_item_list_page" value="' . $i . '" />  |  </form>' . "\n";
    else
      $content .= '<form class="form_item_list_page" method="post" action=""><input type="submit" class="input_item_list_page nonactive" name="wishpot_pub_pro_item_list_page" value="' . $i . '" />  |  </form>' . "\n";
  }
  $content .=
  '      <form class="form_item_list_page" method="post" action=""><input type="submit" class="input_item_list_page_next" name="wishpot_pub_pro_item_list_page_next" value="" /> </form>' . "\n" .
  '      <form class="form_item_list_page" method="post" action=""><input type="submit" class="input_item_list_page_last" name="wishpot_pub_pro_item_list_page_last" value="" /> </form>' . "\n" .
  '    </div>' . "\n" .
  '  </div>' . "\n" .
  '</div>' . "\n" .
  '<div class="wishpot_pub_pro_clear_floats"></div>' . "\n";

  return $content;
}



////////////////////////////////////////////////////////////////////////////////
// sort array
////////////////////////////////////////////////////////////////////////////////
function wishpot_array_msort($array, $cols)
{
    $colarr = array();
    foreach ($cols as $col => $order) {
        $colarr[$col] = array();
        foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
    }
    $eval = 'array_multisort(';
    foreach ($cols as $col => $order) {
        $eval .= '$colarr[\''.$col.'\'],'.$order.',';
    }
    $eval = substr($eval,0,-1).');';
    eval($eval);
    $ret = array();
    foreach ($colarr as $col => $arr) {
        foreach ($arr as $k => $v) {
            $k = substr($k,1);
            if (!isset($ret[$k])) $ret[$k] = $array[$k];
            $ret[$k][$col] = $array[$k][$col];
        }
    }
    return $ret;

}



////////////////////////////////////////////////////////////////////////////////
// search array
////////////////////////////////////////////////////////////////////////////////
function wishpot_array_search($needle = null, $haystack_array = null, $skip = 0)
{
    if($needle == null || $haystack_array == null)
        die('$needle and $haystack_array are mandatory for functie my_array_search()');
    foreach($haystack_array as $key => $eval)
    {
        if($skip != 0)$eval = substr($eval, $skip);
        if(stristr($eval, $needle) !== false) return true;
    }
    return false;
}


////////////////////////////////////////////////////////////////////////////////
// wishpot wp footer
////////////////////////////////////////////////////////////////////////////////
function  wishpot_pub_pro_wp_footer()
{
  global $wpdb,
         $post;

  $title = $post->post_title;

  if ( !(strpos( $title, 'Wishpot Publisher Pro - Product Detail Page' ) === false) )
  {
    $wishpot_post = array(
       'ID'           => $post_ID,
       'post_content' => '[wishpot_pub_pro_product_detail_page]'
       );
    wp_update_post($wishpot_post);
  }

  $slug = $post->post_name;
  if ( !(strpos( $slug, 'wishpot-publisher-pro-product-search-results-page' ) === false) )
  {
//    wp_delete_post( $post->ID, true ); 
  }

  $wishpot_print_ga_script = wishpot_pub_pro_get_option('wishpot_pub_pro_widget_ga');
  if ($wishpot_print_ga_script == 'on') 
  {
?>
      <script type="text/javascript"> var _gaq = _gaq || []; _gaq.push(['_setAccount', 'UA-10915762-1']); _gaq.push(['_trackPageview']); _gaq.push( ['b._setAccount', 'UA-10915762-47'], ['b._setDomainName', 'none'], ['b._setAllowLinker', true], ['b._setCustomVar', 1, 'DomainId', '143', 3], ['b._trackPageview'] ); (function() { var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true; ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s); })(); function recordOutboundLink(category, action, price, sku) { try { var myTracker = _gat._getTrackerByName(); _gaq.push(['myTracker._trackEvent', ' + category + ', ' + action + ']); _gaq.push(['addTrans', '195cc98f6e9cf89fa71b9a61c3acab5d', '', price, '', '', '', '', '']); _gaq.push(['addItem', '195cc98f6e9cf89fa71b9a61c3acab5d', sku.toString(), '', '', price, '1']); _gaq.push(['trackTrans']) }catch(err){} } </script>
<?php
  }

  return;
}




////////////////////////////////////////////////////////////////////////////////
// create wishpot product detail page
////////////////////////////////////////////////////////////////////////////////
function wishpot_pub_pro_create_product_search_results_page()
{
  $temp_page = get_page_by_title( 'Wishpot Publisher Pro - Product Search Results Page' );
  if ( !$temp_page ) 
  {
    $wishpot_post = array(
       'post_title'   => 'Wishpot Publisher Pro - Product Search Results Page',
       'post_content' => '',
       'post_name'    => 'wishpot-publisher-pro-product-search-results-page',
       'post_status'  => 'draft',
       'post_parent'  => 0,
       'comment_status' => 'closed',
       'post_type'    => 'page',
       'post_author'  => 1
      );

    $page_id = wp_insert_post($wishpot_post);
  }
  else
    $page_id = $temp_page->ID;

  wishpot_pub_pro_update_option('wishpot_pub_pro_product_search_results_page_id', $page_id);

  return $page_id;
}



?>