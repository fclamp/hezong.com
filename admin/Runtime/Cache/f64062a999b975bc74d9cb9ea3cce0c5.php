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
<form id="myform" name="myform" action="<?php echo u('setting/edit');?>" enctype="multipart/form-data" method="post">
  <div class="pad-10">
    <div class="col-tab">
      <ul class="tabBut cu-li">
        <li id="tab_setting_1" class="on" onclick="SwapTab('setting','on','',3,1);">网站信息</li>
      </ul>
      
      <div id="div_setting_1" class="contentList pad-10">
          <table width="100%" cellpadding="2" cellspacing="1" class="table_form">
            <tr>
              <th width="120"><?php echo L('site_name');?> :</th>
              <td><input type="text" name="site[site_name]" size="80" value="<?php echo ($set["site_name"]); ?>"></td>
            </tr>
            <tr>
              <th width="120"><?php echo L('site_domain');?> :</th>
              <td><input type="text" name="site[site_domain]" size="80" value="<?php echo ($set["site_domain"]); ?>"></td>
            </tr>    
            <tr>
              <th width="120"><?php echo L('site_title');?> :</th>
              <td><input type="text" name="site[site_title]" size="80" value="<?php echo ($set["site_title"]); ?>"></td>
            </tr> 

            <tr>
              <th width="120"><?php echo L('site_keyword');?> :</th>
              <td><input type="text" name="site[site_keyword]" size="80" value="<?php echo ($set["site_keyword"]); ?>"></td>
            </tr>
            
            <tr>
              <th width="120"><?php echo L('site_description');?> :</th>
              <td><input type="text" name="site[site_description]" size="80" value="<?php echo ($set["site_description"]); ?>"></td>
            </tr>

			<tr>
              <th width="120">网站右下脚信息 :</th>
              <td>
              	<textarea name="site[site_rightinfo]" style="width: 550px; height: 50px;"><?php echo ($set["site_rightinfo"]); ?></textarea>
              	<span style="color:red;">一行存一条信息</span>
              </td>
            </tr>             

			<tr>
              <th width="120">网站脚底信息 :</th>
              <td>
              	<textarea name="site[site_bottominfo]" style="width: 550px; height: 50px;"><?php echo ($set["site_bottominfo"]); ?></textarea>
              	<span style="color:red;">一行存一条信息</span>
              </td>
            </tr> 

			<tr>
              <th width="120"><?php echo L('check_code');?> :</th>
              <td>
                <input type="radio" <?php if($set["check_code"] == '1'): ?>checked="checked"<?php endif; ?> onclick="" value="1" name="site[check_code]" /> 开启 &nbsp;&nbsp;
                <input type="radio" <?php if($set["check_code"] == '0'): ?>checked="checked"<?php endif; ?> onclick="" value="0" name="site[check_code]" /> 关闭 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;				
              </td>
            </tr>
					
        </table>
      </div>
  
        
      <div class="bk15"></div>

      <div class="btn"><input type="submit" value="<?php echo (L("submit")); ?>" onclick="return submitFrom();" name="dosubmit" class="button" id="dosubmit"></div>

    </div>

  </div>

</form>

<script type="text/javascript">
function SwapTab(name,cls_show,cls_hide,cnt,cur){
    for(i=1;i<=cnt;i++){
		if(i==cur){
			 $('#div_'+name+'_'+i).show();
			 $('#tab_'+name+'_'+i).attr('class',cls_show);
		}else{
			 $('#div_'+name+'_'+i).hide();
			 $('#tab_'+name+'_'+i).attr('class',cls_hide);
		}
	}
}

</script>

</body></html>