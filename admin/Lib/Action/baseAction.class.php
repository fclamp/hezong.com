<?php
/**
 * 基础Action
 * 
 * 便于记录日志，所有名称字段都为："name"，主键都为"id"，排序都为：sort，状态都为：status
 * 
 */
class baseAction extends Action
{
	public $user_mode = ''; //用户模型
	public $user_info = ''; //用户模型
	public $admin_mod = ''; //管理员模型

	public $role_mod = ''; //权限表

	
	public $thumb_img_tag = '_list';
	public $ftp_upload_img = False;//是否需要FTP上传图片
	
	function _initialize()
	{

		$this->admin_mod = D ( 'admin' );
		$this->user_mode = D ( 'user' );
		$this->user_info = D ( 'user_info' );		
		
		//判断是否允许ip访问
		$banip = getBanip ();
		if ($banip)
		{
			foreach ( $banip as $key => $value )
			{
				banip ( $value [0], $value [1] );
			}
		}
		include ROOT_PATH . '/includes/lib_common.php';

		// 用户权限检查
		$this->check_priv ();
		
		//需要登陆
		$admin_info = $_SESSION ['admin_info'];
		
		$this->role_mod = D ( "role" );
		//获取用户角色
		$admin_level = $this->role_mod->field ( 'id', 'name' )->where ( 'id=' . $_SESSION ['admin_info'] ['role_id'] . '' )->find ();
		
		$this->assign ( 'admin_level', $admin_level );
		$this->assign ( 'my_info', $admin_info );
		
		// 顶部菜单(注意权限)
		$model = M ( "group" );
		$top_menu = $model->field ( 'id,title' )->where ( 'status=1' )->order ( 'sort ASC' )->select ();
		
		//如果是超级管理员
		if ($_SESSION ['admin_info'] ['id'] == 1)
		{
			//Noting
		} else
		{
			$role_access_mode = D ( 'access' );
			$r_id = intval ( $_SESSION ['admin_info'] ['role_id'] );
			//排开缓存管理177、178
			$res_g = $role_access_mode->query ( "select b.group_id from `cms_access` a,`cms_node` b where a.node_id=b.id and a.role_id=$r_id and b.id !=177 and b.id !=178 group by b.group_id" );
			foreach ( $res_g as $k => $v )
			{
				$res_g [$k] = $v ['group_id'];
			}
			foreach ( $top_menu as $k => $v )
			{
				if (! in_array ( $v ['id'], $res_g ))
				{
					unset ( $top_menu [$k] );
					continue;
				}
			}
		}
		$this->assign ( 'top_menu', $top_menu );
		
		//获取网站配置信息
		$setting_mod = M ( 'setting' );
		$setting = $setting_mod->select ();
		foreach ( $setting as $val )
		{
			$set [$val ['name']] = $val ['data'];
		}
		$this->setting = $set;
		
		$this->assign ( 'show_header', true );
		$this->assign ( 'const', get_defined_constants () );
		
		$this->assign ( 'iframe', $_REQUEST ['iframe'] );
		$def = array ('request' => $_REQUEST );
		$this->assign ( 'def', json_encode ( $def ) );
	}
	
