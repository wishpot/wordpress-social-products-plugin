jQuery(document).ready(function() {
  jQuery('#wishpot_pub_pro_search_input').click(function() {
    if (this.value == this.defaultValue) {
      this.value = '';
    }
  });
  jQuery('#wishpot_pub_pro_search_input').blur(function() {
    if (this.value == '') {
      this.value = this.defaultValue;
    }
  });
});


/*

Show Product Detail Page

called by Product Page and Widgets

*/
function wishpot_pub_pro_show_product_details(placement_id, item_num)
{
  var data = {
             action: 'wishpot_pub_pro_ajax_action',
             wishpot_call_type: 2,
             wishpot_placement_id: placement_id,
             wishpot_item_num: item_num
              };
  var wishpot_result;


  // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
  jQuery.ajaxSetup({ async: false });
  jQuery.post( ajaxurl, data, 
       function( return_data, response, xobj )
       {
         wishpot_result = xobj['responseText'];
         try
         {
           var result_obj = jQuery.parseJSON(wishpot_result);
         }
         catch (e)
         {
           start_pos = wishpot_result.indexOf('{');
           end_pos   = wishpot_result.lastIndexOf('}');
           var wishpot_result_string = wishpot_result.substring(start_pos, end_pos + 1);
           var result_obj = jQuery.parseJSON(wishpot_result_string);
         }

         wishpot_result_html     = result_obj.html;
       }
  );


  var w = window.open( '', 'newWin', 'width=600,height=550,resizable=yes,scrollbars=yes,status=yes,location=yes,toolbar=yes,menubar=yes');  
  w.document.write(wishpot_result_html);
  w.document.close();
  w.focus();

  return false;
}



function wishpot_pub_pro_widget_show_search_results(elem)
{
  var wishpot_search_item_input = elem;

  var wishpot_inputs = elem.childNodes;
  for ( var i=0; i < wishpot_inputs.length; i++ ) 
  {
    var single_input = wishpot_inputs[i];
    if ( single_input.tagName == 'INPUT' )
    {
      var input_name  = single_input.attributes['name'].nodeValue;
      try
      {
        var input_value = single_input.attributes['value'].nodeValue;
        if (input_value)
        {
          switch ( input_name )
          {
            case 'wishpot_placement_id':
              var placement_id  = single_input.attributes['value'].nodeValue;
              break;
            case 'wishpot_category':
              var category   = single_input.attributes['value'].nodeValue;
              break;
            case 'wishpot_keywords':
              var keywords = single_input.attributes['value'].nodeValue;
              break;
            case 'wishpot_widget_search':
              var search_text = single_input.attributes['value'].nodeValue;
              break;
          }
        }
      }
      catch(e)
      {
      }
    }
  }

  var data = {
             action: 'wishpot_pub_pro_ajax_action',
             wishpot_call_type: 1,
             wishpot_placement_id: placement_id,
             wishpot_category: category,
             wishpot_keywords: keywords,
             wishpot_widget_search: search_text
       };
  var wishpot_result_page_url;
  var wishpot_result_page_post_id;
  var wishpot_result;

  // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
  jQuery.ajaxSetup({ async: false });
  jQuery.post( ajaxurl, data, 
       function( return_data, response, xobj )
       {
         wishpot_result = xobj['responseText'];
         try
         {
           var result_obj = jQuery.parseJSON(wishpot_result);
         }
         catch (e)
         {
           start_pos = wishpot_result.indexOf('{');
           end_pos   = wishpot_result.lastIndexOf('}');
           var wishpot_result_string = wishpot_result.substring(start_pos, end_pos + 1);
           var result_obj = jQuery.parseJSON(wishpot_result_string);
         }

         wishpot_result_page_url     = result_obj.url;
         wishpot_result_page_post_id = result_obj.post_id;
       }
  );

  if ( wishpot_result_page_url )
  {
    var w = window.open( wishpot_result_page_url, 'newWin', 'width=800,height=600,resizable=yes,scrollbars=yes,status=yes,location=yes,toolbar=yes,menubar=yes');  
//    w.document.write(html);
    w.document.close();
    w.focus();
  }

  return;  
}
