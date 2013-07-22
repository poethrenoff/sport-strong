<?
	include $_SERVER['DOCUMENT_ROOT'] . '/common/config.php';
	include $_SERVER['DOCUMENT_ROOT'] . '/common/db/db.php';
	include $_SERVER['DOCUMENT_ROOT'] . '/common/upload.php';
	
	include $_SERVER['DOCUMENT_ROOT'] . '/common/smarty/Smarty.class.php';
	
	// Удаляем экранирующие бэкслэши из входных параметров
	if ( get_magic_quotes_gpc() )
	{
		$_GET = stripslashes_mix( $_GET );
		$_POST = stripslashes_mix( $_POST );
		$_COOKIE = stripslashes_mix( $_COOKIE );
		$_REQUEST = stripslashes_mix( $_REQUEST );
	}
	
	// Рекурсивная функция снятия бэкслэшей
	function stripslashes_mix( &$mix )
	{
		if ( is_array( $mix ) )
		{
			foreach( $mix as $key => $value )
			{
				$key_temp = stripslashes( $key );
				if ( $key_temp != $key ) unset( $mix[$key] );
				$mix[$key_temp] = is_array( $value ) ?
					stripslashes_mix( $value ) : stripslashes( $value );
			}
		}
		return $mix;
	}
	
	// Базовый класс для работы с шаблонами
	class SmartyEx extends Smarty
	{
		function SmartyEx()
		{
			$this -> Smarty();
			
			$this -> cache_dir = $_SERVER['DOCUMENT_ROOT'] . '/common/smarty/cache/';
			$this -> compile_dir = $_SERVER['DOCUMENT_ROOT'] . '/common/smarty/compile/';
			
			$this -> caching = false;
		}
	}
	
	// Инициализация строковой переменной
	function init_string( $varname, $vardef = '' )
	{
		if ( isset( $_REQUEST[$varname] ) )
			return (string) $_REQUEST[$varname];
		else
			return (string) $vardef;
	}
	
	// Инициализация массива
	function init_array( $varname, $vardef = array() )
	{
		if ( isset( $_REQUEST[$varname] ) && is_array( $_REQUEST[$varname] ) )
			return (array) $_REQUEST[$varname];
		else
			return (array) $vardef;
	}
	
	// Инициализация переменной из сессии
	function init_session( $varname, $vardef = '' )
	{
		if ( isset( $_SESSION[$varname] ) )
			return (string) $_SESSION[$varname];
		else
			return (string) $vardef;
	}
	
	// Инициализация переменной из куков
	function init_cookie( $varname, $vardef = '' )
	{
		if ( isset( $_COOKIE[$varname] ) )
			return (string) $_COOKIE[$varname];
		else
			return (string) $vardef;
	}
	
	// Метод готовит массив параметров запроса
	function prepare_query( $include = array(), $except = array() )
	{
		$query_array = array();
		if ( is_array( $include ) && !empty( $include ) )
		{
			$request_array = explode( '&', http_build_query( $include ) );
			foreach( $request_array as $request_key => $request_value )
			{
				list( $key, $value ) = explode( '=', $request_value );
				if ( !in_array( $key, $except ) && $value !== '' )
					$query_array[$key] = $value;
			}
		}
		return $query_array;
	}
	
	// Метод формирует массив пар ключ-значение параметров запроса
	function make_query( $include = array(), $except = array() )
	{
		$query_pairs = array();
		foreach ( prepare_query( $include, $except ) as $key => $value )
			$query_pairs[] = $key . '=' . $value;
		
		return $query_pairs;
	}
	
	// Метод формирует массив данных для скрытых полей формы
	function make_hidden( $include = array(), $except = array() )
	{
		$query_pairs = array();
		foreach ( prepare_query( $include, $except ) as $key => $value )
			$query_pairs[htmlspecialchars( urldecode( $key ), ENT_QUOTES )] =
				htmlspecialchars( urldecode( $value ), ENT_QUOTES );
		
		return $query_pairs;
	}
	
	// Метод формирует ссылку на основании переданных данных
	function get_url( $include = array(), $except = array(), $script_name = '', $glue = '&amp;' )
	{
		$query_string = join( $glue, make_query( $include, $except ) );
		return ( $script_name ? $script_name : $_SERVER['SCRIPT_NAME'] ) . ( $query_string ? '?' . $query_string : '' );
	}
	
	// Метод формирует ссылку на основании $_GET и переданных данных
	function get_request_url( $include = array(), $except = array(), $script_name = '', $glue = '&amp;' )
	{
		return get_url( array_merge( $_GET, $include ), $except, $script_name, $glue );
	}
	
	function set_date( $date = '', $mode = 'short' )
	{
		if ( $mode == 'short' )
			if ( preg_match( '/^(\d\d)\.(\d\d)\.(\d\d\d\d)$/', $date, $matches ) )
				return $matches[3].$matches[2].$matches[1].'000000';
		if ( $mode == 'long' )
			if ( preg_match( '/^(\d\d)\.(\d\d)\.(\d\d\d\d)\s+(\d\d):(\d\d)$/', $date, $matches ) )
				return $matches[3].$matches[2].$matches[1].$matches[4].$matches[5].'00';
		if ( $mode == 'full' )
			if ( preg_match( '/^(\d\d)\.(\d\d)\.(\d\d\d\d)\s+(\d\d):(\d\d):(\d\d)$/', $date, $matches ) )
				return $matches[3].$matches[2].$matches[1].$matches[4].$matches[5].$matches[6];
		return '';
	}
	
	function get_date( $date = '', $mode = 'short' )
	{
		if ( preg_match( '/^(\d\d\d\d)(\d\d)(\d\d)(\d\d)(\d\d)(\d\d)$/', $date, $matches ) )
		{
			if ( $mode == 'short' )
				return $matches[3].'.'.$matches[2].'.'.$matches[1];
			if ( $mode == 'long' )
				return $matches[3].'.'.$matches[2].'.'.$matches[1].' '.$matches[4].':'.$matches[5];
			if ( $mode == 'full' )
				return $matches[3].'.'.$matches[2].'.'.$matches[1].' '.$matches[4].':'.$matches[5].':'.$matches[6];
			
			if ( $mode == 'rfc' )
				return date( 'r', mktime( $matches[4], $matches[5], $matches[6], $matches[2], $matches[3], $matches[1] ) );
		}
		return '';
	}
	
	function is_file_exists( $file_name )
	{
		return file_exists( $file_name ) && is_file( $file_name );
	}
	
	class tree
	{
		private static $primary_field = '';
		
		private static $parent_field = '';
		
		private static $records_by_parent = array();
		
		private static $records_as_tree = array();
		
		private static $except = array();
		
		public static function get_tree( &$records, $primary_field, $parent_field, $begin = 0, $except = array() )
		{
			self::$primary_field = $primary_field;
			self::$parent_field = $parent_field;
			self::$except = $except;
			
			self::$records_by_parent = array();
			foreach ( $records as $record )
				if ( isset( $record[self::$parent_field] ) )
					self::$records_by_parent[$record[self::$parent_field]][] = $record;
			
			self::$records_as_tree = array();
			self::build_tree( $begin );
			
			return self::$records_as_tree;
		}
		
		private static function build_tree( $parent_field_id, $depth = 0 )
		{
			if ( isset( self::$records_by_parent[$parent_field_id] ) )
			{
				foreach ( self::$records_by_parent[$parent_field_id] as $record )
				{
					if ( isset( $record[self::$primary_field] ) &&
							!in_array( $record[self::$primary_field], self::$except ) )
					{
						$record['_depth'] = $depth;
						self::$records_as_tree[] = $record;
						self::build_tree( $record[self::$primary_field], $depth + 1 );
					}
				}
			}
		}
	}
	
	function to_translit($string) {
		$string = mb_strtolower($string, "UTF-8");
		$replace = array(
			"."=>"",","=>"","/"=>"_","("=>"",")"=>"","\""=>"","-"=>"_",":"=>"",
			"'"=>""," "=>"_","`"=>"","а"=>"a","А"=>"a","б"=>"b","Б"=>"b","в"=>"v","В"=>"v",
			"г"=>"g","Г"=>"g","д"=>"d","Д"=>"d","е"=>"e","Е"=>"e","ж"=>"zh","Ж"=>"zh",
			"з"=>"z","З"=>"z","и"=>"i","И"=>"i","й"=>"y","Й"=>"y","к"=>"k","К"=>"k",
			"л"=>"l","Л"=>"l","м"=>"m","М"=>"m","н"=>"n","Н"=>"n","о"=>"o","О"=>"o",
			"п"=>"p","П"=>"p","р"=>"r","Р"=>"r","с"=>"s","С"=>"s","т"=>"t","Т"=>"t",
			"у"=>"u","У"=>"u","ф"=>"f","Ф"=>"f","х"=>"h","Х"=>"h","ц"=>"c","Ц"=>"c",
			"ч"=>"ch","Ч"=>"ch","ш"=>"sh","Ш"=>"sh","щ"=>"sch","Щ"=>"sch",
			"ъ"=>"","Ъ"=>"","ы"=>"y","Ы"=>"y","ь"=>"","Ь"=>"","э"=>"e","Э"=>"e",
			"ю"=>"yu","Ю"=>"yu","я"=>"ya","Я"=>"ya","і"=>"i","І"=>"i",
			"ї"=>"yi","Ї"=>"yi","є"=>"e","Є"=>"e","ё"=>"e","Ё"=>"e"
		);
		return $str = iconv("UTF-8","UTF-8//IGNORE", strtr($string,$replace));
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////
	
	function get_time()
	{ 
		list( $usec, $sec ) = explode( ' ', microtime() ); 
		return (float) $usec + (float) $sec; 
	}
?>
