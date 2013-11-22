<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link href="__ROOT__/statics/admin/css/style.css" rel="stylesheet" type="text/css"/>
<link href="__ROOT__/statics/css/dialog.css" rel="stylesheet" type="text/css" />

<script language="javascript" type="text/javascript" src="__ROOT__/statics/js/jquery/jquery-1.4.2.min.js"></script>
<script language="javascript" type="text/javascript" src="__ROOT__/statics/js/jquery/plugins/formvalidator.js"></script>
<script language="javascript" type="text/javascript" src="__ROOT__/statics/js/jquery/plugins/formvalidatorregex.js"></script>

<script language="javascript" type="text/javascript" src="__ROOT__/statics/admin/js/admin_common.js"></script>
<script language="javascript" type="text/javascript" src="__ROOT__/statics/js/dialog.js"></script>
<script language="javascript" type="text/javascript" src="__ROOT__/statics/js/iColorPicker.js"></script>

<script language="javascript">
var URL = '__URL__';
var ROOT_PATH = '__ROOT__';
var APP	 =	 '__APP__';
var lang_please_select = "<?php echo (L("please_select")); ?>";
var def=<?php echo ($def); ?>;
$(function($){
	$("#ajax_loading").ajaxStart(function(){
		$(this).show();
	}).ajaxSuccess(function(){
		$(this).hide();
	});
});

</script>
<title><?php echo (L("website_manage")); ?></title>
</head>
<body>
<div id="ajax_loading" style="width: 96%;text-align: center;">您的请求正在提交中，请稍候...</div>
<?php if($show_header != false):  if(($sub_menu != '') OR ($big_menu != '')): ?><div class="subnav">
    <div class="content-menu ib-a blue line-x">
    	<?php if(!empty($big_menu)): ?><a class="add fb" href="<?php echo ($big_menu["0"]); ?>"><em><?php echo ($big_menu["1"]); ?></em></a>　<?php endif; ?>
    </div>
</div><?php endif;  endif; ?>
<div class="pad-lr-10">
	<form name="searchform" action="" method="get" >
    <table width="100%" cellspacing="0" class="search-form">
        <tbody>
            <tr>
	            <td>
		            <div class="explain-col"> 
				                      操作时间：        
						<link rel="stylesheet" type="text/css" href="__ROOT__/statics/js/calendar/calendar-blue.css"/>
			<script type="text/javascript" src="__ROOT__/statics/js/calendar/calendar.js"></script>
		<input class="date input-text" type="text" name="s_time" id="s_time" size="18" value="<?php echo ($s_time); ?>" />	
					<script language="javascript" type="text/javascript">
	                    Calendar.setup({
	                        inputField     :    "s_time",
	                        ifFormat       :    "%Y-%m-%d",
	                        showsTime      :    "true",
	                        timeFormat     :    "24"
	                    });
	     </script>
		                -   
						
		<input class="date input-text" type="text" name="e_time" id="e_time" size="18" value="<?php echo ($e_time); ?>" />	
					<script language="javascript" type="text/javascript">
	                    Calendar.setup({
	                        inputField     :    "e_time",
	                        ifFormat       :    "%Y-%m-%d",
	                        showsTime      :    "true",
	                        timeFormat     :    "24"
	                    });
	     </script>
		            	<select name="search_type">
		            		<option value="uname" <?php if($search_type == 'uname'): ?>selected="selected"<?php endif; ?> >操作者</option>
		            		<option value="uid" <?php if($search_type == 'uid'): ?>selected="selected"<?php endif; ?> >操作者ID</option>
		            		<option value="msg" <?php if($search_type == 'msg'): ?>selected="selected"<?php endif; ?>>事件</option>
		            	</select> 
						&nbsp;关键字 :
		                <input name="keyword" type="text" class="input-text" size="25" value="<?php echo ($keyword); ?>" />
		                <input type="hidden" name="m" value="logs" />
		                <input type="submit" name="search" class="button" value="搜索" />
		        	</div>
	            </td>
            </tr>
        </tbody>
    </table>
    </form>	
   
    <div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
                <th width=50>ID</th>     
                <th width=60>操作者ID</th> 
				<th width=50>操作者</th> 
				<th>事件</th>              
				<th width=150>操作时间</th> 	
				<th width=80>IP地址</th>	
            </tr>
        </thead>
    	<tbody>
        <?php if(is_array($logs_list)): $k = 0; $__LIST__ = $logs_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($k % 2 );++$k;?><tr>
        	<td align="center"><?php echo ($val["id"]); ?></td>                     
            <td align="center"><?php echo ($val["uid"]); ?></td>
			<td align="center"><?php echo ($val["uname"]); ?></td>			
			<td align="center"><?php echo ($val["msg"]); ?></td>      		
			<td align="center"><?php echo (date("Y-m-d H:i:s",$val["add_time"])); ?></td>
			<td><?php echo ($val["ip"]); ?></td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    	</tbody>
    </table>
    <div class="btn">
		<div id="pages"><?php echo ($page); ?></div>
    </div>
    </div>

</div>
<script language="javascript">

</script>
</body>
</html>