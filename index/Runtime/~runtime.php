<?php $GLOBALS['_beginTime'] = microtime(TRUE);
defined('ROOT_PATH') or define('ROOT_PATH','D:\\work\\hezong.com\\hezong.com');
defined('ROOT_URL') or define('ROOT_URL','http://www.hezong.com');
defined('THINK_PATH') or define('THINK_PATH','./includes/thinkphp/');
defined('APP_NAME') or define('APP_NAME','index');
defined('APP_PATH') or define('APP_PATH','./index/');
defined('MEMORY_LIMIT_ON') or define('MEMORY_LIMIT_ON',true);
defined('RUNTIME_PATH') or define('RUNTIME_PATH','./index/Runtime/');
defined('APP_DEBUG') or define('APP_DEBUG',false);
defined('RUNTIME_FILE') or define('RUNTIME_FILE','./index/Runtime/~runtime.php');
defined('THINK_VERSION') or define('THINK_VERSION','3.0');
defined('THINK_RELEASE') or define('THINK_RELEASE','20120305');
defined('MAGIC_QUOTES_GPC') or define('MAGIC_QUOTES_GPC',false);
defined('IS_CGI') or define('IS_CGI',0);
defined('IS_WIN') or define('IS_WIN',1);
defined('IS_CLI') or define('IS_CLI',0);
defined('_PHP_FILE_') or define('_PHP_FILE_','/index.php');
defined('__ROOT__') or define('__ROOT__','');
defined('URL_COMMON') or define('URL_COMMON',0);
defined('URL_PATHINFO') or define('URL_PATHINFO',1);
defined('URL_REWRITE') or define('URL_REWRITE',2);
defined('URL_COMPAT') or define('URL_COMPAT',3);
defined('CORE_PATH') or define('CORE_PATH','./includes/thinkphp/Lib/');
defined('EXTEND_PATH') or define('EXTEND_PATH','./includes/thinkphp/Extend/');
defined('MODE_PATH') or define('MODE_PATH','./includes/thinkphp/Extend/Mode/');
defined('ENGINE_PATH') or define('ENGINE_PATH','./includes/thinkphp/Extend/Engine/');
defined('VENDOR_PATH') or define('VENDOR_PATH','./includes/thinkphp/Extend/Vendor/');
defined('LIBRARY_PATH') or define('LIBRARY_PATH','./includes/thinkphp/Extend/Library/');
defined('COMMON_PATH') or define('COMMON_PATH','./index/Common/');
defined('LIB_PATH') or define('LIB_PATH','./index/Lib/');
defined('CONF_PATH') or define('CONF_PATH','./index/Conf/');
defined('LANG_PATH') or define('LANG_PATH','./index/Lang/');
defined('TMPL_PATH') or define('TMPL_PATH','./index/Tpl/');
defined('HTML_PATH') or define('HTML_PATH','./index/Html/');
defined('LOG_PATH') or define('LOG_PATH','./index/Runtime/Logs/');
defined('TEMP_PATH') or define('TEMP_PATH','./index/Runtime/Temp/');
defined('DATA_PATH') or define('DATA_PATH','./index/Runtime/Data/');
defined('CACHE_PATH') or define('CACHE_PATH','./index/Runtime/Cache/');

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: common.php 2797 2012-03-03 15:37:38Z liu21st $


/**
 +------------------------------------------------------------------------------
 * Think 基础函数库
 +------------------------------------------------------------------------------
 * @category   Think
 * @package  Common
 * @author   liu21st <liu21st@gmail.com>
 * @version  $Id: common.php 2797 2012-03-03 15:37:38Z liu21st $
 +------------------------------------------------------------------------------
 */

/**
 * 
 * 获取文章里的所有图片地址
 * @param $c 文章内容
 */
