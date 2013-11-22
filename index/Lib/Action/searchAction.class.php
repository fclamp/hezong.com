<?php
/**
 * 
 * 搜索(以后可能会使用xunsou)
 * @author fc_lamp
 *
 */
class searchAction extends baseAction
{
	
	/**
	 * 
	 * 结果
	 * @internal
	 * 
	 */
	public function index()
	{
		clean_xss ( $_GET );
		$list = array();
		
		$total =0;
		
		if(!empty($_GET['keywords']))
		{
			$keywords = $_GET['keywords'];
			$where = "status=1 and title like '%$keywords%'";
			//查询
			$article_table = $this->article_mode->getTableName ();
			$article_list = array ();
			$sql = "select count(id) as num from $article_table where $where ";
			//echo $sql;
			$count = $this->article_mode->query ( $sql );
			if (! empty ( $count [0] ['num'] ))
			{
				$total = $count[0]['num'];
				$p = $this->pager ( $count [0] ['num'],10 );
				$order = 'sort desc,push_time desc';
				$limit = $p->firstRow . ',' . $p->listRows;
				$sql = "select id,catid,title,push_time,abst,img,author,attachment from $article_table where $where  order by $order limit $limit ";
				
				$list = $this->article_mode->query ( $sql );
				
				foreach ( $list as $k => $v )
				{
					$v ['push_time'] = date ( 'Y-m-d H:i:s', $v ['push_time'] );
					$v ['title'] = str_replace($_GET['keywords'], '<span class="c-red">'.$_GET['keywords'].'</span>',$v['title']);
					$v ['url'] = '/?a=showPage&m=index&id=' . $v ['id'];
					$v ['abst'] = my_sub_char ( $v ['abst'], 260 );
					
					$v ['abst'] = str_replace($_GET['keywords'], '<span class="c-red">'.$_GET['keywords'].'</span>',$v['abst']);
					
					if (! empty ( $v ['attachment'] ))
					{
						$v ['attachment'] = ROOT_URL . $v ['attachment'];
					}
					if(empty($v['img']))
					{
						$v['img'] = $this->default_img;
					}					
					
					$list [$k] = $v;
				}
				
				$this->assign ( 'list', $list );
			}			
			
			
		}
		if(empty($list))
		{
			/**
			//获取推荐
			$sql = "select id,title from $article_table order by sort desc,id desc limit 10 ";
			$list = $this->article_mode->query ( $sql );			
			foreach ($list as $k=>$v)
			{
				$v ['url'] = '/?a=showPage&m=index&id=' . $v ['id'];
				$list[$k] = $v;
			}
			$this->assign ( 'other_list', $list );
			**/
		}
		
		

		$this->assign('total',$total);
		
		//呈现列表
		$this->assign ( 'page_title', $_GET['keywords'] );
		$this->display ();
	
	}
}