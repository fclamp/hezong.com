<?php
/**
 * 
 * 资讯信息管理
 * @author fc_lamp
 *
 */
class articleAction extends baseAction
{
	
	protected  $article_mode = NULL;
	protected  $article_data_mode = NULL;
	
	private $role_id = 0;
	private $admin_uid = 0;
	private $admin_name = '';
	
	private $view_article_url = '';
	
	//图片相关(列表)
	public $thumb_w = 300;
	public $thumb_h = 300;
	
	//内容
	public $detail_w = 650;
	public $detail_h = 650;
	
	
	
	//附件上传地址
	public $attachmentPath = '/data/upload/';
	
	public $access_catgory = NULL;
	
	public function _initialize()
	{
		parent::_initialize ();
		
		//文章前台页面
		$this->view_article_url = '/?a=showPage&m=index&id=%s';
		
		$this->role_id = intval ( $_SESSION ['admin_info'] ['role_id'] );
		$this->admin_uid = $_SESSION ['admin_info'] ['id'];
		$this->admin_name = $_SESSION ['admin_info'] ['user_name'];
		
		$this->article_mode = D ( 'article' );
		$this->article_data_mode = D ( 'article_data' );
		
		
		//获取出权限相关栏目
		$access = D ( 'category_access' );
		$res = $access->field ( 'node_id,type' )->where ( 'role_id =' . $this->role_id )->select ();
		foreach ( $res as $v )
		{
			$this->access_catgory [$v ['node_id']] = $v ['node_id'];
		}
		$res = $access = NULL;		
		
	
	}
	
	/**
	 * 
	 * 列表页
	 * @internal
	 * 
	 */
	public function index()
	{
		clean_xss ( $_POST );
		clean_xss ( $_GET );
		
		$keyword_types = array ('title' => '标题', 'author' => '发布人' );
		$this->assign ( 'keyword_types', $keyword_types );
		$status_types = array('-1'=>'状态','0'=>'草稿','1'=>'已发布');
		$this->assign ( 'status_types', $status_types );
		
		
		//获取分类
		$category_mode = D ( 'category' );
		$category_list = $this->get_cate ( $category_mode, 0, 0, True, 1 );
		
		$this->assign ( 'category_list', $category_list );		
		
		
		//关键字
		$where = '1=1';
		if (! empty ( $_GET ['keyword'] ) and isset ( $_GET ['keyword_type'] ) and array_key_exists ( $_GET ['keyword_type'], $keyword_types ))
		{
			$keyword_type = $_GET ['keyword_type'];
			$this->assign ( 'keyword_type', $keyword_type );
			$where .= " AND `$keyword_type` LIKE '%" . $_GET ['keyword'] . "%'";
			$this->assign ( 'keyword', $_GET ['keyword'] );
		}
		//状态
		$post_status = -1;
		unset($status_types['-1']);
		if (isset ( $_GET ['status'] ) and array_key_exists($_GET['status'],$status_types))
		{
			$post_status = id ( $_GET ['status'] );
			$where .= ' AND `status`=' . $post_status;
		}
		$this->assign ( 'post_status', $post_status );
		
		//发布时间
		if (! empty ( $_GET ['s_t'] ))
		{
			$where .= ' AND push_time >=' . strtotime ( $_GET ['time_start'] );
			$this->assign ( 's_t', $_GET ['s_t'] );
		}
		if (! empty ( $_GET ['e_t'] ))
		{
			$where .= ' AND push_time<=' . strtotime ( $_GET ['time_end'] );
			$this->assign ( 'e_t', $_GET ['e_t'] );
		}
		
		//分类
		if (isset ( $_GET ['c_id'] ) and array_key_exists ( $_GET ['c_id'], $this->access_catgory ))
		{
			$c_id = abs ( intval ( $_GET ['c_id'] ) );
			//获取此分类下的所有子级
			$dids = $this->display_tree_ids( $this->get_cate ( $category_mode, $c_id, 0, True, 1 ) );
			$dids .= $c_id;
			$where .= " and catid in($dids)";
			$this->assign ( 'c_id', $c_id );
		} else
		{
			$dids = implode ( ',', $this->access_catgory );
			$where .= " and catid in($dids)";
		}		
		

		//查询
		$article_table = $this->article_mode->getTableName ();
		$article_list = array ();
		$sql = "select count(id) as num from $article_table where $where ";
		//echo $sql;
		$count = $this->article_mode->query ( $sql );
		if (! empty ( $count [0] ['num'] ))
		{
			$p = $this->pager ( $count [0] ['num'], 25 );
			$order = 'sort desc,push_time desc';
			$limit = $p->firstRow . ',' . $p->listRows;
			$sql = "select id,catid,title,push_time,sort,status,author,attachment from $article_table where $where  order by $order limit $limit ";
			//echo $sql;
			$list = $this->article_mode->query ( $sql );
			
			$cat_list = $this->display_tree_all($category_list);
			
			foreach ($list as $k=>$v)
			{
				$v['push_time'] = date('Y-m-d H:i:s',$v['push_time']);
				$v['title'] = htmlspecialchars(my_sub_char($v['title'],69));
				$v['view_url'] = sprintf($this->view_article_url,$v['id']);
				$v['catid'] = isset($cat_list[$v['catid']]) ? $cat_list[$v['catid']]['name'] : '';
				if(!empty($v['attachment']))
				{
					$v['attachment'] = ROOT_URL.$v['attachment'];
				}
				
				$list[$k] = $v;
			}
			
			
			$this->assign ( 'list', $list );
		}
	
		$this->display ();
	}
	