	//检查权限
	public function check_priv($ajax = FALSE)
	{
		if ((! isset ( $_SESSION ['admin_info'] ) || ! $_SESSION ['admin_info']) && ! in_array ( ACTION_NAME, array ('login', 'verify_code' ) ))
		{
			if ($ajax)
			{
				$this->ajaxReturn ( '', '您无权操作此项！', - 1, 'JSON' );
			}
			$this->redirect ( 'public/login' );
		}
		
		//如果是超级管理员，则可以执行所有操作
		if ($_SESSION ['admin_info'] ['id'] == 1)
		{
			return true;
		}
		if (in_array ( ACTION_NAME, array ('status', 'sort' ) ))
		{
			return true;
		}
		
		//排除一些不必要的权限检查
		foreach ( C ( 'IGNORE_PRIV_LIST' ) as $key => $val )
		{
			if (MODULE_NAME == $val ['module_name'])
			{
				if (count ( $val ['action_list'] ) == 0)
					return true;
				
				foreach ( $val ['action_list'] as $action_item )
				{
					if (ACTION_NAME == $action_item)
						return true;
				}
			}
		}
		
		$node_mod = D ( 'node' );
		$node_id = $node_mod->where ( array ('module' => MODULE_NAME, 'action' => ACTION_NAME ) )->getField ( 'id' );
		
		$access_mod = D ( 'access' );
		$rel = $access_mod->where ( array ('node_id' => $node_id, 'role_id' => $_SESSION ['admin_info'] ['role_id'] ) )->count ();
		if (empty ( $rel ))
		{
			if ($ajax)
			{
				$this->ajaxReturn ( '', '您无权操作此项！', - 1, 'JSON' );
			}
			$this->check_accee_error = True;
			$this->error ( '您无权操作此项！' );
		}
		
	}
	
	//截取中文字符串
	public function mubstr($str, $start, $length)
	{
		import ( 'ORG.Util.String' );
		$a = new String ();
		$b = $a->msubstr ( $str, $start, $length );
		return ($b);
	}
	//失败页面重写
	protected function error($message, $url_forward = '', $ms = 3, $dialog = false, $ajax = false, $returnjs = '')
	{
		$this->jumpUrl = $url_forward;
		$this->waitSecond = $ms;
		$this->assign ( 'dialog', $dialog );
		$this->assign ( 'returnjs', $returnjs );
		
		if ($this->check_accee_error)
		{
			//权限错误不跳转
			$this->assign ( 'nojump', 'yes' );
		}
		parent::error ( $message, $ajax );
	}
	//成功页面重写
	protected function success($message, $url_forward = '', $ms = 3, $dialog = false, $ajax = false, $returnjs = '')
	{
		$this->jumpUrl = $url_forward;
		$this->waitSecond = $ms;
		$this->assign ( 'dialog', $dialog );
		$this->assign ( 'returnjs', $returnjs );
		parent::success ( $message, $ajax );
	}
	
	//后台日志记录
	public function admin_log($msg = '')
	{
		$time = time ();
		$ip = ip ();
		$uid = htmlspecialchars($_SESSION ['admin_info'] ['id']);
		$uname = htmlspecialchars($_SESSION ['admin_info'] ['user_name']);
		$logs_mod = D ( 'logs' );
		$msg = htmlspecialchars($msg);
		
		$_updateData = array ('uid' => $uid, 'uname' => $uname, 'ip' => $ip, 'add_time' => $time, 'msg' => $msg );
		$logs_mod->add ( $_updateData );
	}
	
	public function simplexml_obj2array($obj)
	{
		if ($obj instanceof SimpleXMLElement)
		{
			$obj = ( array ) $obj;
		}
		
		if (is_array ( $obj ))
		{
			$result = $keys = array ();
			foreach ( $obj as $key => $value )
			{
				isset ( $keys [$key] ) ? ($keys [$key] += 1) : ($keys [$key] = 1);
				
				if ($keys [$key] == 1)
				{
					$result [$key] = self::simplexml_obj2array ( $value );
				} elseif ($keys [$key] == 2)
				{
					$result [$key] = array ($result [$key], self::simplexml_obj2array ( $value ) );
				} else if ($keys [$key] > 2)
				{
					$result [$key] [] = self::simplexml_obj2array ( $value );
				}
			}
			return $result;
		} else
		{
			return $obj;
		}
	}
	public function saddslashes($value)
	{
		if (empty ( $value ))
		{
			return $value;
		} else
		{
			return is_array ( $value ) ? array_map ( array ('BaseAction', 'saddslashes' ), $value ) : addslashes ( $value );
		}
	}
	
	
	
