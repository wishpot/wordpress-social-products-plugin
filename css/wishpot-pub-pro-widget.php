<?php

global $wishpot_plugin_url;

require_once('../../../../wp-load.php');

header('Content-type: text/css');

?>

/********** Epik Widget  CSS **********/

* { margin:0; padding:0;}

#wishpot_pub_pro_widget_wrapper
{
  width:300px; 
  margin:0 auto;
  font-family: Arial, Helvetica, sans-serif;
}

#wishpot_pub_pro_widget_wrapper .wishpot_pub_pro_widget_search
{
  position:   relative;
  float:      left;
  display:    inline;
}

#wishpot_pub_pro_widget_wrapper .epik_widget{margin-top:50px;}
#wishpot_pub_pro_widget_wrapper .epik_widget{position:relative; background:#000;font-family:Arial, Helvetica, sans-serif;border:1px solid #000;background-position:285px 3px; background-repeat:no-repeat;}

#wishpot_pub_pro_widget_wrapper .epik_widget a{ text-decoration:none;}
#wishpot_pub_pro_widget_wrapper .epik_widget img{border:0;}
#wishpot_pub_pro_widget_wrapper .epik_widget .icon{position:absolute;right:2px;top:4px;}

#wishpot_pub_pro_widget_wrapper .widget160x600{width:158px;height:600px;position:relative;}
#wishpot_pub_pro_widget_wrapper .widget120x600{width:118px;height:600px;position:relative;}
#wishpot_pub_pro_widget_wrapper .widget300x250{width:298px;height:248px;}
#wishpot_pub_pro_widget_wrapper .widget300x600{width:298px;height:600px;}

#wishpot_pub_pro_widget_wrapper .epik_widget h2
{
  margin-left:2px;
  margin-bottom:3px;
  color:#fff;
  font-weight:normal;
  font-size:11px;
  margin-top:2px;
  width: auto;
}

#wishpot_pub_pro_widget_wrapper .widget300x250 form,
#wishpot_pub_pro_widget_wrapper .widget300x600 form
{
margin-top : -5px\9; /* IE8 and below */  
 *margin-top  : -5px; /* IE7 and below */  
}

#wishpot_pub_pro_widget_wrapper .widget300x250 input[type="text"],
#wishpot_pub_pro_widget_wrapper .widget300x600 input[type="text"]
{
  margin: 3px 0px 0px 3px;
line-height:11px;
  padding:0px;
font-size:11px;
float:left;
color:#999;
width:202px;
height:19px;
border:1px solid #64a4fa;
}

#wishpot_pub_pro_widget_wrapper .widget160x600 ul.product li,
#wishpot_pub_pro_widget_wrapper .widget120x600 ul.product li
{
}

#wishpot_pub_pro_widget_wrapper .widget160x600 ul.product li iframe
{
  margin:  5px 0px 5px 0px;
}

#wishpot_pub_pro_widget_wrapper .widget120x600 ul.product li iframe
{
  margin:  5px 0px 5px 10px;
}

#wishpot_pub_pro_widget_wrapper .widget300x250 ul.product li iframe,
#wishpot_pub_pro_widget_wrapper .widget300x600 ul.product li iframe
{
  float: right;
  margin: 0px 5px 0px 0px;
  padding: 0px;
}

#wishpot_pub_pro_widget_wrapper ul.product li img
{
  margin: 0px;
}

#wishpot_pub_pro_widget_wrapper .epik_widget ul.product
{	
  margin-top:5px;
  overflow:scroll !important;
  overflow-x:hidden !important;
  overflow-y:auto;
  list-style:none;
  float:left;
  position:relative;
  display:inline;
  max-width: 99%;
  padding: 0px;
}
.epik_widget ul.product li.no_border{background:none;}

.opera #wishpot_pub_pro_widget_wrapper .widget300x250 ul.product,
.ff3 #wishpot_pub_pro_widget_wrapper .widget300x250 ul.product,
.ff4 #wishpot_pub_pro_widget_wrapper .widget300x250 ul.product,
.safari #wishpot_pub_pro_widget_wrapper .widget300x250 ul.product,
.chrome #wishpot_pub_pro_widget_wrapper .widget300x250 ul.product
{
  height:  195px;
}

