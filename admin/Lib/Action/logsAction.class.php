<?php
/**
 * 
 * 日志管理
 * @author fc_lamp
 *
 */
class logsAction extends baseAction
{
	//显示列表
	public function index()
	{
		clean_xss ( $_GET );
		$logs_mod = D ( 'logs' );
		$where = '1=1';
		//搜索
		if (isset ( $_GET ['search_type'] ) and array_key_exists ( $_GET ['search_type'], array ('uname' => 'uname', 'uid' => 'uid', 'msg' => 'msg' ) ))
		{
			if (! empty ( $_GET ['keyword'] ))
			{
				$keyword = $_GET ['keyword'];
				$field = $_GET ['search_type'];
				if ($field == 'msg')
				{
					$where .= " and $field like '%$keyword%'";
				} elseif ($field == 'uname')
				{
					$where .= " and $field='$keyword'";
				} elseif ($field == 'uid')
				{
					$keyword = abs ( intval ( $keyword ) );
					$where .= " and $field=$keyword";
				}
				
				$this->assign ( 'keyword', $keyword );
				$this->assign ( 'search_type', $_GET ['search_type'] );
			}
		
		}
		
		//时间
		if (! empty ( $_GET ['s_time'] ))
		{
			$s = strtotime ( $_GET ['s_time'] );
			$where .= " and add_time >= $s";
			$this->assign ( 's_time', $_GET ['s_time'] );
		}
		if (! empty ( $_GET ['e_time'] ))
		{
			$s = strtotime ( $_GET ['e_time'] );
			$where .= " and add_time <= $s";
			$this->assign ( 'e_time', $_GET ['e_time'] );
		}
		//echo $where;
		import ( "ORG.Util.Page" );
		$count = $logs_mod->where ( $where )->count ();
		
		if($count >0)
		{
			$p = new Page ( $count, 50 );
			$logs_list = $logs_mod->where ( $where )->limit ( $p->firstRow . ',' . $p->listRows )->order ( 'id desc' )->select ();
			$page = $p->show ();
			$this->assign ( 'page', $page );
			$this->assign ( 'logs_list', $logs_list );			
		}
		$this->display ();
	}
}