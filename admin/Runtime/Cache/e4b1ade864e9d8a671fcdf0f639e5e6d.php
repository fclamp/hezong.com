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
<script type="text/javascript">		
$(function(){
	$("#add_attatch").click(function(){
	$("#attatch_tr").clone().prependTo($("#attatch_tr").parent());
	});
})
</script>

<form action="<?php echo u('index_data/add');?>" method="post" name="myform" id="myform"  enctype="multipart/form-data" style="margin-top:10px;">
  <div class="pad-10">
    <div class="col-tab">
      
      <div id="div_setting_1" class="contentList pad-10">
        <table width="100%" cellpadding="2" cellspacing="1" class="table_form">
          <tr>
            <th width="100">标题:</th>
            <td><input type="text" name="title" id="title" class="input-text" size="60"></td>
          </tr>

          <tr>
            <th width="100">副标题:</th>
            <td><input type="text" name="title2" id="title" class="input-text" size="60"></td>
          </tr>
          
          <tr>
            <th width="100">连接:</th>
            <td><input type="text" name="url" id="url" class="input-text" size="60">
            	<br>(格式：注意使用绝对URL，比如：http://www.chengdu.cn/)
            </td>
          </tr>          

          <tr>
            <th>内容区块:</th>
            <td>
            	<select name="catid">
            	 <?php if(is_array($cate_list)): $i = 0; $__LIST__ = $cate_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($val['name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
              
           </td>
          </tr>
          
          <tr>
            <th>内容类型:</th>
            <td>
            	<select name="type">
            	 <?php if(is_array($type_list)): $i = 0; $__LIST__ = $type_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($val); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
              
           </td>
          </tr>          
          

          <tr>
          	<th>图片 :</th>
            <td><input type="file" name="img" class="input-text"  style="width:200px;" />
     			(格式：<?php echo ($fileExts); ?>)
            </td>
          </tr>        
          
          
          <tr>
            <th>描述:</th>
            <td>
            	
            	<script type="text/javascript" src="__ROOT__/includes/kindeditor/kindeditor.js"></script><script type="text/javascript"> KE.show({ id : 'abst'  ,imageUploadJson:"",urlType : "",items:['source','cut','copy','paste','plainpaste','wordpaste','selectall','formatblock','fontname','fontsize','|','textcolor', 'bgcolor','bold','italic','underline','strikethrough','removeformat','emoticons','link','unlink']});</script><textarea id="abst" style="width:100%;height:180px;" name="abst" ></textarea>
            </td>
          </tr>        
          
          <tr>
            <th>排序 :</th>
            <td><input type="text" name="sort" class="input-text" size="8"></td>
          </tr>
     
          
         <tr>
            <th><?php echo L('status');?> :</th>
            <td><input type="radio" name="status" class="radio_style" value="0">
              &nbsp;草稿&nbsp;&nbsp;&nbsp;
              <input type="radio" name="status" class="radio_style" value="1" checked="checked">
              &nbsp;发布
              </td>
          </tr>
          
          
          
          
               
        </table>
      </div>
      
      <div class="btn"><input type="submit" value="<?php echo (L("submit")); ?>" onclick="return submitFrom();" name="dosubmit" class="button" id="dosubmit"></div>
    </div>
  </div>
</form>
</body></html>