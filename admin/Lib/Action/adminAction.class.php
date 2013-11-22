<?php

class adminAction extends baseAction
{
	function index()
	{
		$admin_mod = D ( 'admin' );
		import ( "ORG.Util.Page" );
		$prex = C ( 'DB_PREFIX' );
		$count = $admin_mod->count ();
		$p = new Page ( $count, 30 );
		
		$tpl_list = $admin_mod->field ( $prex . 'admin.*,' . $prex . 'role.name as role_name' )->join ( 'LEFT JOIN ' . $prex . 'role ON ' . $prex . 'admin.role_id = ' . $prex . 'role.id ' )->limit ( $p->firstRow . ',' . $p->listRows )->order ( $prex . 'admin.add_time DESC' )->select ();
		
		$key = 1;
		$admin_list = array();
		foreach ( $tpl_list as $k => $val )
		{
			//如果不是超级管理员，那么不显示超级管理员
			if($_SESSION ['admin_info'] ['id']!=1 and $val['id']==1)
			{
				continue;
			}
			$val['key'] = ++ $p->firstRow;
			$admin_list [] = $val;
		}
		
		$big_menu = array ('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=admin&a=add\', title:\'添加管理员\', width:\'480\', height:\'250\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', '添加管理员' );
		$page = $p->show ();
		$this->assign ( 'page', $page );
		$this->assign ( 'big_menu', $big_menu );
		$this->assign ( 'admin_list', $admin_list );
		$this->display ();
	}
	
	//修改个人信息
	function edit_personal()
	{
		$id = $_SESSION ['admin_info'] ['id'];
		if (isset ( $_POST ['dosubmit'] ))
		{
			$admin_mod = D ( 'admin' );
			$admin_info = $admin_mod->where ( "id = $id" )->find ();
			if (empty ( $admin_info ))
			{
				$this->error ( '非法操作！' );
			}
			$oldpassword = md5 ( $_POST ['oldpassword'] );
			if ($oldpassword != $admin_info ['password'])
			{
				$this->error ( '输入的旧密码不正确！' );
			}
			
			if ($_POST ['password'] != $_POST ['repassword'])
			{
				$this->error ( '两次输入的密码不相同' );
			}
			
			unset ( $_POST ['repassword'], $_POST ['oldpassword'] );
			$password = md5 ( $_POST ['password'] );
			if (false === $admin_mod->create ())
			{
				$this->error ( $admin_mod->getError () );
			}
			//只修改密码
			$_updateData = array ('password' => $password );
			
			$result = $admin_mod->where ( "id=$id" )->save ( $_updateData );
			if (false !== $result)
			{
				//记录日志
				$this->admin_log ( '修改了密码！' );
				$this->success ( L ( 'operation_success' ) );
			} else
			{
				$this->error ( L ( 'operation_failure' ) );
			}
		} else
		{
			$admin_mod = D ( 'admin' );
			$admin_info = $admin_mod->where ( 'id=' . $id )->find ();
			$this->assign ( 'admin_info', $admin_info );
			$this->assign ( 'show_header', false );
			$this->display ();
		}
	
	}
	
	function add()
	{
		if (isset ( $_POST ['dosubmit'] ))
		{
			$admin_mod = D ( 'admin' );
			if (! isset ( $_POST ['user_name'] ) || ($_POST ['user_name'] == ''))
			{
				$this->error ( '用户名不能为空' );
			}
			if ($_POST ['password'] != $_POST ['repassword'])
			{
				$this->error ( '两次输入的密码不相同' );
			}
			$result = $admin_mod->where ( "user_name='" . $_POST ['user_name'] . "'" )->count ();
			if ($result)
			{
				$this->error ( '管理员' . $_POST ['user_name'] . '已经存在' );
			}
			unset ( $_POST ['repassword'] );
			$_POST ['password'] = md5 ( $_POST ['password'] );
			$admin_mod->create ();
			$admin_mod->add_time = time ();
			$admin_mod->last_time = time ();
			$result = $admin_mod->add ();
			if ($result)
			{
				$this->admin_log ( '添加了管理员 ' . $_POST ['user_name'] . ' 所属组ID: ' . $_POST ['role_id'] );
				$this->success ( L ( 'operation_success' ), '', '', 'add' );
			} else
			{
				$this->error ( L ( 'operation_failure' ) );
			}
		
		} else
		{
			$role_mod = D ( 'role' );
			$role_list = $role_mod->where ( 'status=1' )->select ();
			$this->assign ( 'role_list', $role_list );
			
			$this->assign ( 'show_header', false );
			$this->display ();
		}
	}
	