	/**
	 * 
	 * 添加文章
	 * @internal
	 * 
	 */
	function add()
	{
		set_time_limit ( 0 );		
		
		//获取分类
		$category_mode = D ( 'category' );
		$category_list = $this->get_cate ( $category_mode, 0, 0, True, 1 );	
		
		if (isset ( $_POST ['dosubmit'] ))
		{
			if ($_POST ['title'] == '')
			{
				$this->error ( '标题不能为空！' );
			}
			
			if(empty($_POST['catid']) or !array_key_exists($_POST['catid'],$this->access_catgory))
			{
				$this->error ( '请选择正确的分类！' );
			}
		
			
			if (false === $data = $this->article_mode->create ())
			{
				$this->error ( $this->article_mode->error () );
			}
					
			//上传图片
			$data ['img'] = '';
			if ($_FILES ['img'] ['name'] != '')
			{
				$upload_list = $this->upload_img ( $this->thumb_w, $this->thumb_h );
				if (is_array($upload_list) and isset($upload_list['img_url']))
				{
					$data ['img'] = $upload_list ['img_url'];
				}else
				{
					$this->error ( $upload_list );
				}
			}
			
			//如果有附件
			if ($_FILES ['attachment'] ['name'] != '')
			{
				$attachment = $this->upload_attachment();
				if (is_array($attachment) and isset($attachment['savepath']))
				{
					$data ['attachment'] = $attachment ['savepath'];
				}else
				{
					$this->error ( $attachment );
				}				
			}			
			
			
			$data['title'] = htmlspecialchars($data['title']);
			$data['sort'] = id($data['sort']);
			$data['status'] = id($data['status']);
			$data ['author'] = $this->admin_name;
			$data ['add_time'] = time ();
			$data ['uid'] = $this->admin_uid;
			$data ['push_time'] = strtotime ( $data ['push_time'] );
			$data ['from'] = htmlspecialchars($data['from']);
			//简单去掉JS
			$rea = array(
				'/<\s*s\s*c\s*r\s*i\s*p\s*t\s*>.*?<\s*\/s\s*c\s*r\s*i\s*p\s*t\s*>/i',
				'/<.*?on[a-z]+[^>]*>/i',
			);
			$data ['abst'] = preg_replace($rea,'',$data['abst']);
			
			$article_id = $this->article_mode->add ( $data );
			if ($article_id)
			{
				//更新副表
				$article_data = array ('info' => $_POST ['info'] );
				$article_data['info'] = preg_replace($rea,'',$article_data['info']);
				$article_data ['article_id'] = $article_id;
				$this->article_data_mode->add ( $article_data );
				
				//日志
				$this->admin_log ( '成功添加文章：ID'.$article_id );
				
				$this->success ( '添加成功', '', '', 'add' );
			} else
			{
				$this->error ( '添加失败' );
			}
		}
		$this->assign ( 'push_time', date ( 'Y-m-d H:i', time () ) );
		$this->assign ( 'cate_list',$category_list);
		
		$fileExts = C('UPLOAD');
		$this->assign('fileExts',implode(',',$fileExts['imgAllow']));
		
		$this->display ();
	}

	
	
