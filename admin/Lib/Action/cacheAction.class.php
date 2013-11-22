<?php
/**
 * 
 * 更新缓存
 * @author fc_lamp
 * @time: 20131115修改
 *
 */
class cacheAction extends baseAction
{
	
	public function _initialize()
	{
		parent::_initialize ();
		$this->mod = D ( 'cache' );
	}
	
	function index()
	{
		$this->display ();
	}
	
	function clearCache()
	{
		//更新后台缓存
		$this->clear_dir ( CACHE_PATH );
		$this->clear_dir ( DATA_PATH . '_fields/' );
		$this->clear_dir ( TEMP_PATH );
		
		//更新前台缓存
		$font_root = $_SERVER ['DOCUMENT_ROOT'] . '/index/Runtime/';
		$cache_ = $font_root . 'Cache/';
		$this->clear_dir ( $cache_ );
		
		$data_ = $font_root . 'Data/_fields/';
		$this->clear_dir ( $data_ );
		
		$temp_ = $font_root . 'Temp/';
		$this->clear_dir ( $temp_ );
		
		//Api缓存
		$this->clear_dir ( './Apicache/' );
		
		//运行文件
		$runtime = '~runtime.php';
		$runtime_file_admin = RUNTIME_PATH . $runtime;
		$runtime_file_front = $font_root . $runtime;
		
		if (is_file ( $runtime_file_admin ))
		{
			unlink ( $runtime_file_admin );
		}
		
		if (is_file ( $runtime_file_front ))
		{
			unlink ( $runtime_file_front );
		}
		$this->success ( '更新完成', U ( 'cache/index' ) );
	}
	
	public function clear_dir($dir)
	{

		if (is_dir ( $dir ))
		{
			$files = scandir ( $dir );
			foreach ( $files as $file )
			{
				$file_path = $dir . $file;
				if ($file != '.' and $file != '..' and is_file ( $file_path ))
				{
					unlink ( $file_path );
				}
			}
		}
	}

}