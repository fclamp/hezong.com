<?php
return array(
	//可忽略的权限检查
	'IGNORE_PRIV_LIST'=>array(
		array(
			'module_name'=>'admin',
			'action_list'=>array('ajax_check_username')
		),		
		array(
			'module_name'=>'index',
			'action_list'=>array()
		),		
		array(
			'module_name'=>'public',
			'action_list'=>array()
		),	
	)
);