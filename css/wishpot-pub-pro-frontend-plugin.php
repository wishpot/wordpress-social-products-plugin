<?php

global $wishpot_plugin_url;

require_once('../../../../wp-load.php');

header('Content-type: text/css');

?>


.wishpot_pub_pro_clear_floats
{
  clear:         both;
}


#wishpot_pub_pro_products_page_wrapper
{
  position:      relative;
  display:       inline;
  float:         right;
  width:         100%;
  clear:         both;
  margin:        20px 0px 10px 0px;
}

#wishpot_pub_pro_products_page_wrapper a
{
  color:         blue;
  text-decoration: none;
}

.wishpot_product_page_list_sidebar
{
  position:      relative;
  display:       inline;
  float:         left;
  width:         120px;
}

.wishpot_product_page_list_sidebar h4
{
  margin:        0px 0px 15px 0px;
}

.wishpot_pub_pro_page_list_sidebar_prices
{
  position:      relative;
  display:       block;
  float:         left;
}

.wishpot_pub_pro_page_list_sidebar_prices .input_item_list_prices,
.wishpot_pub_pro_page_list_sidebar_brands .input_item_list_brands
{
  border:        none;
  margin:        0px 0px 3px 0px;
  padding:       0px;
  color:         blue;
  cursor:        pointer;
  background-color: transparent;
}

.wishpot_pub_pro_page_list_sidebar_brands
{
  position:      relative;
  display:       block;
  float:         left;
  clear:         both;
  margin:        25px 0px 0px 0px;
}

.wishpot_product_page_list
{
  display:       inline;
  float:         right;
}

.wishpot_pub_pro_product_items_row
{
  display:       inline;
  float:         left;
  clear:         both;
  margin:        0px 0px 20px 0px;
  padding:       0px 0px 10px 0px;
}

.wishput_pub_pro_product_item_wrapper
{
  position:      relative;
  display:       inline;
  float:         left;
  min-width:     160px;
  margin:        0px 5px 0px 0px;
}

.wishpot_pub_pro_product_item_img
{
  display:       inline;
  float:         left;
  width:         160px;
  height:        160px;
  margin:        0px;
  padding:       0px;
  text-align:    center;
}

.wishpot_pub_pro_product_item_img img
{
  margin:        0px auto;
  text-align:    center;
}

.wishpot_pub_pro_product_title
{
  display:       block;
  text-align:    center;
  clear:         both;
  width:         160px;
  height:        45px;
  font-size:     11px;
}

.wishpot_pub_pro_product_price
{
  display:       block;
  text-align:    center;
  clear:         both;
  font-weight:   bold;
  line-height:   1.5em;
  margin:        5px 0px;
}

.wishpot_pub_pro_product_buttons
{
  display:       inline;
  float:         left;
  clear:         both;
  width:         145px;
  margin:        5px auto 0px auto;
  padding:       0px 0px 0px 15px;
}


.wishpot_pub_pro_product_items_row .wishpot_pub_pro_product_buttons img
{
  border:        none;
  margin:        10px 0px 0px 0px;
}


.wishpot_pub_pro_product_page_footer a
{
  color:         blue;
}

.wishpot_pub_pro_product_page_footer
{
  position:      relative;
  float:         left;
  display:       block;
  clear:         both;
  width:         100%;
  height:        70px;
}

.wishpot_pub_pro_product_page_footer_link
{
  position:      relative;
  float:         left;
  display:       inline;
  margin:        30px 0px 0px;
}

.wishpot_pub_pro_product_page_footer_nav
{
  position:      relative;
  float:         right;
  display:       inline;
  margin:        30px 20px 0px 0px;
  text-align:    left;
  color:         #ff8533;
  vertical-align:baseline;
}

.wishpot_pub_pro_product_page_footer .form_item_list_page
{
  position: relative;
  display: inline;
  float: left;
  font-weight:  600;
  
}

.wishpot_pub_pro_product_page_footer .input_item_list_page
{
  border: none;
  background-image: none;
  background-color: transparent;
  color:  blue;
  padding: 2px 2px 0px 2px;
  margin:  0px 1px;
  text-weight: bold;
  position: relative;
  display: inline;
  float: left;
  z-index: 5;
}

.wishpot_pub_pro_product_page_footer .input_item_list_page:hover,
.wishpot_pub_pro_product_page_footer .input_item_list_page_first:hover,
.wishpot_pub_pro_product_page_footer .input_item_list_page_prev:hover,
.wishpot_pub_pro_product_page_footer .input_item_list_page_next:hover,
.wishpot_pub_pro_product_page_footer .input_item_list_page_last:hover
{
  cursor:  pointer;
}

.wishpot_pub_pro_product_page_footer .active
{
  background-color: #f0f3ff;
}

.wishpot_pub_pro_product_page_footer .nonactive
{
  background-color: transparent;
}

.wishpot_pub_pro_product_page_footer .input_item_list_page_first
{
  border: none;
  background-image: url(<?php echo $wishpot_plugin_url . 'img/page_first.png' ?>);
  background-color: transparent;
  background-repeat: no-repeat;
  color:  red;
  padding: 0px 0px 0px 0px;
  margin:  5px 2px 0px 0px;
  text-weight: bold;
  position: relative;
  display: inline;
  float: left;
  vertical-align: bottom;
  width: 10px;
  height: 10px;
}

