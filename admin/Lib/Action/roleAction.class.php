<?php
class roleAction extends baseAction
{
	function index()
	{
		$role_mod = D ( 'role' );
		import ( "ORG.Util.Page" );
		$count = $role_mod->count ();
		$p = new Page ( $count, 30 );
		
		$role_list = $role_mod->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$big_menu = array ('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=role&a=add\', title:\'添加角色\', width:\'400\', height:\'220\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', '添加组' );
		$page = $p->show ();
		$this->assign ( 'page', $page );
		$this->assign ( 'big_menu', $big_menu );
		$this->assign ( 'role_list', $role_list );
		$this->display ();
	}
	
	function add()
	{
		if (isset ( $_POST ['dosubmit'] ))
		{
			$role_mod = D ( 'role' );
			if (! isset ( $_POST ['name'] ) || ($_POST ['name'] == ''))
			{
				$this->error ( '请填写角色名' );
			}
			$result = $role_mod->where ( "name='" . $_POST ['name'] . "'" )->count ();
			if ($result)
			{
				$this->error ( '角色已经存在' );
			}
			$role_mod->create ();
			$result = $role_mod->add ();
			if ($result)
			{
				$this->admin_log ( '成功添加 ' . $_POST ['name'] . ' 角色，ID: ' . $result );
				$this->success ( L ( 'operation_success' ), '', '', 'add' );
			} else
			{
				$this->error ( L ( 'operation_failure' ) );
			}
		} else
		{
			$this->assign ( 'show_header', false );
			$this->display ();
		}
	}
	
