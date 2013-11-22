<?php

/**
 * 获取请求ip
 *
 * @return ip地址
 */
function ip()
{
	if (getenv ( 'HTTP_CLIENT_IP' ) && strcasecmp ( getenv ( 'HTTP_CLIENT_IP' ), 'unknown' ))
	{
		$ip = getenv ( 'HTTP_CLIENT_IP' );
	} elseif (getenv ( 'HTTP_X_FORWARDED_FOR' ) && strcasecmp ( getenv ( 'HTTP_X_FORWARDED_FOR' ), 'unknown' ))
	{
		$ip = getenv ( 'HTTP_X_FORWARDED_FOR' );
	} elseif (getenv ( 'REMOTE_ADDR' ) && strcasecmp ( getenv ( 'REMOTE_ADDR' ), 'unknown' ))
	{
		$ip = getenv ( 'REMOTE_ADDR' );
	} elseif (isset ( $_SERVER ['REMOTE_ADDR'] ) && $_SERVER ['REMOTE_ADDR'] && strcasecmp ( $_SERVER ['REMOTE_ADDR'], 'unknown' ))
	{
		$ip = $_SERVER ['REMOTE_ADDR'];
	}
	return preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
}

//删除商品图片和目录可以是数组或者文件
function delDirFile($path, $arr)
{
	if (is_array ( $arr ))
	{
		foreach ( $arr as $v )
		{
			$delPath = $path . '/' . $v;
			$allFile = scandir ( $delPath );
			foreach ( $allFile as $val )
			{
				if ($val != '.' || $val != '..')
				{
					$delfile = $delPath . '/' . $val;
					unlink ( $delfile );
				}
			}
			rmdir ( $delPath );
		}
	} else
	{
		$delfile = $path . '/' . $arr;
		unlink ( $delfile );
	}
}
//清除api缓存
function delCache($dir)
{ //删除目录
	$handle = opendir ( $dir );
	while ( $file = readdir ( $handle ) )
	{
		$bdir = $dir . '/' . $file;
		if (filetype ( $bdir ) == 'dir')
		{
			if ($file != '.' && $file != '..')
				delCache ( $bdir );
		} else
		{
			unlink ( $bdir );
		}
	}
	closedir ( $handle );
	rmdir ( $dir );
	return true;
}
//清除所有缓存新方法
function deleteCacheData($dir)
{
	$fileArr = file_list ( $dir );
	foreach ( $fileArr as $file )
	{
		if (strstr ( $file, "Logs" ) == false and file_exists ( $file ))
		{
			unlink ( $file );
		}
	}
}
function file_list($path)
{
	global $fileList;
	if ($handle = opendir ( $path ))
	{
		while ( false !== ($file = readdir ( $handle )) )
		{
			if ($file != "." && $file != "..")
			{
				if (is_dir ( $path . "/" . $file ))
				{
					
					file_list ( $path . "/" . $file );
				} else
				{
					//echo $path."/".$file."<br>";
					$fileList [] = $path . "/" . $file;
				}
			}
		}
	}
	return $fileList;
}

function url_parse($url)
{
	$rs = preg_match ( "/^(http:\/\/|https:\/\/)/", $url, $match );
	if (intval ( $rs ) == 0)
	{
		$url = "http://" . $url;
	}
	return $url;
}
function uimg($img)
{
	if (empty ( $img ))
	{
		return SITE_ROOT . "data/user/avatar.gif";
	}
	return $img;
}
//转换时间
function gmtTime()
{
	return date ( 'YmdHis' );
}
//如果不是二维数组返回true
function IsTwoArray($array)
{
	return count ( $array ) == count ( $array, 1 );
}

/*关键词替换*/

