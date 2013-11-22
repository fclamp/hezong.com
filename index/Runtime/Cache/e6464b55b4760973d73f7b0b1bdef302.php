<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title><?php echo ($SITEINFO['site_title']);  if($page_title): ?>-<?php echo ($page_title);  endif; ?></title>
<meta name="keywords" content="<?php echo ($SITEINFO['site_keyword']); ?>">
<meta name="description" content="<?php echo ($SITEINFO['site_description']); ?>">

<link type="text/css" rel="stylesheet" href="__ROOT__/statics/myweb/css/style.css">
</head>

<body>

	<div class="header">
    	<div class="w_1000 ">
       		<center><img class="logo" alt=""  src="__ROOT__/statics/myweb/images/logo.png"/></center>
        </div>	
    </div>



    <div class="main">
   		<div class="top_pic"></div>
        <div class="w_1000">

            <div class="lister">
            <div class="map"><a target="_blank" href="/">首页</a><?php echo ($show_page_uri); ?></div>
       	    <div class="detail_content summary">
                	<div class="hd">
                    	<h1>对不起，没有你想找的内容，3秒后进入页页！</h1>
                        
                    </div>
                    <div class="bd">
						
                    </div>
              </div>

            </div>
        </div>
    </div>
 	<div class="clear"></div>

<script language="javascript">
	setTimeout("window.location.href='/';",3*1000);
</script>


    <div class="footer2 ">
    	<div class="w_1000">
         <div class="bq">
         	<?php echo ($SITEINFO['site_bottominfo']); ?>
         </div>
         <div class="ewm">
         <span>关注我们:</span>
         <img alt="" src="__ROOT__/statics/myweb/images/foot_07.jpg" />
         </div>
        </div>
    </div>
    <!--footer_end-->

</body>
</html>