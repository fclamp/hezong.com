<?php

class settingAction extends baseAction
{
	function index()
	{   
		$this->assign('set',$this->setting);
		$this->display($_REQUEST['type']);
	}
	function edit()
	{
		$setting_mod = M('setting');
		$post = $this->_stripcslashes($_POST['site']);
		foreach($post as $key=>$val ){
			$key = htmlspecialchars($key);
			$val = htmlspecialchars($val);
			$setting_mod->where("name='".$key."'")->save(array('data'=>$val));
		}
				
		$this->admin_log('修改了网站设置');
		$this->success('修改成功',U('setting/index'));
	} 
}