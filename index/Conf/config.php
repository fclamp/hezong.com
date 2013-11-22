<?php
$config = require("config.inc.php");
$array = array(	
		'DEFAULT_MODULE'=>'index', //默认控制器
		'URL_MODEL' => 1,		
		'URL_HTML_SUFFIX'=>'html',
		'DEFAULT_THEME'=>'myweb', //皮肤设置
        //缓存配置
        'DATA_CACHE_TYPE' => 'file', // 数据缓存方式 文件
        'DATA_CACHE_TIME' => 0, // 数据缓存时间
        'DATA_CACHE_SUBDIR' => true,
        'DATA_PATH_LEVEL' => 2,
       // 'SHOW_PAGE_TRACE' => true, // 显示页面Trace信息

		'URL_REWIRTE_MODE_VAL'=>'1',  //U方法中是否使用自定义的U方法的函数
		'URL_PATHINFO_DEPR'=>'/',  //参数之间的分割符号
		//启用路由功能
		'URL_ROUTER_ON'=>true,
		//路由定义
		'URL_ROUTE_RULES'=>array(
			
		),
);
return array_merge($config, $array);