#wishpot_pub_pro_widget_wrapper .widget300x250 ul.product
{
margin-top: 5px;
  height:199px;
  background: url(<?php echo $wishpot_plugin_url; ?>img/widget/bg1.png);
position:relative;
display:inline;
float:left;
max-width: 99%;
width:99%;
margin-left:1px;
padding: 0px;
}

.opera #wishpot_pub_pro_widget_wrapper .widget300x600 ul.product,
.ff3 #wishpot_pub_pro_widget_wrapper .widget300x600 ul.product,
.ff4 #wishpot_pub_pro_widget_wrapper .widget300x600 ul.product,
.safari #wishpot_pub_pro_widget_wrapper .widget300x600 ul.product,
.chrome #wishpot_pub_pro_widget_wrapper .widget300x600 ul.product
{
  height: 545px;
}

#wishpot_pub_pro_widget_wrapper .widget300x600 ul.product
{
  height:549px;
  background: url(<?php echo $wishpot_plugin_url; ?>img/widget/bg2.png);
position:relative;
display:inline;
float:left;
max-width: 99%;
width:99%;
margin-left:1px;
padding: 0px;
}

#wishpot_pub_pro_widget_wrapper ul.product li ul.star-rating,
#wishpot_pub_pro_widget_wrapper ul.product li ul.star-rating li
{
  position:   relative;
  display:    inline;
  float:      left;
  clear:      none;
  width:      auto;
}

#wishpot_pub_pro_widget_wrapper ul.product li .widget_btn_buy
{
  float:         right;
  margin-right:  15px;
  margin-top:    5px;
}

#wishpot_pub_pro_widget_wrapper .epik_widget ul.product li
{
  padding: 10px 14px 5px 4px;
  height:  auto;
  float:   left;
  background:url(<?php echo $wishpot_plugin_url; ?>img/widget/border_v1.png);
  background-position:bottom center; 
  background-repeat:no-repeat;
  clear:   both;
  width:   100%;
}

#wishpot_pub_pro_widget_wrapper .widget300x600 ul.product li
{
  height:auto;
}

#wishpot_pub_pro_widget_wrapper .widget300x250 ul.product .thumb img,
#wishpot_pub_pro_widget_wrapper .widget300x600 ul.product .thumb img
{
  width:49px;
  height:49px;
}

#wishpot_pub_pro_widget_wrapper .widget160x600 ul.product .thumb img,
#wishpot_pub_pro_widget_wrapper .widget120x600 ul.product .thumb img
{
  max-width: 135px;
  width:     95%;
  max-height:135px;
  margin-right: 5px;
}


#wishpot_pub_pro_widget_wrapper .widget300x250 ul.product .thumb
{
  width:49px;
  height:49px;
  float:left;
  border:1px solid #ccc;
  margin-right:6px;
}
#wishpot_pub_pro_widget_wrapper .widget300x600 ul.product .thumb
{
  width:49px;
  height:49px;
  float:left;
  border:1px solid #ccc;
  margin-right:6px;
  margin-bottom: 10px;
}

#wishpot_pub_pro_widget_wrapper .epik_widget ul.product li p
{
  color:#666;
  font-size:11px;
  margin:   0px 0px 5px 0px;
}
#wishpot_pub_pro_widget_wrapper .epik_widget ul.product li p a{color:#09f;}
#wishpot_pub_pro_widget_wrapper .widget300x250 ul.product li h3,
#wishpot_pub_pro_widget_wrapper .widget300x600 ul.product li h3
{
  float:left;
  font-size:14px; 
  color:#999;
  clear:both;
  margin: 0px;
}
#wishpot_pub_pro_widget_wrapper .widget300x250 ul.product li h3 span,
#wishpot_pub_pro_widget_wrapper .widget300x600 ul.product li h3 span
{
color:#009900
}


#wishpot_pub_pro_widget_wrapper .epik_widget ul.product li ul{margin-bottom:5px;list-style:none;height:15px;}
#wishpot_pub_pro_widget_wrapper .epik_widget ul.product li ul li{float:left;margin-right:5px;padding:0;height:10px;}
#wishpot_pub_pro_widget_wrapper .epik_widget ul.product li ul li img
{
  margin: 0px;
  padding:0px;
}

