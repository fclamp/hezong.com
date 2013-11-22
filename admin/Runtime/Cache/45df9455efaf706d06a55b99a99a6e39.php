<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<div class="pad_10">
<form action="<?php echo u('category/add');?>" method="post" name="myform" id="myform">
<table width="100%" cellpadding="2" cellspacing="1" class="table_form">

	<tr> 
      <th width="80">父级栏目:</th>
      <td>
            <select name="pid" style="width:150px;">
                  <option value="0">--顶级分类--</option>
                   <?php echo tree_select_option($cate_list,'');?>

            </select>      	
      </td>
    </tr>


	<tr> 
      <th width="80">栏目名称 :</th>
      <td><input type="text" name="name" id="name" class="input-text"></td>
    </tr>       
    
 	<tr> 
      <th width="80">栏目类型：</th>
      <td>
            <select name="type" style="width:150px;">
                 <?php if(is_array($cate_type)): $i = 0; $__LIST__ = $cate_type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($val); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>     
            </select>      	
      </td>
    </tr>   
    
    
    
    <tr>
      <th>排序  :</th>
      <td><input type="text" name="sort" id="sort" class="input-text"></td>
    </tr>    
    
    <tr>
      <th>状态 :</th>
      <td>
      	<input type="radio" name="status" class="radio_style" value="1" checked="checked" > &nbsp;有效&nbsp;&nbsp;&nbsp;
        <input type="radio" name="status" class="radio_style" value="0"> &nbsp;禁用
      </td>
    </tr>
</table>
<input type="submit" name="dosubmit" id="dosubmit" class="dialog" value=" ">
</form>
<script type="text/javascript">
	$(function(){
		$.formValidator.initConfig({
			formid:"myform",
			autotip:true,
			onerror:function(msg,obj){
				window.top.art.dialog({
					content:msg,
					lock:true,
					width:'200',
					height:'50'},
					 function()
					 {
					 	this.close();
						$(obj).focus();
					 })
		}});		
		
		$("#name").formValidator({
			onshow:"不能为空",onfocus:"不能为空"
		}).inputValidator({
			min:1,onerror:"请填写分类名称"
		});

	
	})
</script>
</div>
</body>
</html>