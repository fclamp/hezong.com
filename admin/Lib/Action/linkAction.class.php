<?php
/**
 * 
 *  连接管理
 * @author fc_lamp
 *
 */
class linkAction extends baseAction
{
	public $link_mode = NULL;
	
	public $bottomLinkExten = array('1'=>'区块一','2'=>'区块二','3'=>'区块三');
	
	public function _initialize()
	{
		//权限
		parent::_initialize ();
		
		$this->link_mode = D('link');		
		
	}
	
	//*******************顶部导航栏*********************
	
	/**
	 * 
	 * 顶部导航列表
	 * @internal
	 * 
	 */
	function index()
	{
		//搜索
		$where = 'catid=0';
		$count = $this->link_mode->where ( $where )->count ();
		if($count >0)
		{
			$p = $this->pager ( $count,25 );
			$link_list = $this->link_mode->where ( $where )->limit ( $p->firstRow . ',' . $p->listRows )->order ('sort desc,id desc')->select ();
			
			foreach ( $link_list as $k => $val )
			{
				$val['name'] = htmlspecialchars($val['name']);
				$val['url'] = htmlspecialchars($val['url']);
				
				$link_list[$k] = $val;
			}
			$this->assign ( 'link_list', $link_list );			
		}
		
		$big_menu = array ('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=link&a=add\', title:\'添加顶部导航栏\', width:\'500\', height:\'250\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', '添加顶部导航栏' );
		$this->assign ( 'big_menu', $big_menu );
		$this->display ();
	}
	
	/**
	 * 
	 * '添加顶部导航栏'
	 * @internal
	 * 
	 */
	function add()
	{
		if (isset ( $_POST ['dosubmit'] ))
		{
			$data = array ();
			$name = isset ( $_POST ['name'] ) && trim ( $_POST ['name'] ) ? trim ( $_POST ['name'] ) : $this->error ( L ( 'input' ) . L ( 'flink_name' ) );
			$url = isset ( $_POST ['url'] ) && trim ( $_POST ['url'] ) ? trim ( $_POST ['url'] ) : $this->error ( L ( 'input' ) . L ( 'flink_url' ) );
			$exist = $this->link_mode->where ( "catid=0 and name='" . $name . "'" )->count ();
			if ($exist != 0)
			{
				$this->error ( '该导航已经存在' );
			}
			$data = $this->link_mode->create ();
			clean_xss($data,True);
			$f = $this->link_mode->add ( $data );
			
			$this->admin_log ( '连接管理  添加顶部导航栏 名称:'.$name.'，ID：'.$f );
			
			$this->success ( L ( 'operation_success' ), '', '', 'add' );
		}

		$this->assign('formAction',U('link/add'));
		
		$this->assign ( 'show_header', false );
		$this->display ();
	}
	
	/**
	 * 
	 * 编辑顶部导航栏
	 * @internal
	 * 
	 */
	function edit()
	{
		$link_id = id($_REQUEST['id']);
		
		$link_info = $this->link_mode->where ( 'catid=0 and id=' . $link_id )->find ();
		if(empty($link_info))
		{
			$this->assign ( 'nojump', 'yes' );
			$this->error ( '此信息已不存在' );
		}
		
		
		if (isset ( $_POST ['dosubmit'] ))
		{
			$name = isset ( $_POST ['name'] ) && trim ( $_POST ['name'] ) ? trim ( $_POST ['name'] ) : $this->error ( L ( 'input' ) . L ( 'flink_name' ) );
			$url = isset ( $_POST ['url'] ) && trim ( $_POST ['url'] ) ? trim ( $_POST ['url'] ) : $this->error ( L ( 'input' ) . L ( 'flink_url' ) );
			$exist = $this->link_mode->where ( "id != $link_id and catid=0 and name='" . $name . "'" )->count ();
			if ($exist != 0)
			{
				$this->error ( '该导航已经存在' );
			}			
			
			$data = $this->link_mode->create ();
			clean_xss($data,True);
			$this->link_mode->where ( "id=$link_id" )->save ( $data );
			
			$this->admin_log ( '连接管理 编辑顶部导航栏 名称:'.$name.'，ID：'.$link_id );
			
			$this->success ( L ( 'operation_success' ), '', '', 'edit' );
		} 
		
		$this->assign('formAction',U('link/edit'));
		$this->assign ( 'link_info', $link_info );
		$this->assign ( 'show_header', false );
		$this->display ();
	
	}
	
	
	/**
	 * 删除顶部导航
	 * @internal
	 * 
	 */
	public function delete()
	{
		$node_mod = D ( 'node' );
		$mod_info = $node_mod->where ( "module='" . MODULE_NAME . "'" )->find ();
		$msg = $mod_info ['module_name'] . ' 删除顶部导航栏信息，名称:%s，ID:%s';
		
		$name = '';
		$result = FALSE;
		if (isset ( $_POST ['id'] ) && is_array ( $_POST ['id'] ))
		{
			foreach ( $_POST ['id'] as $k => $v )
			{
				$_POST ['id'] [$k] = abs ( intval ( $v ) );
			}
			$ids = implode ( ',', $_POST ['id'] );
			$info = $this->link_mode->field ( 'name' )->where ( "catid=0 and id in($ids)" )->select ();
			
			foreach ( $info as $v )
			{
				$name .= '[' . $v ['name'] . ']';
			}
			
			$result = $this->link_mode->where ( "`id` in($ids) and catid=0" )->delete ();;
		} elseif (isset ( $_GET ['id'] ) and is_numeric ( $_GET ['id'] ))
		{
			$ids = intval ( $_GET ['id'] );
			$info = $this->link_mode->field ( 'name' )->where ( "catid=0 and id in($ids)" )->select ();
			
			foreach ( $info as $v )
			{
				$name .= '[' . $v ['name'] . ']';
			}
			$result = $this->link_mode->where ( "`id` in($ids) and catid=0" )->delete ();;
		}
		
		if ($result)
		{
			$this->admin_log ( sprintf ( $msg, $name, $ids ) );
			
			$this->success ( L ( 'operation_success' ) );
		} else
		{
			$this->error ( L ( 'operation_failure' ) );
		}
	}	
	
	
	