	public function edit()
	{
		if (isset ( $_POST ['dosubmit'] ))
		{
			$role_mod = D ( 'role' );
			if (false === $role_mod->create ())
			{
				$this->error ( $role_mod->getError () );
			}
			$result = $role_mod->save ();
			if (false !== $result)
			{
				$this->admin_log ( '编辑了角色ID:' . $_POST ['id'] . '信息,角色名为：' . $_POST ['name'] );
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
			$role_info = $role_mod->where ( 'id=' . $id )->find ();
			$this->assign ( 'role_info', $role_info );
			$this->assign ( 'show_header', false );
			$this->display ();
		}
	}
	
	function delete()
	{
		if ((! isset ( $_GET ['id'] ) || empty ( $_GET ['id'] )) && (! isset ( $_POST ['id'] ) || empty ( $_POST ['id'] )))
		{
			$this->error ( '请选择要删除的角色！' );
		}
		$role_mod = D ( 'role' );
		$u = '';
		if (isset ( $_POST ['id'] ) && is_array ( $_POST ['id'] ))
		{
			$ids = array();
			foreach ($_POST['id'] as $id)
			{
				$id = id($id);
				if($id==1)
				{
					continue;
				}
				
				$ids[$id] = $id;
			}
			$ids = implode ( ',', $ids );
			
			$info = $role_mod->field ( 'name' )->where ( "id in($ids)" )->select ();
			
			foreach ( $info as $v )
			{
				$u .= '[' . $v ['name'] . ']';
			}
			
			$role_mod->delete ( $ids );
		} else
		{
			$ids = intval ( $_GET ['id'] );
			if($ids==1)
			{
				$this->error ( '禁止删除！' );
			}
			
			$info = $role_mod->field ( 'name' )->where ( "id in($ids)" )->select ();
			
			foreach ( $info as $v )
			{
				$u .= '[' . $v ['name'] . ']';
			}
			$role_mod->delete ( $ids );
		}
		$this->admin_log ( '删除了角色  ' . $u . '  角色ID：' . $ids );
		$this->success ( L ( 'operation_success' ) );
	}
	
	//授权
	public function auth()
	{
		$role_id = intval ( $_REQUEST ['id'] );
		//获取角色名称
		$role_mode = D ( 'role' );
		$role_info = $role_mode->where ( 'id=' . $role_id )->find ();
		if (empty ( $role_info ))
		{
			$this->error ( '此角色已不存在！' );
		}
		$this->assign ( 'role_info', $role_info );
		
		$node_ids_res = D ( "access" )->where ( "role_id=" . $role_id )->field ( "node_id" )->select ();
		$node_ids = array ();
		foreach ( $node_ids_res as $row )
		{
			array_push ( $node_ids, $row ['node_id'] );
		}
		//取出模块授权
		$modules = D ( "node" )->where ( "status = 1 and auth_type = 0" )->select ();
		foreach ( $modules as $k => $v )
		{
			//如果不是超级管理员，菜单设置不显示
			if($_SESSION['admin_info']['id'] != 1 and in_array($v['module'],array('node','group')))
			{
				continue;	
			}
			$modules [$k] ['actions'] = D ( "node" )->where ( "status=1 and auth_type>0 and module='" . $v ['module'] . "'" )->select ();
		}
		foreach ( $modules as $k => $module )
		{
			//如果不是超级管理员，菜单设置不显示
			if($_SESSION['admin_info']['id'] != 1 and in_array($module['module'],array('node','group')))
			{
				unset($modules[$k]);
				continue;	
			}			
			
			if (in_array ( $module ['id'], $node_ids ))
			{
				$modules [$k] ['checked'] = true;
			} else
			{
				$modules [$k] ['checked'] = false;
			}
			foreach ( $module ['actions'] as $ak => $action )
			{
				if (in_array ( $action ['id'], $node_ids ))
				{
					$modules [$k] ['actions'] [$ak] ['checked'] = true;
				} else
				{
					$modules [$k] ['actions'] [$ak] ['checked'] = false;
				}
			}
		}
		
		//获取权限表
		$c_depart_mod = D ( 'category' );
		
		//获取角色已有的权限
		$tpl = D ( 'category_access' )->where ( "role_id=" . $role_id )->field ( "node_id,type" )->select ();
		$has_access = array ();
		foreach ( $tpl as $v )
		{
			$has_access [$v ['type']] [$v ['node_id']] = $v;
		}
		$has_access [1] = isset ( $has_access [1] ) ? $has_access [1] : array ();
		$has_access [2] = isset ( $has_access [2] ) ? $has_access [2] : array ();
		
		//呈现数据
		$this->assign ( 'depart_access_list', $this->get_tree ( $has_access [1], $this->get_cate_comm ( $c_depart_mod, 0, 0, True ) ) );
		
		//基础权限
		$this->assign ( 'access_list', $modules );
		$this->assign ( 'id', $role_id );
		$this->display ();
	}
	
	//用呈现例表
	private function get_tree($accessed, $data, $type = 1)
	{
		$list = array ();
		foreach ( $data as $v )
		{
			$vv = $v;
			if (array_key_exists ( $vv ['id'], $accessed ))
			{
				$vv ['checked'] = 1;
			}
			unset ( $vv ['items'] );
			$vv ['cls'] = '';
			if (! empty ( $v ['items'] ))
			{
				$vv ['cls'] = 'yes';
				$list [$v ['id']] = $vv;
				$list = $list + $this->get_tree ( $accessed, $v ['items'], $type );
			} else
			{
				$list [$v ['id']] = $vv;
			}
		
		}
		return $list;
	}
	

	
	//更新权限
	public function auth_submit()
	{
		clean_xss ( $_POST );
		clean_xss ( $_GET );
		
		$role_id = intval ( $_REQUEST ['id'] );
		//获取角色名称
		$role_mode = D ( 'role' );
		$role_info = $role_mode->where ( 'id=' . $role_id )->find ();
		if (empty ( $role_info ))
		{
			$this->error ( '此角色已不存在！' );
		}
		
		//删除原有基础权限
		$access = D ( 'access' );
		$access->where ( "role_id=" . $role_id )->delete ();
		//添加基础权限
		$table = $access->getTableName ();
		$sql_s = "insert into $table(role_id,node_id) values";
		$sql_e = '';
		$node_ids = $_REQUEST ['access_node'];
		foreach ( $node_ids as $node_id )
		{
			if (is_numeric ( $node_id ))
			{
				$node_id = abs ( intval ( $node_id ) );
				$sql_e .= "($role_id,$node_id),";
			}
		}
		$sql_e = trim ( $sql_e, ',' );
		if (! empty ( $sql_e ))
		{
			$access->execute ( $sql_s . $sql_e );
		}
		
		//删除原权限
		$c_access_mod = D ( 'category_access' );
		$c_access_mod->where ( "role_id=" . $role_id )->delete ();
		
		//栏目
		$c_c_table = $c_access_mod->getTableName ();
		$sql_s = "insert into $c_c_table(role_id,node_id) values";
		$sql_e = '';
		$c_depart_access = ! empty ( $_POST ['departids'] ) ? $_POST ['departids'] : array ();
		foreach ( $c_depart_access as $v )
		{
			if (is_numeric ( $v ))
			{
				$v = abs ( intval ( $v ) );
				$sql_e .= "($role_id,$v),";
			}
		}
		$sql_e = trim ( $sql_e, ',' );
		if (! empty ( $sql_e ))
		{
			$c_access_mod->execute ( $sql_s . $sql_e );
		}
		
		$this->admin_log ( '编辑了角色 : ' . $role_info ['name'] . '  的权限信息，ID：' . $role_id );
		$this->success ( L ( 'operation_success' ) );
	}
	//修改状态
	function status()
	{
		$role_mod = D ( 'role' );
		$id = intval ( $_REQUEST ['id'] );
		
		$info = $role_mod->where ( "id=$id" )->find ();
		
		$type = trim ( $_REQUEST ['type'] );
		$sql = "update " . C ( 'DB_PREFIX' ) . "role set $type=($type+1)%2 where id='$id'";
		
		$this->admin_log ( '修改了角色' . $info ['name'] . ' 状态， 角色ID：' . $id );
		
		$res = $role_mod->execute ( $sql );
		$values = $role_mod->where ( 'id=' . $id )->find ();
		$this->ajaxReturn ( $values [$type] );
	}
}