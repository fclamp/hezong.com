<?php
/**
 * 
 * 首页资讯信息管理
 * @author fc_lamp
 *
 */
class index_dataAction extends baseAction
{
	
	private $index_mode = NULL;
	
	private $role_id = 0;
	private $admin_uid = 0;
	private $admin_name = '';
	
	//内容区块
	private $data_cates = array(
		'1'=>array('name'=>'幻灯片','imgSize'=>array(2000,650),),
		'2'=>array('name'=>'企业概况','imgSize'=>array(400,200)),
		'3'=>array('name'=>'企业动态','imgSize'=>array(200,150)),
		'4'=>array('name'=>'工程案例','imgSize'=>array(200,200)),
	
	);
	//内容特点
	private $data_types = array(
		'0'=>'无',
		'1'=>'视频',
		'2'=>'图文'
	);
	
	public function _initialize()
	{
		parent::_initialize ();
		
		$this->role_id = intval ( $_SESSION ['admin_info'] ['role_id'] );
		$this->admin_uid = $_SESSION ['admin_info'] ['id'];
		$this->admin_name = $_SESSION ['admin_info'] ['user_name'];
		
		$this->index_mode = D ( 'index_data' );
	
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
		$status_types = array('-1'=>'--状态--','0'=>'草稿','1'=>'已发布');
		$this->assign ( 'status_types', $status_types );
		
		$this->assign ( 'data_cates', $this->data_cates );
		
		
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
		
		//分类
		if (isset ( $_GET ['c_id'] ) and array_key_exists ( $_GET ['c_id'], $this->data_cates ))
		{
			$c_id = abs ( intval ( $_GET ['c_id'] ) );
			$where .= " and catid =$c_id";
			$this->assign ( 'c_id', $c_id );
		}		
		

		//查询
		$article_table = $this->index_mode->getTableName ();
		$article_list = array ();
		$sql = "select count(id) as num from $article_table where $where ";
		//echo $sql;
		$count = $this->index_mode->query ( $sql );
		if (! empty ( $count [0] ['num'] ))
		{
			$p = $this->pager ( $count [0] ['num'], 25 );
			$order = 'sort desc,id desc';
			$limit = $p->firstRow . ',' . $p->listRows;
			$sql = "select id,catid,title,url,sort,status,author from $article_table where $where  order by $order limit $limit ";
			//echo $sql;
			$list = $this->index_mode->query ( $sql );

			foreach ($list as $k=>$v)
			{
				$v['title'] = htmlspecialchars(my_sub_char($v['title'],69));
				$v['catid'] = isset($this->data_cates[$v['catid']]) ? $this->data_cates[$v['catid']]['name'] : '';
				
				$list[$k] = $v;
			}
			
			
			$this->assign ( 'list', $list );
		}
	
		$this->display ();
	}
	