	//*******************底部导航栏*********************
	public function indexBottom()
	{
		//搜索
		$where = 'catid=1';
		$count = $this->link_mode->where ( $where )->count ();
		if($count >0)
		{
			$p = $this->pager ( $count,25 );
			$link_list = $this->link_mode->where ( $where )->limit ( $p->firstRow . ',' . $p->listRows )->order ('sort desc,id desc')->select ();
			
			foreach ( $link_list as $k => $val )
			{
				$val['name'] = htmlspecialchars($val['name']);
				$val['url'] = htmlspecialchars($val['url']);
				
				$link_list[$k] = $val;
			}
			$this->assign ( 'link_list', $link_list );			
		}
		
		$big_menu = array ('javascript:window.top.art.dialog({id:\'addBottom\',iframe:\'?m=link&a=addBottom\', title:\'添加底部导航栏\', width:\'500\', height:\'250\', lock:true}, function(){var d = window.top.art.dialog({id:\'addBottom\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'addBottom\'}).close()});void(0);', '添加底部导航栏' );
		$this->assign ( 'big_menu', $big_menu );
		
		$this->assign('bottomLinkExten',$this->bottomLinkExten);
		
		$this->display ();		
	}
	
	/**
	 * 
	 * '添加底部导航栏'
	 * @internal
	 * 
	 */
	function addBottom()
	{
		
		if (isset ( $_POST ['dosubmit'] ))
		{
			$data = array ();
			$name = isset ( $_POST ['name'] ) && trim ( $_POST ['name'] ) ? trim ( $_POST ['name'] ) : $this->error ( L ( 'input' ) . L ( 'flink_name' ) );
			$url = isset ( $_POST ['url'] ) && trim ( $_POST ['url'] ) ? trim ( $_POST ['url'] ) : $this->error ( L ( 'input' ) . L ( 'flink_url' ) );
			$exist = $this->link_mode->where ( "catid=1 and name='" . $name . "'" )->count ();
			if ($exist != 0)
			{
				$this->error ( '该导航已经存在' );
			}
			$data = $this->link_mode->create ();
			clean_xss($data,True);
			$data['catid'] = 1;
			$link_id = $this->link_mode->add ( $data );
			
			$this->admin_log ( '连接管理 添加底部导航栏 名称:'.$name.'，ID：'.$link_id );
			
			$this->success ( L ( 'operation_success' ), '', '', 'addBottom' );
		}
			
		$this->assign ( 'show_header', false );
		$this->assign('bottomLinkExten',$this->bottomLinkExten);
		$this->display ();
	}	
	
	
	/**
	 * 
	 * 编辑底部导航栏
	 * @internal
	 * 
	 */
	function editBottom()
	{
		$link_id = id($_REQUEST['id']);
		
		$link_info = $this->link_mode->where ( 'catid=1 and id=' . $link_id )->find ();
		if(empty($link_info))
		{
			$this->assign ( 'nojump', 'yes' );
			$this->error ( '此信息已不存在' );
		}
		
		
		if (isset ( $_POST ['dosubmit'] ))
		{
			
			$name = isset ( $_POST ['name'] ) && trim ( $_POST ['name'] ) ? trim ( $_POST ['name'] ) : $this->error ( L ( 'input' ) . L ( 'flink_name' ) );
			$url = isset ( $_POST ['url'] ) && trim ( $_POST ['url'] ) ? trim ( $_POST ['url'] ) : $this->error ( L ( 'input' ) . L ( 'flink_url' ) );
			$exist = $this->link_mode->where ( "id != $link_id and catid=1 and name='" . $name . "'" )->count ();
			if ($exist != 0)
			{
				$this->error ( '该导航已经存在' );
			}			
			
			$data = $this->link_mode->create ();
			clean_xss($data,True);
			$data['catid']=1;
			$this->link_mode->where ( "id=$link_id" )->save ( $data );
			
			$this->admin_log ( '连接管理  编辑底部导航栏 名称:'.$name.'，ID：'.$link_id );
			
			$this->success ( L ( 'operation_success' ), '', '', 'editBottom' );
		} 
		
		
		$this->assign('bottomLinkExten',$this->bottomLinkExten);
		
		$this->assign ( 'link_info', $link_info );
		$this->assign ( 'show_header', false );
		$this->display ();
	
	}	
	
	
	/**
	 * 删除底部导航
	 * @internal
	 * 
	 */
	public function deleteBottom()
	{
		$node_mod = D ( 'node' );
		$mod_info = $node_mod->where ( "module='" . MODULE_NAME . "'" )->find ();
		$msg = $mod_info ['module_name'] . ' 删除底部导航栏信息，名称:%s，ID:%s';
		
		$name = '';
		$result = FALSE;
		if (isset ( $_POST ['id'] ) && is_array ( $_POST ['id'] ))
		{
			foreach ( $_POST ['id'] as $k => $v )
			{
				$_POST ['id'] [$k] = abs ( intval ( $v ) );
			}
			$ids = implode ( ',', $_POST ['id'] );
			$info = $this->link_mode->field ( 'name' )->where ( "catid=1 and id in($ids)" )->select ();
			
			foreach ( $info as $v )
			{
				$name .= '[' . $v ['name'] . ']';
			}
			
			$result = $this->link_mode->where ( "`id` in($ids) and catid=1" )->delete ();;
		} elseif (isset ( $_GET ['id'] ) and is_numeric ( $_GET ['id'] ))
		{
			$ids = intval ( $_GET ['id'] );
			$info = $this->link_mode->field ( 'name' )->where ( "catid=1 and id in($ids)" )->select ();
			
			foreach ( $info as $v )
			{
				$name .= '[' . $v ['name'] . ']';
			}
			$result = $this->link_mode->where ( "`id` in($ids) and catid=1" )->delete ();;
		}
		
		if ($result)
		{
			$this->admin_log ( sprintf ( $msg, $name, $ids ) );
			
			$this->success ( L ( 'operation_success' ) );
		} else
		{
			$this->error ( L ( 'operation_failure' ) );
		}
	}	
	
	
	
	
	
	
	