	/**
	 * 
	 * 上传图片处理并且产生小图
	 * @param unknown_type $thumb_w 小图宽
	 * @param unknown_type $thumb_h 小图高
	 * @internal  $thumb_w、$thumb_h 0时不会生成小图
	 * $ori_w、 $ori_h 为需要的原图大小，如果给值将会压缩原图，为0时不会压缩
	 * 成功时:array('img_url')
	 */
	public function upload_img($ori_w = 0, $ori_h = 0, $thumb_w = 0, $thumb_h = 0,$file='')
	{
		if(empty($file))
		{
			$file = $_FILES['img'];
		}
		
		$uploadList = array ();
		
		import ( "ORG.Net.UploadFile" );
		$upload = new UploadFile ();
		
		//导入配置
		$uploadConfig = C('UPLOAD');
		
		//设置上传文件大小
		$upload->maxSize = $uploadConfig['fileSize'];
		$upload->allowExts = $uploadConfig['imgAllow'];
		$upload->savePath = ROOT_PATH.$uploadConfig['fileUploadPath'];
		
		$upload->saveRule = uniqid;
		if (! $upload->uploadOne($file,'','image'))
		{
			//捕获上传异常
			$uploadList = '图片上传错误：'.$upload->getErrorMsg ();
			return $uploadList;
		} else
		{
			//取得成功上传的文件信息
			$uploadList = $upload->getUploadFileInfo ();
			
			if (empty ( $uploadList [0] ['savename'] ))
			{
				$uploadList = '图片上传错误：文件上传失败！';
				return $uploadList;
			}
			$uploadList = reset ( $uploadList );
			
			$ori_img = $uploadList ['savepath'] . $uploadList ['savename'];
			
			//是否FTP上传图片
			if($this->ftp_upload_img)
			{
				$ftp = ftp ();
				if(!$ftp)
				{
					$uploadList = '图片上传错误：FTP无法连接!';
					
					//删除本地
					unlink ( $ori_img );
					
					return $uploadList;
				}
				$ftp_dir = explode ( '-', date ( 'Y-m-d' ) );
				$ftp_dir_path = $uploadConfig['ftpDir'] . $ftp_dir [0] . '/' . $ftp_dir [1] . '/' . $ftp_dir [2] . '/';				
			}
			
			//是否生成小图
			if ($thumb_w > 0 and $thumb_h > 0)
			{
				import ( 'ORG.Util.Image' );
				$save_name = reset ( explode ( '.', $uploadList ['savename'] ) );
				$save_name .= $this->thumb_img_tag . '.' . $uploadList ['extension'];
				$thumb_img = $uploadList ['savepath'] . $save_name;
				Image::thumb ( $ori_img, $thumb_img, $type = '', $thumb_w, $thumb_h );
				
				if($this->ftp_upload_img)
				{
					//FTP上传小图
					$remote = $ftp_dir_path . $save_name;
					
					$ftp->put ( $remote, $thumb_img );
					
					//删除本地
					unlink ( $thumb_img );					
				}
				
			}
			
			//是否还要压缩原图
			if ($ori_w > 0 and $ori_h > 0 and ($ori_w < $uploadList['width'] or $ori_h < $uploadList['height']))
			{
				import ( 'ORG.Util.Image' );
				Image::thumb ( $ori_img, $ori_img, $type = '', $ori_w, $ori_h );
			}
			
			if($this->ftp_upload_img)
			{
				//FTP上传原图
				$remote = $ftp_dir_path . $uploadList ['savename'];
				$ftp->put ( $remote, $ori_img );
				//删除本地
				unlink ( $ori_img );
				
				$uploadList ['img_url'] = $uploadConfig['imgDomain'] . $remote;				
			}else
			{
				$uploadList ['img_url'] = $uploadConfig['imgDomain'] . $uploadConfig['fileUploadPath'].$uploadList ['savename'];
			}
			
		}
		return $uploadList;
	}	
	
	
	