function get_c_imgs($c)
{
	$imgs = array ();
	if (preg_match_all ( "/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $c, $matches ))
	{
		return $matches [3];
	}
	return $imgs;
}


/**
 * 
 * 按字符长度截取
 * @param unknown_type $str
 * @param unknown_type $len
 * @param unknown_type $dot
 */
function my_sub_char($str, $len = 6, $dot = '...')
{
	if (strlen ( $str ) <= $len)
	{
		return $str;
	}
	$new_str = '';
	$i = 0;
	while ( True )
	{
		$new_str .= mb_substr ( $str, $i, 1, 'utf-8' );
		if (strlen ( $new_str ) > $len)
		{
			break;
		}
		$i ++;
	}
	return $new_str . $dot;
}



/**
 * 
 * 获取出所有合理状态下的连接
 * 
 * @internal
 * 0:顶部；1：底部;2：友情链接
 * @return array('tLinks'=>array(),'bLinks'=>array(),'flinks'=>array())
 * 
 */
function get_avalinks($fields='*')
{
	$array = array('tLinks'=>array(),'bLinks'=>array(),'flinks'=>array());
	$mode = D ( 'link' );
	$res = $mode->where ('status=1')->field($fields)->order('sort desc,id desc')->select();
	foreach ($res as $v)
	{
		//解析出a,m
		preg_match('/a=([a-z]+)/i',$v['url'],$match);
		if(!empty($match[1]))
		{
			$v['a'] = $match[1];
		}else
		{
			$v['a'] = '';
		}
		preg_match('/m=([a-z]+)/i',$v['url'],$match);
		if(!empty($match[1]))
		{
			$v['m'] = $match[1];
		}else
		{
			$v['m'] = '';
		}
		
		//解析出ID(文章id,分类cateid)
		preg_match('/(cateid|id)=([0-9]+)/i',$v['url'],$match);
		if(!empty($match[1]))
		{
			$v['uri_id'] = $match[2];
		}
		
		
		if($v['catid']==2)
		{
			$array['flinks'][] = $v;
		}elseif($v['catid']==1)
		{
			$array['bLinks'][] = $v;
		}elseif($v['catid']==0)
		{
			$array['tLinks'][] = $v;
		}
	}
	//var_dump($array);exit;
	return $array;
}

/**
 * 
 * 导入FTP类
 * @return ftp object
 */
function ftp()
{

	$uploadConfig = C('UPLOAD');
	
	vendor ( 'Ftps' );
	$ftp = new Ftps ();
	$f = $ftp->connect ( $uploadConfig['ftpHost'], $uploadConfig['ftpUser'],$uploadConfig['ftpPwd'], $uploadConfig['ftpPort'] );
	if(!$f)
	{
		return False;
	}
	return $ftp;
}


/**
 * 
 * 清除XSS
 * @param unknown_type $string
 */
function clean_xss(&$string,$simple=False)
{
	if (! is_array ( $string ))
	{
		$string = trim ( $string );
		$string = htmlspecialchars ( $string );		
		if($simple)
		{
			return True;
		}
		
		$string = strip_tags ( $string );
		$string = str_replace ( array ('"', "\\", "'", "/", "..", "../", "./", "//" ), '', $string );
		$no = '/%0[0-8bcef]/';
		$string = preg_replace ( $no, '', $string );
		$no = '/%1[0-9a-f]/';
		$string = preg_replace ( $no, '', $string );
		$no = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';
		$string = preg_replace ( $no, '', $string );
		return True;
	}
	$keys = array_keys ( $string );
	foreach ( $keys as $key )
	{
		clean_xss ( $string [$key],$simple);
	}
}




// 记录和统计时间（微秒）
function G($start, $end = '', $dec = 4)
{
	static $_info = array ();
	if (is_float ( $end ))
	{ // 记录时间
		$_info [$start] = $end;
	} elseif (! empty ( $end ))
	{ // 统计时间
		if (! isset ( $_info [$end] ))
			$_info [$end] = microtime ( TRUE );
		return number_format ( ($_info [$end] - $_info [$start]), $dec );
	} else
	{ // 记录时间
		$_info [$start] = microtime ( TRUE );
	}
}

// 设置和获取统计数据
function N($key, $step = 0)
{
	static $_num = array ();
	if (! isset ( $_num [$key] ))
	{
		$_num [$key] = 0;
	}
	if (empty ( $step ))
		return $_num [$key];
	else
		$_num [$key] = $_num [$key] + ( int ) $step;
}

/**
 +----------------------------------------------------------
 * 字符串命名风格转换
 * type
 * =0 将Java风格转换为C的风格
 * =1 将C风格转换为Java的风格
 +----------------------------------------------------------
 * @access protected
 +----------------------------------------------------------
 * @param string $name 字符串
 * @param integer $type 转换类型
 +----------------------------------------------------------
 * @return string
 +----------------------------------------------------------
 */
function parse_name($name, $type = 0)
{
	if ($type)
	{
		return ucfirst ( preg_replace ( "/_([a-zA-Z])/e", "strtoupper('\\1')", $name ) );
	} else
	{
		return strtolower ( trim ( preg_replace ( "/[A-Z]/", "_\\0", $name ), "_" ) );
	}
}

// 优化的require_once
function require_cache($filename)
{
	static $_importFiles = array ();
	if (! isset ( $_importFiles [$filename] ))
	{
		if (file_exists_case ( $filename ))
		{
			require $filename;
			$_importFiles [$filename] = true;
		} else
		{
			$_importFiles [$filename] = false;
		}
	}
	return $_importFiles [$filename];
}

// 区分大小写的文件存在判断
function file_exists_case($filename)
{
	if (is_file ( $filename ))
	{
		if (IS_WIN && C ( 'APP_FILE_CASE' ))
		{
			if (basename ( realpath ( $filename ) ) != basename ( $filename ))
				return false;
		}
		return true;
	}
	return false;
}

/**
 +----------------------------------------------------------
 * 导入所需的类库 同java的Import
 * 本函数有缓存功能
 +----------------------------------------------------------
 * @param string $class 类库命名空间字符串
 * @param string $baseUrl 起始路径
 * @param string $ext 导入的文件扩展名
 +----------------------------------------------------------
 * @return boolen
 +----------------------------------------------------------
 */
function import($class, $baseUrl = '', $ext = '.class.php')
{
	static $_file = array ();
	$class = str_replace ( array ('.', '#' ), array ('/', '.' ), $class );
	if ('' === $baseUrl && false === strpos ( $class, '/' ))
	{
		// 检查别名导入
		return alias_import ( $class );
	}
	if (isset ( $_file [$class . $baseUrl] ))
		return true;
	else
		$_file [$class . $baseUrl] = true;
	$class_strut = explode ( '/', $class );
	if (empty ( $baseUrl ))
	{
		if ('@' == $class_strut [0] || APP_NAME == $class_strut [0])
		{
			//加载当前项目应用类库
			$baseUrl = dirname ( LIB_PATH );
			$class = substr_replace ( $class, basename ( LIB_PATH ) . '/', 0, strlen ( $class_strut [0] ) + 1 );
		} elseif ('think' == strtolower ( $class_strut [0] ))
		{ // think 官方基类库
			$baseUrl = CORE_PATH;
			$class = substr ( $class, 6 );
		} elseif (in_array ( strtolower ( $class_strut [0] ), array ('org', 'com' ) ))
		{
			// org 第三方公共类库 com 企业公共类库
			$baseUrl = LIBRARY_PATH;
		} else
		{ // 加载其他项目应用类库
			$class = substr_replace ( $class, '', 0, strlen ( $class_strut [0] ) + 1 );
			$baseUrl = APP_PATH . '../' . $class_strut [0] . '/' . basename ( LIB_PATH ) . '/';
		}
	}
	if (substr ( $baseUrl, - 1 ) != '/')
		$baseUrl .= '/';
	$classfile = $baseUrl . $class . $ext;
	if (! class_exists ( basename ( $class ), false ))
	{
		// 如果类不存在 则导入类库文件
		return require_cache ( $classfile );
	}
}

/**
 +----------------------------------------------------------
 * 基于命名空间方式导入函数库
 * load('@.Util.Array')
 +----------------------------------------------------------
 * @param string $name 函数库命名空间字符串
 * @param string $baseUrl 起始路径
 * @param string $ext 导入的文件扩展名
 +----------------------------------------------------------
 * @return void
 +----------------------------------------------------------
 */
function load($name, $baseUrl = '', $ext = '.php')
{
	$name = str_replace ( array ('.', '#' ), array ('/', '.' ), $name );
	if (empty ( $baseUrl ))
	{
		if (0 === strpos ( $name, '@/' ))
		{
			//加载当前项目函数库
			$baseUrl = COMMON_PATH;
			$name = substr ( $name, 2 );
		} else
		{
			//加载ThinkPHP 系统函数库
			$baseUrl = EXTEND_PATH . 'Function/';
		}
	}
	if (substr ( $baseUrl, - 1 ) != '/')
		$baseUrl .= '/';
	require_cache ( $baseUrl . $name . $ext );
}

// 快速导入第三方框架类库
// 所有第三方框架的类库文件统一放到 系统的Vendor目录下面
// 并且默认都是以.php后缀导入
function vendor($class, $baseUrl = '', $ext = '.php')
{
	if (empty ( $baseUrl ))
		$baseUrl = VENDOR_PATH;
	return import ( $class, $baseUrl, $ext );
}

// 快速定义和导入别名
function alias_import($alias, $classfile = '')
{
	static $_alias = array ();
	if (is_string ( $alias ))
	{
		if (isset ( $_alias [$alias] ))
		{
			return require_cache ( $_alias [$alias] );
		} elseif ('' !== $classfile)
		{
			// 定义别名导入
			$_alias [$alias] = $classfile;
			return;
		}
	} elseif (is_array ( $alias ))
	{
		$_alias = array_merge ( $_alias, $alias );
		return;
	}
	return false;
}

/**
 +----------------------------------------------------------
 * D函数用于实例化Model 格式 项目://分组/模块
 +----------------------------------------------------------
 * @param string name Model资源地址
 +----------------------------------------------------------
 * @return Model
 +----------------------------------------------------------
 */
function D($name = '')
{
	if (empty ( $name ))
		return new Model ();
	static $_model = array ();
	if (isset ( $_model [$name] ))
		return $_model [$name];
	if (strpos ( $name, '://' ))
	{ // 指定项目
		$name = str_replace ( '://', '/Model/', $name );
	} else
	{
		$name = C ( 'DEFAULT_APP' ) . '/Model/' . $name;
	}
	import ( $name . 'Model' );
	$class = basename ( $name . 'Model' );
	if (class_exists ( $class ))
	{
		$model = new $class ();
	} else
	{
		$model = new Model ( basename ( $name ) );
	}
	$_model [$name] = $model;
	return $model;
}

/**
 +----------------------------------------------------------
 * M函数用于实例化一个没有模型文件的Model
 +----------------------------------------------------------
 * @param string name Model名称 支持指定基础模型 例如 MongoModel:User
 * @param string tablePrefix 表前缀
 * @param mixed $connection 数据库连接信息
 +----------------------------------------------------------
 * @return Model
 +----------------------------------------------------------
 */
function M($name = '', $tablePrefix = '', $connection = '')
{
	static $_model = array ();
	if (strpos ( $name, ':' ))
	{
		list ( $class, $name ) = explode ( ':', $name );
	} else
	{
		$class = 'Model';
	}
	if (! isset ( $_model [$name . '_' . $class] ))
		$_model [$name . '_' . $class] = new $class ( $name, $tablePrefix, $connection );
	return $_model [$name . '_' . $class];
}

/**
 +----------------------------------------------------------
 * A函数用于实例化Action 格式：[项目://][分组/]模块
 +----------------------------------------------------------
 * @param string name Action资源地址
 +----------------------------------------------------------
 * @return Action
 +----------------------------------------------------------
 */
function A($name)
{
	static $_action = array ();
	if (isset ( $_action [$name] ))
		return $_action [$name];
	if (strpos ( $name, '://' ))
	{ // 指定项目
		$name = str_replace ( '://', '/Action/', $name );
	} else
	{
		$name = '@/Action/' . $name;
	}
	import ( $name . 'Action' );
	$class = basename ( $name . 'Action' );
	if (class_exists ( $class, false ))
	{
		$action = new $class ();
		$_action [$name] = $action;
		return $action;
	} else
	{
		return false;
	}
}

// 远程调用模块的操作方法
// URL 参数格式 [项目://][分组/]模块/操作
function R($url, $vars = array())
{
	$info = pathinfo ( $url );
	$action = $info ['basename'];
	$module = $info ['dirname'];
	$class = A ( $module );
	if ($class)
		return call_user_func_array ( array (&$class, $action ), $vars );
	else
		return false;
}

// 获取和设置语言定义(不区分大小写)
function L($name = null, $value = null)
{
	static $_lang = array ();
	// 空参数返回所有定义
	if (empty ( $name ))
		return $_lang;
	
		// 判断语言获取(或设置)
	// 若不存在,直接返回全大写$name
	if (is_string ( $name ))
	{
		$name = strtoupper ( $name );
		if (is_null ( $value ))
			return isset ( $_lang [$name] ) ? $_lang [$name] : $name;
		$_lang [$name] = $value; // 语言定义
		return;
	}
	// 批量定义
	if (is_array ( $name ))
		$_lang = array_merge ( $_lang, array_change_key_case ( $name, CASE_UPPER ) );
	return;
}

// 获取配置值
function C($name = null, $value = null)
{
	static $_config = array ();
	// 无参数时获取所有
	if (empty ( $name ))
		return $_config;
	
		// 优先执行设置获取或赋值
	if (is_string ( $name ))
	{
		if (! strpos ( $name, '.' ))
		{
			$name = strtolower ( $name );
			if (is_null ( $value ))
				return isset ( $_config [$name] ) ? $_config [$name] : null;
			$_config [$name] = $value;
			return;
		}
		// 二维数组设置和获取支持
		$name = explode ( '.', $name );
		$name [0] = strtolower ( $name [0] );
		if (is_null ( $value ))
			return isset ( $_config [$name [0]] [$name [1]] ) ? $_config [$name [0]] [$name [1]] : null;
		$_config [$name [0]] [$name [1]] = $value;
		return;
	}
	// 批量设置
	if (is_array ( $name ))
	{
		return $_config = array_merge ( $_config, array_change_key_case ( $name ) );
	}
	return null; // 避免非法参数
}

// 处理标签扩展
function tag($tag, &$params = NULL)
{
	// 系统标签扩展
	$extends = C ( 'extends.' . $tag );
	// 应用标签扩展
	$tags = C ( 'tags.' . $tag );
	if (! empty ( $tags ))
	{
		if (empty ( $tags ['_overlay'] ) && ! empty ( $extends ))
		{ // 合并扩展
			$tags = array_unique ( array_merge ( $extends, $tags ) );
		} elseif (isset ( $tags ['_overlay'] ))
		{ // 通过设置 '_overlay'=>1 覆盖系统标签
			unset ( $tags ['_overlay'] );
		}
	} elseif (! empty ( $extends ))
	{
		$tags = $extends;
	}
	if ($tags)
	{
		if (APP_DEBUG)
		{
			G ( $tag . 'Start' );
			Log::record ( 'Tag[ ' . $tag . ' ] --START--', Log::INFO );
		}
		// 执行扩展
		foreach ( $tags as $key => $name )
		{
			if (! is_int ( $key ))
			{ // 指定行为类的完整路径 用于模式扩展
				$name = $key;
			}
			
			B ( $name, $params );
		}
		if (APP_DEBUG)
		{ // 记录行为的执行日志
			Log::record ( 'Tag[ ' . $tag . ' ] --END-- [ RunTime:' . G ( $tag . 'Start', $tag . 'End', 6 ) . 's ]', Log::INFO );
		}
	} else
	{ // 未执行任何行为 返回false
		return false;
	}
}

// 动态添加行为扩展到某个标签
function add_tag_behavior($tag, $behavior, $path = '')
{
	$array = C ( 'tags.' . $tag );
	if (! $array)
	{
		$array = array ();
	}
	if ($path)
	{
		$array [$behavior] = $path;
	} else
	{
		$array [] = $behavior;
	}
	C ( 'tags.' . $tag, $array );
}

// 过滤器方法
function filter($name, &$content)
{
	$class = $name . 'Filter';
	require_cache ( LIB_PATH . 'Filter/' . $class . '.class.php' );
	$filter = new $class ();
	$content = $filter->run ( $content );
}

// 执行行为
function B($name, &$params = NULL)
{
	$class = $name . 'Behavior';
	G ( 'behaviorStart' );
	$behavior = new $class ();
	$behavior->run ( $params );
	if (APP_DEBUG)
	{ // 记录行为的执行日志
		G ( 'behaviorEnd' );
		Log::record ( 'Run ' . $name . ' Behavior [ RunTime:' . G ( 'behaviorStart', 'behaviorEnd', 6 ) . 's ]', Log::INFO );
	}
}

// 渲染输出Widget
function W($name, $data = array(), $return = false)
{
	$class = $name . 'Widget';
	require_cache ( LIB_PATH . 'Widget/' . $class . '.class.php' );
	if (! class_exists ( $class ))
		throw_exception ( L ( '_CLASS_NOT_EXIST_' ) . ':' . $class );
	$widget = Think::instance ( $class );
	$content = $widget->render ( $data );
	if ($return)
		return $content;
	else
		echo $content;
}

// 去除代码中的空白和注释
function strip_whitespace($content)
{
	//由于清除缓存时，耗内存过大，因此直接返内容(20130123改)。
	return $content;
	$stripStr = '';
	//分析php源码
	$tokens = token_get_all ( $content );
	$last_space = false;
	for($i = 0, $j = count ( $tokens ); $i < $j; $i ++)
	{
		if (is_string ( $tokens [$i] ))
		{
			$last_space = false;
			$stripStr .= $tokens [$i];
		} else
		{
			switch ($tokens [$i] [0])
			{
				//过滤各种PHP注释
				case T_COMMENT :
				case T_DOC_COMMENT :
					break;
				//过滤空格
				case T_WHITESPACE :
					if (! $last_space)
					{
						$stripStr .= ' ';
						$last_space = true;
					}
					break;
				case T_START_HEREDOC :
					$stripStr .= "<<<THINK\n";
					break;
				case T_END_HEREDOC :
					$stripStr .= "THINK;\n";
					for($k = $i + 1; $k < $j; $k ++)
					{
						if (is_string ( $tokens [$k] ) && $tokens [$k] == ';')
						{
							$i = $k;
							break;
						} else if ($tokens [$k] [0] == T_CLOSE_TAG)
						{
							break;
						}
					}
					break;
				default :
					$last_space = false;
					$stripStr .= $tokens [$i] [1];
			}
		}
	}
	return $stripStr;
}

// 循环创建目录
function mk_dir($dir, $mode = 0777)
{
	if (is_dir ( $dir ) || @mkdir ( $dir, $mode ))
		return true;
	if (! mk_dir ( dirname ( $dir ), $mode ))
		return false;
	return @mkdir ( $dir, $mode );
}

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: Think.class.php 2791 2012-02-29 10:08:57Z liu21st $

/**
 +------------------------------------------------------------------------------
 * ThinkPHP Portal类
 +------------------------------------------------------------------------------
 * @category   Think
 * @package  Think
 * @subpackage  Core
 * @author    liu21st <liu21st@gmail.com>
 * @version   $Id: Think.class.php 2791 2012-02-29 10:08:57Z liu21st $
 +------------------------------------------------------------------------------
 */
class Think {

	private static $_instance = array();

	/**
	 +----------------------------------------------------------
	 * 应用程序初始化
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @return void
	 +----------------------------------------------------------
	 */
	static public function Start() {
		// 设定错误和异常处理
		set_error_handler(array('Think', 'appError'));
		set_exception_handler(array('Think', 'appException'));
		// 注册AUTOLOAD方法
		spl_autoload_register(array('Think', 'autoload'));
		
		// 运行应用
		App::run();
		return;
	}

	

	/**
	 +----------------------------------------------------------
	 * 系统自动加载ThinkPHP类库
	 * 并且支持配置自动加载路径
	 +----------------------------------------------------------
	 * @param string $class 对象类名
	 +----------------------------------------------------------
	 * @return void
	 +----------------------------------------------------------
	 */
	public static function autoload($class) {
		// 检查是否存在别名定义
		if (alias_import($class))
		return;

		if (substr($class, -8) == 'Behavior') { // 加载行为
			if (require_cache(CORE_PATH . 'Behavior/' . $class . '.class.php')
			|| require_cache(EXTEND_PATH . 'Behavior/' . $class . '.class.php')
			|| require_cache(LIB_PATH . 'Behavior/' . $class . '.class.php')
			|| (defined('MODE_NAME') && require_cache(MODE_PATH . ucwords(MODE_NAME) . '/Behavior/' . $class . '.class.php'))) {
				return;
			}
		} elseif (substr($class, -5) == 'Model') { // 加载模型
			if (require_cache(LIB_PATH . 'Model/' . $class . '.class.php')
			|| require_cache(EXTEND_PATH . 'Model/' . $class . '.class.php')) {
				return;
			}
		} elseif (substr($class, -6) == 'Action') { // 加载控制器
			if ((defined('GROUP_NAME') && require_cache(LIB_PATH . 'Action/' . GROUP_NAME . '/' . $class . '.class.php'))
			|| require_cache(LIB_PATH . 'Action/' . $class . '.class.php')
			|| require_cache(EXTEND_PATH . 'Action/' . $class . '.class.php')) {
				return;
			}
		}

		// 根据自动加载路径设置进行尝试搜索
		$paths = explode(',', C('APP_AUTOLOAD_PATH'));
		foreach ($paths as $path) {
			if (import($path . '.' . $class))
			// 如果加载类成功则返回
			return;
		}
	}

	/**
	 +----------------------------------------------------------
	 * 取得对象实例 支持调用类的静态方法
	 +----------------------------------------------------------
	 * @param string $class 对象类名
	 * @param string $method 类的静态方法名
	 +----------------------------------------------------------
	 * @return object
	 +----------------------------------------------------------
	 */
	static public function instance($class, $method = '') {
		$identify = $class . $method;
		if (!isset(self::$_instance[$identify])) {
			if (class_exists($class)) {
				$o = new $class();
				if (!empty($method) && method_exists($o, $method))
				self::$_instance[$identify] = call_user_func_array(array(&$o, $method));
				else
				self::$_instance[$identify] = $o;
			}
			else
			halt(L('_CLASS_NOT_EXIST_') . ':' . $class);
		}
		return self::$_instance[$identify];
	}

	/**
	 +----------------------------------------------------------
	 * 自定义异常处理
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @param mixed $e 异常对象
	 +----------------------------------------------------------
	 */
	static public function appException($e) {
		halt($e->__toString());
	}

	/**
	 +----------------------------------------------------------
	 * 自定义错误处理
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @param int $errno 错误类型
	 * @param string $errstr 错误信息
	 * @param string $errfile 错误文件
	 * @param int $errline 错误行数
	 +----------------------------------------------------------
	 * @return void
	 +----------------------------------------------------------
	 */
	static public function appError($errno, $errstr, $errfile, $errline) {
		switch ($errno) {
			case E_ERROR:
			case E_USER_ERROR:
				$errorStr = "[$errno] $errstr " . basename($errfile) . " 第 $errline 行.";
				if (C('LOG_RECORD'))
				Log::write($errorStr, Log::ERR);
				halt($errorStr);
				break;
			case E_STRICT:
			case E_USER_WARNING:
			case E_USER_NOTICE:
			default:
				$errorStr = "[$errno] $errstr " . basename($errfile) . " 第 $errline 行.";
				Log::record($errorStr, Log::NOTICE);
				break;
		}
	}

	/**
	 +----------------------------------------------------------
	 * 自动变量设置
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @param $name 属性名称
	 * @param $value  属性值
	 +----------------------------------------------------------
	 */
	public function __set($name, $value) {
		if (property_exists($this, $name))
		$this->$name = $value;
	}

	/**
	 +----------------------------------------------------------
	 * 自动变量获取
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @param $name 属性名称
	 +----------------------------------------------------------
	 * @return mixed
	 +----------------------------------------------------------
	 */
	public function __get($name) {
		return isset($this->$name) ? $this->$name : null;
	}

}
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: ThinkException.class.php 2791 2012-02-29 10:08:57Z liu21st $

/**
 +------------------------------------------------------------------------------
 * ThinkPHP系统异常基类
 +------------------------------------------------------------------------------
 * @category   Think
 * @package  Think
 * @subpackage  Exception
 * @author    liu21st <liu21st@gmail.com>
 * @version   $Id: ThinkException.class.php 2791 2012-02-29 10:08:57Z liu21st $
 +------------------------------------------------------------------------------
 */
class ThinkException extends Exception {

	/**
	 +----------------------------------------------------------
	 * 异常类型
	 +----------------------------------------------------------
	 * @var string
	 * @access private
	 +----------------------------------------------------------
	 */
	private $type;

	// 是否存在多余调试信息
	private $extra;

	/**
	 +----------------------------------------------------------
	 * 架构函数
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @param string $message  异常信息
	 +----------------------------------------------------------
	 */
	public function __construct($message,$code=0,$extra=false) {
		parent::__construct($message,$code);
		$this->type = get_class($this);
		$this->extra = $extra;
	}

	/**
	 +----------------------------------------------------------
	 * 异常输出 所有异常处理类均通过__toString方法输出错误
	 * 每次异常都会写入系统日志
	 * 该方法可以被子类重载
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @return array
	 +----------------------------------------------------------
	 */
	public function __toString() {
		$trace = $this->getTrace();
		if($this->extra)
		// 通过throw_exception抛出的异常要去掉多余的调试信息
		array_shift($trace);
		$this->class = $trace[0]['class'];
		$this->function = $trace[0]['function'];
		$this->file = $trace[0]['file'];
		$this->line = $trace[0]['line'];
		$file   =   file($this->file);
		$traceInfo='';
		$time = date('y-m-d H:i:m');
		foreach($trace as $t) {
			$traceInfo .= '['.$time.'] '.$t['file'].' ('.$t['line'].') ';
			$traceInfo .= $t['class'].$t['type'].$t['function'].'(';
			$traceInfo .= implode(', ', $t['args']);
			$traceInfo .=")\n";
		}
		$error['message']   = $this->message;
		$error['type']      = $this->type;
		$error['detail']    = L('_MODULE_').'['.MODULE_NAME.'] '.L('_ACTION_').'['.ACTION_NAME.']'."\n";
		$error['detail']   .=   ($this->line-2).': '.$file[$this->line-3];
		$error['detail']   .=   ($this->line-1).': '.$file[$this->line-2];
		$error['detail']   .=   '<font color="#FF6600" >'.($this->line).': <strong>'.$file[$this->line-1].'</strong></font>';
		$error['detail']   .=   ($this->line+1).': '.$file[$this->line];
		$error['detail']   .=   ($this->line+2).': '.$file[$this->line+1];
		$error['class']     =   $this->class;
		$error['function']  =   $this->function;
		$error['file']      = $this->file;
		$error['line']      = $this->line;
		$error['trace']     = $traceInfo;

		// 记录 Exception 日志
		if(C('LOG_EXCEPTION_RECORD')) {
			Log::Write('('.$this->type.') '.$this->message);
		}
		return $error ;
	}

}
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: Behavior.class.php 2702 2012-02-02 12:35:01Z liu21st $

/**
 +------------------------------------------------------------------------------
 * ThinkPHP Behavior基础类
 +------------------------------------------------------------------------------
 * @category   Think
 * @package  Think
 * @subpackage  Util
 * @author liu21st <liu21st@gmail.com>
 * @version  $Id: Behavior.class.php 2702 2012-02-02 12:35:01Z liu21st $
 +------------------------------------------------------------------------------
 */
abstract class Behavior {

	// 行为参数 和配置参数设置相同
	protected $options =  array();

	/**
	 +----------------------------------------------------------
	 * 架构函数
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 */
	public function __construct() {
		if(!empty($this->options)) {
			foreach ($this->options as $name=>$val){
				if(NULL !== C($name)) { // 参数已设置 则覆盖行为参数
					$this->options[$name]  =  C($name);
				}else{ // 参数未设置 则传入默认值到配置
					C($name,$val);
				}
			}
			array_change_key_case($this->options);
		}
	}

	// 获取行为参数
	public function __get($name){
		return $this->options[strtolower($name)];
	}

	/**
	 +----------------------------------------------------------
	 * 执行行为 run方法是Behavior唯一的接口
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @param mixed $params  行为参数
	 +----------------------------------------------------------
	 * @return void
	 +----------------------------------------------------------
	 */
	abstract public function run(&$params);

}
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: ReadHtmlCacheBehavior.class.php 2744 2012-02-18 11:27:14Z liu21st $

/**
 +------------------------------------------------------------------------------
 * 系统行为扩展 静态缓存读取
 +------------------------------------------------------------------------------
 */
class ReadHtmlCacheBehavior extends Behavior {
	protected $options   =  array(
            'HTML_CACHE_ON'=>false,
            'HTML_CACHE_TIME'=>60,
            'HTML_CACHE_RULES'=>array(),
            'HTML_FILE_SUFFIX'=>'.html',
	);

	// 行为扩展的执行入口必须是run
	public function run(&$params){
		// 开启静态缓存
		if(C('HTML_CACHE_ON'))  {
			if(($cacheTime = $this->requireHtmlCache()) && $this->checkHTMLCache(HTML_FILE_NAME,$cacheTime)) { //静态页面有效
				// 读取静态页面输出
				readfile(HTML_FILE_NAME);
				exit();
			}
		}
	}

	// 判断是否需要静态缓存
	static private function requireHtmlCache() {
		// 分析当前的静态规则
		$htmls = C('HTML_CACHE_RULES'); // 读取静态规则
		if(!empty($htmls)) {
			// 静态规则文件定义格式 actionName=>array(‘静态规则’,’缓存时间’,’附加规则')
			// 'read'=>array('{id},{name}',60,'md5') 必须保证静态规则的唯一性 和 可判断性
			// 检测静态规则
			$moduleName = strtolower(MODULE_NAME);
			if(isset($htmls[$moduleName.':'.ACTION_NAME])) {
				$html   =   $htmls[$moduleName.':'.ACTION_NAME];   // 某个模块的操作的静态规则
			}elseif(isset($htmls[$moduleName.':'])){// 某个模块的静态规则
				$html   =   $htmls[$moduleName.':'];
			}elseif(isset($htmls[ACTION_NAME])){
				$html   =   $htmls[ACTION_NAME]; // 所有操作的静态规则
			}elseif(isset($htmls['*'])){
				$html   =   $htmls['*']; // 全局静态规则
			}elseif(isset($htmls['empty:index']) && !class_exists(MODULE_NAME.'Action')){
				$html   =    $htmls['empty:index']; // 空模块静态规则
			}elseif(isset($htmls[$moduleName.':_empty']) && $this->isEmptyAction(MODULE_NAME,ACTION_NAME)){
				$html   =    $htmls[$moduleName.':_empty']; // 空操作静态规则
			}
			if(!empty($html)) {
				// 解读静态规则
				$rule    = $html[0];
				// 以$_开头的系统变量
				$rule  = preg_replace('/{\$(_\w+)\.(\w+)\|(\w+)}/e',"\\3(\$\\1['\\2'])",$rule);
				$rule  = preg_replace('/{\$(_\w+)\.(\w+)}/e',"\$\\1['\\2']",$rule);
				// {ID|FUN} GET变量的简写
				$rule  = preg_replace('/{(\w+)\|(\w+)}/e',"\\2(\$_GET['\\1'])",$rule);
				$rule  = preg_replace('/{(\w+)}/e',"\$_GET['\\1']",$rule);
				// 特殊系统变量
				$rule  = str_ireplace(
				array('{:app}','{:module}','{:action}','{:group}'),
				array(APP_NAME,MODULE_NAME,ACTION_NAME,defined('GROUP_NAME')?GROUP_NAME:''),
				$rule);
				// {|FUN} 单独使用函数
				$rule  = preg_replace('/{|(\w+)}/e',"\\1()",$rule);
				if(!empty($html[2])) $rule    =   $html[2]($rule); // 应用附加函数
				$cacheTime = isset($html[1])?$html[1]:C('HTML_CACHE_TIME'); // 缓存有效期
				// 当前缓存文件
				define('HTML_FILE_NAME',HTML_PATH . $rule.C('HTML_FILE_SUFFIX'));
				return $cacheTime;
			}
		}
		// 无需缓存
		return false;
	}

	/**
	 +----------------------------------------------------------
	 * 检查静态HTML文件是否有效
	 * 如果无效需要重新更新
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @param string $cacheFile  静态文件名
	 * @param integer $cacheTime  缓存有效期
	 +----------------------------------------------------------
	 * @return boolen
	 +----------------------------------------------------------
	 */
	static public function checkHTMLCache($cacheFile='',$cacheTime='') {
		if(!is_file($cacheFile)){
			return false;
		}elseif (filemtime(C('TEMPLATE_NAME')) > filemtime($cacheFile)) {
			// 模板文件如果更新静态文件需要更新
			return false;
		}elseif(!is_numeric($cacheTime) && function_exists($cacheTime)){
			return $cacheTime($cacheFile);
		}elseif ($cacheTime != 0 && time() > filemtime($cacheFile)+$cacheTime) {
			// 文件是否在有效期
			return false;
		}
		//静态文件有效
		return true;
	}

	//检测是否是空操作
	static private function isEmptyAction($module,$action) {
		$className =  $module.'Action';
		$class=new $className;
		return !method_exists($class,$action);
	}

}
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: CheckRouteBehavior.class.php 2731 2012-02-14 04:35:43Z liu21st $

/**
 +------------------------------------------------------------------------------
 * 系统行为扩展 路由检测
 +------------------------------------------------------------------------------
 */
class CheckRouteBehavior extends Behavior {
    // 行为参数定义（默认值） 可在项目配置中覆盖
    protected $options   =  array(
        'URL_ROUTER_ON'         => false,   // 是否开启URL路由
        'URL_ROUTE_RULES'       => array(), // 默认路由规则，注：分组配置无法替代
        );

    // 行为扩展的执行入口必须是run
    public function run(&$return){
        // 优先检测是否存在PATH_INFO
        $regx = trim($_SERVER['PATH_INFO'],'/');
        //print_r($regx);exit;
        if(empty($regx)) return $return = true;
        // 是否开启路由使用
        if(!C('URL_ROUTER_ON')) return $return = false;
        // 路由定义文件优先于config中的配置定义
        $routes = C('URL_ROUTE_RULES');
        //print_r($routes);exit; 
        // 路由处理 
        
        if(!empty($routes)) {
            $depr = C('URL_PATHINFO_DEPR');
            // 分隔符替换 确保路由定义使用统一的分隔符
            $regx = str_replace($depr,'/',$regx);
            foreach ($routes as $rule=>$route){
                if(0===strpos($rule,'/') && preg_match($rule,$regx,$matches)) { // 正则路由
                    
                    return $return = $this->parseRegex($matches,$route,$regx);
                }else{ // 规则路由
                    $len1=   substr_count($regx,'/');
                    $len2 =  substr_count($rule,'/');
                    //print_r($regx."<br>");
                    //print_r($rule);exit;
                    //var_dump($len1>=$len2);exit;
                    if($len1>=$len2) {
                        if('$' == substr($rule,-1,1)) {// 完整匹配
                            if($len1 != $len2) {
                                continue;
                            }else{
                                $rule =  substr($rule,0,-1);
                            }
                        }
                        $match  =  $this->checkUrlMatch($regx,$rule);
                        if($match)  return $return = $this->parseRule($rule,$route,$regx);
                    }
                }
            }
        }
        $return = false;
    }

    // 检测URL和规则路由是否匹配
    private function checkUrlMatch($regx,$rule) {
        $m1 = explode('/',$regx);
        $m2 = explode('/',$rule);
        $match = true; // 是否匹配
        foreach ($m2 as $key=>$val){
            if(':' == substr($val,0,1)) {// 动态变量
                if(strpos($val,'\\')) {
                    $type = substr($val,-1);
                    if('d'==$type && !is_numeric($m1[$key])) {
                        $match = false;
                        break;
                    }
                }elseif(strpos($val,'^')){
                    $array   =  explode('|',substr(strstr($val,'^'),1));
                    if(in_array($m1[$key],$array)) {
                        $match = false;
                        break;
                    }
                }
            }elseif(0 !== strcasecmp($val,$m1[$key])){
                $match = false;
                break;
            }
        }
        return $match;
    }

    // 解析规范的路由地址
    // 地址格式 [分组/模块/操作?]参数1=值1&参数2=值2...
    private function parseUrl($url) {
        $var  =  array();
        if(false !== strpos($url,'?')) { // [分组/模块/操作?]参数1=值1&参数2=值2...
            $info   =  parse_url($url);
            $path = explode('/',$info['path']);
            parse_str($info['query'],$var);
        }elseif(strpos($url,'/')){ // [分组/模块/操作]
            $path = explode('/',$url);
        }else{ // 参数1=值1&参数2=值2...
            parse_str($url,$var);
        }
        if(isset($path)) {
            $var[C('VAR_ACTION')] = array_pop($path);
            if(!empty($path)) {
                $var[C('VAR_MODULE')] = array_pop($path);
            }
            if(!empty($path)) {
                $var[C('VAR_GROUP')]  = array_pop($path);
            }
        }
        return $var;
    }

    // 解析规则路由
    // '路由规则'=>'[分组/模块/操作]?额外参数1=值1&额外参数2=值2...'
    // '路由规则'=>array('[分组/模块/操作]','额外参数1=值1&额外参数2=值2...')
    // '路由规则'=>'外部地址'
    // '路由规则'=>array('外部地址','重定向代码')
    // 路由规则中 :开头 表示动态变量
    // 外部地址中可以用动态变量 采用 :1 :2 的方式
    // 'news/:month/:day/:id'=>array('News/read?cate=1','status=1'),
    // 'new/:id'=>array('/new.php?id=:1',301), 重定向
    private function parseRule($rule,$route,$regx) {
        // 获取路由地址规则
        $url   =  is_array($route)?$route[0]:$route;
        // 获取URL地址中的参数
        $paths = explode('/',$regx);
        // 解析路由规则
        $matches  =  array();
        $rule =  explode('/',$rule);
        foreach ($rule as $item){
            if(0===strpos($item,':')) { // 动态变量获取
                if($pos = strpos($item,'^') ) {
                    $var  =  substr($item,1,$pos-1);
                }elseif(strpos($item,'\\')){
                    $var  =  substr($item,1,-2);
                }else{
                    $var  =  substr($item,1);
                }
                $matches[$var] = array_shift($paths);
            }else{ // 过滤URL中的静态变量
                array_shift($paths);
            }
        }
        if(0=== strpos($url,'/') || 0===strpos($url,'http')) { // 路由重定向跳转
            if(strpos($url,':')) { // 传递动态参数
                $values  =  array_values($matches);
                $url  =  preg_replace('/:(\d)/e','$values[\\1-1]',$url);
            }
            header("Location: $url", true,(is_array($route) && isset($route[1]))?$route[1]:301);
            exit;
        }else{
            // 解析路由地址
            $var  =  $this->parseUrl($url);
            // 解析路由地址里面的动态参数
            $values  =  array_values($matches);
            foreach ($var as $key=>$val){
                if(0===strpos($val,':')) {
                    $var[$key] =  $values[substr($val,1)-1];
                }
            }
            $var   =   array_merge($matches,$var);
            // 解析剩余的URL参数
            if($paths) {
                preg_replace('@(\w+)\/([^,\/]+)@e', '$var[strtolower(\'\\1\')]="\\2";', implode('/',$paths));
            }
            // 解析路由自动传人参数
            if(is_array($route) && isset($route[1])) {
                parse_str($route[1],$params);
                $var   =   array_merge($var,$params);
            }
            $_GET   =  array_merge($var,$_GET);
        }
        return true;
    }

    // 解析正则路由
    // '路由正则'=>'[分组/模块/操作]?参数1=值1&参数2=值2...'
    // '路由正则'=>array('[分组/模块/操作]?参数1=值1&参数2=值2...','额外参数1=值1&额外参数2=值2...')
    // '路由正则'=>'外部地址'
    // '路由正则'=>array('外部地址','重定向代码')
    // 参数值和外部地址中可以用动态变量 采用 :1 :2 的方式
    // '/new\/(\d+)\/(\d+)/'=>array('News/read?id=:1&page=:2&cate=1','status=1'),
    // '/new\/(\d+)/'=>array('/new.php?id=:1&page=:2&status=1','301'), 重定向
    private function parseRegex($matches,$route,$regx) {
        // 获取路由地址规则
        $url   =  is_array($route)?$route[0]:$route;
        $url   =  preg_replace('/:(\d)/e','$matches[\\1]',$url);
        if(0=== strpos($url,'/') || 0===strpos($url,'http')) { // 路由重定向跳转
            header("Location: $url", true,(is_array($route) && isset($route[1]))?$route[1]:301);
            exit;
        }else{
            // 解析路由地址
            $var  =  $this->parseUrl($url);
            // 解析剩余的URL参数
            $regx =  substr_replace($regx,'',0,strlen($matches[0]));
            if($regx) {
                preg_replace('@(\w+)\/([^,\/]+)@e', '$var[strtolower(\'\\1\')]="\\2";', $regx);
            }
            // 解析路由自动传人参数
            if(is_array($route) && isset($route[1])) {
                parse_str($route[1],$params);
                $var   =   array_merge($var,$params);
            }
            $_GET   =  array_merge($var,$_GET);
        }
        return true;
    }
}
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: LocationTemplateBehavior.class.php 2702 2012-02-02 12:35:01Z liu21st $

/**
 +------------------------------------------------------------------------------
 * 系统行为扩展 自动定位模板文件
 +------------------------------------------------------------------------------
 */
class LocationTemplateBehavior extends Behavior {
	// 行为扩展的执行入口必须是run
	public function run(&$templateFile){
		// 自动定位模板文件
		if(!file_exists_case($templateFile))
		$templateFile   = $this->parseTemplateFile($templateFile);
	}

	/**
	 +----------------------------------------------------------
	 * 自动定位模板文件
	 +----------------------------------------------------------
	 * @access private
	 +----------------------------------------------------------
	 * @param string $templateFile 文件名
	 +----------------------------------------------------------
	 * @return string
	 +----------------------------------------------------------
	 * @throws ThinkExecption
	 +----------------------------------------------------------
	 */
	private function parseTemplateFile($templateFile) {
		if(''==$templateFile) {
			// 如果模板文件名为空 按照默认规则定位
			$templateFile = C('TEMPLATE_NAME');
		}elseif(false === strpos($templateFile,C('TMPL_TEMPLATE_SUFFIX'))){
			// 解析规则为 模板主题:模块:操作 不支持 跨项目和跨分组调用
			$path   =  explode(':',$templateFile);
			$action = array_pop($path);
			$module = !empty($path)?array_pop($path):MODULE_NAME;
			if(!empty($path)) {// 设置模板主题
				$path = dirname(THEME_PATH).'/'.array_pop($path).'/';
			}else{
				$path = THEME_PATH;
			}
			$depr = defined('GROUP_NAME')?C('TMPL_FILE_DEPR'):'/';
			$templateFile  =  $path.$module.$depr.$action.C('TMPL_TEMPLATE_SUFFIX');
		}
		if(!file_exists_case($templateFile))
		throw_exception(L('_TEMPLATE_NOT_EXIST_').'['.$templateFile.']');
		return $templateFile;
	}
}
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: ParseTemplateBehavior.class.php 2740 2012-02-17 08:16:42Z liu21st $

/**
 +------------------------------------------------------------------------------
 * 系统行为扩展 模板解析
 +------------------------------------------------------------------------------
 */

class ParseTemplateBehavior extends Behavior {
	// 行为参数定义（默认值） 可在项目配置中覆盖
	protected $options   =  array(
	// 布局设置
        'TMPL_ENGINE_TYPE'		=> 'Think',     // 默认模板引擎 以下设置仅对使用Think模板引擎有效
        'TMPL_CACHFILE_SUFFIX'  => '.php',      // 默认模板缓存后缀
        'TMPL_DENY_FUNC_LIST'	=> 'echo,exit',	// 模板引擎禁用函数
        'TMPL_DENY_PHP'  =>false, // 默认模板引擎是否禁用PHP原生代码
        'TMPL_L_DELIM'          => '{',			// 模板引擎普通标签开始标记
        'TMPL_R_DELIM'          => '}',			// 模板引擎普通标签结束标记
        'TMPL_VAR_IDENTIFY'     => 'array',     // 模板变量识别。留空自动判断,参数为'obj'则表示对象
        'TMPL_STRIP_SPACE'      => true,       // 是否去除模板文件里面的html空格与换行
        'TMPL_CACHE_ON'			=> true,        // 是否开启模板编译缓存,设为false则每次都会重新编译
        'TMPL_CACHE_TIME'		=>	 0,         // 模板缓存有效期 0 为永久，(以数字为值，单位:秒)
        'TMPL_LAYOUT_ITEM'    =>   '{__CONTENT__}', // 布局模板的内容替换标识
        'LAYOUT_ON'           => false, // 是否启用布局
        'LAYOUT_NAME'       => 'layout', // 当前布局名称 默认为layout

	// Think模板引擎标签库相关设定
        'TAGLIB_BEGIN'          => '<',  // 标签库标签开始标记
        'TAGLIB_END'            => '>',  // 标签库标签结束标记
        'TAGLIB_LOAD'           => true, // 是否使用内置标签库之外的其它标签库，默认自动检测
        'TAGLIB_BUILD_IN'       => 'cx', // 内置标签库名称(标签使用不必指定标签库名称),以逗号分隔 注意解析顺序
        'TAGLIB_PRE_LOAD'       => '',   // 需要额外加载的标签库(须指定标签库名称)，多个以逗号分隔
	);

	// 行为扩展的执行入口必须是run
	public function run(&$_data){
		$engine  = strtolower(C('TMPL_ENGINE_TYPE'));
		if('think'==$engine){ // 采用Think模板引擎
			if($this->checkCache($_data['file'])) { // 缓存有效
				// 分解变量并载入模板缓存
				extract($_data['var'], EXTR_OVERWRITE);
				//载入模版缓存文件
				include C('CACHE_PATH').md5($_data['file']).C('TMPL_CACHFILE_SUFFIX');
			}else{
				$tpl = Think::instance('ThinkTemplate');
				// 编译并加载模板文件
				$tpl->fetch($_data['file'],$_data['var']);
			}
		}else{
			// 调用第三方模板引擎解析和输出
			$class   = 'Template'.ucwords($engine);
			if(is_file(CORE_PATH.'Driver/Template/'.$class.'.class.php')) {
				// 内置驱动
				$path = CORE_PATH;
			}else{ // 扩展驱动
				$path = EXTEND_PATH;
			}
			if(require_cache($path.'Driver/Template/'.$class.'.class.php')) {
				$tpl   =  new $class;
				$tpl->fetch($_data['file'],$_data['var']);
			}else {  // 类没有定义
				throw_exception(L('_NOT_SUPPERT_').': ' . $class);
			}
		}
	}

	/**
	 +----------------------------------------------------------
	 * 检查缓存文件是否有效
	 * 如果无效则需要重新编译
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @param string $tmplTemplateFile  模板文件名
	 +----------------------------------------------------------
	 * @return boolen
	 +----------------------------------------------------------
	 */
	protected function checkCache($tmplTemplateFile) {
		if (!C('TMPL_CACHE_ON')) // 优先对配置设定检测
		return false;
		$tmplCacheFile = C('CACHE_PATH').md5($tmplTemplateFile).C('TMPL_CACHFILE_SUFFIX');
		if(!is_file($tmplCacheFile)){
			return false;
		}elseif (filemtime($tmplTemplateFile) > filemtime($tmplCacheFile)) {
			// 模板文件如果有更新则缓存需要更新
			return false;
		}elseif (C('TMPL_CACHE_TIME') != 0 && time() > filemtime($tmplCacheFile)+C('TMPL_CACHE_TIME')) {
			// 缓存是否在有效期
			return false;
		}
		// 开启布局模板
		if(C('LAYOUT_ON')) {
			$layoutFile  =  THEME_PATH.C('LAYOUT_NAME').C('TMPL_TEMPLATE_SUFFIX');
			if(filemtime($layoutFile) > filemtime($tmplCacheFile)) {
				return false;
			}
		}
		// 缓存有效
		return true;
	}
}
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: ContentReplaceBehavior.class.php 2777 2012-02-23 13:07:50Z liu21st $

/**
 +------------------------------------------------------------------------------
 * 系统行为扩展 模板内容输出替换
 +------------------------------------------------------------------------------
 */
class ContentReplaceBehavior extends Behavior {
	// 行为参数定义
	protected $options   =  array(
        'TMPL_PARSE_STRING'=>array(),
	);

	// 行为扩展的执行入口必须是run
	public function run(&$content){
		$content = $this->templateContentReplace($content);
	}

	/**
	 +----------------------------------------------------------
	 * 模板内容替换
	 +----------------------------------------------------------
	 * @access protected
	 +----------------------------------------------------------
	 * @param string $content 模板内容
	 +----------------------------------------------------------
	 * @return string
	 +----------------------------------------------------------
	 */
	protected function templateContentReplace($content) {
		// 系统默认的特殊变量替换
		$replace =  array(
            '__TMPL__'      => APP_TMPL_PATH,  // 项目模板目录
            '__ROOT__'      => __ROOT__,       // 当前网站地址
            '__APP__'       => __APP__,        // 当前项目地址
            '__GROUP__'   =>   defined('GROUP_NAME')?__GROUP__:__APP__,
            '__ACTION__'    => __ACTION__,     // 当前操作地址
            '__SELF__'      => __SELF__,       // 当前页面地址
            '__URL__'       => __URL__,
            '../Public'   => APP_TMPL_PATH.'Public',// 项目公共模板目录
            '__PUBLIC__'  => __ROOT__.'/Public',// 站点公共目录
		);
		// 允许用户自定义模板的字符串替换
		if(is_array(C('TMPL_PARSE_STRING')) )
		$replace =  array_merge($replace,C('TMPL_PARSE_STRING'));
		$content = str_replace(array_keys($replace),array_values($replace),$content);
		return $content;
	}

}
// +----------------------------------------------------------------------
// | TOPThink [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2010 http://topthink.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: TokenBuildBehavior.class.php 2659 2012-01-23 15:04:24Z liu21st $

/**
 +------------------------------------------------------------------------------
 * 系统行为扩展 表单令牌生成
 +------------------------------------------------------------------------------
 */
class TokenBuildBehavior extends Behavior {
	// 行为参数定义
	protected $options   =  array(
        'TOKEN_ON'              => true,     // 开启令牌验证
        'TOKEN_NAME'            => '__hash__',    // 令牌验证的表单隐藏字段名称
        'TOKEN_TYPE'            => 'md5',   // 令牌验证哈希规则
        'TOKEN_RESET'               =>   true, // 令牌错误后是否重置
	);

	public function run(&$content){
		if(C('TOKEN_ON')) {
			if(strpos($content,'{__TOKEN__}')) {
				// 指定表单令牌隐藏域位置
				$content = str_replace('{__TOKEN__}',$this->buildToken(),$content);
			}elseif(preg_match('/<\/form(\s*)>/is',$content,$match)) {
				// 智能生成表单令牌隐藏域
				$content = str_replace($match[0],$this->buildToken().$match[0],$content);
			}
		}
	}

	// 创建表单令牌
	private function buildToken() {
		$tokenName   = C('TOKEN_NAME');
		$tokenType = C('TOKEN_TYPE');
		if(!isset($_SESSION[$tokenName])) {
			$_SESSION[$tokenName]  = array();
		}
		// 标识当前页面唯一性
		$tokenKey  =  md5($_SERVER['REQUEST_URI']);
		if(isset($_SESSION[$tokenName][$tokenKey])) {// 相同页面不重复生成session
			$tokenValue = $_SESSION[$tokenName][$tokenKey];
		}else{
			$tokenValue = $tokenType(microtime(TRUE));
			$_SESSION[$tokenName][$tokenKey]   =  $tokenValue;
		}
		// 执行一次额外动作防止远程非法提交
		if($action   =  C('TOKEN_ACTION')){
			$_SESSION[$action($tokenKey)] = true;
		}
		$token   =  '<input type="hidden" name="'.$tokenName.'" value="'.$tokenKey.'_'.$tokenValue.'" />';
		return $token;
	}
}
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: WriteHtmlCacheBehavior.class.php 2702 2012-02-02 12:35:01Z liu21st $

/**
 +------------------------------------------------------------------------------
 * 系统行为扩展 静态缓存写入
 * 增加配置参数如下：
 +------------------------------------------------------------------------------
 */
class WriteHtmlCacheBehavior extends Behavior {

	// 行为扩展的执行入口必须是run
	public function run(&$content){
		if(C('HTML_CACHE_ON') && defined('HTML_FILE_NAME'))  {
			//静态文件写入
			// 如果开启HTML功能 检查并重写HTML文件
			// 没有模版的操作不生成静态文件
			if(!is_dir(dirname(HTML_FILE_NAME)))
			mk_dir(dirname(HTML_FILE_NAME));
			if( false === file_put_contents( HTML_FILE_NAME , $content ))
			throw_exception(L('_CACHE_WRITE_ERROR_').':'.HTML_FILE_NAME);
		}
	}
}
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: ShowRuntimeBehavior.class.php 2702 2012-02-02 12:35:01Z liu21st $

/**
 +------------------------------------------------------------------------------
 * 系统行为扩展 运行时间信息显示
 +------------------------------------------------------------------------------
 */
class ShowRuntimeBehavior extends Behavior {
	// 行为参数定义
	protected $options   =  array(
        'SHOW_RUN_TIME'			=> false,   // 运行时间显示
        'SHOW_ADV_TIME'			=> false,   // 显示详细的运行时间
        'SHOW_DB_TIMES'			=> false,   // 显示数据库查询和写入次数
        'SHOW_CACHE_TIMES'		=> false,   // 显示缓存操作次数
        'SHOW_USE_MEM'			=> false,   // 显示内存开销
        'SHOW_LOAD_FILE'          => false,   // 显示加载文件数
        'SHOW_FUN_TIMES'         => false ,  // 显示函数调用次数
	);

	// 行为扩展的执行入口必须是run
	public function run(&$content){
		if(C('SHOW_RUN_TIME')){
			if(false !== strpos($content,'{__NORUNTIME__}')) {
				$content   =  str_replace('{__NORUNTIME__}','',$content);
			}else{
				$runtime = $this->showTime();
				if(strpos($content,'{__RUNTIME__}'))
				$content   =  str_replace('{__RUNTIME__}',$runtime,$content);
				else
				$content   .=  $runtime;
			}
		}else{
			$content   =  str_replace(array('{__NORUNTIME__}','{__RUNTIME__}'),'',$content);
		}
	}

	/**
	 +----------------------------------------------------------
	 * 显示运行时间、数据库操作、缓存次数、内存使用信息
	 +----------------------------------------------------------
	 * @access private
	 +----------------------------------------------------------
	 * @return string
	 +----------------------------------------------------------
	 */
	private function showTime() {
		// 显示运行时间
		G('beginTime',$GLOBALS['_beginTime']);
		G('viewEndTime');
		$showTime   =   'Process: '.G('beginTime','viewEndTime').'s ';
		if(C('SHOW_ADV_TIME')) {
			// 显示详细运行时间
			$showTime .= '( Load:'.G('beginTime','loadTime').'s Init:'.G('loadTime','initTime').'s Exec:'.G('initTime','viewStartTime').'s Template:'.G('viewStartTime','viewEndTime').'s )';
		}
		if(C('SHOW_DB_TIMES') && class_exists('Db',false) ) {
			// 显示数据库操作次数
			$showTime .= ' | DB :'.N('db_query').' queries '.N('db_write').' writes ';
		}
		if(C('SHOW_CACHE_TIMES') && class_exists('Cache',false)) {
			// 显示缓存读写次数
			$showTime .= ' | Cache :'.N('cache_read').' gets '.N('cache_write').' writes ';
		}
		if(MEMORY_LIMIT_ON && C('SHOW_USE_MEM')) {
			// 显示内存开销
			$showTime .= ' | UseMem:'. number_format((memory_get_usage() - $GLOBALS['_startUseMems'])/1024).' kb';
		}
		if(C('SHOW_LOAD_FILE')) {
			$showTime .= ' | LoadFile:'.count(get_included_files());
		}
		if(C('SHOW_FUN_TIMES')) {
			$fun  =  get_defined_functions();
			$showTime .= ' | CallFun:'.count($fun['user']).','.count($fun['internal']);
		}
		return $showTime;
	}
}
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: ShowPageTraceBehavior.class.php 2702 2012-02-02 12:35:01Z liu21st $

/**
 +------------------------------------------------------------------------------
 * 系统行为扩展 页面Trace显示输出
 +------------------------------------------------------------------------------
 */
class ShowPageTraceBehavior extends Behavior {
	// 行为参数定义
	protected $options   =  array(
        'SHOW_PAGE_TRACE'        => false,   // 显示页面Trace信息
	);

	// 行为扩展的执行入口必须是run
	public function run(&$params){
		if(C('SHOW_PAGE_TRACE')) {
			echo $this->showTrace();
		}
	}

	/**
	 +----------------------------------------------------------
	 * 显示页面Trace信息
	 +----------------------------------------------------------
	 * @access private
	 +----------------------------------------------------------
	 */
	private function showTrace() {
		// 系统默认显示信息
		$log  =   Log::$log;
		$files =  get_included_files();
		$trace   =  array(
            '请求时间'=>  date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME']),
            '当前页面'=>  __SELF__,
            '请求协议'=>  $_SERVER['SERVER_PROTOCOL'].' '.$_SERVER['REQUEST_METHOD'],
            '运行信息'=>  $this->showTime(),
            '会话ID'    =>  session_id(),
            '日志记录'=>  count($log)?count($log).'条日志<br/>'.implode('<br/>',$log):'无日志记录',
            '加载文件'=>  count($files).str_replace("\n",'<br/>',substr(substr(print_r($files,true),7),0,-2)),
		);

		// 读取项目定义的Trace文件
		$traceFile  =   CONF_PATH.'trace.php';
		if(is_file($traceFile)) {
			// 定义格式 return array('当前页面'=>$_SERVER['PHP_SELF'],'通信协议'=>$_SERVER['SERVER_PROTOCOL'],...);
			$trace   =  array_merge(include $traceFile,$trace);
		}
		// 设置trace信息
		trace($trace);
		// 调用Trace页面模板
		ob_start();
		include C('TMPL_TRACE_FILE')?C('TMPL_TRACE_FILE'):THINK_PATH.'Tpl/page_trace.tpl';
		return ob_get_clean();
	}

	/**
	 +----------------------------------------------------------
	 * 显示运行时间、数据库操作、缓存次数、内存使用信息
	 +----------------------------------------------------------
	 * @access private
	 +----------------------------------------------------------
	 * @return string
	 +----------------------------------------------------------
	 */
	private function showTime() {
		// 显示运行时间
		G('beginTime',$GLOBALS['_beginTime']);
		G('viewEndTime');
		$showTime   =   'Process: '.G('beginTime','viewEndTime').'s ';
		// 显示详细运行时间
		$showTime .= '( Load:'.G('beginTime','loadTime').'s Init:'.G('loadTime','initTime').'s Exec:'.G('initTime','viewStartTime').'s Template:'.G('viewStartTime','viewEndTime').'s )';
		// 显示数据库操作次数
		if(class_exists('Db',false) ) {
			$showTime .= ' | DB :'.N('db_query').' queries '.N('db_write').' writes ';
		}
		// 显示缓存读写次数
		if( class_exists('Cache',false)) {
			$showTime .= ' | Cache :'.N('cache_read').' gets '.N('cache_write').' writes ';
		}
		// 显示内存开销
		if(MEMORY_LIMIT_ON ) {
			$showTime .= ' | UseMem:'. number_format((memory_get_usage() - $GLOBALS['_startUseMems'])/1024).' kb';
		}
		// 显示文件加载数
		$showTime .= ' | LoadFile:'.count(get_included_files());
		// 显示函数调用次数 自定义函数,内置函数
		$fun  =  get_defined_functions();
		$showTime .= ' | CallFun:'.count($fun['user']).','.count($fun['internal']);
		return $showTime;
	}
}alias_import(array (
  'Model' => './includes/thinkphp/Lib/Core/Model.class.php',
  'Db' => './includes/thinkphp/Lib/Core/Db.class.php',
  'Log' => './includes/thinkphp/Lib/Core/Log.class.php',
  'ThinkTemplate' => './includes/thinkphp/Lib/Template/ThinkTemplate.class.php',
  'TagLib' => './includes/thinkphp/Lib/Template/TagLib.class.php',
  'Cache' => './includes/thinkphp/Lib/Core/Cache.class.php',
  'Widget' => './includes/thinkphp/Lib/Core/Widget.class.php',
  'TagLibCx' => './includes/thinkphp/Lib/Driver/TagLib/TagLibCx.class.php',
));

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id$

/**
  +------------------------------------------------------------------------------
 * Think 标准模式公共函数库
  +------------------------------------------------------------------------------
 * @category   Think
 * @package  Common
 * @author   liu21st <liu21st@gmail.com>
 * @version  $Id$
  +------------------------------------------------------------------------------
 */

// 错误输出
function halt($error) {
    $e = array();
    if (APP_DEBUG) {
        //调试模式下输出错误信息
        if (!is_array($error)) {
            $trace = debug_backtrace();
            $e['message'] = $error;
            $e['file'] = $trace[0]['file'];
            $e['class'] = $trace[0]['class'];
            $e['function'] = $trace[0]['function'];
            $e['line'] = $trace[0]['line'];
            $traceInfo = '';
            $time = date('y-m-d H:i:m');
            foreach ($trace as $t) {
                $traceInfo .= '[' . $time . '] ' . $t['file'] . ' (' . $t['line'] . ') ';
                $traceInfo .= $t['class'] . $t['type'] . $t['function'] . '(';
                $traceInfo .= implode(', ', $t['args']);
                $traceInfo .=')<br/>';
            }
            $e['trace'] = $traceInfo;
        }
        else {
            $e = $error;
        }
        // 包含异常页面模板
        include C('TMPL_EXCEPTION_FILE');
    }
    else {
        //否则定向到错误页面
        $error_page = C('ERROR_PAGE');
        if (!empty($error_page)) {
            redirect($error_page);
        }
        else {
            if (C('SHOW_ERROR_MSG'))
                $e['message'] = is_array($error) ? $error['message'] : $error;
            else
                $e['message'] = C('ERROR_MESSAGE');
            // 包含异常页面模板
            include C('TMPL_EXCEPTION_FILE');
        }
    }
    exit;
}

// 自定义异常处理
function throw_exception($msg, $type = 'ThinkException', $code = 0) {
    if (class_exists($type, false))
        throw new $type($msg, $code, true);
    else
        halt($msg);        // 异常类型不存在则输出错误信息字串
}

// 浏览器友好的变量输出
function dump($var, $echo = true, $label = null, $strict = true) {
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
        else {
            $output = $label . print_r($var, true);
        }
    }
    else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace("/\]\=\>\n(\s+)/m", '] => ', $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    }else
        return $output;
}

// 区间调试开始
function debug_start($label = '') {
    $GLOBALS[$label]['_beginTime'] = microtime(TRUE);
    if (MEMORY_LIMIT_ON)
        $GLOBALS[$label]['_beginMem'] = memory_get_usage();
}

// 区间调试结束，显示指定标记到当前位置的调试
function debug_end($label = '') {
    $GLOBALS[$label]['_endTime'] = microtime(TRUE);
    echo '<div style="text-align:center;width:100%">Process ' . $label . ': Times ' . number_format($GLOBALS[$label]['_endTime'] - $GLOBALS[$label]['_beginTime'], 6) . 's ';
    if (MEMORY_LIMIT_ON) {
        $GLOBALS[$label]['_endMem'] = memory_get_usage();
        echo ' Memories ' . number_format(($GLOBALS[$label]['_endMem'] - $GLOBALS[$label]['_beginMem']) / 1024) . ' k';
    }
    echo '</div>';
}

// 添加和获取页面Trace记录
function trace($title = '', $value = '') {
    if (!C('SHOW_PAGE_TRACE'))
        return;
    static $_trace = array();
    if (is_array($title)) { // 批量赋值
        $_trace = array_merge($_trace, $title);
    }
    elseif ('' !== $value) { // 赋值
        $_trace[$title] = $value;
    }
    elseif ('' !== $title) { // 取值
        return $_trace[$title];
    }
    else { // 获取全部Trace数据
        return $_trace;
    }
}

// 设置当前页面的布局
function layout($layout) {
    if (false !== $layout) {
        // 开启布局
        C('LAYOUT_ON', true);
        if (is_string($layout)) {
            C('LAYOUT_NAME', $layout);
        }
    }
}

// URL组装 支持不同模式
// 格式：U('[分组/模块/操作]?参数','参数','伪静态后缀','是否跳转','显示域名')
function U($url,$vars='',$suffix=true,$redirect=false,$domain=false) {    
    // 解析URL
    $info =  parse_url($url);
    //["path"] => string(10) "item/index"

    $url   =  !empty($info['path'])?$info['path']:ACTION_NAME;
    // 解析子域名
    if($domain===true){
        $domain = $_SERVER['HTTP_HOST'];
        if(C('APP_SUB_DOMAIN_DEPLOY') ) { // 开启子域名部署
            $domain = $domain=='localhost'?'localhost':'www'.strstr($_SERVER['HTTP_HOST'],'.');
            // '子域名'=>array('项目[/分组]');
            foreach (C('APP_SUB_DOMAIN_RULES') as $key => $rule) {
                if(false === strpos($key,'*') && 0=== strpos($url,$rule[0])) {
                    $domain = $key.strstr($domain,'.'); // 生成对应子域名
                    $url   =  substr_replace($url,'',0,strlen($rule[0]));
                    break;
                }
            }
        }
    }
    
    // 解析参数
    if(is_string($vars)) { // aaa=1&bbb=2 转换成数组
        parse_str($vars,$vars);   
    }elseif(!is_array($vars)){
        $vars = array(); 
    }
    if(isset($info['query'])) { // 解析地址里面参数 合并到vars
        parse_str($info['query'],$params);        
        $vars = array_merge($params,$vars);        
    }
    foreach ($vars as $key=>$value){
    	$vars_norouter[$key]=$value;
    }  
    // 填充附加参数
    if(C('URL_REWIRTE_MODE_VAL')&&C('URL_MODEL') != 0){
        foreach($vars as $k=>$v){
            $url_vars[] = $v;
        }
        $vars = implode("/",$url_vars);
    }   
    // URL组装
    $depr = C('URL_PATHINFO_DEPR');
    if($url) {
        if(0=== strpos($url,'/')) {// 定义路由
            $route   =  true;
            $url   =  substr($url,1);
            if('/' != $depr) {
                $url   =  str_replace('/',$depr,$url);
            }
        }else{
            if('/' != $depr) { // 安全替换
                $url   =  str_replace('/',$depr,$url);
            }
            // 解析分组、模块和操作
            $url   =  trim($url,$depr);
            $path = explode($depr,$url);
            $var  =  array();
            $var[C('VAR_ACTION')] = !empty($path)?array_pop($path):ACTION_NAME;
            $var[C('VAR_MODULE')] = !empty($path)?array_pop($path):MODULE_NAME;
            
            if(C('URL_CASE_INSENSITIVE')) {
                $var[C('VAR_MODULE')] =  parse_name($var[C('VAR_MODULE')]);
            }
            
            if(C('APP_GROUP_LIST')) {
                if(!empty($path)) {
                    $group   =  array_pop($path);
                    $var[C('VAR_GROUP')]  =   $group;
                }else{
                    if(GROUP_NAME != C('DEFAULT_GROUP')) {
                        $var[C('VAR_GROUP')]  =   GROUP_NAME;
                    }
                }
            }
        }
    }
     
    if(C('URL_MODEL') == 0) { // 普通模式URL转换
        $url   =  __APP__.'?'.http_build_query($var);
        if(!empty($vars)) {
            $vars = http_build_query($vars);
            $url   .= '&'.$vars;
        }
    }else{ // PATHINFO模式或者兼容URL模式
        if(isset($route)) {
            $url   =  __APP__.'/'.$url;
        }else{
            $url   =  __APP__.'/'.implode($depr,array_reverse($var));
        }
       // print_r($var);
        if(C('URL_REWIRTE_MODE_VAL')){
            // 组合默认路径
	        $router_ruler = include ROOT_PATH . '/router.inc.php';
            $site_url = implode("/",array_reverse($var));     
            if($router_ruler[$site_url]){            	
               $url = __APP__.'/'.$router_ruler[$site_url];               
               $url = rtrim($url.$depr.$vars,$depr); 
            }
            else{
            	if(!empty($vars_norouter)){            		         		
	            	 $vars_norouter = http_build_query($vars_norouter);
	           		 $url .= $depr.str_replace(array('=','&'),$depr,$vars_norouter);
        	    }
            }
        }       
        if(!empty($vars) && !C('URL_REWIRTE_MODE_VAL')) { // 添加参数
            $vars = http_build_query($vars);
            $url .= $depr.str_replace(array('=','&'),$depr,$vars);
        }    
        if($suffix){
            $suffix   =  $suffix===true?C('URL_HTML_SUFFIX'):$suffix;
            if($suffix) {
                $url  .=  '.'.ltrim($suffix,'.');
            }
        }
    }
    
    ///index.php?s=/item/index/id/1 
    if($domain) {
        $url   =  'http://'.$domain.$url;
    }else {
        $url = "http://" . $_SERVER['HTTP_HOST'] . ($_SERVER['SERVER_PORT'] == 80 ? '' : ':' . $_SERVER['SERVER_PORT']) . $url;
    }
    if($redirect) // 直接跳转URL
        redirect($url);
    else
        return $url;
}

// URL重定向
function redirect($url, $time = 0, $msg = '') {
    //多行URL地址支持
    $url = str_replace(array("\n", "\r"), '', $url);
    if (empty($msg))
        $msg = "系统将在{$time}秒之后自动跳转到{$url}！";
    if (!headers_sent()) {
        // redirect
        if (0 === $time) {
            header('Location: ' . $url);
        }
        else {
            header("refresh:{$time};url={$url}");
            echo($msg);
        }
        exit();
    }
    else {
        $str = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        if ($time != 0)
            $str .= $msg;
        exit($str);
    }
}

// 全局缓存设置和读取
function S($name, $value = '', $expire = null, $type = '', $options = null) {
    static $_cache = array();
    //取得缓存对象实例
    $cache = Cache::getInstance($type, $options);
    if ('' !== $value) {
        if (is_null($value)) {
            // 删除缓存
            $result = $cache->rm($name);
            if ($result)
                unset($_cache[$type . '_' . $name]);
            return $result;
        }else {
            // 缓存数据
            $cache->set($name, $value, $expire);
            $_cache[$type . '_' . $name] = $value;
        }
        return;
    }
    if (isset($_cache[$type . '_' . $name]))
        return $_cache[$type . '_' . $name];
    // 获取缓存数据
    $value = $cache->get($name);
    $_cache[$type . '_' . $name] = $value;
    return $value;
}

// 快速文件数据读取和保存 针对简单类型数据 字符串、数组
function F($name, $value = '', $path = DATA_PATH) {
    static $_cache = array();
    $filename = $path . $name . '.php';
    if ('' !== $value) {
        if (is_null($value)) {
            // 删除缓存
            return unlink($filename);
        }
        else {
            // 缓存数据
            $dir = dirname($filename);
            // 目录不存在则创建
            if (!is_dir($dir))
                mkdir($dir);
            $_cache[$name] = $value;
            return file_put_contents($filename, strip_whitespace("<?php\nreturn " . var_export($value, true) . ";\n?>"));
        }
    }
    if (isset($_cache[$name]))
        return $_cache[$name];
    // 获取缓存数据
    if (is_file($filename)) {
        $value = include $filename;
        $_cache[$name] = $value;
    }
    else {
        $value = false;
    }
    return $value;
}

// 取得对象实例 支持调用类的静态方法
function get_instance_of($name, $method = '', $args = array()) {
    static $_instance = array();
    $identify = empty($args) ? $name . $method : $name . $method . to_guid_string($args);
    if (!isset($_instance[$identify])) {
        if (class_exists($name)) {
            $o = new $name();
            if (method_exists($o, $method)) {
                if (!empty($args)) {
                    $_instance[$identify] = call_user_func_array(array(&$o, $method), $args);
                }
                else {
                    $_instance[$identify] = $o->$method();
                }
            }
            else
                $_instance[$identify] = $o;
        }
        else
            halt(L('_CLASS_NOT_EXIST_') . ':' . $name);
    }
    return $_instance[$identify];
}

// 根据PHP各种类型变量生成唯一标识号
function to_guid_string($mix) {
    if (is_object($mix) && function_exists('spl_object_hash')) {
        return spl_object_hash($mix);
    }
    elseif (is_resource($mix)) {
        $mix = get_resource_type($mix) . strval($mix);
    }
    else {
        $mix = serialize($mix);
    }
    return md5($mix);
}

// xml编码
function xml_encode($data, $encoding = 'utf-8', $root = 'think') {
    $xml = '<?xml version="1.0" encoding="' . $encoding . '"?>';
    $xml.= '<' . $root . '>';
    $xml.= data_to_xml($data);
    $xml.= '</' . $root . '>';
    return $xml;
}

function data_to_xml($data) {
    $xml = '';
    foreach ($data as $key => $val) {
        is_numeric($key) && $key = "item id=\"$key\"";
        $xml.="<$key>";
        $xml.= ( is_array($val) || is_object($val)) ? data_to_xml($val) : $val;
        list($key, ) = explode(' ', $key);
        $xml.="</$key>";
    }
    return $xml;
}

// session管理函数
function session($name, $value = '') {
    $prefix = C('SESSION_PREFIX');
    if (is_array($name)) { // session初始化 在session_start 之前调用
        if (isset($name['prefix']))
            C('SESSION_PREFIX', $name['prefix']);
        if (isset($_REQUEST[C('VAR_SESSION_ID')])) {
            session_id($_REQUEST[C('VAR_SESSION_ID')]);
        }
        elseif (isset($name['id'])) {
            session_id($name['id']);
        }
        ini_set('session.auto_start', 0);
        if (isset($name['name']))
            session_name($name['name']);
        if (isset($name['path']))
            session_save_path($name['path']);
        if (isset($name['domain']))
            ini_set('session.cookie_domain', $name['domain']);
        if (isset($name['expire']))
            ini_set('session.gc_maxlifetime', $name['expire']);
        if (isset($name['use_trans_sid']))
            ini_set('session.use_trans_sid', $name['use_trans_sid'] ? 1 : 0);
        if (isset($name['use_cookies']))
            ini_set('session.use_cookies', $name['use_cookies'] ? 1 : 0);
        if (isset($name['type']))
            C('SESSION_TYPE', $name['type']);
        if (C('SESSION_TYPE')) { // 读取session驱动
            $class = 'Session' . ucwords(strtolower(C('SESSION_TYPE')));
            // 检查驱动类
            if (require_cache(EXTEND_PATH . 'Driver/Session/' . $class . '.class.php')) {
                $hander = new $class();
                $hander->execute();
            }
            else {
                // 类没有定义
                throw_exception(L('_CLASS_NOT_EXIST_') . ': ' . $class);
            }
        }
        // 启动session
        if (C('SESSION_AUTO_START'))
            session_start();
    }elseif ('' === $value) {
        if (0 === strpos($name, '[')) { // session 操作
            if ('[pause]' == $name) { // 暂停session
                session_write_close();
            }
            elseif ('[start]' == $name) { // 启动session
                session_start();
            }
            elseif ('[destroy]' == $name) { // 销毁session
                $_SESSION = array();
                session_unset();
                session_destroy();
            }
            elseif ('[regenerate]' == $name) { // 重新生成id
                session_regenerate_id();
            }
        }
        elseif (0 === strpos($name, '?')) { // 检查session
            $name = substr($name, 1);
            if ($prefix) {
                return isset($_SESSION[$prefix][$name]);
            }
            else {
                return isset($_SESSION[$name]);
            }
        }
        elseif (is_null($name)) { // 清空session
            if ($prefix) {
                unset($_SESSION[$prefix]);
            }
            else {
                $_SESSION = array();
            }
        }
        elseif ($prefix) { // 获取session
            return $_SESSION[$prefix][$name];
        }
        else {
            return $_SESSION[$name];
        }
    }
    elseif (is_null($value)) { // 删除session
        if ($prefix) {
            unset($_SESSION[$prefix][$name]);
        }
        else {
            unset($_SESSION[$name]);
        }
    }
    else { // 设置session
        if ($prefix) {
            if (!is_array($_SESSION[$prefix])) {
                $_SESSION[$prefix] = array();
            }
            $_SESSION[$prefix][$name] = $value;
        }
        else {
            $_SESSION[$name] = $value;
        }
    }
}

// Cookie 设置、获取、删除
function cookie($name, $value = '', $option = null) {
    // 默认设置
    $config = array(
        'prefix' => C('COOKIE_PREFIX'), // cookie 名称前缀
        'expire' => C('COOKIE_EXPIRE'), // cookie 保存时间
        'path' => C('COOKIE_PATH'), // cookie 保存路径
        'domain' => C('COOKIE_DOMAIN'), // cookie 有效域名
    );
    // 参数设置(会覆盖黙认设置)
    if (!empty($option)) {
        if (is_numeric($option))
            $option = array('expire' => $option);
        elseif (is_string($option))
            parse_str($option, $option);
        $config = array_merge($config, array_change_key_case($option));
    }
    // 清除指定前缀的所有cookie
    if (is_null($name)) {
        if (empty($_COOKIE))
            return;
        // 要删除的cookie前缀，不指定则删除config设置的指定前缀
        $prefix = empty($value) ? $config['prefix'] : $value;
        if (!empty($prefix)) {// 如果前缀为空字符串将不作处理直接返回
            foreach ($_COOKIE as $key => $val) {
                if (0 === stripos($key, $prefix)) {
                    setcookie($key, '', time() - 3600, $config['path'], $config['domain']);
                    unset($_COOKIE[$key]);
                }
            }
        }
        return;
    }
    $name = $config['prefix'] . $name;
    if ('' === $value) {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null; // 获取指定Cookie
    }
    else {
        if (is_null($value)) {
            setcookie($name, '', time() - 3600, $config['path'], $config['domain']);
            unset($_COOKIE[$name]); // 删除指定cookie
        }
        else {
            // 设置cookie
            $expire = !empty($config['expire']) ? time() + intval($config['expire']) : 0;
            setcookie($name, $value, $expire, $config['path'], $config['domain']);
            $_COOKIE[$name] = $value;
        }
    }
}

// 加载扩展配置文件
function load_ext_file() {
    // 加载自定义外部文件
    if (C('LOAD_EXT_FILE')) {
        $files = explode(',', C('LOAD_EXT_FILE'));
        foreach ($files as $file) {
            $file = COMMON_PATH . $file . '.php';
            if (is_file($file))
                include $file;
        }
    }
    // 加载自定义的动态配置文件
    if (C('LOAD_EXT_CONFIG')) {
        $configs = C('LOAD_EXT_CONFIG');
        if (is_string($configs))
            $configs = explode(',', $configs);
        foreach ($configs as $key => $config) {
            $file = CONF_PATH . $config . '.php';
            if (is_file($file)) {
                is_numeric($key) ? C(include $file) : C($key, include $file);
            }
        }
    }
}

// 获取客户端IP地址
function get_client_ip() {
    static $ip = NULL;
    if ($ip !== NULL)
        return $ip;
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos = array_search('unknown', $arr);
        if (false !== $pos)
            unset($arr[$pos]);
        $ip = trim($arr[0]);
    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $ip = (false !== ip2long($ip)) ? $ip : '0.0.0.0';
    return $ip;
}

function send_http_status($code) {
    static $_status = array(
// Success 2xx
200 => 'OK',
 // Redirection 3xx
301 => 'Moved Permanently',
 302 => 'Moved Temporarily ', // 1.1
// Client Error 4xx
400 => 'Bad Request',
 403 => 'Forbidden',
 404 => 'Not Found',
 // Server Error 5xx
500 => 'Internal Server Error',
 503 => 'Service Unavailable',
    );
    if (isset($_status[$code])) {
        header('HTTP/1.1 ' . $code . ' ' . $_status[$code]);
        // 确保FastCGI模式下正常
        header('Status:' . $code . ' ' . $_status[$code]);
    }
}

function url_compare($url, $route) {
    ksort($url);
    $url_keys = array_keys($url);
    ksort($route);
    $route_keys = array_keys($route);

    if ($url['a'] != $route['a'] || $url['m'] != $route['m'] || $url_keys != $route_keys) {
        return false;
    }
    else {
        return true;
    }
}

function parseUrl($url) {
    $var = array();
    if (false !== strpos($url, '?')) { // [分组/模块/操作?]参数1=值1&参数2=值2...
        $info = parse_url($url);
        $path = explode('/', $info['path']);
        parse_str($info['query'], $var);
    }
    elseif (strpos($url, '/')) { // [分组/模块/操作]
        $path = explode('/', $url);
    }
    else { // 参数1=值1&参数2=值2...
        parse_str($url, $var);
    }
    if (isset($path)) {
        $var[C('VAR_ACTION')] = array_pop($path);
        if (!empty($path)) {
            $var[C('VAR_MODULE')] = array_pop($path);
        }
        if (!empty($path)) {
            $var[C('VAR_GROUP')] = array_pop($path);
        }
    }
    return $var;
}

function id($id)
{
	return abs(intval($id));
}
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: Log.class.php 2791 2012-02-29 10:08:57Z liu21st $

/**
 +------------------------------------------------------------------------------
 * 日志处理类
 +------------------------------------------------------------------------------
 * @category   Think
 * @package  Think
 * @subpackage  Core
 * @author    liu21st <liu21st@gmail.com>
 * @version   $Id: Log.class.php 2791 2012-02-29 10:08:57Z liu21st $
 +------------------------------------------------------------------------------
 */
class Log {

	// 日志级别 从上到下，由低到高
	const EMERG   = 'EMERG';  // 严重错误: 导致系统崩溃无法使用
	const ALERT    = 'ALERT';  // 警戒性错误: 必须被立即修改的错误
	const CRIT      = 'CRIT';  // 临界值错误: 超过临界值的错误，例如一天24小时，而输入的是25小时这样
	const ERR       = 'ERR';  // 一般错误: 一般性错误
	const WARN    = 'WARN';  // 警告性错误: 需要发出警告的错误
	const NOTICE  = 'NOTIC';  // 通知: 程序可以运行但是还不够完美的错误
	const INFO     = 'INFO';  // 信息: 程序输出信息
	const DEBUG   = 'DEBUG';  // 调试: 调试信息
	const SQL       = 'SQL';  // SQL：SQL语句 注意只在调试模式开启时有效

	// 日志记录方式
	const SYSTEM = 0;
	const MAIL      = 1;
	const FILE       = 3;
	const SAPI      = 4;

	// 日志信息
	static $log =   array();

	// 日期格式
	static $format =  '[ c ]';

	/**
	 +----------------------------------------------------------
	 * 记录日志 并且会过滤未经设置的级别
	 +----------------------------------------------------------
	 * @static
	 * @access public
	 +----------------------------------------------------------
	 * @param string $message 日志信息
	 * @param string $level  日志级别
	 * @param boolean $record  是否强制记录
	 +----------------------------------------------------------
	 * @return void
	 +----------------------------------------------------------
	 */
	static function record($message,$level=self::ERR,$record=false) {
		if($record || strpos(C('LOG_LEVEL'),$level)) {
			$now = date(self::$format);
			self::$log[] =   "{$now} ".$_SERVER['REQUEST_URI']." | {$level}: {$message}\r\n";
		}
	}

	/**
	 +----------------------------------------------------------
	 * 日志保存
	 +----------------------------------------------------------
	 * @static
	 * @access public
	 +----------------------------------------------------------
	 * @param integer $type 日志记录方式
	 * @param string $destination  写入目标
	 * @param string $extra 额外参数
	 +----------------------------------------------------------
	 * @return void
	 +----------------------------------------------------------
	 */
	static function save($type='',$destination='',$extra='') {
		$type = $type?$type:C('LOG_TYPE');
		if(self::FILE == $type) { // 文件方式记录日志信息
			if(empty($destination))
			$destination = LOG_PATH.date('y_m_d').'.log';
			//检测日志文件大小，超过配置大小则备份日志文件重新生成
			if(is_file($destination) && floor(C('LOG_FILE_SIZE')) <= filesize($destination) )
			rename($destination,dirname($destination).'/'.time().'-'.basename($destination));
		}else{
			$destination   =   $destination?$destination:C('LOG_DEST');
			$extra   =  $extra?$extra:C('LOG_EXTRA');
		}
		error_log(implode('',self::$log), $type,$destination ,$extra);
		// 保存后清空日志缓存
		self::$log = array();
		//clearstatcache();
	}

	/**
	 +----------------------------------------------------------
	 * 日志直接写入
	 +----------------------------------------------------------
	 * @static
	 * @access public
	 +----------------------------------------------------------
	 * @param string $message 日志信息
	 * @param string $level  日志级别
	 * @param integer $type 日志记录方式
	 * @param string $destination  写入目标
	 * @param string $extra 额外参数
	 +----------------------------------------------------------
	 * @return void
	 +----------------------------------------------------------
	 */
	static function write($message,$level=self::ERR,$type='',$destination='',$extra='') {
		$now = date(self::$format);
		$type = $type?$type:C('LOG_TYPE');
		if(self::FILE == $type) { // 文件方式记录日志
			if(empty($destination))
			$destination = LOG_PATH.date('y_m_d').'.log';
			//检测日志文件大小，超过配置大小则备份日志文件重新生成
			if(is_file($destination) && floor(C('LOG_FILE_SIZE')) <= filesize($destination) )
			rename($destination,dirname($destination).'/'.time().'-'.basename($destination));
		}else{
			$destination   =   $destination?$destination:C('LOG_DEST');
			$extra   =  $extra?$extra:C('LOG_EXTRA');
		}
		error_log("{$now} ".$_SERVER['REQUEST_URI']." | {$level}: {$message}\r\n", $type,$destination,$extra );
		//clearstatcache();
	}
}
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: Dispatcher.class.php 2760 2012-02-20 12:43:06Z liu21st $

/**
 +------------------------------------------------------------------------------
 * ThinkPHP内置的Dispatcher类
 * 完成URL解析、路由和调度
 +------------------------------------------------------------------------------
 * @category   Think
 * @package  Think
 * @subpackage  Util
 * @author    liu21st <liu21st@gmail.com>
 * @version   $Id: Dispatcher.class.php 2760 2012-02-20 12:43:06Z liu21st $
 +------------------------------------------------------------------------------
 */
class Dispatcher {

    /**
     +----------------------------------------------------------
     * URL映射到控制器
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    static public function dispatch() {
        $urlMode  =  C('URL_MODEL');
        if(!empty($_GET[C('VAR_PATHINFO')])) { // 判断URL里面是否有兼容模式参数
            $_SERVER['PATH_INFO']   = $_GET[C('VAR_PATHINFO')];
            unset($_GET[C('VAR_PATHINFO')]);
        }
        if($urlMode == URL_COMPAT ){
            // 兼容模式判断
            define('PHP_FILE',_PHP_FILE_.'?'.C('VAR_PATHINFO').'=');
        }elseif($urlMode == URL_REWRITE ) {
            //当前项目地址
            $url    =   dirname(_PHP_FILE_);
            if($url == '/' || $url == '\\')
                $url    =   '';
            define('PHP_FILE',$url);
        }else {
            //当前项目地址
            define('PHP_FILE',_PHP_FILE_);
        }

        // 开启子域名部署
        if(C('APP_SUB_DOMAIN_DEPLOY')) {
            $rules = C('APP_SUB_DOMAIN_RULES');
            $subDomain    = strtolower(substr($_SERVER['HTTP_HOST'],0,strpos($_SERVER['HTTP_HOST'],'.')));
            define('SUB_DOMAIN',$subDomain); // 二级域名定义
            if($subDomain && isset($rules[$subDomain])) {
                $rule =  $rules[$subDomain];
            }elseif(isset($rules['*'])){ // 泛域名支持
                if('www' != $subDomain && !in_array($subDomain,C('APP_SUB_DOMAIN_DENY'))) {
                    $rule =  $rules['*'];
                }
            }
            if(!empty($rule)) {
                // 子域名部署规则 '子域名'=>array('分组名/[模块名]','var1=a&var2=b');
                $array   =  explode('/',$rule[0]);
                $module = array_pop($array);
                if(!empty($module)) {
                    $_GET[C('VAR_MODULE')] = $module;
                    $domainModule   =  true;
                }
                if(!empty($array)) {
                    $_GET[C('VAR_GROUP')]  = array_pop($array);
                    $domainGroup =  true;
                }
                if(isset($rule[1])) { // 传入参数
                    parse_str($rule[1],$parms);
                    $_GET   =  array_merge($_GET,$parms);
                }
            }
        }
        // 分析PATHINFO信息
        if(empty($_SERVER['PATH_INFO'])) {
            $types   =  explode(',',C('URL_PATHINFO_FETCH'));
            foreach ($types as $type){
                if(0===strpos($type,':')) {// 支持函数判断
                    $_SERVER['PATH_INFO'] =   call_user_func(substr($type,1));
                    break;
                }elseif(!empty($_SERVER[$type])) {
                    $_SERVER['PATH_INFO'] = (0 === strpos($_SERVER[$type],$_SERVER['SCRIPT_NAME']))?
                        substr($_SERVER[$type], strlen($_SERVER['SCRIPT_NAME']))   :  $_SERVER[$type];
                    break;
                }
            }
        }
        $depr = C('URL_PATHINFO_DEPR');
        if(!empty($_SERVER['PATH_INFO'])) {
            if(C('URL_HTML_SUFFIX')) {
                $_SERVER['PATH_INFO'] = preg_replace('/\.'.trim(C('URL_HTML_SUFFIX'),'.').'$/i', '', $_SERVER['PATH_INFO']);
            }
            if(!self::routerCheck()){   // 检测路由规则 如果没有则按默认规则调度URL
                $paths = explode($depr,trim($_SERVER['PATH_INFO'],'/'));
                // 直接通过$_GET['_URL_'][1] $_GET['_URL_'][2] 获取URL参数 方便不用路由时参数获取
                $_GET[C('VAR_URL_PARAMS')]   =  $paths;
                $var  =  array();
                if (C('APP_GROUP_LIST') && !isset($_GET[C('VAR_GROUP')])){
                    $var[C('VAR_GROUP')] = in_array(strtolower($paths[0]),explode(',',strtolower(C('APP_GROUP_LIST'))))? array_shift($paths) : '';
                    if(C('APP_GROUP_DENY') && in_array(strtolower($var[C('VAR_GROUP')]),explode(',',strtolower(C('APP_GROUP_DENY'))))) {
                        // 禁止直接访问分组
                        exit;
                    }
                }
                if(!isset($_GET[C('VAR_MODULE')])) {// 还没有定义模块名称
                    $var[C('VAR_MODULE')]  =   array_shift($paths);
                }
                $var[C('VAR_ACTION')]  =   array_shift($paths);
                // 解析剩余的URL参数
                $res = preg_replace('@(\w+)'.$depr.'([^'.$depr.'\/]+)@e', '$var[\'\\1\']=\'\\2\';', implode($depr,$paths));
                $_GET   =  array_merge($var,$_GET);
            }
            define('__INFO__',$_SERVER['PATH_INFO']);
        }

        // 获取分组 模块和操作名称
        if (C('APP_GROUP_LIST')) {
            define('GROUP_NAME', self::getGroup(C('VAR_GROUP')));
        }
        define('MODULE_NAME',self::getModule(C('VAR_MODULE')));
        define('ACTION_NAME',self::getAction(C('VAR_ACTION')));
        // URL常量
        define('__SELF__',strip_tags($_SERVER['REQUEST_URI']));
        // 当前项目地址
        define('__APP__',strip_tags(PHP_FILE));
        // 当前模块和分组地址
        $module = defined('P_MODULE_NAME')?P_MODULE_NAME:MODULE_NAME;
        if(defined('GROUP_NAME')) {
            define('__GROUP__',(!empty($domainGroup) || strtolower(GROUP_NAME) == strtolower(C('DEFAULT_GROUP')) )?__APP__ : __APP__.'/'.GROUP_NAME);
            define('__URL__',!empty($domainModule)?__GROUP__.$depr : __GROUP__.$depr.$module);
        }else{
            define('__URL__',!empty($domainModule)?__APP__.'/' : __APP__.'/'.$module);
        }
        // 当前操作地址
        define('__ACTION__',__URL__.$depr.ACTION_NAME);
        //保证$_REQUEST正常取值
        $_REQUEST = array_merge($_POST,$_GET);
    }

    /**
     +----------------------------------------------------------
     * 路由检测
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    static public function routerCheck() {
        $return   =  false;
        // 路由检测标签
        tag('route_check',$return);
        return $return;
    }

    /**
     +----------------------------------------------------------
     * 获得实际的模块名称
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    static private function getModule($var) {
        $module = (!empty($_GET[$var])? $_GET[$var]:C('DEFAULT_MODULE'));
        unset($_GET[$var]);
        if(C('URL_CASE_INSENSITIVE')) {
            // URL地址不区分大小写
            define('P_MODULE_NAME',strtolower($module));
            // 智能识别方式 index.php/user_type/index/ 识别到 UserTypeAction 模块
            $module = ucfirst(parse_name(P_MODULE_NAME,1));
        }
        return strip_tags($module);
    }

    /**
     +----------------------------------------------------------
     * 获得实际的操作名称
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    static private function getAction($var) {
        $action   = !empty($_POST[$var]) ?
            $_POST[$var] :
            (!empty($_GET[$var])?$_GET[$var]:C('DEFAULT_ACTION'));
        unset($_POST[$var],$_GET[$var]);
        define('P_ACTION_NAME',$action);
        return strip_tags(C('URL_CASE_INSENSITIVE')?strtolower($action):$action);
    }

    /**
     +----------------------------------------------------------
     * 获得实际的分组名称
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    static private function getGroup($var) {
        $group   = (!empty($_GET[$var])?$_GET[$var]:C('DEFAULT_GROUP'));
        unset($_GET[$var]);
        return strip_tags(C('URL_CASE_INSENSITIVE') ?ucfirst(strtolower($group)):$group);
    }

}
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: App.class.php 2792 2012-03-02 03:36:36Z liu21st $

/**
 +------------------------------------------------------------------------------
 * ThinkPHP 应用程序类 执行应用过程管理
 * 可以在模式扩展中重新定义 但是必须具有Run方法接口
 +------------------------------------------------------------------------------
 * @category   Think
 * @package  Think
 * @subpackage  Core
 * @author    liu21st <liu21st@gmail.com>
 * @version   $Id: App.class.php 2792 2012-03-02 03:36:36Z liu21st $
 +------------------------------------------------------------------------------
 */
class App {

	/**
	 +----------------------------------------------------------
	 * 应用程序初始化
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @return void
	 +----------------------------------------------------------
	 */
	static public function init() {

		// 设置系统时区
		date_default_timezone_set(C('DEFAULT_TIMEZONE'));
		// 加载动态项目公共文件和配置
		load_ext_file();
		// URL调度
		Dispatcher::dispatch();

		if(defined('GROUP_NAME')) {
			// 加载分组配置文件
			if(is_file(CONF_PATH.GROUP_NAME.'/config.php'))
			C(include CONF_PATH.GROUP_NAME.'/config.php');
			// 加载分组函数文件
			if(is_file(COMMON_PATH.GROUP_NAME.'/function.php'))
			include COMMON_PATH.GROUP_NAME.'/function.php';
		}

		/* 获取模板主题名称 */
		$templateSet =  C('DEFAULT_THEME');
		if(C('TMPL_DETECT_THEME')) {// 自动侦测模板主题
			$t = C('VAR_TEMPLATE');
			if (isset($_GET[$t])){
				$templateSet = $_GET[$t];
			}elseif(cookie('think_template')){
				$templateSet = cookie('think_template');
			}
			// 主题不存在时仍改回使用默认主题
			if(!is_dir(TMPL_PATH.$templateSet))
			$templateSet = C('DEFAULT_THEME');
			cookie('think_template',$templateSet);
		}
		/* 模板相关目录常量 */
		define('THEME_NAME',   $templateSet);                  // 当前模板主题名称
		$group   =  defined('GROUP_NAME')?GROUP_NAME.'/':'';
		define('THEME_PATH',   TMPL_PATH.$group.(THEME_NAME?THEME_NAME.'/':''));
		define('APP_TMPL_PATH',__ROOT__.'/'.APP_NAME.(APP_NAME?'/':'').basename(TMPL_PATH).'/'.$group.(THEME_NAME?THEME_NAME.'/':''));
		C('TEMPLATE_NAME',THEME_PATH.MODULE_NAME.(defined('GROUP_NAME')?C('TMPL_FILE_DEPR'):'/').ACTION_NAME.C('TMPL_TEMPLATE_SUFFIX'));
		C('CACHE_PATH',CACHE_PATH.$group);
		return ;
	}

	/**
	 +----------------------------------------------------------
	 * 执行应用程序
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @return void
	 +----------------------------------------------------------
	 * @throws ThinkExecption
	 +----------------------------------------------------------
	 */
	static public function exec() {
		// 安全检测
		if(!preg_match('/^[A-Za-z_0-9]+$/',MODULE_NAME)){
			$module =  false;
		}else{
			//创建Action控制器实例
			$group =  defined('GROUP_NAME') ? GROUP_NAME.'/' : '';
			$module  =  A($group.MODULE_NAME);
		}

		if(!$module) {
			if(function_exists('__hack_module')) {
				// hack 方式定义扩展模块 返回Action对象
				$module = __hack_module();
				if(!is_object($module)) {
					// 不再继续执行 直接返回
					return ;
				}
			}else{
				// 是否定义Empty模块
				$module = A('Empty');
				if(!$module){
					$msg =  L('_MODULE_NOT_EXIST_').MODULE_NAME;
					if(APP_DEBUG) {
						// 模块不存在 抛出异常
						throw_exception($msg);
					}else{
						if(C('LOG_EXCEPTION_RECORD')) Log::write($msg);
						send_http_status(404);
						exit;
					}
				}
			}
		}
		//获取当前操作名
		$action = ACTION_NAME;
		// 获取操作方法名标签
		tag('action_name',$action);
		if (method_exists($module,'_before_'.$action)) {
			// 执行前置操作
			call_user_func(array(&$module,'_before_'.$action));
		}
		//执行当前操作
		call_user_func(array(&$module,$action));
		if (method_exists($module,'_after_'.$action)) {
			//  执行后缀操作
			call_user_func(array(&$module,'_after_'.$action));
		}
		return ;
	}

	/**
	 +----------------------------------------------------------
	 * 运行应用实例 入口文件使用的快捷方法
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @return void
	 +----------------------------------------------------------
	 */
	static public function run() {
		// 项目初始化标签
		tag('app_init');
		App::init();
		// 项目开始标签
		tag('app_begin');
		// Session初始化
		session(C('SESSION_OPTIONS'));
		// 记录应用初始化时间
		G('initTime');
		App::exec();
		// 项目结束标签
		tag('app_end');
		// 保存日志记录
		if(C('LOG_RECORD')) Log::save();
		return ;
	}

}
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: Action.class.php 2791 2012-02-29 10:08:57Z liu21st $

/**
 +------------------------------------------------------------------------------
 * ThinkPHP Action控制器基类 抽象类
 +------------------------------------------------------------------------------
 * @category   Think
 * @package  Think
 * @subpackage  Core
 * @author   liu21st <liu21st@gmail.com>
 * @version  $Id: Action.class.php 2791 2012-02-29 10:08:57Z liu21st $
 +------------------------------------------------------------------------------
 */
abstract class Action {

	// 视图实例对象
	protected $view   =  null;
	// 当前Action名称
	private $name =  '';

	/**
	 +----------------------------------------------------------
	 * 架构函数 取得模板对象实例
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 */
	public function __construct() {
		tag('action_begin');
		//实例化视图类
		$this->view       = Think::instance('View');
		//控制器初始化
		if(method_exists($this,'_initialize'))
		$this->_initialize();
	}

	/**
	 +----------------------------------------------------------
	 * 获取当前Action名称
	 +----------------------------------------------------------
	 * @access protected
	 +----------------------------------------------------------
	 */
	protected function getActionName() {
		if(empty($this->name)) {
			// 获取Action名称
			$this->name     =   substr(get_class($this),0,-6);
		}
		return $this->name;
	}

	/**
	 +----------------------------------------------------------
	 * 是否AJAX请求
	 +----------------------------------------------------------
	 * @access protected
	 +----------------------------------------------------------
	 * @return bool
	 +----------------------------------------------------------
	 */
	protected function isAjax() {
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) ) {
			if('xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH']))
			return true;
		}
		if(!empty($_POST[C('VAR_AJAX_SUBMIT')]) || !empty($_GET[C('VAR_AJAX_SUBMIT')]))
		// 判断Ajax方式提交
		return true;
		return false;
	}

	/**
	 +----------------------------------------------------------
	 * 模板显示
	 * 调用内置的模板引擎显示方法，
	 +----------------------------------------------------------
	 * @access protected
	 +----------------------------------------------------------
	 * @param string $templateFile 指定要调用的模板文件
	 * 默认为空 由系统自动定位模板文件
	 * @param string $charset 输出编码
	 * @param string $contentType 输出类型
	 +----------------------------------------------------------
	 * @return void
	 +----------------------------------------------------------
	 */
	protected function display($templateFile='',$charset='',$contentType='') {
		$this->view->display($templateFile,$charset,$contentType);
	}

	/**
	 +----------------------------------------------------------
	 *  获取输出页面内容
	 * 调用内置的模板引擎fetch方法，
	 +----------------------------------------------------------
	 * @access protected
	 +----------------------------------------------------------
	 * @param string $templateFile 指定要调用的模板文件
	 * 默认为空 由系统自动定位模板文件
	 +----------------------------------------------------------
	 * @return string
	 +----------------------------------------------------------
	 */
	protected function fetch($templateFile='') {
		return $this->view->fetch($templateFile);
	}

	/**
	 +----------------------------------------------------------
	 *  创建静态页面
	 +----------------------------------------------------------
	 * @access protected
	 +----------------------------------------------------------
	 * @htmlfile 生成的静态文件名称
	 * @htmlpath 生成的静态文件路径
	 * @param string $templateFile 指定要调用的模板文件
	 * 默认为空 由系统自动定位模板文件
	 +----------------------------------------------------------
	 * @return string
	 +----------------------------------------------------------
	 */
	protected function buildHtml($htmlfile='',$htmlpath='',$templateFile='') {
		$content = $this->fetch($templateFile);
		$htmlpath   = !empty($htmlpath)?$htmlpath:HTML_PATH;
		$htmlfile =  $htmlpath.$htmlfile.C('HTML_FILE_SUFFIX');
		if(!is_dir(dirname($htmlfile)))
		// 如果静态目录不存在 则创建
		mk_dir(dirname($htmlfile));
		if(false === file_put_contents($htmlfile,$content))
		throw_exception(L('_CACHE_WRITE_ERROR_').':'.$htmlfile);
		return $content;
	}

	/**
	 +----------------------------------------------------------
	 * 模板变量赋值
	 +----------------------------------------------------------
	 * @access protected
	 +----------------------------------------------------------
	 * @param mixed $name 要显示的模板变量
	 * @param mixed $value 变量的值
	 +----------------------------------------------------------
	 * @return void
	 +----------------------------------------------------------
	 */
	protected function assign($name,$value='') {
		$this->view->assign($name,$value);
	}

	public function __set($name,$value) {
		$this->view->assign($name,$value);
	}

	/**
	 +----------------------------------------------------------
	 * 取得模板显示变量的值
	 +----------------------------------------------------------
	 * @access protected
	 +----------------------------------------------------------
	 * @param string $name 模板显示变量
	 +----------------------------------------------------------
	 * @return mixed
	 +----------------------------------------------------------
	 */
	public function __get($name) {
		return $this->view->get($name);
	}

	/**
	 +----------------------------------------------------------
	 * 魔术方法 有不存在的操作的时候执行
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @param string $method 方法名
	 * @param array $args 参数
	 +----------------------------------------------------------
	 * @return mixed
	 +----------------------------------------------------------
	 */
	public function __call($method,$args) {
		if( 0 === strcasecmp($method,ACTION_NAME)) {
			if(method_exists($this,'_empty')) {
				// 如果定义了_empty操作 则调用
				$this->_empty($method,$args);
			}elseif(file_exists_case(C('TEMPLATE_NAME'))){
				// 检查是否存在默认模版 如果有直接输出模版
				$this->display();
			}elseif(function_exists('__hack_action')) {
				// hack 方式定义扩展操作
				__hack_action();
			}elseif(APP_DEBUG) {
				// 抛出异常
				throw_exception(L('_ERROR_ACTION_').ACTION_NAME);
			}else{

				//fc_lamp 不存在动作时，更改错误显示
				send_http_status ( 404 );
				$this->display ( 'public:404' );
				exit ();				
				
				
			}
		}else{
			switch(strtolower($method)) {
				// 判断提交方式
				case 'ispost':
				case 'isget':
				case 'ishead':
				case 'isdelete':
				case 'isput':
					return strtolower($_SERVER['REQUEST_METHOD']) == strtolower(substr($method,2));
					// 获取变量 支持过滤和默认值 调用方式 $this->_post($key,$filter,$default);
				case '_get':      $input =& $_GET;break;
				case '_post':$input =& $_POST;break;
				case '_put': parse_str(file_get_contents('php://input'), $input);break;
				case '_request': $input =& $_REQUEST;break;
				case '_session': $input =& $_SESSION;break;
				case '_cookie':  $input =& $_COOKIE;break;
				case '_server':  $input =& $_SERVER;break;
				case '_globals':  $input =& $GLOBALS;break;
				default:
					throw_exception(__CLASS__.':'.$method.L('_METHOD_NOT_EXIST_'));
			}
			if(isset($input[$args[0]])) { // 取值操作
				$data	 =	 $input[$args[0]];
				$fun  =  $args[1]?$args[1]:C('DEFAULT_FILTER');
				$data	 =	 $fun($data); // 参数过滤
			}else{ // 变量默认值
				$data	 =	 isset($args[2])?$args[2]:NULL;
			}
			return $data;
		}
	}
	
	
	/**
	 * 
	 * 创建 验证码
	 */
	public function verify()
	{
		import ( "ORG.Util.Captcha" );
		$width = 130;
		$height = 45;
		$wordLength = 5;
		$fontSize = 25;
		$text = '';
		
		//创建验证码
		$ValidateObj = new Captcha ();
		//$ValidateObj->debug = True;
		$ValidateObj->width = $width;
		$ValidateObj->height = $height;
		$ValidateObj->maxWordLength = $wordLength;
		$ValidateObj->minWordLength = $wordLength;
		$ValidateObj->fontSize = $fontSize;
		$ValidateObj->CreateImage ( $text );
		
		$_SESSION ['verify'] = md5 ( $text );
	}

	
	/**
	 * 
	 * 获取出所有分类(通用)
	 * @param unknown_type $mod
	 * @param unknown_type $id
	 * @param unknown_type $level
	 * @param unknown_type $child
	 * @param unknown_type $field
	 * @param unknown_type $orderby
	 */
	public function get_cate_comm($mod, $id = 0, $level = 0, $child = False, $field = '', $orderby = '`sort` DESC,id DESC')
	{
		if (empty ( $field ))
		{
			$field = 'id,name,pid,type';
		}
		
		$list = array ();
		$res = $mod->field ( $field )->where ( 'pid=' . $id . ' and `status`=1' )->order ( $orderby )->select ();
		if (empty ( $res ))
		{
			return $list;
		}
		$level += 1;
		
		//是否要获取子级
		if ($child)
		{
			foreach ( $res as $v )
			{
				$v['access'] = 'yes';
				$v ['level'] = $level;
				$v ['items'] = $this->get_cate_comm ( $mod, $v ['id'], $level, True, $field );
				$list [$v['id']] = $v;
			}
		} else
		{
			foreach ( $res as  $v )
			{
				$v['access'] = 'yes';
				$v ['level'] = $level;
				$list [$v['id']] = $v;
			}
		}
		
		return $list;
	}	
	
	
	/**
	 * 
	 * 平行呈现树形结构的分类（仅ID）
	 * @param unknown_type $data
	 * @internal
	 *  结果后面有','
	 */
	public function display_tree_ids($data)
	{
		$ids = '';
		foreach ( $data as $v )
		{
			if (isset ( $v ['access'] ) and $v ['access'] == 'yes')
			{
				$ids .= $v ['id'] . ',';
			}
			
			if (! empty ( $v ['items'] ))
			{
				$ids .= $this->display_tree_ids ( $v ['items'] );
			}
		}
		return $ids;
	}	
	

	/**
	 * 
	 * 平行呈现树形结构的分类
	 * @param unknown_type $data
	 */
	public function display_tree_all($data)
	{
		$array =  array();
		foreach ( $data as $v )
		{
			if (isset ( $v ['access'] ) and $v ['access'] == 'yes')
			{
				$t = $v;
				unset($t['items']);
				$array[$v['id']]= $t;
			}
			
			if (! empty ( $v ['items'] ))
			{
				$array += $this->display_tree_all ( $v ['items'] );
				
			}
		}
		return $array;
	}	
	
	
	/**
	 +----------------------------------------------------------
	 * 操作错误跳转的快捷方法
	 +----------------------------------------------------------
	 * @access protected
	 +----------------------------------------------------------
	 * @param string $message 错误信息
	 * @param string $jumpUrl 页面跳转地址
	 * @param Boolean $ajax 是否为Ajax方式
	 +----------------------------------------------------------
	 * @return void
	 +----------------------------------------------------------
	 */
	protected function error($message,$jumpUrl='',$ajax=false) {
		$this->dispatchJump($message,0,$jumpUrl,$ajax);
	}

	/**
	 +----------------------------------------------------------
	 * 操作成功跳转的快捷方法
	 +----------------------------------------------------------
	 * @access protected
	 +----------------------------------------------------------
	 * @param string $message 提示信息
	 * @param string $jumpUrl 页面跳转地址
	 * @param Boolean $ajax 是否为Ajax方式
	 +----------------------------------------------------------
	 * @return void
	 +----------------------------------------------------------
	 */
	protected function success($message,$jumpUrl='',$ajax=false) {
		$this->dispatchJump($message,1,$jumpUrl,$ajax);
	}

	/**
	 +----------------------------------------------------------
	 * Ajax方式返回数据到客户端
	 +----------------------------------------------------------
	 * @access protected
	 +----------------------------------------------------------
	 * @param mixed $data 要返回的数据
	 * @param String $info 提示信息
	 * @param boolean $status 返回状态
	 * @param String $status ajax返回类型 JSON XML
	 +----------------------------------------------------------
	 * @return void
	 +----------------------------------------------------------
	 */
	protected function ajaxReturn($data,$info='',$status=1,$type='') {
		$result  =  array();
		$result['status']  =  $status;
		$result['info'] =  $info;
		$result['data'] = $data;
		//扩展ajax返回数据, 在Action中定义function ajaxAssign(&$result){} 方法 扩展ajax返回数据。
		if(method_exists($this,'ajaxAssign'))
		$this->ajaxAssign($result);
		if(empty($type)) $type  =   C('DEFAULT_AJAX_RETURN');
		if(strtoupper($type)=='JSON') {
			// 返回JSON数据格式到客户端 包含状态信息
			header('Content-Type:text/html; charset=utf-8');
			exit(json_encode($result));
		}elseif(strtoupper($type)=='XML'){
			// 返回xml格式数据
			header('Content-Type:text/xml; charset=utf-8');
			exit(xml_encode($result));
		}elseif(strtoupper($type)=='EVAL'){
			// 返回可执行的js脚本
			header('Content-Type:text/html; charset=utf-8');
			exit($data);
		}else{
			// TODO 增加其它格式
		}
	}

	/**
	 +----------------------------------------------------------
	 * Action跳转(URL重定向） 支持指定模块和延时跳转
	 +----------------------------------------------------------
	 * @access protected
	 +----------------------------------------------------------
	 * @param string $url 跳转的URL表达式
	 * @param array $params 其它URL参数
	 * @param integer $delay 延时跳转的时间 单位为秒
	 * @param string $msg 跳转提示信息
	 +----------------------------------------------------------
	 * @return void
	 +----------------------------------------------------------
	 */
	protected function redirect($url,$params=array(),$delay=0,$msg='') {
		$url    =   U($url,$params);
		redirect($url,$delay,$msg);
	}

	/**
	 +----------------------------------------------------------
	 * 默认跳转操作 支持错误导向和正确跳转
	 * 调用模板显示 默认为public目录下面的success页面
	 * 提示页面为可配置 支持模板标签
	 +----------------------------------------------------------
	 * @param string $message 提示信息
	 * @param Boolean $status 状态
	 * @param string $jumpUrl 页面跳转地址
	 * @param Boolean $ajax 是否为Ajax方式
	 +----------------------------------------------------------
	 * @access private
	 +----------------------------------------------------------
	 * @return void
	 +----------------------------------------------------------
	 */
	private function dispatchJump($message,$status=1,$jumpUrl='',$ajax=false) {
		// 判断是否为AJAX返回
		if($ajax || $this->isAjax()) $this->ajaxReturn($ajax,$message,$status);
		if(!empty($jumpUrl)) $this->assign('jumpUrl',$jumpUrl);
		// 提示标题
		$this->assign('msgTitle',$status? L('_OPERATION_SUCCESS_') : L('_OPERATION_FAIL_'));
		//如果设置了关闭窗口，则提示完毕后自动关闭窗口
		if($this->view->get('closeWin'))    $this->assign('jumpUrl','javascript:window.close();');
		$this->assign('status',$status);   // 状态
		//保证输出不受静态缓存影响
		C('HTML_CACHE_ON',false);
		if($status) { //发送成功信息
			$this->assign('message',$message);// 提示信息
			// 成功操作后默认停留1秒
			if(!$this->view->get('waitSecond'))    $this->assign('waitSecond','1');
			// 默认操作成功自动返回操作前页面
			if(!$this->view->get('jumpUrl')) $this->assign("jumpUrl",$_SERVER["HTTP_REFERER"]);
			$this->display(C('TMPL_ACTION_SUCCESS'));
			exit;
		}else{
			$this->assign('error',$message);// 提示信息
			//发生错误时候默认停留3秒
			if(!$this->view->get('waitSecond'))    $this->assign('waitSecond','3');
			// 默认发生错误的话自动返回上页
			if(!$this->view->get('jumpUrl')) $this->assign('jumpUrl',"javascript:history.back(-1);");
			$this->display(C('TMPL_ACTION_ERROR'));
			// 中止执行  避免出错后继续执行
			exit ;
		}
	}

	/**
	 +----------------------------------------------------------
	 * 析构方法
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 */
	public function __destruct() {
		// 保存日志
		if(C('LOG_RECORD')) Log::save();
		// 执行后续操作
		tag('action_end');
	}
}
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: View.class.php 2702 2012-02-02 12:35:01Z liu21st $