function ReplaceKeywords($content)
{
	if (empty ( $content ))
	{
		return ($content);
	}
	//获取屏蔽词语
	if (file_exists ( './data/word.txt' ))
	{
		$str = file_get_contents ( './data/word.txt' );
		$arrKeywords = explode ( ',', $str );
		$array_keywords = array ();
		foreach ( $arrKeywords as $key => $value )
		{
			$array_keywords [] = explode ( '|', $value );
		}
		foreach ( $array_keywords as $arr ) //遍历关键字
		{
			if (strpos ( $content, $arr [0] ) > - 1)
			{
				$content = preg_replace ( "/" . $arr [0] . "/i", $arr [1], $content );
				$arrTemp [] = $arr;
			}
		}
		return $content;
	} else
	{
		return $content;
	}

}
/**
 * $username 用户名
 
 * 
 * */




//表单过滤函数
function setFormString($_string)
{
	if (! get_magic_quotes_gpc ())
	{
		if (is_array ( $_string ))
		{
			foreach ( $_string as $_key => $_value )
			{
				$_string [$_key] = setFormString ( $_value ); //迭代调用
			}
		} else
		{
			return addslashes ( $_string ); //mysql_real_escape_string($_string, $_link);不支持就用代替addslashes();
		}
	}
	return $_string;
}
//对象表单选项转换
function setObjFormItem($_data, $_key, $_value)
{
	$_items = array ();
	if (is_array ( $_data ))
	{
		foreach ( $_data as $_v )
		{
			$_items [$_v->$_key] = $_v->$_value;
		}
	}
	return $_items;
}
//数组表单转换
function setArrayFormItem($_data, $_key, $_value)
{
	$_items = array ();
	if (is_array ( $_data ))
	{
		foreach ( $_data as $_v )
		{
			$_items [$_v [$_key]] = $_v [$_value];
		}
	}
	return $_items;
}



//屏蔽ip
function banip($value1, $value2)
{
	$ban_range_low = ip2long ( $value1 );
	$ban_range_up = ip2long ( $value2 );
	$ip = ip2long ( $_SERVER ["REMOTE_ADDR"] );
	if ($ip >= $ban_range_low && $ip <= $ban_range_up)
	{
		echo "对不起,您的IP在被禁止的IP段之中，禁止访问！";
		exit ();
	}
}
function getBanip()
{
	if (file_exists ( './data/banip_config_inc.php' ))
	{
		$banip = @file_get_contents ( './data/banip_config_inc.php' );
		$banip = unserialize ( $banip );
		return $banip;
	} else
	{
		return false;
	}
}
/*
*  获取用户头像
   m大 z中 s小
*/
function getUserFace($uid, $type = 's')
{
	$array = array ("80" => "m_", "60" => "z_", "35" => "s_" );
	
	if ($type == 'all')
	{
		foreach ( $array as $k => $v )
		{
			$facePath = "./data/user/{$uid}/{$v}{$uid}.jpg";
			if (file_exists ( $facePath ))
			{
				$face [$k] = "./data/user/{$uid}/{$array[$k]}{$uid}.jpg";
			} else
			{
				$face [$k] = "./data/user/{$array[$k]}avatar.gif";
			}
		}
		
		return $face;
	} else
	{
		$defaultFace = "./data/user/{$type}_avatar.gif";
		$newFace = "./data/user/{$uid}/{$type}_{$uid}.jpg";
		if (file_exists ( $newFace ))
			$face = "./data/user/{$uid}/{$type}_{$uid}.jpg";
		else
			$face = "./data/user/{$type}_avatar.gif";
		return $face;
	}
}

//返回毛利润率
function liru($real_in, $in)
{
	if (empty ( $in ) or $in == '0.00')
	{
		return '0.00%';
	}
	$s = ($real_in / $in) * 100;
	return sprintf ( '%6.2f', $s ) . '%';
}

/**
 * 
 * 获取分类名称
 * @param unknown_type $data 数据源
 * @param unknown_type $field 要获取的字段值
 * @param unknown_type $key 比较字段
 * @param unknown_type $value 比较字段值
 */
function get_tree_name($data, $field, $key, $value)
{
	$str = '';
	if (empty ( $data ))
	{
		return $str;
	}
	foreach ( $data as $v )
	{
		if (isset ( $v [$key] ) and $v [$key] == $value and isset ( $v [$field] ))
		{
			$str = $v [$field];
			return $str;
		}
		if (! empty ( $v ['items'] ))
		{
			$str .= get_tree_name ( $v ['items'], $field, $key, $value );
		}
	
	}
	return $str;
}