#wishpot_pub_pro_widget_wrapper .epik_widget ul.product li h4{font-size:20px;font-weight:normal;color:#999;}
#wishpot_pub_pro_widget_wrapper .epik_widget ul.product li center{padding-top:5px;}
#wishpot_pub_pro_widget_wrapper .epik_widget ul.product li center p{font-size:14px;}



/*** 160 **/
#wishpot_pub_pro_widget_wrapper .widget160x600  ul.product
{
  background:url(<?php echo $wishpot_plugin_url; ?>img/widget/bg2.png);
  height:549px;
  float:left;
position:relative;
display:inline;
max-width: 99%;
width:99%;
text-align:center;
}
#wishpot_pub_pro_widget_wrapper .widget160x600  ul.product li
{
  background:url(<?php echo $wishpot_plugin_url; ?>img/widget/border_v2.png);
  background-position:bottom center; 
  background-repeat:no-repeat;
  padding-left:4px;
  height:auto;
  padding-right:5px;
  padding-top:5px;
  padding-bottom:30px;
  margin:     10px 0px 5px 0px;
}
#wishpot_pub_pro_widget_wrapper .widget160x600 h2
{
  line-height:15px;
  font-style: none;
  clear:      none;

}

#wishpot_pub_pro_widget_wrapper .widget160x600 ul.product .thumb
{
  width:135px;
  height:135px;
}

#wishpot_pub_pro_widget_wrapper .widget160x600 input[type="text"]
{
  margin: 2px 0px 2px 2px;
  float:left;
  padding:0px;
  line-height:11px;
  font-size:11px;
  color:#999;
  width:150px;
  height:20px;
  border:1px solid #64a4fa;
}
#wishpot_pub_pro_widget_wrapper .widget160x600 ul.product li h3
{
  float:    left;
  font-size:11px; 
  color:#999;
  clear:none;
  margin: 5px auto 5px 20px;
  text-align: center;
}
#wishpot_pub_pro_widget_wrapper .widget160x600 ul.product li p
{
  color:#666;
  font-size:11px;
  margin:10px 8px 0px 0px;
  display:inline-block;
  height:72px;
}
#wishpot_pub_pro_widget_wrapper .widget160x600 ul.product li h3 span{color:#009900}
#wishpot_pub_pro_widget_wrapper .widget160x600 ul.product li ul 
{
  margin-left:30px;
  margin-bottom:8px;
  padding: 0px;
}
#wishpot_pub_pro_widget_wrapper .widget160x600  .widget_btn_search
{
position:absolute;
	text-indent:-9999px;
	display:inline-block;
height:15px;
width:16px;
background:url(<?php echo $wishpot_plugin_url; ?>img/widget/search.gif);
right:5px;
top:26px;
border:none;	
}

#wishpot_pub_pro_widget_wrapper .widget160x600 ul.product li .widget_btn_buy
{
  margin:  2px 0px 5px 20px;
  float:left;
  text-align: center;
  line-height:14px;
  height:14px;
  font-size:11px; 
  color:#09f;
  font-weight:bold;
  text-align:center;
  border:1px solid #ccc;
  width:54px;
  background:url(<?php echo $wishpot_plugin_url; ?>/img/widget/button.png);
  padding-left:2px;
  padding-right:2px;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
  clear: both;
}



/*** 120 ***/

