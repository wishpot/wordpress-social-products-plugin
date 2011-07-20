<?php


function wishpot_pub_pro_plugin_print_option_page()
{
  $options = get_option('wishpot_pub_pro_options');

  $wishpot_pub_pro_tracking_id     = wishpot_pub_pro_get_option('wishpot_tracking_id');
  $wishpot_pub_pro_pagesize        = wishpot_pub_pro_get_option('wishpot_pub_pro_pagesize');
  $wishpot_pub_pro_widget_ga       = wishpot_pub_pro_get_option('wishpot_pub_pro_widget_ga');
  $wishpot_pub_pro_pp_fblike       = wishpot_pub_pro_get_option('wishpot_pub_pro_pp_fblike');
  $wishpot_pub_pro_pp_fbshare      = wishpot_pub_pro_get_option('wishpot_pub_pro_pp_fbshare');
  $wishpot_pub_pro_pp_twshare      = wishpot_pub_pro_get_option('wishpot_pub_pro_pp_twshare');


  $arr_pagesize = array(
                    '15'   => '3x5',
                    '18'   => '3x6',
                    '20'   => '4x5'
                 );


  //  check if default cat exists
  if ( !get_cat_ID('Wishpot Publisher Pro') ) 
  {
    wp_create_category( 'Wishpot Publisher Pro' );
  }

  $wishpot_cat = get_cat_ID( 'Wishpot Publisher Pro' );
  $args = array(    
             'type'          => 'post',    
             'child_of'      => $wishpot_cat,
             'order_by'      => 'id',
             'order'         => 'desc',
             'hide_empty'    => 0
             );
  $wishpot_categories = get_categories( 'hide_empty=0&child_of=' . $wishpot_cat  ); 

  echo
  '<div class="wrap">' . "\n" .
  '  <a name="Top"></a>' . "\n" .
  '  <div class="icon32"></div>' . "\n" .
  '  <h2>Wishpot Publisher Pro&copy; - Plugin Settings</h2>' . "\n" .
  '  <hr />' . "\n" .
  '  <p>' . "\n" .
  '    <b>Welcome to Wishpot Publisher Pro&copy; WP Tool!</b><br />' . "\n" .
  '    ' . __('This free plugin allows you to display various ads on your blog. You can display them in any widget area or on wordpress pages.', 'wishpot-pub-pro') . '<br />' . "\n" .
  '    ' . __('The ads can be customized in size and count of visible products.', 'wishpot-pub-pro') . "\n" .
  '  </p>' . "\n" .
  '  <hr />' . "\n" .
  '  <div class="clear"></div>' . "\n" . 
  '  <form name="wishpot_options_form" method="post" action="">' . "\n";

  wp_nonce_field('wishpot_options_form');

  echo
  '  <div class="metabox-holder has-right-sidebar" id="plugin-panel-widgets">' . "\n" .
  '    <div class="postbox-container" id="plugin-main">' . "\n" .
  '      <div class="has-sidebar-content">' . "\n" .
  '        <div class="meta-box-sortables ui-sortable" id="normal-sortables" unselectable="on">' . "\n" .
  '          <div class="postbox ui-droppable" id="wishpot-settings">' . "\n" .
  '            <div title="' . __('Zum umschalten klicken', 'wishpot-pub-pro') . '" class="handlediv"><br /></div>' . "\n" .
  '            <h3 class="hndle">' . __('Global Settings', 'wishpot-pub-pro') . '</h3>' . "\n" .
  '            <div class="inside">' . "\n" .
  '              <b>Import from ' . $url_display . '</b>' . "\n" .
  '              <table class="form-table">' . "\n" .
  '              <tr><th class="wishpot_option_left_part"><label for="">' . __('Add New Categories', 'wishpot-pub-pro') . '</label></th>' . "\n" .
  '                  <td><select name="wishpot_pub_pro_cats_select[]" id="wishpot_pub_pro_cats_select_tag" multiple="multiple" size="5">' . "\n";

/*
  '              <tr><th class="wishpot_option_left_part"><label for="wishpot_tracking_id">Enter your WishPot Tracking Id</label></th>' . "\n" .
  '                  <td><input type="text" id="wishpot_pub_pro_tracking_id_id" name="wishpot_pub_pro_tracking_id" value="' . $wishpot_pub_pro_tracking_id . '" /></td>' . "\n" .
  '              </tr>' . "\n" .
*/

  foreach( $wishpot_categories as $cat)
  { 
    if ( in_array( $cat->cat_ID, $wishpot_pub_pro_cats ) )
    {
      echo '  <option value="' . $cat->cat_ID . '" selected="selected">' . $cat->cat_name . '</option>' . "\n";
    }
    else
    {
      echo '  <option value="' . $cat->cat_ID . '">' . $cat->cat_name . '</option>' . "\n";
    }
  }

  echo
  '                   </select><br /><br />' . "\n" .
  '                   <div class="margintb">New Category: <input type="text" value="" name="wishpot_pub_pro_new_cat_name"  /></div>' . "\n" .
  '                   <div class="margintb">Parent Category: <b>Wishpot Publisher Pro</b></div>' . "\n" .
  '                   <br />' . "\n" .
  '                   <div class="div-wait" id="divwait3"><img src="' . WISPURL . 'img/loading.gif" /></div>' . "\n" .
  '                   <input type="submit" class="button-primary" value="Add New Category" id="wishpot_pub_pro_add_cat_btn" name="wishpot_pub_pro_add_cat_btn" onclick="document.getElementById(nameofDivWait).style.display=\'inline\';this.form.submit();" />' . "\n" .    
  '                   <div class="div-wait" id="divwait4"><img src="' . WISPURL . 'img/loading.gif" /></div>' . "\n" .
  '                   <input type="submit" class="button-primary" value="Reload Categories" id="wishpot_pub_pro_reload_cats_btn" name="wishpot_pub_pro_reload_cats_btn" onclick="document.getElementById(nameofDivWait).style.display=\'inline\';this.form.submit();" /><br />' . "\n" .    
  '                   </td>' . "\n" .
  '              </tr>' . "\n";

  if ( $wishpot_pub_pro_widget_ga == 'on' )
    $checked = ' checked="checked" ';
  else
    $checked = ' ';

  echo
  '              <tr><th class="wishpot_option_left_part"><label for="wishpot_pub_pro_wdget_ga">Google Analytics Code: </label></th>' . "\n" .
  '                  <td><input type="checkbox" name="wishpot_pub_pro_widget_ga" value="open" ' . $checked . ' />' . __('Add Google Analytics Code to the widgets', 'wishpot-pub-pro') . '<br />' . "\n" .
  '                  ' . __('We use Google Analytics for statistical purpose and to improve our service.', 'wishpot-pub-pro') . '<br /><br />' . "\n" .
  '                  </td>' . "\n" .
  '              </tr>' . "\n" .
  '              </table>' . "\n" .
  '              <div class="submit">' . "\n" .
  '                <div class="div-wait" id="divwaitms0"><img src="' . WISPURL . 'img/loading.gif" /></div>' . "\n" .
  '                <input type="submit" class="button-secondary" value="Save Changes" id="wishpot_save_btn_above" name="wishpot_pub_pro_update_options_btn" onclick="document.getElementById(nameofDivWait).style.display=\'inline\';this.form.submit();" />' . "\n" .
  '              </div>' . "\n" .
  '            </div>' . "\n" .
  '          </div>' . "\n" .
  '          <div class="postbox ui-droppable" id="spinning-text-div">' . "\n" .
  '            <div title="' . __('Zum umschalten klicken', 'wishpot-pub-pro') . '" class="handlediv"><br /></div>' . "\n" .
  '            <h3 class="hndle">' . __('Product Pages', 'wishpot-pub-pro') . '</h3>' . "\n" .
  '            <div class="inside">' . "\n" .
  '              <p>' . "\n" .
  '                ' . __('Settings for the Product Pages.', 'wishpot-pub-pro') . "\n" .
  '              </p>' . "\n" .
  '              <table class="form-table">' . "\n" .
  '              <tr><th class="wishpot_option_left_part"><label for="">' . __('How many products should be displayed on one page', 'wishpot-pub-pro') . '</label></th>' . "\n" .
  '                  <td>' . "\n" .
  '                    <div class="margintb">' . "\n" .
  '                      <ul class="one-row"><li>' . "\n";

  foreach( $arr_pagesize as $key => $type )
  {
    if ( $key == $wishpot_pub_pro_pagesize )
      $checked = ' checked="checked" ';
    else
      $checked = ' ';
    echo '      <input type="radio" class="wishpot-radio" name="wishpot_pub_pro_pagesize" id="wishpot_pub_pro_pagesize_' . $key . '" value="' . $key . '"' . $checked . ' />' . "\n";
    echo '      <label for="wishpot_pub_pro_pagesize_' . $key . '">' . $type . '</label>' . "\n";
  }

  echo
  '                      </li></ul></div><br />' . "\n" .
  '                </td>' . "\n" .
  '              </tr>' . "\n";

/*

  if ( $wishpot_pub_pro_pp_fblike == 'on' )
    $checked = ' checked="checked" ';
  else
    $checked = ' ';

  echo
  '              <tr><th class="wishpot_option_left_part"><label for="wishpot_pub_pro_pp_fblike">Enable Facebook Like Button: </label></th>' . "\n" .
  '                  <td><input type="checkbox" name="wishpot_pub_pro_pp_fblike" value="open" ' . $checked . ' /></td>' . "\n" .
  '              </tr>' . "\n";

  if ( $wishpot_pub_pro_pp_fbshare == 'on' )
    $checked = ' checked="checked" ';
  else
    $checked = ' ';

  echo
  '              <tr><th class="wishpot_option_left_part"><label for="wishpot_pub_pro_pp_fbshare">Enable Facebook Share Button: </label></th>' . "\n" .
  '                  <td><input type="checkbox" name="wishpot_pub_pro_pp_fbshare" value="open" ' . $checked . ' /></td>' . "\n" .
  '              </tr>' . "\n";

  if ( $wishpot_pub_pro_pp_twshare == 'on' )
    $checked = ' checked="checked" ';
  else
    $checked = ' ';

  echo
  '              <tr><th class="wishpot_option_left_part"><label for="wishpot_pub_pro_pp_twshare">Enable Twitter Share Button: </label></th>' . "\n" .
  '                  <td><input type="checkbox" name="wishpot_pub_pro_pp_twshare" value="open" ' . $checked . ' /></td>' . "\n" .
  '              </tr>' . "\n" .

*/

  echo
  '              <tr><th class="wishpot_option_left_part"><label for=""></label></th>' . "\n" .
  '                  <td></td>' . "\n" .
  '              </tr>' . "\n" .
  '              </table>' . "\n" .
  '              <div class="submit">' . "\n" .
  '                <div class="div-wait" id="divwaitspt0"><img src="' . WISPURL . 'img/loading.gif" /></div>' . "\n" .
  '                <input type="submit" class="button-secondary" value="Save Changes" id="wishpot_pub_pro_save_btn_prod" name="wishpot_pub_pro_update_options_btn" onclick="document.getElementById(nameofDivWait).style.display=\'inline\';this.form.submit();" />' . "\n" .
  '                <div class="right-bottom"><a href="#Top">Back to Top</a></div>' . "\n" .
  '              </div>' . "\n" .
  '              <br /><hr /><br />' . "\n" .
  '              <table>' . "\n" .
  '              <tr>' . "\n" .
  '                  <td>' . "\n" .
  '                  To display product ads on one of your wordpress pages you can use the following shorttags:<br /><br />' . "\n" .
  '                  </td>' . "\n" .
  '              </tr>' . "\n" .
  '              <tr>' . "\n" .
  '                  <td></td>' . "\n" .
  '              </tr>' . "\n" .
  '              <tr>' . "\n" .
  '                <td>' . "\n" .
  '                  <table class="form-table">' . "\n" .
  '                  <tr><th class="wishpot_option_left_part"><label for="wishpot_pub_pro_pp_twshare">[wishpot_ads_product_page]</label></th>' . "\n" .
  '                    <td>Use this tag to start with a Wishpot Product Page</td>' . "\n" .
  '                  </tr>' . "\n" .
  '                  <tr><th class="wishpot_option_left_part"><label for="wishpot_pub_pro_pp_twshare">[wishpot_ads_category=xxx]</label></th>' . "\n" .
  '                    <td>Use this tag to get products from a category or from all categories like: [wishpot_ads_category=all] or [wishpot_ads_category=Video Games]</td>' . "\n" .
  '                  </tr>' . "\n" .
  '                  <tr><th class="wishpot_option_left_part"><label for="wishpot_pub_pro_pp_twshare">[wishpot_ads_keywords=xxx]</label></th>' . "\n" .
  '                    <td>Use this tag to get products with a specific term included like: [wishpot_ads_keywords=xbox]</td>' . "\n" .
  '                  </tr>' . "\n" .
  '                  <tr><th class="wishpot_option_left_part"><label for="wishpot_pub_pro_pp_twshare">[wishpot_ads_placement_id=xxx]</label></th>' . "\n" .
  '                    <td>Use this tag to get products for your placement id on wishpot.</td>' . "\n" .
  '                  </tr>' . "\n" .
  '                  <tr><th class="wishpot_option_left_part"><label for="wishpot_pub_pro_pp_twshare">[wishpot_ads_source=xxx]</label></th>' . "\n" .
  '                    <td>Use this tag to determine the source of the results on wishpot.</td>' . "\n" .
  '                  </tr>' . "\n" .
  '                  </table>' . "\n" .
  '                </td>' . "\n" .
  '              </tr>' . "\n" .
  '              <tr>' . "\n" .
  '                  <td><br /><hr /><br /></td>' . "\n" .
  '              </tr>' . "\n" .
  '              <tr>' . "\n" .
  '                  <td>' . "\n" .
  '                  <u><b>ATTENTION</b></u><br /><br />' . "\n" .
  '                  This plugin is creating a page to display search results from the widgets search.<br /><br />' . "\n" .
  '                  <b>Please take care that this page is excluded from your menu !!!</b><br /><br />' . "\n" .
  '                  </td>' . "\n" .
  '              </tr>' . "\n" .
  '              <tr>' . "\n" .
  '                  <td></td>' . "\n" .
  '              </tr>' . "\n" .
  '              </table>' . "\n" .
  '            </div>' . "\n" .
  '          </div>' . "\n" .
  '        </div>' . "\n" .
  '      </div>' . "\n" .
  '    </div>' . "\n" .
  '    <div class="postbox-container" id="plugin-news">' . "\n" .
  '      <div class="meta-box-sortables ui-sortable" id="side-sortables" unselectable="on">' . "\n" .
  '        <div class="postbox ui-droppable" id="wishpot_info">' . "\n" .
  '          <div title="' . __('Zum umschalten klicken', 'wishpot-pub-pro') . '" class="handlediv"><br /></div>' . "\n" .
  '          <h3 class="hndle">Wishpot</h3>' . "\n" .
  '          <div class="inside">' . "\n" .
  '            <ul>' . "\n" .
  '              <li><img class="img-link-ico" src="' . WISPURL . 'img/wishpot_favicon.ico" alt="Wishpot.com Logo" /><a class="link-extern" href="http://www.wishpot.com" target="_blank" title="Wishpot.com">Wishpot.com</a></li>' . "\n" .
  '            </ul>' . "\n";

/*
  '            <hr />' . "\n" .
  '            <h4>Infos</h4>' . "\n" .    
  '            <p>infos.</p>' . "\n" .
  '            <ul>' . "\n" .
  '              <li><img class="img-link-ico" src="' . WISPURL . 'img/wishpot_favicon.ico" alt="Wishpot.com Logo" /><a class="link-extern" href="http://www.wishpot.com" target="_blank" title="Wishpot.com">Wishpot.com</a></li>' . "\n" .
  '            </ul>' . "\n" .
  '            <hr />' . "\n" .
*/

  echo
  '          </div>' . "\n" .
  '        </div>' . "\n";

/*
  '        <div class="postbox ui-droppable" id="wishpot_links">' . "\n" .
  '          <div title="' . __('Zum umschalten klicken', 'wishpot-pub-pro') . '" class="handlediv"><br /></div>' . "\n" .
  '          <h3 class="hndle">Links</h3>' . "\n" .
  '          <div class="inside">' . "\n" .
  '            <ul>' . "\n" .
  '              <li><img class="img-link-ico" src="' . WISPURL . 'img/wishpot_favicon.ico" alt="Wishpot Logo" /><a class="link-extern" href="http://www.wordpress.org/plugins/wishpot-publisher-pro" target="_blank" title="Wishpot Wordpress Plugin">Wordpress Plugin Page</a></li>' . "\n" .
  '            </ul>' . "\n" .
  '          </div>' . "\n" .
  '        </div>' . "\n" .

*/

  echo
  '      </div>' . "\n" .
  '    </div>' . "\n" .
  '  </div>' . "\n" .
  '  </form>' . "\n" .
  '</div' . "\n";
 
}





?>