	/**
	 * 
	 * 添加信息
	 * @internal
	 * 
	 */
	function add()
	{
		set_time_limit ( 0 );		
		
		if (isset ( $_POST ['dosubmit'] ))
		{
			if (empty($_POST ['title']) or empty($_POST['url']))
			{
				$this->error ( '标题、连接不能为空！' );
			}
			
			
			if(empty($_POST['catid']) or !array_key_exists($_POST['catid'],$this->data_cates))
			{
				$this->error ( '请选择正确的内容区块！' );
			}
		
			
			if (false === $data = $this->index_mode->create ())
			{
				$this->error ( $this->index_mode->error () );
			}
			$data['catid'] = id($data['catid']);		
			//上传图片
			$data ['img'] = '';
			if ($_FILES ['img'] ['name'] != '')
			{  
				//获取相应的大小
				list($thumb_w,$thumb_h) = $this->data_cates[$data['catid']]['imgSize'];
				$upload_list = $this->upload_img ( $thumb_w, $thumb_h );
				if (is_array($upload_list) and isset($upload_list['img_url']))
				{
					$data ['img'] = $upload_list ['img_url'];
				}else
				{
					$this->error ( $upload_list );
				}
			}
			
			$data['title'] = htmlspecialchars($data['title']);
			$data['title2'] = htmlspecialchars($data['title2']);
			$data['url'] = htmlspecialchars($data['url']);
			$data['type'] = id($data['type']);
			$data['sort'] = id($data['sort']);
			$data['status'] = id($data['status']);
			$data ['author'] = $this->admin_name;
			$data ['push_time'] = time ();
			$data ['uid'] = $this->admin_uid;
			
			//简单去掉JS
			$rea = array(
				'/<\s*s\s*c\s*r\s*i\s*p\s*t\s*>.*?<\s*\/s\s*c\s*r\s*i\s*p\s*t\s*>/i',
				'/<.*?on[a-z]+[^>]*>/i',
			);
			$data ['abst'] = preg_replace($rea,'',$data['abst']);
			
			$article_id = $this->index_mode->add ( $data );
			if ($article_id)
			{
				//日志
				$this->admin_log ( '成功添加首页内容：ID'.$article_id );
				
				$this->success ( '添加成功', '', '', 'add' );
			} else
			{
				$this->error ( '添加失败' );
			}
		}

		$this->assign ( 'cate_list',$this->data_cates);
		$this->assign ( 'type_list',$this->data_types);
		
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
		$article_info = $this->index_mode->where ( 'id=' . $article_id )->find ();
		if (! isset ( $article_info ['id'] ))
		{
			$this->assign ( 'nojump', 'yes' );
			$this->error ( '此信息已不存在' );
		}
		
		if (isset ( $_POST ['dosubmit'] ))
		{

			if (empty($_POST ['title']) or empty($_POST['url']))
			{
				$this->error ( '标题、连接不能为空！' );
			}
			
			
			if(empty($_POST['catid']) or !array_key_exists($_POST['catid'],$this->data_cates))
			{
				$this->error ( '请选择正确的内容区块！' );
			}
		
			
			if (false === $data = $this->index_mode->create ())
			{
				$this->error ( $this->index_mode->error () );
			}
			$data['catid'] = id($data['catid']);
					
			//上传图片
			$old_img = '';
			if ($_FILES ['img'] ['name'] != '')
			{  
				//获取相应的大小
				list($thumb_w,$thumb_h) = $this->data_cates[$data['catid']]['imgSize'];
				$upload_list = $this->upload_img ( $thumb_w, $thumb_h );
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
			
			$data['title'] = htmlspecialchars($data['title']);
			$data['title2'] = htmlspecialchars($data['title2']);
			$data['url'] = htmlspecialchars($data['url']);
			$data['type'] = id($data['type']);
			$data['sort'] = id($data['sort']);
			$data['status'] = id($data['status']);
			$data ['author'] = $this->admin_name;
			$data ['push_time'] = time ();
			$data ['uid'] = $this->admin_uid;
			
			//简单去掉JS
			$rea = array(
				'/<\s*s\s*c\s*r\s*i\s*p\s*t\s*>.*?<\s*\/s\s*c\s*r\s*i\s*p\s*t\s*>/i',
				'/<.*?on[a-z]+[^>]*>/i',
			);
			$data ['abst'] = preg_replace($rea,'',$data['abst']);
			
			//更新主表
			$result = $this->index_mode->where ( 'id=' . $article_id )->save ( $data );
			
			
			//删除旧图片
			$this->delete_old_img($old_img);			
			
			//日志
			$this->admin_log ( '成功修改首页内容信息：ID'.$article_id );				
				
			$this->success ( '编辑成功', '', '', 'edit' );
			
		}		
		
		$this->assign ( 'cate_list',$this->data_cates);
		$this->assign ( 'type_list',$this->data_types);
		
		$this->assign('index_info',$article_info);
		
		$fileExts = C('UPLOAD');
		$this->assign('fileExts',implode(',',$fileExts['imgAllow']));
		
		$this->display ();
	
	}
	
	/**
	 * 删除信息
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
		
		
		//获取出文章主图片
		$all_imgs = array ();
		$tpl = $this->index_mode->field ( '`img`' )->where ( "`id` in($ids)" )->select ();
		foreach ( $tpl as $img )
		{
			$all_imgs [$img ['img']] = $img ['img'];
		}
		
		//删除信息
		$this->index_mode->where ( "`id` in($ids)" )->delete ();
		
		//删除旧图片
		foreach ($all_imgs as $img)
		{
			$this->delete_old_img($img);
		}
		
		
		//日志
		$this->admin_log ( '成功删除首页内容信息：ID'.$ids );
		
		$this->success ( L ( 'operation_success' ) );
	}
}