#wishpot_pub_pro_widget_wrapper .widget120x600  ul.product
{
float:left;
height:545px;
background:url(<?php echo $wishpot_plugin_url; ?>/img/widget/bg2.png);
text-align:center;
max-width: 99%;
width:99%;
padding: 0px;
}
#wishpot_pub_pro_widget_wrapper .widget120x600  ul.product li
{
float: left;
padding-left:4px;
height:auto;
background:url(<?php echo $wishpot_plugin_url; ?>/img/widget/border_v2.png);
background-position:bottom center; 
background-repeat:no-repeat;
padding-right:5px;
padding-top:5px;
padding-bottom:30px;
}
#wishpot_pub_pro_widget_wrapper .widget120x600  h2{line-height:15px;}
#wishpot_pub_pro_widget_wrapper .widget120x600 ul.product .thumb
{
  width:135px;
  height:135px;
}
#wishpot_pub_pro_widget_wrapper .widget120x600 input[type="text"]
{
  margin:   2px 0px 2px 2px;
  float:left;
  padding:0px;
line-height:11px;
font-size:11px;
color:#999;
width:110px;
height:20px;
border:1px solid #64a4fa;
}
#wishpot_pub_pro_widget_wrapper .widget120x600 ul.product li h3
{
font-size:11px; 
color:#999;
  margin: 0px;
  text-align: center;
}
#wishpot_pub_pro_widget_wrapper .widget120x600 ul.product li p
{
  color:#666;
  font-size:11px;
  margin-top:10px;
  margin-right:8px;
  display:inline-block;
  height:92px;
}
#wishpot_pub_pro_widget_wrapper .widget120x600 ul.product li h3 span{color:#009900}
#wishpot_pub_pro_widget_wrapper .widget120x600 ul.product li ul
{
margin-left:10px;
  padding: 0px;
}



#wishpot_pub_pro_widget_wrapper .widget120x600  .widget_btn_search
{
position:absolute;
	text-indent:-9999px;
	display:inline-block;
height:15px;
width:16px;
background:url(<?php echo $wishpot_plugin_url; ?>img/widget/search.gif);
right:5px;
top:26px;
border:none;	

padding: 0px 0px 0px 0px;
margin-left: -22px;

}

#wishpot_pub_pro_widget_wrapper .widget120x600 .widget_btn_buy{line-height:14px;height:14px;font-size:11px; color:#09f;font-weight:bold;
text-align:center;border:1px solid #ccc;width:54px;background:url(<?php echo $wishpot_plugin_url; ?>/img/widget/button.png);padding-left:2px;padding-right:2px;-webkit-border-radius: 3px;
-moz-border-radius: 3px;
border-radius: 3px;}




#wishpot_pub_pro_widget_wrapper .widget300x250 .widget_btn_buy,
#wishpot_pub_pro_widget_wrapper .widget300x600 .widget_btn_buy
{
  float:right;
  line-height:14px;
height:14px;
font-size:11px; 
color:#09f;
font-weight:bold;
text-align:center;
border:1px solid #ccc;
width:54px;
background:url(<?php echo $wishpot_plugin_url; ?>/img/widget/button.png);
padding-left:2px;
padding-right:2px;
-webkit-border-radius: 3px;
-moz-border-radius: 3px;
border-radius: 3px;
}


.opera #wishpot_pub_pro_widget_wrapper .widget300x250 .widget_btn_search,
.opera #wishpot_pub_pro_widget_wrapper .widget300x600 .widget_btn_search,
.safari #wishpot_pub_pro_widget_wrapper .widget300x250 .widget_btn_search,
.safari #wishpot_pub_pro_widget_wrapper .widget300x600 .widget_btn_search,
.ff3 #wishpot_pub_pro_widget_wrapper .widget300x250 .widget_btn_search,
.ff3 #wishpot_pub_pro_widget_wrapper .widget300x600 .widget_btn_search,
.ff4 #wishpot_pub_pro_widget_wrapper .widget300x250 .widget_btn_search,
.ff4 #wishpot_pub_pro_widget_wrapper .widget300x600 .widget_btn_search,
.chrome #wishpot_pub_pro_widget_wrapper .widget300x250 .widget_btn_search,
.chrome #wishpot_pub_pro_widget_wrapper .widget300x600 .widget_btn_search
{
  top: 27px;
}

#wishpot_pub_pro_widget_wrapper .widget300x250 .widget_btn_search,
#wishpot_pub_pro_widget_wrapper .widget300x600 .widget_btn_search
{
position:absolute;
text-indent:-9999px;
display:inline-block;
height:15px;
width:16px;
top:22px;
right:5px;
background: transparent url(<?php echo $wishpot_plugin_url; ?>img/widget/search.gif) no-repeat;
border: none;	
padding: 0px 0px 0px 0px;
margin-left: -22px;
}

