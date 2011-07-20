<?php

global $wishpot_plugin_url;

require_once('../../../../wp-load.php');

header('Content-type: text/css');

?>

#plugin-main
{
  width:  69%;
}

#plugin-news
{
  width:  29%;
}

.label-hb
{
  position:  relative;
  min-width: 5em;
  display:   inline;
  float:     left;
}

.meta-box-sortables
{
  margin: 0px 5px;
}

.margintb
{
  margin: 5px 0 5px 0;
}

.right-bottom
{
  float:  right;
}

.right-bottom a
{
  text-decoration: none;
}

.postbox .inside
{
  position:  relative;
  margin:    10px;
}

#plugin-main .postbox .inside .submit
{
  margin:  5px 0px 0px 0px;
  padding: 0px;
  float:   none;
}

#wishpot_host_blog_select
{
  min-width:     10em;
}

.one-row
{
  position:  relative;
  display:   inline;
  float:     left;
}

.clear
{
  clear:     both;
}

.float-left
{
  position: relative;
  float:  left;
}

.float-right
{
  position: relative;
  float:  right;
}

.link-extern
{
  text-decoration: none;
}

<?php

echo
'
.icon32
{
  background: transparent url(' . $wishpot_plugin_url . 'img/wishpot_favicon_32x32.ico) no-repeat top left;
}

#wishpot-settings .inside
{
  background: transparent url(' . $wishpot_plugin_url . 'img/wishpot_favicon_32x32.ico) no-repeat right bottom;
}
';

?>

.wishpot_widget_option_left_part
{
  width:        25%;
  vAlign:       top;
  padding-top:  10px;
  font-weight:  bold;
  font-size:    12px;
  text-align:   left;
}

.wishpot_widget_option_middle_part
{
  width:        50%;
  vAlign:       top;
  font-weight:  normal;
  font-size:    12px;
  text-align:   right;
}

.wishpot_widget_option_right_part
{
  width:        25%;
  vAlign:       top;
  padding-top:  10px;
  font-weight:  thin;
  font-size:    0.75em;
  text-align:   right;
}

.wishpot_widget_option_one_row
{
  width:        100%;
  vAlign:       top;
  padding-top:  10px;
  font-weight:  normal;
  font-size:    10px;
  text-align:   left;
  float:        left;
  display:      inline;
}

.wishpot_option_left_part
{
  width:        40%;
  vAlign:       top;
  padding-top:  10px;
  font-weight:  bold;
  font-size:    12px;
}

.div-wait
{
  display: none;
  padding: 0px;
  margin:  0px;
}

.div-wait img
{
  height: 25px; 
  width: 25px;
  margin-bottom:-8px;
}

.img-link-ico
{
  margin-right:  5px;
}

select#wishpot_import_cats_select_tag
{
  height: auto;
}

.ds_box 
{
	background-color: #FFF;
	border: 2px solid #336699;    
	position: absolute;
	z-index: 32767;
        width:300px;
		/*height:180px;*/
        padding-left:10px;
        padding-right:10px;
        padding-bottom:10px;
        font-size:12px;
        font-family: arial;
}


.settingsForm
{
  width:400px;
  display:block;
}

.settingsForm hr
{
  color:#F1F1F1;
}

.settingsForm h2
{
  font-weight: normal;
}

.settingsForm table
{
  width:100%;
  border:0;
}

/*.settingsForm table td{
     padding: 6px;
}*/

.form_element_caption
{
  padding-top:12px;
  font-weight:bold;
  font-size:12px;
  width:100%;
}

.settingsForm textarea
{
  width:100%;
}

.settingsForm .rb
{
  margin:0px 10px 0px 10px;
}

.settingsForm .frb
{
  margin:0px 10px 0px 0px;
}



    

    