/**
 +------------------------------------------------------------------------------
 * ThinkPHP 视图输出
 +------------------------------------------------------------------------------
 * @category   Think
 * @package  Think
 * @subpackage  Core
 * @author liu21st <liu21st@gmail.com>
 * @version  $Id: View.class.php 2702 2012-02-02 12:35:01Z liu21st $
 +------------------------------------------------------------------------------
 */
class View {
	protected $tVar        =  array(); // 模板输出变量

	/**
	 +----------------------------------------------------------
	 * 模板变量赋值
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @param mixed $name
	 * @param mixed $value
	 +----------------------------------------------------------
	 */
	public function assign($name,$value=''){
		if(is_array($name)) {
			$this->tVar   =  array_merge($this->tVar,$name);
		}elseif(is_object($name)){
			foreach($name as $key =>$val)
			$this->tVar[$key] = $val;
		}else {
			$this->tVar[$name] = $value;
		}
	}

	/**
	 +----------------------------------------------------------
	 * 取得模板变量的值
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @param string $name
	 +----------------------------------------------------------
	 * @return mixed
	 +----------------------------------------------------------
	 */
	public function get($name){
		if(isset($this->tVar[$name]))
		return $this->tVar[$name];
		else
		return false;
	}

	/* 取得所有模板变量 */
	public function getAllVar(){
		return $this->tVar;
	}