	/**
	 * 
	 * 通用的添加操作
	 */
	public function base_add()
	{
		$mod = D ( MODULE_NAME );
		
		$node_mod = D ( 'node' );
		$mod_info = $node_mod->where ( "module='" . MODULE_NAME . "'" )->find ();
		$msg = $mod_info ['module_name'] . ' 添加信息，名称:%s，ID:%s';
		
		if ($mod->create ())
		{
			$rel = $mod->add ();
			if (false !== $rel)
			{
				$_POST ['title'] = isset ( $_POST ['title'] ) ? $_POST ['title'] : '';
				$name = isset ( $_POST ['name'] ) ? $_POST ['name'] : $_POST ['title'];
				
				$this->admin_log ( sprintf ( $msg, $name, $rel ) );
				$this->success ( L ( 'operation_success' ), '', '', 'add' );
			} else
			{
				$this->error ( L ( 'operation_failure' ) );
			}
		} else
		{
			$this->error ( $mod->getError () );
		}
	}
	
	/**
	 * 
	 * 通用编辑操作
	 */
	public function base_edit()
	{
		$mod = D ( MODULE_NAME );
		
		$node_mod = D ( 'node' );
		$mod_info = $node_mod->where ( "module='" . MODULE_NAME . "'" )->find ();
		$msg = $mod_info ['module_name'] . ' 修改了信息，名称:%s，ID:%s';
		
		if (false === $mod->create ())
		{
			$this->error ( $mod->getError () );
		}
		$result = $mod->save ();
		if (false !== $result)
		{
			$_POST ['title'] = isset ( $_POST ['title'] ) ? $_POST ['title'] : '';
			$name = isset ( $_POST ['name'] ) ? $_POST ['name'] : $_POST ['title'];
			
			$this->admin_log ( sprintf ( $msg, $name, $_POST ['id'] ) );
			$this->success ( L ( 'operation_success' ), '', '', 'edit' );
		} else
		{
			$this->error ( L ( 'operation_failure' ) );
		}
	}
	