	/**
	 * 
	 * 编辑文章
	 * @internal
	 * 
	 */
	function edit()
	{
		set_time_limit ( 0 );
		
		if (! isset ( $_REQUEST ['id'] ) or ! is_numeric ( $_REQUEST ['id'] ))
		{
			$this->assign ( 'nojump', 'yes' );
			$this->error ( '非法操作');
		}
		$article_id = id( $_REQUEST ['id'] );
		//主表
		$article_info = $this->article_mode->where ( 'id=' . $article_id )->find ();
		if (! isset ( $article_info ['id'] ))
		{
			$this->assign ( 'nojump', 'yes' );
			$this->error ( '此信息已不存在' );
		}
		//权限
		if(!array_key_exists($article_info['catid'],$this->access_catgory))
		{
			$this->assign ( 'nojump', 'yes' );
			$this->error ( '对不起，您的权限不足！' );
		}		
	
		//获取分类
		$category_mode = D ( 'category' );
		$category_list = $this->get_cate ( $category_mode, 0, 0, True, 1 );	
		
		if (isset ( $_POST ['dosubmit'] ))
		{
			if ($_POST ['title'] == '')
			{
				$this->error ( '标题不能为空！' );
			}
			
			if(empty($_POST['catid']) or !array_key_exists($_POST['catid'],$this->access_catgory))
			{
				$this->error ( '请选择正确的分类！' );
			}
		
			
			if (false === $data = $this->article_mode->create ())
			{
				$this->error ( $this->article_mode->error () );
			}
			
			//上传图片
			$old_img = '';
			if ($_FILES ['img'] ['name'] != '')
			{
				$upload_list = $this->upload_img ( $this->thumb_w, $this->thumb_h );
				if (is_array($upload_list) and isset($upload_list['img_url']))
				{
					$data ['img'] = $upload_list ['img_url'];
					$old_img = $article_info['img'];
					
				}else
				{
					$this->error ( $upload_list );
				}
			}elseif(isset($data['img']))
			{
				unset($data['img']);
			}
			
			//如果有附件
			$oldAttachment = '';
			if ($_FILES ['attachment'] ['name'] != '')
			{
				$attachment = $this->upload_attachment();
				if (is_array($attachment) and isset($attachment['savepath']))
				{
					$data ['attachment'] = $attachment ['savepath'];
					$oldAttachment = $article_info['attachment'];
				}else
				{
					$this->error ( $attachment );
				}				
			}elseif(isset($data['attachment']))
			{
				unset($data['attachment']);
			}			
			
			$data['title'] = htmlspecialchars($data['title']);
			$data['sort'] = id($data['sort']);
			$data['status'] = id($data['status']);
			$data ['author'] = $this->admin_name;
			$data ['uid'] = $this->admin_uid;
			$data ['push_time'] = strtotime ( $data ['push_time'] );
			$data ['from'] = htmlspecialchars($data['from']);
			//简单去掉JS
			$rea = array(
				'/<\s*s\s*c\s*r\s*i\s*p\s*t\s*>.*?<\s*\/s\s*c\s*r\s*i\s*p\s*t\s*>/i',
				'/<.*?on[a-z]+[^>]*>/i',
			);
			$data ['abst'] = preg_replace($rea,'',$data['abst']);
			
			//更新主表
			$result = $this->article_mode->where ( 'id=' . $article_id )->save ( $data );
			
			//更新副表
			$article_data = array ('info' => $_POST ['info'] );
			$article_data['info'] = preg_replace($rea,'',$article_data['info']);
			$_POST = NULL;
				
			$this->article_data_mode->where ( 'article_id=' . $article_id )->save ( $article_data );

			
			//删除旧的附件
			if(!empty($oldAttachment) and file_exists(ROOT_PATH.$oldAttachment))
			{
				unlink(ROOT_PATH.$oldAttachment);
			}

			//删除旧图片
			$this->delete_old_img($old_img);			
			
			//日志
			$this->admin_log ( '成功修改文章：ID'.$article_id );				
				
			$this->success ( '编辑成功', '', '', 'edit' );
			
		}		
		
		
		//获取附表
		$info = $this->article_data_mode->field ( 'info' )->where ( 'article_id=' . $article_id )->find ();
		$article_info ['info'] = $info ['info'];
		$article_info ['push_time'] = date ( 'Y-m-d H:i', $article_info ['push_time'] );
		$info = NULL;
		
		$this->assign('cate_list',$category_list);
		$article_info['attachment'] = $article_info['attachment']=='' ? '' : ROOT_URL.$article_info['attachment'];
		$this->assign ( 'article_info', $article_info );
		
		$fileExts = C('UPLOAD');
		$this->assign('fileExts',implode(',',$fileExts['imgAllow']));
		
		$this->display ();
	
	}
	