	// 调试页面所有的模板变量
	public function traceVar(){
		foreach ($this->tVar as $name=>$val){
			dump($val,1,'['.$name.']<br/>');
		}
	}

	/**
	 +----------------------------------------------------------
	 * 加载模板和页面输出 可以返回输出内容
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @param string $templateFile 模板文件名
	 * @param string $charset 模板输出字符集
	 * @param string $contentType 输出类型
	 +----------------------------------------------------------
	 * @return mixed
	 +----------------------------------------------------------
	 */
	public function display($templateFile='',$charset='',$contentType='') {
		G('viewStartTime');
		// 视图开始标签
		tag('view_begin',$templateFile);
		// 解析并获取模板内容
		$content = $this->fetch($templateFile);
		// 输出模板内容
		$this->show($content,$charset,$contentType);
		// 视图结束标签
		tag('view_end');
	}

	/**
	 +----------------------------------------------------------
	 * 输出内容文本可以包括Html
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @param string $content 输出内容
	 * @param string $charset 模板输出字符集
	 * @param string $contentType 输出类型
	 +----------------------------------------------------------
	 * @return mixed
	 +----------------------------------------------------------
	 */
	public function show($content,$charset='',$contentType=''){
		if(empty($charset))  $charset = C('DEFAULT_CHARSET');
		if(empty($contentType)) $contentType = C('TMPL_CONTENT_TYPE');
		// 网页字符编码
		header('Content-Type:'.$contentType.'; charset='.$charset);
		header('Cache-control: private');  //支持页面回跳
		header('X-Powered-By:ThinkPHP');
		// 输出模板文件
		echo $content;
	}

