<?php

class groupAction extends baseAction
{
	
	function index()
	{
		$group_mod = D ( 'group' );
		$group_list = $group_mod->order ( 'sort ASC' )->select ();
		$this->assign ( 'group_list', $group_list );
		$big_menu = array ('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=group&a=add\', title:\'添加菜单分类\', width:\'500\', height:\'170\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', '添加菜单分类' );
		$this->assign ( 'big_menu', $big_menu );
		$this->display ();
	}
	
	//增加
	function add()
	{
		clean_xss($_POST);
		if (isset ( $_POST ['dosubmit'] ))
		{
			$group_mod = D ( 'group' );
			if (! isset ( $_POST ['title'] ) || ($_POST ['title'] == ''))
			{
				$this->error ( L ( 'group_title_require' ) );
			}
			$result = $group_mod->where ( "title='" . $_POST ['title'] . "'" )->count ();
			if ($result)
			{
				$this->error ( L ( 'group_title_exist' ) );
			}
			$this->base_add ();
		} else
		{
			$this->display ();
		}
	}
	
	//修改
	function edit()
	{
		clean_xss($_GET);
		clean_xss($_POST);
		
		if (isset ( $_POST ['dosubmit'] ))
		{
			$group_mod = D ( 'group' );
			$count = $group_mod->where ( "id!=" . $_POST ['id'] . " and title='" . $_POST ['title'] . "'" )->count ();
			if ($count > 0)
			{
				$this->error ( L ( 'group_title_exist' ) );
			}
			$this->base_edit();
		} else
		{
			if (isset ( $_GET ['id'] ))
			{
				$id = isset ( $_GET ['id'] ) && intval ( $_GET ['id'] ) ? intval ( $_GET ['id'] ) : $this->error ( '参数错误' );
			}
			$group_mod = D ( 'group' );
			$group_info = $group_mod->where ( 'id=' . $id )->find ();
			$this->assign ( 'group_info', $group_info );
			$this->display ();
		}
	}
	
	public function ajax_check_title()
	{
		$title = $_GET ['title'];
		if (D ( 'group' )->check_title ( $title ))
		{
			//不存在
			echo '1';
		} else
		{
			//存在
			echo '0';
		}
		exit ();
	}
}