	/**
	 * 
	 * 通用删除操作
	 */
	public function delete()
	{
		$mod = D ( MODULE_NAME );
		
		$node_mod = D ( 'node' );
		$mod_info = $node_mod->where ( "module='" . MODULE_NAME . "'" )->find ();
		$msg = $mod_info ['module_name'] . ' 删除信息，名称:%s，ID:%s';
		
		$name = '';
		$result = FALSE;
		if (isset ( $_POST ['id'] ) && is_array ( $_POST ['id'] ))
		{
			foreach ( $_POST ['id'] as $k => $v )
			{
				$_POST ['id'] [$k] = abs ( intval ( $v ) );
			}
			$ids = implode ( ',', $_POST ['id'] );
			$info = $mod->field ( 'name' )->where ( "id in($ids)" )->select ();
			
			foreach ( $info as $v )
			{
				$name .= '[' . $v ['name'] . ']';
			}
			
			$result = $mod->delete ( $ids );
		} elseif (isset ( $_GET ['id'] ) and is_numeric ( $_GET ['id'] ))
		{
			$ids = intval ( $_GET ['id'] );
			$info = $mod->field ( 'name' )->where ( "id in($ids)" )->select ();
			
			foreach ( $info as $v )
			{
				$name .= '[' . $v ['name'] . ']';
			}
			$result = $mod->delete ( $ids );
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
	
	/**
	 * 
	 * 通用改变状态
	 */
	public function status()
	{
		$mod = D ( MODULE_NAME );
		$id = intval ( $_REQUEST ['id'] );
		$type = trim ( $_REQUEST ['type'] );
		
		//记录日志
		$node_mod = D ( 'node' );
		$mod_info = $node_mod->where ( "module='" . MODULE_NAME . "'" )->find ();
		$msg = $mod_info ['module_name'] . ' 改变状态信息，名称:%s，ID:%s';
		$info = $mod->where ( "id=$id" )->find ();
		$this->admin_log ( sprintf ( $msg, $info ['name'], $id, $type ) );
		
		$sql = "update " . C ( 'DB_PREFIX' ) . MODULE_NAME . " set $type=($type+1)%2 where id='$id' limit 1";
		$res = $mod->execute ( $sql );
		$values = $mod->where ( 'id=' . $id )->find ();
		$this->ajaxReturn ( $values [$type] );
	}
	
	/**
	 * 
	 * 通用排序方法单个排序
	 */
	public function sort()
	{
		$mod = D ( MODULE_NAME );
		$id = intval ( $_REQUEST ['id'] );
		$type = trim ( $_REQUEST ['type'] );
		$num = trim ( $_REQUEST ['num'] );
		if (! is_numeric ( $num ))
		{
			$values = $mod->where ( 'id=' . $id )->find ();
			$this->ajaxReturn ( $values [$type] );
			exit ();
		}
		
		//记录日志
		$node_mod = D ( 'node' );
		$mod_info = $node_mod->where ( "module='" . MODULE_NAME . "'" )->find ();
		$msg = $mod_info ['module_name'] . ' 改变排序，名称:%s，ID:%s，序值：%s';
		$info = $mod->where ( "id=$id" )->find ();
		$this->admin_log ( sprintf ( $msg, $info ['name'], $id, $num ) );
		
		$sql = "update " . C ( 'DB_PREFIX' ) . MODULE_NAME . " set $type=$num where id='$id' limit 1";
		
		$res = $mod->execute ( $sql );
		$values = $mod->where ( 'id=' . $id )->find ();
		$this->ajaxReturn ( $values [$type] );
	}
	
	public function check_res($result)
	{
		if ($result)
		{
			$this->success ( L ( 'operation_success' ) );
		} else
		{
			$this->error ( L ( 'operation_failure' ) );
		}
	}
	
	/*
	 * 通用检查值是否存在,存在则返回true
	 * */
	public function ajax_check_exist()
	{
		$mod = D ( MODULE_NAME );
		$clientid = $_REQUEST ['clientid'];
		if (! isset ( $clientid ))
			exit ();
		
		$clientid_val = $_REQUEST [$clientid];
		$id = intval ( $_REQUEST ['id'] );
		if ($id > 0)
		{
			//edit
			$where = "$clientid='$clientid_val' and id!=$id";
		} else
		{
			//add
			$where = "$clientid='$clientid_val'";
		}
		$this->ajaxReturn ( $mod->where ( $where )->count () > 0 );
	}
	/*
	 * 通用排序
	 * */
	public function sort_order()
	{
		$mod = D ( MODULE_NAME );
		if (isset ( $_POST ['listorders'] ))
		{
			foreach ( $_POST ['listorders'] as $id => $sort_order )
			{
				$data ['sort_order'] = $sort_order;
				$mod->where ( 'id=' . $id )->save ( $data );
			}
			$this->success ( L ( 'operation_success' ) );
		}
		$this->error ( L ( 'operation_failure' ) );
	}
	public function _stripcslashes($arr)
	{
		if (ini_get ( 'magic_quotes_gpc' ) != '1')
			return $arr;
		foreach ( $arr as $key => $val )
		{
			$arr [$key] = stripcslashes ( $val );
		}
		return $arr;
	}
	//返回分页信息
	public function pager($count, $pagesize = 20)
	{
		import ( "ORG.Util.Page" );
		$pager = new Page ( $count, $pagesize );
		$this->assign ( 'page', $pager->show () );
		return $pager;
	}
	public function append_user($res)
	{
		foreach ( $res as $key => $val )
		{
			$res [$key] ['user'] = $this->user_mode->where ( 'id=' . $val ['uid'] )->find ();
		}
		return $res;
	}
}