	/**
	 +----------------------------------------------------------
	 * 解析和获取模板内容 用于输出
	 +----------------------------------------------------------
	 * @access public
	 +----------------------------------------------------------
	 * @param string $templateFile 模板文件名
	 +----------------------------------------------------------
	 * @return string
	 +----------------------------------------------------------
	 */
	public function fetch($templateFile='') {
		// 模板文件解析标签
		tag('view_template',$templateFile);
		// 模板文件不存在直接返回
		if(!is_file($templateFile)) return NULL;
		// 页面缓存
		ob_start();
		ob_implicit_flush(0);
		if('php' == strtolower(C('TMPL_ENGINE_TYPE'))) { // 使用PHP原生模板
			// 模板阵列变量分解成为独立变量
			extract($this->tVar, EXTR_OVERWRITE);
			// 直接载入PHP模板
			include $templateFile;
		}else{
			// 视图解析标签
			$params = array('var'=>$this->tVar,'file'=>$templateFile);
			tag('view_parse',$params);
		}
		// 获取并清空缓存
		$content = ob_get_clean();
		// 内容过滤标签
		tag('view_filter',$content);
		// 输出模板文件
		return $content;
	}
}
/**
 +----------------------------------------------------------
 * 字符串截取，支持中文和其他编码
 +----------------------------------------------------------
 * @static
 * @access public
 +----------------------------------------------------------
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 +----------------------------------------------------------
 * @return string
 +----------------------------------------------------------
 */