.wishpot_pub_pro_product_page_footer .input_item_list_page_prev
{
  border: none;
  background-image: url(<?php echo $wishpot_plugin_url . 'img/left-pointer.png' ?>);
  background-color: transparent;
  background-repeat: no-repeat;
  color:  red;
  padding: 0px 4px 0px 0px;
  margin:  5px 2px 0px 0px;
  text-weight: bold;
  position: relative;
  display: inline;
  float: left;
  vertical-align: bottom;
  width: 10px;
  height: 10px;
}

.wishpot_pub_pro_product_page_footer .input_item_list_page_next
{
  border: none;
  background-image: url(<?php echo $wishpot_plugin_url . 'img/right-pointer.png' ?>);
  background-color: transparent;
  background-repeat: no-repeat;
  color:  red;
  padding: 0px 0px 0px 4px;
  margin:  5px 0px 0px 2px;
  text-weight: bold;
  position: relative;
  display: inline;
  float: left;
  width: 10px;
  height: 10px;
}

.wishpot_pub_pro_product_page_footer .input_item_list_page_last
{
  border: none;
  background-image: url(<?php echo $wishpot_plugin_url . 'img/page_last.png' ?>);
  background-color: transparent;
  background-repeat: no-repeat;
  color:  red;
  padding: 0px 0px 0px 0px;
  margin:  5px 0px 0px 2px;
  text-weight: bold;
  position: relative;
  display: inline;
  float: left;
  width: 10px;
  height: 10px;
}


.wishpot_pub_pro_product_page_header
{
  position:      relative;
  display:       inline;
  height:        70px;
  float:         left;
  width:         100%;
  margin:        0px 0px 10px 0px;
}

.wishpot_pub_pro_category
{
  position:      relative;
  display:       inline;
  float:         left;
}

.wishpot_pub_pro_search
{
  position:      relative;
  display:       inline;
  float:         right;
  margin:        10px 0px 0px 0px;
}

input#wishpot_pub_pro_item_list_search
{
  background:    none transparent scroll repeat 0% 0%;
  height:        26px;
  margin:        0px;
}

input.input_item_list_search
{
  margin:        0px 0px 0px 0px;
  padding:       0px;
  background:    url(<?php echo $wishpot_plugin_url . 'img/search-icon.png' ?>);
  border:        none;
  width:         16px;
  height:        16px;  
  vertical-align:middle;
}


/*
product detail page 
*/

#wishpot_pub_pro_products_detail_page_wrapper
{
  position:      relative;
  display:       inline;
  float:         left;
  width:         100%;
  height:        auto;
  clear:         both;
  margin:        0px;
  padding:       5px;
  font-family:   Arial, Helvetica, sans-serif;
  background:    url(<?php echo $wishpot_plugin_url . 'img/widget/bg3.png' ?>);
}

.wishpot_product_detail_product_page_item
{
  position:      relative;
  display:       inline;
  float:         left;
  width:         100%;
}

.wishpot_pub_pro_detail_product_item_img
{
  position:      relative;
  display:       inline;
  float:         left;
  width:         160px;
  height:        160px;
  margin:        0px 20px 10px 0px;
}

.wishpot_pub_pro_detail_product_item_img a
{
}

.wishpot_pub_pro_detail_product_item_img img
{
  border:        none;
}

.wishpot_pub_pro_detail_product_title
{
  position:      relative;
  display:       inline;
  float:         left;
}

.wishpot_pub_pro_detail_product_brand
{
  position:      relative;
  display:       block;
  float:         left;
  margin:        10px 0px 5px 0px;
}

.wishpot_pub_pro_detail_product_price
{
  position:      relative;
  display:       block;
  float:         left;
  margin:        10px 0px 5px 0px;
}

.wishpot_pub_pro_product_details_page_header
{
  height:        auto;
}

.wishpot_pub_pro_detail_product_description
{
  position:      relative;
  display:       block;
  float:         left;
  margin:        15px 0px 5px 0px;
  clear:         both;
  width:         100%;
}

.wishpot_pub_pro_detail_product_offers
{
  position:      relative;
  display:       block;
  float:         left;
  margin:        15px 0px 5px 0px;
  padding:       10px 0px;
  clear:         both;
  width:         100%;
  font-size:     16px;
}

.wishpot_pub_pro_detail_product_offer
{
  position:      relative;
  display:       block;
  float:         left;
  margin:        5px 0px 5px 0px;
  padding:       10px 0px;
  clear:         both;
  width:         100%;
  font-size:     12px;
}

.wishpot_pub_pro_detail_product_offer img
{
  position:      relative;
  display:       inline;
  float:         left;
}


.wishpot_pub_pro_detail_product_offers_price
{
  position:      relative;
  display:       inline;
  float:         left;
  margin:        0px 0px 0px 10px;
}

.wishpot_pub_pro_detail_product_offers_buttons
{
  position:      relative;
  display:       inline;
  float:         left;
  clear:         both;
}

.wishpot_pub_pro_product_buttons img,
.wishpot_pub_pro_detail_product_offers_buttons img
{
  border:        none;
  margin:        10px 10px 10px 0px;
}