	/**
	 * 删除文章
	 * @internal
	 * 
	 * @see baseAction::delete()
	 */
	function delete()
	{
		clean_xss($_GET);
		clean_xss($_POST);
		
		if (empty ( $_POST ['id'] ) or ! is_array ( $_POST ['id'] ))
		{
			$this->assign ( 'nujump', 'yes' );
			$this->error ( '请选择要删除的资讯！' );
		}
		
		$ids = array ();
		foreach ( $_POST ['id'] as $val )
		{
			if (! is_numeric ( $val ))
			{
				//只要有一个不成功
				$this->assign ( 'nujump', 'yes' );
				$this->error ( 'ID非法！' );
			}
			$ids [$val] = id ( $val );
		}
		$ids_array = $ids;
		$ids = implode ( ',', $ids );
		
		$a_info = $this->article_mode->where("`id` in($ids)")->field('id,attachment,img')->select();
		if(empty($a_info))
		{
			$this->success ( L ( 'operation_success' ) );
		}
		$allimgs = $attachs = array();
		foreach ($a_info as $a)
		{
			$attachs[$a['attachment']] = $a['attachment'];
			$allimgs[$a['img']] = $a['img'];
		}
		$a_info = $a =NULL;
		
		$tpl = $this->article_data_mode->where("article_id in($ids)")->field('info')->select();
		foreach ($tpl as $t)
		{
			$imgs = get_c_imgs ($t['info']);
			foreach ( $imgs as $img )
			{
				$allimgs [$img] = $img;
			}			
		}
		$tpl = NULL;
		
		
		
		//删除文章
		$this->article_mode->where ( "`id` in($ids)" )->delete ();
		//删除附表中的数据
		$this->article_data_mode->where ( "article_id in($ids)" )->delete ();
		
		//删除附件
		foreach ($attachs as $a)
		{
			if(!empty($a) and file_exists(ROOT_PATH.$a))
			{
				unlink(ROOT_PATH.$a);
			}
		}
		
		//删除图片
		foreach ($allimgs as $img)
		{
			$this->delete_old_img($img);
		}
		
		//日志
		$this->admin_log ( '内容管理删除文章：ID'.$ids);	
		
	}
	