function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true)
{
	if (function_exists ( "mb_substr" ))
		$slice = mb_substr ( $str, $start, $length, $charset );
	elseif (function_exists ( 'iconv_substr' ))
	{
		$slice = iconv_substr ( $str, $start, $length, $charset );
		if (false === $slice)
		{
			$slice = '';
		}
	} else
	{
		$re ['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
		$re ['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
		$re ['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
		$re ['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
		preg_match_all ( $re [$charset], $str, $match );
		$slice = join ( "", array_slice ( $match [0], $start, $length ) );
	}
	return $suffix ? $slice . '' : $slice;
}
//计算时间
function gettime($time)
{
	if ($rtime = (time () - $time) / 3600 / 24 / 365 > 1)
	{
		$rtime = (time () - $time) / 3600 / 24 / 365;
		return floor ( $rtime ) . "年前";
	} elseif ($rtime = (time () - $time) / 3600 / 24 / 30 > 1)
	{
		$rtime = (time () - $time) / 3600 / 24 / 30;
		return floor ( $rtime ) . "月前";
	} elseif ($rtime = (time () - $time) / 3600 / 24 > 1)
	{
		$rtime = (time () - $time) / 3600 / 24;
		return floor ( $rtime ) . "天前";
	} elseif ($rtime = (time () - $time) / 3600 > 1)
	{
		$rtime = (time () - $time) / 3600;
		return floor ( $rtime ) . "小时前";
	} elseif ((time () - $time) / 60 > 1)
	{
		$rtime = (time () - $time) / 60;
		return floor ( $rtime ) . "分钟前";
	} elseif ((time () - $time) < 60)
	{
		return time () - $time . "秒前";
	}
}
//获取用户名
function getUserName($uid)
{
	$map ['id'] = $uid;
	$uc = M ( 'user' )->field ( 'name' )->where ( $map )->find ();
	return $uc ['name'];
}
/*
*   返回剪裁后的图片地址$id = 商品ID    $width = 剪裁后的图片宽度
*/
function isImages($id)
{
	$path1 = ROOT_PATH . '/data/items/' . $id . '/' . md5 ( 64 ) . '_64.jpg';
	$path2 = ROOT_PATH . '/data/items/' . $id . '/' . md5 ( 210 ) . '_210.jpg';
	$path3 = ROOT_PATH . '/data/items/' . $id . '/' . md5 ( 450 ) . '_450.jpg';
	return file_exists ( $path1 ) && file_exists ( $path2 ) && file_exists ( $path3 ) ? true : false;
}
//屏蔽蜘蛛访问
function banspider($ban_str)
{
	if (preg_match ( "/($ban_str)/i", $_SERVER ['HTTP_USER_AGENT'] ))
	{
		exit ();
	}
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
*   返回剪裁后的图片地址$id = 商品ID    $width = 剪裁后的图片宽度
*/
function base64ImagesPath($id, $width)
{
	return base64_encode ( SITE_ROOT . '/data/items/' . $id . '/' . md5 ( $width ) . '_' . $width . '.jpg' );
}
//剪裁图平
function calculation($iamges, $path, $width = array('64','210','450'))
{
	foreach ( $width as $vwidth )
	{
		if (! isDir ( $path ))
		{
			return "建立目录不成功！";
		}
		//获取图片资源的宽度、高度、类型
		list ( $imagewidth, $imageheight, $imageType ) = getimagesize ( $iamges );
		switch ($imageType)
		{
			case "image/gif" :
				$im = imagecreatefromgif ( $iamges );
				break;
			case "image/pjpeg" :
			case "image/jpeg" :
			case "image/jpg" :
				$im = imagecreatefromjpeg ( $iamges );
				break;
			case "image/png" :
			case "image/x-png" :
				$im = imagecreatefrompng ( $iamges );
				break;
		}
		
		//计算比例
		$proportion = $vwidth / $imagewidth;
		//$im = imagecreatefromjpeg($iamges);
		

		//计算新图片大小   
		$new_img_width = $proportion * $imagewidth;
		$new_img_height = $proportion * $imageheight;
		
		if ($vwidth < $imagewidth)
		{
			$newim = imagecreatetruecolor ( $new_img_width, $new_img_height );
			//复制资源
			imagecopyresampled ( $newim, $im, 0, 0, 0, 0, $new_img_width, $new_img_height, $imagewidth, $imageheight );
		} else
		{
			$newim = imagecreatetruecolor ( $imagewidth, $imageheight );
			//复制资源
			imagecopyresampled ( $newim, $im, 0, 0, 0, 0, $imagewidth, $imageheight, $imagewidth, $imageheight );
		}
		$saveimages = $path . md5 ( $vwidth ) . '_' . $vwidth . ".jpg";
		
		//header('Content-Type: image/jpeg');
		//imagejpeg($newim); 
		imagejpeg ( $newim, $saveimages, 75 );
		imagedestroy ( $newim );
		imagedestroy ( $im );
	}
}
function isDir($path)
{
	if (is_dir ( $path ))
	{
		return true;
	} else
	{
		if (mkdir ( $path, 777 ))
			return true;
		else
			return false;
	}
}
/*url_parse*/
function url_parse($url)
{
	$rs = preg_match ( "/^(http:\/\/|https:\/\/)/", $url, $match );
	if (intval ( $rs ) == 0)
	{
		$url = "http://" . $url;
	}
	return $url;
}
function base64encode($data)
{
	return base64_encode ( $data );
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

/*
    获取用户金钱
*/
/*
    写入cookie方法
*/
function writeCookie($uid, $uname)
{
	$last_time = time ();
	$key = md5 ( $uid . $uname . $last_time );
	cookie ( 'user[id]', $uid );
	cookie ( 'user[name]', $uname );
	cookie ( 'user[login_time]', $last_time );
	cookie ( 'user[key]', $key );
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
			$facePath = ROOT_PATH . "/data/user/{$uid}/{$v}{$uid}.jpg";
			if (file_exists ( $facePath ))
			{
				$face [$k] = SITE_ROOT . "data/user/{$uid}/{$array[$k]}{$uid}.jpg";
			} else
			{
				$face [$k] = SITE_ROOT . "data/user/{$array[$k]}avatar.gif";
			}
		}
		
		return $face;
	} else
	{
		$defaultFace = ROOT_PATH . "/data/user/{$type}_avatar.gif";
		$newFace = ROOT_PATH . "/data/user/{$uid}/{$type}_{$uid}.jpg";
		if (file_exists ( $newFace ))
			$face = SITE_ROOT . "data/user/{$uid}/{$type}_{$uid}.jpg";
		else
			$face = SITE_ROOT . "data/user/{$type}_avatar.gif";
		return $face;
	
	}

}
/*
*  获取管理员用户名
*/
function getAdminUserName()
{
	if ($_SESSION ['admin_info'] ['user_name'])
	{
		return $_SESSION ['admin_info'] ['user_name'];
	} else
	{
		$adminUser = M ( "admin" )->where ( "id=1" )->find ();
		return $adminUser ['user_name'];
	}
}

function uc($url, $vars = '', $suffix = true, $redirect = false, $domain = false)
{
	$uid = empty ( $_REQUEST ['uid'] ) ? $_COOKIE ['user'] ['id'] : intval ( $_REQUEST ['uid'] );
	if ($vars == '')
	{
		$vars = "&uid=" . $uid;
	} elseif (is_array ( $vars ))
	{
		$vars ['uid'] = $uid;
	}
	return u ( $url, $vars, $suffix, $redirect, $domain );
}
function uimg($img)
{
	if (empty ( $img ))
	{
		return SITE_ROOT . "data/user/avatar.gif";
	}
	return $img;
}
/*
 * 检查是否喜欢、分享,不存在则添加
 * */
function check_favorite($type, $id)
{
	$mod = D ( $type );
	if (! $mod->where ( "items_id=$id and uid=" . $_COOKIE ['user'] ['id'] )->count () > 0)
	{
		$mod->add ( array ('items_id' => $id, 'uid' => $_COOKIE ['user'] ['id'], 'add_time' => time () ) );
		return false;
	}
	return true;
}
/*
 * 获取喜欢记录
 * */
function get_favorite($type, $pagesize = 8)
{
	import ( "ORG.Util.Page" );
	
	if ($type == 'like_list')
	{
		$mod = D ( $type );
		$items_mod = D ( 'items' );
		
		$where = 'uid=' . $_COOKIE ['user'] ['id'];
		
		$count = $mod->where ( $where )->count ();
		$p = new Page ( $count, $pagesize );
		
		$like_list = $mod->where ( $where )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		
		foreach ( $like_list as $key => $val )
		{
			
			$list [$key] = $items_mod->where ( 'id=' . $val ['items_id'] )->find ();
		}
		return array ('list' => $list, 'page' => $p->show () );
	} else if ($type == 'share_list')
	{
		$where = 'uid=' . $_COOKIE ['user'] ['id'];
		$mod = D ( 'items' );
		$count = $mod->where ( $where )->count ();
		
		$p = new Page ( $count, $pagesize );
		$list = $mod->where ( $where )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		return array ('list' => $list, 'page' => $p->show () );
	}
}
//检测cookie是否正常
function check_cookie()
{
	if (isset ( $_COOKIE ['user'] ))
	{
		$key = $_COOKIE ['user'] ['key'];
		$now_key = $_SESSION ['user_info'] ['id'] . $_SESSION ['user_info'] ['user_name']. $_SESSION ['user'] ['login_time'];
		if ($key != md5 ( $now_key ))
		{
			return false;
		}
		
		return true;
	
	} else
	{
		return false;
	}
}
//转换时间
function gmtTime()
{
	return date ( 'Ymdhis' );
}
//表单转义
function setFormString($_string)
{
	if (! get_magic_quotes_gpc ())
	{
		if (is_array ( $_string ))
		{
			foreach ( $_string as $_key => $_value )
			{
				$_string [$_key] = setFormString ( $_value ); //不支持就用代替addslashes();
			}
		} else
		{
			return addslashes ( $_string ); //mysql_real_escape_string($_string, $_link);
		}
	}
	return $_string;
}
//如果不是二维数组返回true
function IsTwoArray($array)
{
	return count ( $array ) == count ( $array, 1 );
}
/*
 * code=1表示是赋值操作
 * code=2表示取值操作
 * */
function replace_url($url, $code = 1)
{
	if ($code == 1)
	{
		$url = str_replace ( "img", "<1<", $url );
		$url = str_replace ( "image", "<2<", $url );
		$url = str_replace ( "taobaocdn.com", "<3<", $url );
		$url = str_replace ( "59miao.com", "<4<", $url );
		$url = str_replace ( "/bao/uploaded", "<5<", $url );
		$url = str_replace ( "210x1000", "<6<", $url );
		$url = str_replace ( "http://", "<7<", $url );
		$url = base64_encode ( $url );
		//$url=substr($url, 0,10).'/'.substr($url, 10,strlen($url)).'.jpg';
		$url = substr ( $url, 0, 10 ) . '/' . substr ( $url, 10, 10 ) . '/' . substr ( $url, 20, strlen ( $url ) ) . '.jpg';
	
		//$url = $url .'.jpg';
	//if($weijingtai==1){$url="photo/".$url;}else{$url="photo.php?url=".$url;} 
	}
	if ($code == 2)
	{
		$url = str_replace ( ".jpg", "", $url );
		$url = str_replace ( "/", "", $url );
		$url = base64_decode ( $url );
		$url = str_replace ( "<1<", "img", $url );
		$url = str_replace ( "<2<", "image", $url );
		$url = str_replace ( "<3<", "taobaocdn.com", $url );
		$url = str_replace ( "<4<", "59miao.com", $url );
		$url = str_replace ( "<5<", "/bao/uploaded", $url );
		$url = str_replace ( "<6<", "210x1000", $url );
		$url = str_replace ( "<7<", "http://", $url );
	
	}
	return $url;
}
//数组中随机取出俩个数
function getRandArray($array)
{
	$i = rand ( 0, count ( $array ) - 1 );
	if ($i == count ( $array ) - 1)
	{
		$j = 0;
	} else
	{
		$j = $i + 1;
	}
	$new_ad_rel = array ();
	
	$new_ad_rel [] = $array [$i];
	$new_ad_rel [] = $array [$j];
	return $new_ad_rel;
}


L(array (
  '_MODULE_NOT_EXIST_' => '无法加载模块',
  '_ERROR_ACTION_' => '非法操作',
  '_LANGUAGE_NOT_LOAD_' => '无法加载语言包',
  '_TEMPLATE_NOT_EXIST_' => '模板不存在',
  '_MODULE_' => '模块',
  '_ACTION_' => '操作',
  '_ACTION_NOT_EXIST_' => '控制器不存在或者没有定义',
  '_MODEL_NOT_EXIST_' => '模型不存在或者没有定义',
  '_VALID_ACCESS_' => '没有权限',
  '_XML_TAG_ERROR_' => 'XML标签语法错误',
  '_DATA_TYPE_INVALID_' => '非法数据对象！',
  '_OPERATION_WRONG_' => '操作出现错误',
  '_NOT_LOAD_DB_' => '无法加载数据库',
  '_NOT_SUPPORT_DB_' => '系统暂时不支持数据库',
  '_NO_DB_CONFIG_' => '没有定义数据库配置',
  '_NOT_SUPPERT_' => '系统不支持',
  '_CACHE_TYPE_INVALID_' => '无法加载缓存类型',
  '_FILE_NOT_WRITEABLE_' => '目录（文件）不可写',
  '_METHOD_NOT_EXIST_' => '您所请求的方法不存在！',
  '_CLASS_NOT_EXIST_' => '实例化一个不存在的类！',
  '_CLASS_CONFLICT_' => '类名冲突',
  '_TEMPLATE_ERROR_' => '模板引擎错误',
  '_CACHE_WRITE_ERROR_' => '缓存文件写入失败！',
  '_TAGLIB_NOT_EXIST_' => '标签库未定义',
  '_OPERATION_FAIL_' => '操作失败！',
  '_OPERATION_SUCCESS_' => '操作成功！',
  '_SELECT_NOT_EXIST_' => '记录不存在！',
  '_EXPRESS_ERROR_' => '表达式错误',
  '_TOKEN_ERROR_' => '表单令牌错误',
  '_RECORD_HAS_UPDATE_' => '记录已经更新',
  '_NOT_ALLOW_PHP_' => '模板禁用PHP代码',
));C(array (
  'app_status' => 'debug',
  'app_file_case' => false,
  'app_autoload_path' => '',
  'app_tags_on' => true,
  'app_sub_domain_deploy' => false,
  'app_sub_domain_rules' => 
  array (
  ),
  'app_sub_domain_deny' => 
  array (
  ),
  'app_group_list' => '',
  'cookie_expire' => 3600,
  'cookie_domain' => '',
  'cookie_path' => '/',
  'cookie_prefix' => '',
  'default_app' => '@',
  'default_lang' => 'zh-cn',
  'default_theme' => 'myweb',
  'default_group' => 'Home',
  'default_module' => 'index',
  'default_action' => 'index',
  'default_charset' => 'utf-8',
  'default_timezone' => 'PRC',
  'default_ajax_return' => 'JSON',
  'default_filter' => 'htmlspecialchars',
  'db_type' => 'mysql',
  'db_host' => '127.0.0.1',
  'db_name' => 'hezong.com',
  'db_user' => 'root',
  'db_pwd' => '',
  'db_port' => '3306',
  'db_prefix' => 'cms_',
  'db_fieldtype_check' => false,
  'db_fields_cache' => true,
  'db_charset' => 'utf8',
  'db_deploy_type' => 0,
  'db_rw_separate' => false,
  'db_master_num' => 1,
  'db_sql_build_cache' => false,
  'db_sql_build_queue' => 'file',
  'db_sql_build_length' => 20,
  'data_cache_time' => 0,
  'data_cache_compress' => false,
  'data_cache_check' => false,
  'data_cache_type' => 'file',
  'data_cache_path' => './index/Runtime/Temp/',
  'data_cache_subdir' => true,
  'data_path_level' => 2,
  'error_message' => '您浏览的页面暂时发生了错误！请稍后再试～或者联系管理员',
  'error_page' => '',
  'show_error_msg' => false,
  'log_record' => false,
  'log_type' => 3,
  'log_dest' => '',
  'log_extra' => '',
  'log_level' => 'EMERG,ALERT,CRIT,ERR',
  'log_file_size' => 2097152,
  'log_exception_record' => false,
  'session_auto_start' => true,
  'session_options' => 
  array (
  ),
  'session_type' => '',
  'session_prefix' => '',
  'var_session_id' => 'session_id',
  'tmpl_content_type' => 'text/html',
  'tmpl_action_error' => 'public:error',
  'tmpl_action_success' => 'public:success',
  'tmpl_exception_file' => './includes/thinkphp/Tpl/think_exception.tpl',
  'tmpl_detect_theme' => false,
  'tmpl_template_suffix' => '.html',
  'tmpl_file_depr' => '/',
  'url_case_insensitive' => false,
  'url_model' => 1,
  'url_pathinfo_depr' => '/',
  'url_pathinfo_fetch' => 'ORIG_PATH_INFO,REDIRECT_PATH_INFO,REDIRECT_URL',
  'url_html_suffix' => 'html',
  'var_group' => 'g',
  'var_module' => 'm',
  'var_action' => 'a',
  'var_ajax_submit' => 'ajax',
  'var_pathinfo' => 's',
  'var_url_params' => '_URL_',
  'var_template' => 't',
  'token_on' => false,
  'url_rewirte_mode_val' => '1',
  'url_router_on' => true,
  'url_route_rules' => 
  array (
  ),
  'extends' => 
  array (
    'app_init' => 
    array (
    ),
    'app_begin' => 
    array (
      0 => 'ReadHtmlCache',
    ),
    'route_check' => 
    array (
      0 => 'CheckRoute',
    ),
    'app_end' => 
    array (
    ),
    'path_info' => 
    array (
    ),
    'action_begin' => 
    array (
    ),
    'action_end' => 
    array (
    ),
    'view_begin' => 
    array (
    ),
    'view_template' => 
    array (
      0 => 'LocationTemplate',
    ),
    'view_parse' => 
    array (
      0 => 'ParseTemplate',
    ),
    'view_filter' => 
    array (
      0 => 'ContentReplace',
      1 => 'TokenBuild',
      2 => 'WriteHtmlCache',
      3 => 'ShowRuntime',
    ),
    'view_end' => 
    array (
      0 => 'ShowPageTrace',
    ),
  ),
));G('loadTime');Think::Start();