<?php
/**
 * 
 * 栏目管理
 * @author fc_lamp
 *
 */
class categoryAction extends baseAction
{
	public $cate_mod = NULL;
	public $cate_type = array('1'=>'列表栏目','2'=>'单页栏目');
	
	
	public function _initialize()
	{
		parent::_initialize ();
		$this->cate_mod = D ( 'category' );
		
		$this->assign('cate_type',$this->cate_type);
		
	}
	
	//显示列表
	public function index()
	{
		$cate_list = $this->get_tree ( $this->get_cate ( 0, 0, True ) );
		
		$this->assign ( 'page', '' );
		$this->assign ( 'cate_list', $cate_list );
		$this->display ();
	}
	
	/**
	 * 
	 * 添加
	 * @internal
	 * 
	 */
	public function add()
	{
		clean_xss ( $_POST );
		if (! empty ( $_POST ['name'] ))
		{
			$_POST ['name'] = trim ( $_POST ['name'] );
			$result = $this->cate_mod->where ( "name='" . $_POST ['name'] . "'" )->count ();
			if ($result)
			{
				$this->error ( '栏目已存在！' );
			}
			$_POST ['add_time'] = time ();
			$this->base_add ();
		}
		
		$this->assign ( 'cate_list', $this->get_cate ( 0, 0, True ) );
		$this->display ();
	}	
	
	/**
	 * 
	 * 修改
	 * @internal
	 * 
	 */
	public function edit()
	{
		clean_xss ( $_GET );
		if (! empty ( $_POST ['id'] ))
		{
			$_POST ['id'] = abs ( intval ( $_POST ['id'] ) );
			$_POST ['name'] = trim ( $_POST ['name'] );
			$result = $this->cate_mod->where ( "name='" . $_POST ['name'] . "' and id !=" . $_POST ['id'] )->count ();
			if ($result)
			{
				$this->error ( '栏目已存在！' );
			}
			
			$this->base_edit ();
		} else
		{
			if (isset ( $_GET ['id'] ))
			{
				$cate_id = isset ( $_GET ['id'] ) && intval ( $_GET ['id'] ) ? intval ( $_GET ['id'] ) : $this->error ( L ( 'please_select' ) );
			}
			
			$part = $this->cate_mod->where ( 'id=' . $cate_id )->find ();
			$this->assign ( 'cate_list', $this->get_cate ( 0, 0, True ) );
			$this->assign ( 'show_header', false );
			$this->assign ( 'part', $part );
			$this->display ();
		}
	}
	
	
	/**
	 * 
	 * 删除栏目
	 * @internal
	 * 
	 */
	public function delete()
	{
		$mod_info = D ( 'node' )->where ( "module='" . MODULE_NAME . "'" )->find ();
		$msg = $mod_info ['module_name'] . ' 删除信息(包括所有子栏目)，名称:%s，ID:%s';
		
		$name = '';
		$result = FALSE;
		if (isset ( $_POST ['id'] ) && is_array ( $_POST ['id'] ))
		{
			foreach ( $_POST ['id'] as $k => $v )
			{
				$_POST ['id'] [$k] = abs ( intval ( $v ) );
			}
			$ids = implode ( ',', $_POST ['id'] );
			$info = $this->cate_mod->field ( 'name' )->where ( "id in($ids)" )->select ();
			
			foreach ( $info as $v )
			{
				$name .= '[' . $v ['name'] . ']';
			}
			
			$result = $this->cate_mod->delete ( $ids );
		} elseif (isset ( $_GET ['id'] ) and is_numeric ( $_GET ['id'] ))
		{
			$ids = intval ( $_GET ['id'] );
			$info = $this->cate_mod->field ( 'name' )->where ( "id in($ids)" )->select ();
			
			foreach ( $info as $v )
			{
				$name .= '[' . $v ['name'] . ']';
			}
			$result = $this->cate_mod->delete ( $ids );
		}
		
		if ($result)
		{
			$this->admin_log ( sprintf ( $msg, $name, $ids ) );
			//删除子级
			$ids = explode(',',$ids);
			foreach ($ids as $id)
			{
				$this->delete_child($id);
			}			
			
			$this->success ( L ( 'operation_success' ) );
		} else
		{
			$this->error ( L ( 'operation_failure' ) );
		}
	}	
	
	
	//删除子栏目
	private function delete_child($pid)
	{
		$pid = abs(intval($pid));
		$res = $this->cate_mod->field ( 'id' )->where ( "pid=$pid" )->select ();
		//删除子级
		$this->cate_mod->where ( "pid=$pid" )->delete ();
		
		if (empty ( $res ))
		{
			return False;
		}
		foreach ( $res as $r )
		{
			$this->delete_child( $r ['id'] );
		}
	}	
	

	
	
	//用呈现例表
	private function get_tree($data)
	{
		$list = array ();
		foreach ( $data as $v )
		{
			$vv = $v;
			unset ( $vv ['items'] );
			$vv ['cls'] = '';
			if (! empty ( $v ['items'] ))
			{
				$vv ['cls'] = 'yes';
				$list [$v ['id']] = $vv;
				$list = $list + $this->get_tree ( $v ['items'] );
			} else
			{
				$list [$v ['id']] = $vv;
			}
		
		}
		return $list;
	}
	
	private function get_cate($id = 0, $level = 0, $child = False, $field = '', $orderby = '`sort` DESC,id DESC')
	{
		if (empty ( $field ))
		{
			$field = '*';
		}
		
		$list = array ();
		$res = $this->cate_mod->field ( $field )->where ( 'pid=' . $id )->order ( $orderby )->select ();
		if (empty ( $res ))
		{
			return array ();
		}
		$level += 1;
		
		//是否要获取子级
		if ($child)
		{
			foreach ( $res as $k => $v )
			{
				$v ['access'] = 'yes';
				$v ['level'] = $level;
				$v ['items'] = $this->get_cate ( $v ['id'], $level, True, $field );
				$res [$k] = $v;
			}
		} else
		{
			foreach ( $res as $k => $v )
			{
				$v ['access'] = 'yes';
				$v ['level'] = $level;
				$res [$k] = $v;
			}
		}
		
		return $res;
	}
	
	
}