	/**
	 * 
	 * 资讯编辑器文件上传
	 * @internal
	 * 
	 */
	public function article_upload_img()
	{
		header ( 'Content-type: text/html; charset=UTF-8' );
		
		$data = array ('error' => 1, 'message' => '文件上传失败！' );
		//原图上传
		$upload_list = $this->upload_img ( $this->detail_w,$this->detail_h,0,0,$_FILES['imgFile']);
		if (is_array($upload_list) and isset($upload_list['img_url']))
		{
			$data ['error'] = 0;
			$data ['url'] = $upload_list ['img_url'];
			
			//日志
			$this->admin_log ( '编辑器文件上传');		
		} else
		{
			$data ['message'] = $upload_list;
		}
		
		echo json_encode ( $data );
		exit ();
	}
	
	
	/**
	 * 
	 * 上传附件
	 * @internal
	 * 
	 */
	private function upload_attachment()
	{
		
		$uploadList = array ();
		
		import ( "ORG.Net.UploadFile" );
		$upload = new UploadFile ();
		
		//设置上传文件大小
		$upload->maxSize = 5000000;
		$upload->allowExts = array ('zip', 'rar','tar' );
		$upload->savePath = ROOT_PATH.$this->attachmentPath;
		
		$upload->saveRule = uniqid;
		if (! $upload->uploadOne($_FILES ['attachment']))
		{
			//捕获上传异常
			$uploadList = $upload->getErrorMsg ();
			return $uploadList;
		} else
		{
			//取得成功上传的文件信息
			$uploadList = reset($upload->getUploadFileInfo ());
			$uploadList['savepath'] = $this->attachmentPath.$uploadList['savename'];
		}
		return $uploadList;
	}
	
	/**
	 * 
	 * 获取出分类信息(根据权限来获取)
	 * @param unknown_type $mod
	 * @param unknown_type $id 表示从哪一层开始
	 * @param unknown_type $level
	 * @param unknown_type $child
	 * @param unknown_type $field
	 * @param unknown_type $orderby
	 */
	private function get_cate($mod, $id = 0, $level = 0, $child = False, $type = 1, $field = '*', $orderby = '`sort` ASC,id DESC')
	{
		
		$all_list = $role_list = array ();
		//权限超级管理员一样受限(权限下所有分类)
		$ids = implode ( ',', $this->access_catgory );
		
		if (empty ( $ids ))
		{
			return $role_list;
		}
		$where = " `status`=1 and id in($ids)";
		$tpl_list = $mod->field ( $field )->where ( $where )->order ( $orderby )->select ();
		if (empty ( $tpl_list ))
		{
			return $role_list;
		}
		foreach ( $tpl_list as $v )
		{
			$v ['access'] = 'yes';
			$role_list [$v ['id']] = $v;
		}
		
		//获取所有的分类
		$tpl_list = $mod->field ( 'id,pid' )->select ();
		foreach ( $tpl_list as $v )
		{
			$all_list [$v ['id']] = $v;
		}
		$tpl_list = NULL;
		//根据层级关系补全分类（注意：权限）
		foreach ( $role_list as $v )
		{
			if (isset ( $all_list [$v ['pid']] ) and ! isset ( $role_list [$v ['pid']] ))
			{
				$role_list [$v ['pid']] = $all_list [$v ['pid']];
				
				$role_list [$v ['pid']] ['access'] = 'no';
			
			}
		}
		$all_list = NULL;
		
		//获取层级关系
		if ($child)
		{
			$this->cate_res = $role_list;
			$role_list = $this->create_tree_list ( $id, $level );
		}
		return $role_list;
	}
	
	/**
	 * 
	 * 产生层级列表
	 * @param unknown_type $pid
	 * @param unknown_type $level
	 */
	private function create_tree_list($pid = 0, $level = 0)
	{
		$childs = $list = array ();
		//找出数据源
		foreach ( $this->cate_res as $v )
		{
			if ($v ['pid'] == $pid)
			{
				$childs [] = $v;
			}
		}
		if (empty ( $childs ))
		{
			return array ();
		}
		$level ++;
		//写入数据 
		foreach ( $childs as $v )
		{
			$v ['level'] = $level;
			$v ['items'] = $this->create_tree_list ( $v ['id'], $level );
			$list [$v ['id']] = $v;
		}
		return $list;
	}

}