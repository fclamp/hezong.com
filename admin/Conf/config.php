<?php
if (!defined('THINK_PATH'))	exit();

$config = require("config.inc.php");
$ignorechenk=require 'configs/ignorecheck.config.php';

//$imgDomain = 'http://cc'.rand(1,4).'.xxx.com';

$array = array( 	
    'URL_MODEL' => 0,
    'LANG_SWITCH_ON' => True,
    'DEFAULT_LANG' => 'zh-cn', // 默认语言
    'LANG_AUTO_DETECT' => False, // 自动侦测语言     
 	'APP_AUTOLOAD_PATH'=>'@.TagLib',//	
	'TMPL_ACTION_ERROR'     => 'public:error',
    'TMPL_ACTION_SUCCESS'   => 'public:success',
    'SHOW_PAGE_TRACE'=>false,	  //是否显示TRACE信息	
	'HTML_CACHE_ON'=>false,
	'UPLOAD'=>array( //文件上传配置(仅针对图片)
		'ftpHost'=>'xxxx',
		'ftpUser'=>'xxxx',
		'ftpPwd'=>'xxxx',
		'ftpDir'=>'/xxxx/',
		'ftpPort'=>'xxxx',
		'imgDomain'=>ROOT_URL,
		'fileSize'=>3292200,//3M
		'imgAllow'=>array ('jpg', 'gif', 'png', 'jpeg' ),
		'fileUploadPath'=>'/data/upload/',
	),
);
return array_merge($config,$ignorechenk,$array);