//分类树型下接框
function tree_select_option($data, $selected = 0, $other = '')
{
	
	$str = '';
	if (empty ( $data ))
	{
		return $str;
	}
	foreach ( $data as $v )
	{
		if (isset ( $v ['access'] ) and $v ['access'] == 'yes')
		{
			$str .= "<option value=\"{$v['id']}\" level=\"{$v['level']}\"";
			if (! empty ( $other ))
			{
				$str .= " data=\"{$v[$other]}\"";
			}
			if ($v ['id'] == $selected)
			{
				$str .= ' selected="selected"';
			}
			$str .= '>' . str_repeat ( '&nbsp;&nbsp;&nbsp;', $v ['level'] );
			
			$str .= "{$v['name']}</option>";
		}
		$str .= tree_select_option ( $v ['items'], $selected, $other );
	}
	return $str;
}

//以XLS导出数据
//$kn = array('id' => '订单编号','title'=>'项目') $ecs[] = array('id'=>0,'title'=>'')
//down_xls($ecs, $kn, 'fiel.xls');
function down_xls($data, $keynames, $name = 'dataxls')
{
	$xls [] = "<html><meta http-equiv=content-type content=\"text/html; charset=UTF-8\"><body><table border='1'>";
	$xls [] = "<tr><td>ID</td><td>" . implode ( "</td><td>", array_values ( $keynames ) ) . '</td></tr>';
	foreach ( $data as $o )
	{
		$line = array (++ $index );
		foreach ( $keynames as $k => $v )
		{
			$line [] = $o [$k];
		}
		$xls [] = '<tr><td>' . implode ( "</td><td>", $line ) . '</td></tr>';
	}
	$xls [] = '</table></body></html>';
	$xls = join ( "\r\n", $xls );
	header ( 'Content-Disposition: attachment; filename="' . $name . '.xls"' );
	die ( mb_convert_encoding ( $xls, 'UTF-8', 'UTF-8' ) );
}

/**
 * 
 * 访问权限页面上的显示
 * @param unknown_type $m
 * @param unknown_type $a
 * @return 1 有权限 -1无权限
 */
function is_access($m, $a)
{
	if($m=='cache' and $a=='index')
	{
		$a = 'clearCache';
	}
	
	$str = 1;
	
	if($_SESSION ['admin_info'] ['id'] == 1)
	{
		return $str;
	}	
	
	$node_mod = D ( 'node' );
	$access_mod = D ( 'access' );
	$node_id = $node_mod->where ( array ('module' => $m, 'action' => $a ) )->getField ( 'id' );
	$rel = $access_mod->where ( array ('node_id' => $node_id, 'role_id' => $_SESSION ['admin_info'] ['role_id'] ) )->count ();
	if (empty ( $rel ))
	{
		$str = - 1;
	}
	return $str;
}

/**
 * 
 * 过期提醒
 * @param unknown_type $e_time 结束时间
 * @param unknown_type $money 应该收总金额
 * @param unknown_type $income 实收总金额
 * @param unknown_type $day 距结束时间
 */
function expire_tip($e_time, $money, $income, $day = '+3 days')
{
	$now = time ();
	
	//未过期	
	if ($e_time >= $now)
	{
		if ($income >= $money)
		{
			return 'green';
		} else
		{
			$now_e_time = strtotime ( $day, $now );
			if ($now_e_time >= $e_time)
			{
				return '#ffcc00';
			}
		}
	
	} else
	{
		//过期
		if ($income >= $money)
		{
			return 'green';
		} else
		{
			return 'red';
		}
	
	}
	return '';
}



/**
 * 
 * 获取子记录数
 */
function get_child_num($id)
{
	$mode = D ( 'contract' );
	$res = $mode->field ( 'id' )->where ( "p_id=$id" )->count ();
	return $res;
}