	//*******************友情连接********************
	/**
	 * 
	 * 友情连接列表
	 * @internal
	 * 
	 */
	function indexFlink()
	{
		clean_xss($_GET);
		//搜索
		$where = 'catid=2';
		if (isset ( $_GET ['keyword'] ) && trim ( $_GET ['keyword'] ))
		{
			$where .= " AND name LIKE '%" . $_GET ['keyword'] . "%'";
			$this->assign ( 'keyword', $_GET ['keyword'] );
		}
		$count = $this->link_mode->where ( $where )->count ();
		if($count >0)
		{
			$p = $this->pager ( $count,25 );
			$link_list = $this->link_mode->where ( $where )->limit ( $p->firstRow . ',' . $p->listRows )->order ('sort desc,id desc')->select ();
			
			foreach ( $link_list as $k => $val )
			{
				$val['name'] = htmlspecialchars($val['name']);
				$val['url'] = htmlspecialchars($val['url']);
				
				$link_list[$k] = $val;
			}
			$this->assign ( 'link_list', $link_list );			
		}
		
		$big_menu = array ('javascript:window.top.art.dialog({id:\'addFlink\',iframe:\'?m=link&a=addFlink\', title:\'添加友情连接\', width:\'500\', height:\'250\', lock:true}, function(){var d = window.top.art.dialog({id:\'addFlink\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'addFlink\'}).close()});void(0);', '添加友情连接' );
		$this->assign ( 'big_menu', $big_menu );

		$this->display ();			
	}	
	
