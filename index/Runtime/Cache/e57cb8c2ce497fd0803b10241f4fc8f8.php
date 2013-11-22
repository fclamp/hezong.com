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
        <div class="nav">
        	<div class=" nav_bar w_1000">
            	<ul class="nav_li">
                	
                	<li <?php if($is_index == 'yes'): ?>class="current"<?php endif; ?>><a href="/">首页</a></li>
					<?php if(is_array($ALLLinks['tLinks'])): $i = 0; $__LIST__ = $ALLLinks['tLinks'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li <?php if(($ACTION_NAME == $val['a'] and $MODULE_NAME == $val['m']) and ($_GET['id'] == $val['uri_id'] or $_GET['cateid'] == $val['uri_id'])): ?>class="current"<?php endif; ?> ><a href="<?php echo ($val['url']); ?>"><?php echo ($val['name']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
        </div>
    </div>


    <div class="main">
      <div id="slide" class="magic">
      	<img class="prev" src="__ROOT__/statics/myweb/images/back_03.png" />
        <img class="next" src="__ROOT__/statics/myweb/images/before_03.png" />
        <ul class="slide-photo">
        
        <?php if(is_array($indexInfo1['1'])): $i = 0; $__LIST__ = $indexInfo1['1'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li style="background:url('<?php echo ($val["img"]); ?>') center 0 no-repeat;"></li><?php endforeach; endif; else: echo "" ;endif; ?>

        </ul>
       
        <ul class="slide-info">
        
         <?php if(is_array($indexInfo1['1'])): $i = 0; $__LIST__ = $indexInfo1['1'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li>
           <h1><a href="<?php echo ($val["url"]); ?>"><?php echo ($val["title"]); ?></a></h1>
           <h3><?php echo ($val["title2"]); ?></h3>
         </li><?php endforeach; endif; else: echo "" ;endif; ?>

        </ul>
        
        <div class="slide-triggers">
        	<span class="triggers-wrap">
			        	
        	</span>
        </div>
      </div>
        <div class="wrap w_1000">
        <div class="col-left">
        	<div id="kg" class="box">
            <div class="hd"><span>企业概况</span></div>
            <div class="bd">
            	<img class="pic" alt="" src="<?php echo ($indexInfo1[2][0]['img']); ?>" />
                <p class="summary"><?php echo ($indexInfo1[2][0]['abst']); ?></p>
            </div>
          </div>
        </div>
        <div class="col-centent">
        	<div class="box">
            <div class="hd"><span>企业动态</span></div>
            <div class="bd">
            	<ul class="list-f14">
            	<?php if(is_array($indexInfo1['3'])): $i = 0; $__LIST__ = $indexInfo1['3'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li><a target="" href="<?php echo ($val["url"]); ?>"><?php echo ($val["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
          </div>
        </div>
		<div class="col-right">
        	<div class="box">
            <div class="hd"><span>工程案例</span></div>
            <div class="bd">
            	<ul class="list-photo">
            		<?php if(is_array($indexInfo1['4'])): $i = 0; $__LIST__ = $indexInfo1['4'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($val["url"]); ?>"><img alt="" width="150" height="90" src="<?php echo ($val["img"]); ?>"><span><?php echo ($val["title"]); ?></span></a></li><?php endforeach; endif; else: echo "" ;endif; ?>

            	</ul>
            </div>
          </div>
        </div>
        <i class="clear"></i>
       </div>
    </div>


<script type="text/javascript" src="__ROOT__/statics/myweb/js/jquery-1.4.2.js"></script>
<script type="text/javascript">

	function slide_player(slide_id,t){
		var n = 0;
		var O_slide = $("#" + slide_id);
		var O_list = O_slide.find(".slide-photo");
		var O_title = O_slide.find(".slide-info");
		var O_trigger = O_slide.find(".triggers-wrap");
		var btn_p = O_slide.find(".prev");
		var btn_n = O_slide.find(".next");
		var l = O_list.find("li").length;
		var html = '';
		for(var i = 1; i <= l; i++){
			if(i == 1){
				html += '<i class="current"></i>';
			}
			else{
				html += '<i></i>';
			}
		}
		O_trigger.html(html);	//渲染数字触发器
		
		O_slide.hover(function(){
			btn_p.show();
			btn_n.show();
			clearInterval(loopTime);
			},
			function(){
				btn_p.hide();
				btn_n.hide();
				loopTime = setInterval(function(){
					slidePlayer(n);
					n++;
					if(n == l){
						n = 0;
					}},t);
		});
		btn_p.click(function(){
			n--;
			if(n < 0){n = l - 1;}
			slidePlayer(n);
		});
		btn_n.click(function(){
			n++;
			if(n == l){n = 0;}		
			slidePlayer(n);
		});
		var loopTime = setInterval(function(){	//循环切换
			slidePlayer(n);
			n++;
			if(n == l){
				n = 0;
			}
		},t);

		O_trigger.find("i").click(function(){	//鼠标事件
			index = O_trigger.find("i").index(this);
			slidePlayer(n);
		});
		function slidePlayer(n){	//定义幻灯播放效果
			O_list.find("li")
			.eq(n).show()
			.siblings().hide();
			O_title.find("li")
			.eq(n).show()
			.siblings().hide();
			O_trigger.find("i")
			.eq(n).addClass("current")
			.siblings().removeClass("current");
		}
	}
	
	slide_player("slide",4000);
</script>


<div class="footer">
		<div class="linkers w_1000">
        	<p>
        	<?php if(is_array($ALLLinks['flinks'])): $i = 0; $__LIST__ = $ALLLinks['flinks'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><a href="<?php echo ($val['url']); ?>"><?php echo ($val['name']); ?></a><span>|</span><?php endforeach; endif; else: echo "" ;endif; ?>
        	</p>	
        </div>
    	<div class="bqs">
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
</div>
</body>
</html>