	//修改管理员信息
	function edit()
	{
		if ($_SESSION ['admin_info'] ['id'] != 1 and $_REQUEST ['id'] == 1)
		{
			$this->error('禁止操作！');
		}
		
		if (isset ( $_POST ['dosubmit'] ))
		{
			$admin_mod = D ( 'admin' );
			$count = $admin_mod->where ( "id!=" . $_POST ['id'] . " and user_name='" . $_POST ['user_name'] . "'" )->count ();
			if ($count > 0)
			{
				$this->error ( '用户名已经存在！' );
			}
			//print_r($count);exit;
			if ($_POST ['password'])
			{
				if (strlen ( $_POST ['password'] ) < 6)
				{
					$this->error ( '密码不能小于6位！' );
				}
				if ($_POST ['password'] != $_POST ['repassword'])
				{
					$this->error ( '两次输入的密码不相同' );
				}
				$_POST ['password'] = md5 ( $_POST ['password'] );
			} else
			{
				unset ( $_POST ['password'] );
			}
			unset ( $_POST ['repassword'] );
			if (false === $admin_mod->create ())
			{
				$this->error ( $admin_mod->getError () );
			}
			
			$result = $admin_mod->save ();
			if (false !== $result)
			{
				$this->admin_log ( '修改了 管理员 ' . $_POST ['user_name'] . ' 信息,ID：' . $_POST ['id'] . ' ， 所属组ID: ' . $_POST ['role_id'] );
				$this->success ( L ( 'operation_success' ), '', '', 'edit' );
			} else
			{
				$this->error ( L ( 'operation_failure' ) );
			}
		} else
		{
			if (isset ( $_GET ['id'] ))
			{
				$id = isset ( $_GET ['id'] ) && intval ( $_GET ['id'] ) ? intval ( $_GET ['id'] ) : $this->error ( '参数错误' );
			}
			$role_mod = D ( 'role' );
			$role_list = $role_mod->where ( 'status=1' )->select ();
			$this->assign ( 'role_list', $role_list );
			
			$admin_mod = D ( 'admin' );
			$admin_info = $admin_mod->where ( 'id=' . $id )->find ();
			$this->assign ( 'admin_info', $admin_info );
			$this->assign ( 'show_header', false );
			$this->display ();
		}
	}
	
	function delete()
	{
		if ((! isset ( $_GET ['id'] ) || empty ( $_GET ['id'] )) && (! isset ( $_POST ['id'] ) || empty ( $_POST ['id'] )))
		{
			$this->error ( '请选择要删除的管理员！' );
		}
		$admin_mod = D ( 'admin' );
		$u = '';
		if (isset ( $_POST ['id'] ) && is_array ( $_POST ['id'] ))
		{
			$ids = array();
			foreach ($_POST['id'] as $v)
			{
				if(is_numeric($v) and $v != 1)
				{
					$ids[] = intval($v);
				}
			}
			$ids = implode ( ',', $ids );
			$info = $admin_mod->field ( 'user_name' )->where ( "id in($ids)" )->select ();
			
			foreach ( $info as $v )
			{
				$u .= '[' . $v ['user_name'] . ']';
			}
			$admin_mod->delete ( $ids );
		} else
		{
			$ids = intval ( $_GET ['id'] );
			if($ids == 1)
			{
				$this->error('禁止操作');
			}
			$info = $admin_mod->field ( 'user_name' )->where ( "id in($ids)" )->select ();
			
			foreach ( $info as $v )
			{
				$u .= '[' . $v ['user_name'] . ']';
			}
			$admin_mod->delete ( $ids );
		}
		$this->admin_log ( '删除了管理员  ' . $u . '  管理员ID：' . $ids );
		$this->success ( L ( 'operation_success' ) );
	}
	
	public function ajax_check_username()
	{
		$user_name = $_GET ['user_name'];
		$id = isset ( $_GET ['id'] ) && intval ( $_GET ['id'] ) ? intval ( $_GET ['id'] ) : '';
		if (D ( 'admin' )->check_username ( $user_name, $id ))
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
	function ajax_check_used()
	{
		clean_xss ( $_GET );
		$admin_mod = D ( 'admin' );
		$count = $admin_mod->where ( "id!=" . intval ( $_GET ['id'] ) . " and user_name='" . $_GET ['user_name'] . "'" )->count ();
		echo $count;
		exit ();
		if ($count > 0)
		{
			echo "0";
		} else
		{
			echo "1";
		}
	}
	//修改状态
	function status()
	{
		$admin_mod = D ( 'admin' );
		$id = intval ( $_REQUEST ['id'] );
		$info = $admin_mod->where ( "id=$id" )->find ();
		
		$type = trim ( $_REQUEST ['type'] );
		$sql = "update " . C ( 'DB_PREFIX' ) . "admin set $type=($type+1)%2 where id='$id'";
		$res = $admin_mod->execute ( $sql );
		$this->admin_log ( '修改了管理员' . $info ['user_name'] . ' 状态，  管理员ID：' . $id );
		$values = $admin_mod->where ( 'id=' . $id )->find ();
		$this->ajaxReturn ( $values [$type] );
	}
}