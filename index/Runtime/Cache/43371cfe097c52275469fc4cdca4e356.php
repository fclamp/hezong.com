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
        	<div class="sider_nav">
            	<ul class="sider_bar">

                	<li <?php if($is_index == 'yes'): ?>class="current"<?php endif; ?>><a href="/">首页</a></li>
                	
					<?php if(is_array($ALLLinks['tLinks'])): $i = 0; $__LIST__ = $ALLLinks['tLinks'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li <?php if($info['catid'] == $val['uri_id']): ?>class="current"<?php endif; ?> ><a href="<?php echo ($val['url']); ?>"><?php echo ($val['name']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>

                </ul>
            </div>
            <div class="lister">
            <div class="map"><a target="_blank" href="/">首页</a><?php echo ($show_page_uri); ?></div>
       	    <div class="detail_content summary">
                	<div class="hd">
                    	<h1><?php echo ($info["title"]); ?></h1>
                        <p>来源：<?php echo ($info["from"]); ?>&nbsp;&nbsp;时间：<?php echo ($info["push_time"]); ?></p>
                    </div>
                    <div class="bd">
						<?php echo ($info["info"]); ?>
                    </div>
              </div>
       	    <div class="others">
       	    	<?php if($more['down']): ?><em>下一篇：<a target="" href="/?a=showPage&m=index&id=<?php echo ($more['down']['id']); ?>"><?php echo ($more['down']['title']); ?></a></em><?php endif; ?>
				<?php if($more['up']): ?><span>上一篇：<a target="" href="/?a=showPage&m=index&id=<?php echo ($more['up']['id']); ?>"><?php echo ($more['up']['title']); ?></a></span><?php endif; ?>
            </div>
            </div>
        </div>
    </div>
 	<div class="clear"></div>



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