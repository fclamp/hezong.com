<?php
class publicAction extends baseAction
{
	/**
	 * 菜单页面
	 * 
	 */
	public function menu()
	{
		if(empty($_SESSION ['admin_info'] ['id']))
		{
			return False;
		}
		
		//显示则面菜单项(注意权限)
		$id = intval ( $_REQUEST ['tag'] ) == 0 ? 6 : intval ( $_REQUEST ['tag'] );
		$menu = array ();
		$role_id = D ( 'admin' )->where ( 'id=' . $_SESSION ['admin_info'] ['id'] )->getField ( 'role_id' );
		$node_ids_res = D ( "access" )->where ( "role_id=" . $role_id )->field ( "node_id" )->select ();
		
		$node_ids = array ();
		foreach ( $node_ids_res as $row )
		{
			$node_ids[$row ['node_id']] = $row ['node_id'];
		}
		$node_ids_res = $row = NULL;
		if(empty($node_ids))
		{
			return False;
		}
		
		$node_ids = implode(',',$node_ids);
		$node = M ( "node" );
		$where = "auth_type<>2 AND status=1 AND is_show=0 AND group_id=$id";
		if($_SESSION ['admin_info'] ['id'] != 1)
		{
			$where .= " and id in($node_ids)";
		}
		
		$list = $node->where ( $where )->field ( 'id,action,action_name,module,module_name,data' )->order ( 'sort DESC,id desc' )->select ();
		foreach ( $list as $key => $action )
		{
			$data_arg = array ();
			if ($action ['data'])
			{
				$data_arr = explode ( '&', $action ['data'] );
				foreach ( $data_arr as $data_one )
				{
					$data_one_arr = explode ( '=', $data_one );
					$data_arg [$data_one_arr [0]] = $data_one_arr [1];
				}
			}
			$action ['url'] = U ( $action ['module'] . '/' . $action ['action'], $data_arg );
			if ($action ['action'])
			{
				$menu [$action ['module']] ['navs'] [] = $action;
			}
			$menu [$action ['module']] ['name'] = $action ['module_name'];
			$menu [$action ['module']] ['id'] = $action ['id'];
		}
		
		$f_m = reset ( $menu );
		
		$this->assign ( 'f_m', reset ( $f_m ['navs'] ) );
		$this->assign ( 'menu', $menu );
		$this->display ( 'left' );
	}
	
	/**	 
	 * 后台主页
	 */
	public function main()
	{
		$this->display ();
	}
	
	/**
	 * 
	 * 登录
	 * @internal
	 * 
	 */
	public function login()
	{
		
		$admin_mod = M ( 'admin' );
		if ($_POST)
		{
			$username = $_POST ['username'] && trim ( $_POST ['username'] ) ? trim ( $_POST ['username'] ) : '';
			$password = $_POST ['password'] && trim ( $_POST ['password'] ) ? trim ( $_POST ['password'] ) : '';
			if (! $username || ! $password)
			{
				redirect ( u ( 'public/login' ) );
			}
			if ($this->setting ['check_code'] == 1)
			{
				if ($_SESSION ['verify'] != md5 ( $_POST ['verify'] ))
				{
					$this->error ( L ( 'verify_error' ) );
				}
			}
			
			$admin_info = $admin_mod->where ( "user_name='$username'" )->find ();
			
			
			if (empty($admin_info ['password']))
			{
				$this->error ( '帐号不存在或已禁用！' );
			} else
			{
				if ($admin_info ['password'] != md5 ( $password ))
				{
					$this->error ( '帐号不存在或密码错误！' );
				}
				
				$_SESSION ['admin_info'] = $admin_info;
				
				//更新登录的时间
				$ip = ip ();
				$admin_mod->where ( "id={$admin_info['id']}" )->save ( array ('last_time' => time (), 'last_ip' => $ip ) );
				
				//记录日志
				$this->admin_log ( '成功登录后台！' );
				
				$this->success ( '登录成功！', u ( 'index/index' ) );
				exit ();
			}
		}
		$this->assign ( 'set', $this->setting );
		$this->display ();
	}
	
	/**
	 * 退出
	 * @internal
	 * 
	 */
	public function logout()
	{
		if (isset ( $_SESSION ['admin_info'] ))
		{
			//记录日志
			$this->admin_log ( '退出后台！' );
			
			$_COOKIE = $_SESSION = NULL;
			setcookie ( session_id (), '', time () - 3600, '/' );
			
			
			session_destroy();
			$this->success ( '退出登录成功！', u ( 'public/login' ) );
		} else
		{
			$this->error ( '已经退出登录！' );
		}
	}
}