	/**
	 * 
	 * '添加友情连接'
	 * @internal
	 * 
	 */
	function addFlink()
	{
		
		if (isset ( $_POST ['dosubmit'] ))
		{
			$data = array ();
			$name = isset ( $_POST ['name'] ) && trim ( $_POST ['name'] ) ? trim ( $_POST ['name'] ) : $this->error ( L ( 'input' ) . L ( 'flink_name' ) );
			$url = isset ( $_POST ['url'] ) && trim ( $_POST ['url'] ) ? trim ( $_POST ['url'] ) : $this->error ( L ( 'input' ) . L ( 'flink_url' ) );
			$exist = $this->link_mode->where ( "catid=2 and name='" . $name . "'" )->count ();
			if ($exist != 0)
			{
				$this->error ( '该连接已经存在' );
			}
			$data = $this->link_mode->create ();
			clean_xss($data,True);
			$data['catid'] = 2;
			$link_id = $this->link_mode->add ( $data );
			
			$this->admin_log ( '连接管理 添加友情连接 名称:'.$name.'，ID：'.$link_id );
			
			$this->success ( L ( 'operation_success' ), '', '', 'addFlink' );
		}
			
		$this->assign ( 'show_header', false );
		
		$this->assign('formAction',U('link/addFlink'));
		$this->display ('add');
	}

	/**
	 * 
	 * 编辑友情连接
	 * @internal
	 * 
	 */
	function editFlink()
	{
		$link_id = id($_REQUEST['id']);
		
		$link_info = $this->link_mode->where ( 'catid=2 and id=' . $link_id )->find ();
		if(empty($link_info))
		{
			$this->assign ( 'nojump', 'yes' );
			$this->error ( '此信息已不存在' );
		}
		
		
		if (isset ( $_POST ['dosubmit'] ))
		{
			$name = isset ( $_POST ['name'] ) && trim ( $_POST ['name'] ) ? trim ( $_POST ['name'] ) : $this->error ( L ( 'input' ) . L ( 'flink_name' ) );
			$url = isset ( $_POST ['url'] ) && trim ( $_POST ['url'] ) ? trim ( $_POST ['url'] ) : $this->error ( L ( 'input' ) . L ( 'flink_url' ) );
			$exist = $this->link_mode->where ( "id != $link_id and catid=2 and name='" . $name . "'" )->count ();
			if ($exist != 0)
			{
				$this->error ( '该连接已经存在' );
			}			
			
			$data = $this->link_mode->create ();
			clean_xss($data,True);
			$data['catid'] = 2;
			$this->link_mode->where ( "id=$link_id" )->save ( $data );
			
			$this->admin_log ( '连接管理 编辑友情连接 名称:'.$name.'，ID：'.$link_id );
			
			$this->success ( L ( 'operation_success' ), '', '', 'editFlink' );
		} 
		
		$this->assign('formAction',U('link/editFlink'));
		$this->assign ( 'link_info', $link_info );
		$this->assign ( 'show_header', false );
		$this->display ('edit');
	
	}	
	
	/**
	 * 删除友情连接
	 * @internal
	 * 
	 */
	public function deleteFlink()
	{
		$node_mod = D ( 'node' );
		$mod_info = $node_mod->where ( "module='" . MODULE_NAME . "'" )->find ();
		$msg = $mod_info ['module_name'] . ' 删除友情连接信息，名称:%s，ID:%s';
		
		$name = '';
		$result = FALSE;
		if (isset ( $_POST ['id'] ) && is_array ( $_POST ['id'] ))
		{
			foreach ( $_POST ['id'] as $k => $v )
			{
				$_POST ['id'] [$k] = abs ( intval ( $v ) );
			}
			$ids = implode ( ',', $_POST ['id'] );
			$info = $this->link_mode->field ( 'name' )->where ( "catid=2 and id in($ids)" )->select ();
			
			foreach ( $info as $v )
			{
				$name .= '[' . $v ['name'] . ']';
			}
			if(!empty($ids))
			{
				$result = $this->link_mode->where ( "`id` in($ids) and catid=2" )->delete ();	
			}
			
			
		} elseif (isset ( $_GET ['id'] ) and is_numeric ( $_GET ['id'] ))
		{
			$ids = intval ( $_GET ['id'] );
			$info = $this->link_mode->field ( 'name' )->where ( "catid=2 and id in($ids)" )->select ();
			
			foreach ( $info as $v )
			{
				$name .= '[' . $v ['name'] . ']';
			}
			if(!empty($ids))
			{
				$result = $this->link_mode->where ( "`id` in($ids) and catid=2" )->delete ();	
			}
		}
		
		if ($result)
		{
			$this->admin_log ( sprintf ( $msg, $name, $ids ) );
			
			$this->success ( L ( 'operation_success' ) );
		} else
		{
			$this->error ( L ( 'operation_failure' ) );
		}
	}	
	
}